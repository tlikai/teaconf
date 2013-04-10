<?php
/**
 * UserController class file
 *
 * @author likai<youyuge@gmail.com>
 * @link http://www.youyuge.com/
 */

/**
 * User controller class
 */

class UserController extends Controller
{
    const RESET_PASSWORD_EXPIRES = 7200;

    /**
     * 用户注册
     *
     * @uri site/register
     * @method POST
     *
     * @param string $email
     * @param string $name
     * @param string $password
     */
    public function actionRegister($email, $name, $password)
    {
        if(!Yii::app()->user->getIsGuest())
            $this->response('Logged', Response::BAD_REQUEST);

        $passwordHash = Bcrypt::hash(trim($password));
        $user = new User('create');
        $user->email = strtolower(trim($email));
        $user->name = trim($name);
        $user->password = $password;
        list($user->avatar_small, $user->avatar_middle, $user->avatar_large) = AvatarUtil::gavatar($user->email);
        if($user->validate())
        {
            $user->password = $passwordHash;
            if($user->save())
            {
                $identity = new UserIdentity($user->id, $user->password);
                $identity->username = $user->name;
                Yii::app()->user->login($identity);
                $this->response($user, Response::OK);
            }
        }
        $this->response($user->getErrorMessage(), Response::BAD_REQUEST);
    }

    /**
     * 用户登录
     *
     * @uri site/login
     * @method POST
     *
     * @param string $id name or email
     * @param string $password
     * @param boolean $rememberMe
     */
	public function actionLogin($id, $password, $rememberMe = false)
	{
        if(!Yii::app()->user->getIsGuest())
            $this->error('Logged', Response::BAD_REQUEST);

        $identity = new UserIdentity($id, $password);
        if($identity->authenticate())
        {
			$duration = $rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($identity, $duration);
            $this->response(User::model()->findByPk($identity->id), Response::OK);
        }
        $this->error('Invalid ID or password', Response::BAD_REQUEST);
	}

    /**
     * 用户验证
     */
    public function actionAuthenticate()
    {
        if(!Yii::app()->user->getIsGuest())
        {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $this->response($user, Response::OK);
        }
        $this->error('Unauthorized', Response::UNAUTHORIZED);
    }

    /**
     * 用户退出
     *
     * @uri site/logout
     * @method PUT
     */
	public function actionLogout()
	{
        if(Yii::app()->user->getIsGuest())
            $this->error('Unauthorized', Response::BAD_REQUEST);
		Yii::app()->user->logout();
        $this->response('Success', Response::OK);
	}

    /**
     * 重置密码预约
     *
     * uri: /user/resetPassword
     * method: POST
     *
     * @param string $email
     */
    public function actionReserveRestPassword($email)
    {
        $user = User::model()->findById($email);
        if(!$user)
            $this->response('Unknow user', Response::BAD_REQUEST);
        $code = User::generateSecureCode();
        $expires = time() + self::RESET_PASSWORD_EXPIRES;
        $url = Yii::app()->createAbsoluteUrl('user/actionRestPassword') . '?' . http_build_query(array( 
            'userId' => $user->id,
            'code' => $code,
            'expires' => $expires,
            'sign' => md5($user->id . $code . $expires),
        ));
        $user->secure_code = $code;
        if($user->save())
            echo $url;
            // TODO send mail
        else
            $this->response('Unknow error', Response::SERVER_ERROR);
    }

    /**
     * 重置密码
     *
     * uri: /user/resetPassword
     * method: PUT
     *
     * @param integer $userId
     * @param string $code
     * @param integer $expires
     * @param string $sign
     * @param string $password
     */
    public function actionResetPassword($userId, $code, $expires, $sign, $password)
    {
        $user = User::model()->findByPk($userId);
        if(!$user)
            $this->response('Unknow user', Response::BAD_REQUEST);
        if(md5($userId . $code . $expires) != $sign || time() - $expires > self::RESET_PASSWORD_EXPIRES  || $code != $user->secure_code)
            $this->response('Token failed or expired', Response::BAD_REQUEST);
        $password = Bcrypt::hash($password);
        $user->password = $password;
        if($user->save())
            $this->response('Reset password success', Response::OK);
        $this->response('Reset password failed', Response::SERVER_ERROR);
    }
}
