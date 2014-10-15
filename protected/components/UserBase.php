<?php
/**
 * @author Krzysztof Sowa
 */

abstract class UserBase extends CActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;

    public $new_password;
    public $password_repeat;
    public $current_password;
    public $count;

    protected static $currentUser = false;

    public $addToJSON = array();
    public $removeFromJSON = array();
    /**
     * @param integer $daysBack
     * @return integer
     */
    public static function getTotalUsersNumber($daysBack = null)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('is_admin', 0);
        $criteria->compare('status', UserHelper::STATUS_ACTIVE);

        if($daysBack !== null){
            $criteria->addCondition('t.created_at > NOW() - INTERVAL :days_back DAY');
            $criteria->params[':days_back'] = $daysBack;
        }

        return User::model()->count($criteria);
    }

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail($email)
    {
        return $this->findByAttributes(array('email' => $email));
    }

    /**
     * @param integer $id
     * @return User
     */
    public function getById($id)
    {
        return $this->findByPk($id);
    }

    /**
     * @return User
     */
    public static function getCurrent()
    {
        if(self::$currentUser === false){
            $cacheId = 'user_info';
            $cached = SessionHelper::get( $cacheId );
            if(!$cached){
                $cached = Users::loadAndGetCurrent();
                SessionHelper::set($cacheId, $cached);
            }
            self::$currentUser = $cached;
        }

        return self::$currentUser;
    }

    protected function afterSave() {
        $cacheId = 'user_info';
        SessionHelper::unsetData( $cacheId );
        return parent::afterSave();
    }

    public static function getStatuses($id = null)
    {
        $data = array(
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        );

        if($id !== null){
            return isset($data[$id]) ? $data[$id] : $id;
        }

        return $data;
    }

    public function updateLastLoginTime()
    {
        SessionHelper::set('last_logged_time', $this->last_logged_time);

        $mysqlDate = date("Y-m-d H:i:s", time());
        $this->last_logged_time = $mysqlDate;
        $this->setScenario('system-update');
        $this->save();
    }

    /**
     * @return User
     */
    public static function loadAndGetCurrent($with = array())
    {
        $userId = self::getCurrentId();
        if($userId){
            $criteria = new CDbCriteria();
            if($with){
                $criteria->with = $with;
            }

            return Users::model()->findByPk($userId, $criteria);
        }

        return null;
    }

    public static function getCurrentId()
    {
        return self::loggedIn() ? Yii::app()->user->id : null;
    }

    /**
     * @return Boolean
     */
    public static function loggedIn()
    {
        return !Yii::app()->user->isGuest;
    }

    /**
     * @param String $password
     * @return Boolean
     */
    public function validatePassword($password)
    {
        $salt = $this->getPasswordSalt();
        return $this->hashPassword($password, $salt) === $this->password;
    }

    /**
     * @return string
     */
    protected function getPasswordSalt()
    {
        $position = strrpos($this->password, '$', 3);
        $salt = substr($this->password, 0, $position + 1);

        return $salt;
    }

    /**
     * @param String $password
     * @param String $salt
     * @return String
     */
    protected function hashPassword($password, $salt)
    {
        return crypt($password, $salt);
    }

    public function forceLogin()
    {
        // auto login
        $identity = new UserIdentity($this->email, $this->password);
        $identity->setId($this->id);
        $identity->user = $this;
        $identity->errorCode = UserIdentity::ERROR_NONE;

        Yii::app()->user->login($identity);
        $this->updateLastLoginTime();
    }

    /**
     * @param integer $length
     * @return string
     */
    protected function generateSalt($length = null)
    {
        if(!$length){
            $length = rand(12, 16);
        }
        $salt = '$6$rounds=' . rand(60000, 70000) . '$' . StringHelper::randomString($length, 3);

        return $salt;
    }

    public function setNewPassword($password)
    {
        $salt = $this->generateSalt();
        $this->password = $this->hashPassword($password, $salt);
    }

//    public function ruleCheckCurrentPassword($attribute)
//    {
//        $hash = $this->{$attribute} ? $this->hashPassword($this->{$attribute}, $this->salt) : '';
//
//        if($hash != $this->password){
//            $this->addError($attribute, 'Current Password is incorrect');
//        }
//    }

    public function ruleHashPassword($attribute)
    {
        if($this->{$attribute}){
            $salt = $this->generateSalt();
            $this->password = $this->hashPassword($this->{$attribute}, $salt);
        }
    }

    public function ruleChangePassword($attribute)
    {
        if($this->{$attribute}){
            $this->setNewPassword($this->{$attribute});
        }
    }

    public function ruleCheckCurrentPassword($attribute)
    {
        $salt = $this->getPasswordSalt();

        $hash = $this->{$attribute} ? $this->hashPassword($this->{$attribute}, $salt) : '';

        if($hash != $this->password){
            $this->addError($attribute, Yii::t('profile', 'Current Password is incorrect'));
        }
    }

    public function ruleGenerateActivationKey($attribute)
    {
        $key = StringHelper::randomString(rand(45, 50), 2);
        $this->{$attribute} = $key;
    }

    public function ruleAddImage($attribute)
    {
        $this->addImage($attribute);
    }

    /**
     * @param string $key
     * @return UserBase
     */
    public function getByActivationKey($key)
    {
        if(!$key){
            return null;
        }

        $criteria = new CDbCriteria();
        $criteria->compare('t.activation_key', $key);
        $criteria->compare('t.status', UserHelper::STATUS_PENDING_ACTIVATION);

        $record = $this->find($criteria);

        return $record;
    }

    /**
     * @return boolean
     */
    public function activateUser()
    {
        $this->status = UserHelper::STATUS_ACTIVE;
        $this->activation_key = null;
        $this->setScenario('system-update');

        $result = $this->save();

        return $result;
    }


    public function toJSON()
    {
        $data = iterator_to_array($this);
        $data = array_merge($data, $this->relationsToJSON());

        foreach($this->addToJSON as $item)
        {
            $data[$item] = $this->{$item};
        }

        foreach($this->removeFromJSON as $item)
        {
            unset($data[$item]);
        }

        return $data;
    }

    public function relationsToJSON()
    {
        $data = array();
        foreach ($this->relations() as $relation => $options)
        {
            if ($this->hasRelated($relation))
            {
                $relationData = $this->getRelated($relation);

                if (is_object($relationData))
                {
                    if (method_exists($relationData, 'toJSON')) $relationData = $relationData->toJSON();
                }
                else if (is_array($relationData))
                {
                    $relationDataItems = array();
                    foreach($relationData as $item)
                    {
                        if (method_exists($item, 'toJSON')) $relationDataItems[] = $item->toJSON();
                    }
                    $relationData = $relationDataItems;
                }

                $data[$relation] = $relationData;


            }
        }
        return $data;
    }
}
