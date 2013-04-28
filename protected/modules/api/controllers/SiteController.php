<?php

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

}
