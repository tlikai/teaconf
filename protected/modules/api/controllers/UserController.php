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
            Response::forbidden('Has logged');

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
                Response::ok($user);
            }
        }
        Response::badRequest($user->getFirstError());
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
            Response::forbidden('Has logged');

        $identity = new UserIdentity($id, $password);
        if($identity->authenticate())
        {
			$duration = $rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($identity, $duration);
            Response::ok($this->loadModel($identity->id));
        }
        Response::badRequest('Invalid ID or password');
	}

    /**
     * 用户验证
     */
    public function actionAuthenticate()
    {
        if(!Yii::app()->user->getIsGuest())
        {
            $user = $this->loadModel(Yii::app()->user->id);
            Response::ok($user);
        }
        Response::unAuthorized();
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
            Response::unAuthorized();
		Yii::app()->user->logout();
        Response::ok();
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
        $user = $this->loadModel($userId);
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
            Response::serverError();
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
        $user = $this->loadModel($userId);
        if(md5($userId . $code . $expires) != $sign || time() - $expires > self::RESET_PASSWORD_EXPIRES  || $code != $user->secure_code)
            Response::badRequest('Token failed or expired');
        $password = Bcrypt::hash($password);
        $user->password = $password;
        if($user->save())
            Response::ok('Reset password success');
        Response::serverError('Reset password failed');
    }

    /**
     * 加载用户模型
     *
     * @param integer $id
     * @return User
     */
    public function loadModel($id)
    {
        $model = User::model()->findByPk($id);
        if($model === null)
            Response::notFound('The user does not exist');
        return $model;
    }
}
