<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    public $user;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		//$users=array(
			// username => password
		//	'demo'=>'demo',
		//	'admin'=>'admin',
		//);
        $username = strtolower($this->username);
        $usMod = new Users;
        $usArr = $usMod->find('LOWER(login)=?', array($username));
        //foreach($usArr as $uItem){
        //    $users[$uItem->login] = $uItem['pass'];
        //}
        if(!isset($usArr->login)){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }else {
            $users = array($usArr->login => $usArr->pass);

        }
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
        //elseif($usArr->status !=='1')
            //$this->errorCode = 'You should confirm registration, the message was sent on '. $usArr->email;
		else{
            $this->_id = $usArr->id;
            $this->user = $usArr;
            $this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
        /*
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;*/
	}

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }
}