<?php

class SiteController extends Controller
{
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

        $userPassword = Bcrypt::hash(trim($_POST['password']));
        $user = new User();
        $user->email = strtolower(trim($email));
        $user->name = trim($name);
        $user->password = $userPassword;
        if($user->save())
        {
            list($large, $middle, $small) = AvatarUtil::fetch($user->email);
            if(!empty($large))
            {
                $user->avatar_large = $large;
                $user->avatar_middle = $middle;
                $user->avatar_small = $small;
                $user->save();
            }
            $this->response($user, Response::OK);
        }
        $this->response($user->getErrors(), Response::BAD_REQUEST);
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
            $this->response('Logged', Response::BAD_REQUEST);

        $identity = new UserIdentity($id, $password);
        if($identity->authenticate())
        {
			$duration = $rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($identity, $duration);
            $this->response($identity->id, Response::OK);
        }
        $this->response('Invalid ID or password', Response::BAD_REQUEST);
	}

    public function actionAuthentication()
    {
        if(!Yii::app()->user->getIsGuest())
        {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $this->response($user, Response::OK);
        }
        $this->response('Unauthorized', Response::UNAUTHORIZED);
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
            $this->response('Failed', Response::BAD_REQUEST);
		Yii::app()->user->logout();
        $this->response('Success', Response::OK);
	}

    public function actionError()
    {
		if($error = Yii::app()->errorHandler->error)
            defined(YII_DEBUG) ? print($error) : $this->response($error['message'], $error['code']);
    }
}
