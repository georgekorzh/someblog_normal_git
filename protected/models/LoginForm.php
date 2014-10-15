<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
    public $id;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),

            //array('username, password', 'safe')
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
        if($this->_identity===null)
        {
            $this->_identity=new UserIdentity($this->username,$this->password);
            $this->_identity->authenticate();
        }
        //return true;
        if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identity,$duration);
            return true;
        }
        else
            return false;
    }




    public function loginapi()
        {
            /** @var User $model */
            $model = $this;


            // login by model
            if ($this->id)
            {
                //return true;
                $model = $this;
            }
            else
            {
                // try get model by api token
                if (!empty($data['token']))
                {

                    if (!$model = self::getByApiToken($data['token']))
                    {
                        $this->addError('token', 'Wrong api token');
                        return false;
                    }
                }else{
                    return $this->login();
                }
            }

            if (!$model->id)
            {
                $this->addError('email', 'User not found');
                return false;
            }
            //return true;


            // All OK
            $model->forceLogin();
            return true;

    }
    //public function validate(){
    //    return true;
    //}

    public function getApiToken()
    {
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
