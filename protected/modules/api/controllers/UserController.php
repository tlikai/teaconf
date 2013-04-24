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
     * 获取用户主题
     *
     * @uri user/topics/{id}
     * @method GET
     * 
     * @param integer $id
     */
    public function actionTopics($id)
    {
        $user = $this->loadModel($id);
        Response::ok($user->topics);
    }

    /**
     * 获取用户回复
     *
     * @uri user/replies/{id}
     * @method GET
     *
     * @param integer $id
     */
    public function actionReplies($id)
    {
        $user = $this->loadModel($id);
        Response::ok($user->posts);
    }

    /**
     * 获取用户关注
     *
     * @uri user/watch/{id}
     * @method GET
     *
     * @param integer $id
     */
    public function actionWatch($id)
    {
        $user = $this->loadModel($id);
        Response::ok($user->watch);
    }

    /**
     * 获取用户喜欢
     *
     * @uri user/likes/{id}
     * @method GET
     *
     * @param integer $id
     */
    public function actionLikes($id)
    {
        $user = $this->loadModel($id);
        Response::ok($user->likes);
    }

    public function actionRead($id)
    {
        $user = $this->loadModel($id);
        Response::ok($user);
    }

    /**
     * 更新头像
     * @uri user/updateAvatar
     * @method POST
     */
    public function actionUpdateAvatar()
    {
        Yii::app()->user->requirePermission('updateAvatar');

        Yii::import('ext.file.Upload');
        $upload = new Upload('user_file[0]', array(
            'savePath' => ROOT_PATH . '/uploads/avatar',
            'allowTypes' => array('image/jpeg', 'image/png'),
            'maxSize' => 1048576, // 1MB
        ));

        if($upload->validate())
        {
            $upload->save();

            // create large thumbnail
            Yii::import('ext.image.Image');
            $image = Image::factory($upload->file, Image::GD);
            $path = pathinfo($upload->file, PATHINFO_DIRNAME);
            $name = pathinfo($upload->file, PATHINFO_FILENAME);
            $ext = pathinfo($upload->file, PATHINFO_EXTENSION);

            $large = $path . '/' . $name . '!' . AvatarUtil::LARGE . '.' . $ext;
            $middle = $path . '/' . $name . '!' . AvatarUtil::MIDDLE. '.' . $ext;
            $small = $path . '/' . $name . '!' . AvatarUtil::SMALL . '.' . $ext;
            $image->resize(AvatarUtil::LARGE_SIZE, Image::AUTO)->crop(AvatarUtil::LARGE_SIZE, AvatarUtil::LARGE_SIZE)->saveAs($large);
            $image->resize(AvatarUtil::MIDDLE_SIZE, Image::AUTO)->crop(AvatarUtil::MIDDLE_SIZE, AvatarUtil::MIDDLE_SIZE)->saveAs($middle);
            $image->resize(AvatarUtil::SMALL_SIZE, Image::AUTO)->crop(AvatarUtil::SMALL_SIZE, AvatarUtil::SMALL_SIZE)->saveAs($small);

            unlink($upload->file);
            $attributes = array(
                'avatar_large' => str_replace(ROOT_PATH, '', $large),
                'avatar_middle' => str_replace(ROOT_PATH, '', $middle),
                'avatar_small' => str_replace(ROOT_PATH, '', $small),
            );
            if(User::model()->updateByPk(Yii::app()->user->id, $attributes))
                Response::ok($attributes);
        }

        Response::badRequest($upload->error);
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
            Response::ok($this->loadModel($identity->id));
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
     * 修改用户资料
     *
     * uri: /user/{id}
     * method: PUT
     *
     * @param integer $id
     */
    public function actionUpdate($id, $weibo, $wechat, $signature)
    {
        if(Yii::app()->user->isGuest)
            Response::forbidden();
        if(Yii::app()->user->id != $id)
            Response::unAuthorized();
        $model = $this->loadModel($id);
        $model->weibo = $weibo;
        $model->qq = $wechat;
        $model->signature = $signature;
        if($model->save())
            Response::ok($model);
        Response::serverError();
    }

    public function actionChangePassword($id, $password, $newPassword, $confirmPassword)
    {
        $model = $this->loadModel($id);
        $model->scenario = 'changePassword';
        if(!Bcrypt::verify($password, $model->password))
            Response::badRequest('Current password is invalid');
        $model->newPassword = $newPassword;
        $model->confirmPassword = $confirmPassword;
        if($model->validate())
        {
            $model->password = Bcrypt::hash($newPassword);
            if($model->save())
                Response::ok($model);
        }
        Response::badRequest($model->getFirstError());
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
