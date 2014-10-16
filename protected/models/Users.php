<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $login
 * @property string $email
 * @property string $pass
 * @property string $pic
 *
 * The followings are the available model relations:
 * @property Posts[] $posts
 */
class Users extends UserBase
{
    public $pic;
    public $imgobj;
    const LEFT_COMMENT = '3';
    const CONFIRMED = '2';
    const UNCONFIRMED = '1';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, email, pass', 'required'),
			array('login, pass', 'length', 'max'=>20),
			array('email', 'length','min'=>5, 'max'=>60),
			array('pic', 'file', 'types'=>'png, jpg, gif', 'allowEmpty' => true),
			//array('pic', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, login, email, pass', 'safe', 'on'=>'search'),
			array('id, login, email, pass, pic', 'safe', 'on'=>'search'),
			//array('id, login, email, pass', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'posts' => array(self::HAS_MANY, 'Posts', 'id_author'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'email' => 'Email',
			'pass' => 'Pass',
			'pic' => 'Image',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('pic',$this->pic,false);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    public static function getCurrent()
    {
        return parent::getCurrent();
    }

    public function getApiToken()
    {
        //return 'test';
        return DCrypt::encrypt(array('id' => $this->id), Yii::app()->params['privateKey']);
    }

    public static function getByApiToken($token)
    {
        $data = DCrypt::decrypt($token, Yii::app()->params['privateKey']);
        return User::model()->findByPk($data['id']);
    }


    public function getLoginToken()
    {
        return DCrypt::encrypt(array('id' => $this->id, 'salt' => $this->password), Yii::app()->params['privateKey']);
    }


}
