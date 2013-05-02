<?php
/**
 * UserIdentity
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class UserIdentity extends CUserIdentity
{
    public $id;

    public function __construct($id, $password)
    {
        $this->id = $this->username = strtolower($id);
        $this->password = $password;
    }

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
        $user = User::findById($this->id);
        if(!$user)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
        elseif(!Bcrypt::verify($this->password, $user->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->id = $user->id;
            $this->username = $user->name;
			$this->errorCode = self::ERROR_NONE;
        }
		return !$this->errorCode;
	}

    public function getId()
    {
        return $this->id;
    }
}
