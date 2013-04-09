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
