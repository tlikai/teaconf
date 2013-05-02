<?php
/**
 * SiteController
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class SiteController extends Controller
{
    const RESET_PASSWORD_EXPIRES = 7200;

    /**
     * 重置密码预约
     *
     * uri: /resetPassword
     * method: POST
     *
     * @param string $email
     */
    public function actionReserveRestPassword($email)
    {
        $user = User::model()->findById($email);
        if($user === null)
            Response::badRequest('Invalid email address');
        $code = User::generateSecureCode();
        $expires = time() + self::RESET_PASSWORD_EXPIRES;
        $url = Yii::app()->createAbsoluteUrl('resetPassword') . '?' . http_build_query(array( 
            'user_id' => $user->id,
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
     * uri: /resetPassword
     * method: PUT
     *
     * @param integer $user_id
     * @param string $code
     * @param integer $expires
     * @param string $sign
     * @param string $newPassword
     * @param string $confirmPassword
     */
    public function actionResetPassword($user_id, $code, $expires, $sign, $newPassword, $confirmPassword)
    {
        $user = User::model()->findByPk($user_id);
        $user->scenario = 'changePassword';
        if($user === null)
            Response::badRequest('Invalid user');
        if(md5($user_id. $code . $expires) != $sign || time() - $expires > self::RESET_PASSWORD_EXPIRES  || $code != $user->secure_code)
            Response::badRequest('Token failed or expired');

        $user->newPassword = $newPassword;
        $user->confirmPassword = $confirmPassword;
        if($user->validate())
        {
            $user->password = Bcrypt::hash($newPassword);
            $user->secure_code = '';
            if($user->save())
                Response::ok('Reset password success');
            Response::serverError();
        }
        Response::badRequest($user->getFirstError());
    }

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
        $user = new User();
        $user->email = strtolower(trim($email));
        $user->name = strtolower(trim($name));
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
            Response::ok(User::model()->findByPk($identity->id));
        }
        Response::badRequest(Yii::t('error', 'Invalid ID or password'));
	}

    /**
     * 用户验证
     */
    public function actionAuthenticate()
    {
        if(!Yii::app()->user->getIsGuest())
        {
            $user = User::model()->findByPk(Yii::app()->user->id);
            if($user)
                Response::ok($user);
            Yii::app()->user->logout();
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
}
