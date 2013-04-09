<?php
/**
 * OpenIdUserIdentity class file.
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 OpenIdUserIdentity
 *
 * @author likai<youyuge@gmail.com>
 * @version $Id$
 */
class OpenIdUserIdentity extends CUserIdentity
{
    public $id;
    public $provider;
    public $token;

    public function __construct($provider, $token)
    {
        $this->provider = $provider;
        $this->token = $token;
    }

	public function authenticate()
	{
        $auth = UserAuth::model()->findByAttributes(array(
            'provider' => $this->provider,
            'provider_id' => $this->token['provider_id'],
        ));

        if($auth)
        {
            $auth->attributes = array_merge($auth->attributes, $this->token);
            $auth->save();

            $user = User::model()->findByPk($auth->user_id);
            $this->id = $user->id;
            $this->username = $user->name;
            $this->errorCode = self::ERROR_NONE;
        }
        else
            $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		return !$this->errorCode;
	}
}
