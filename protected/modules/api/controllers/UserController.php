<?php
/**
 * UserController
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class UserController extends Controller
{
    /**
     * 读取用户信息
     *
     * uri: /user/{id}
     * method: GET
     *
     * @param integer $id
     */
    public function actionRead($id)
    {
        $user = $this->loadModel($id);
        Response::ok($user);
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

    /**
     * 获取用户主题
     *
     * @uri user/{id}/posts
     * @method GET
     * 
     * @param integer $id
     */
    public function actionTopics($id)
    {
        $model = new Topic();
        $model->creator_id = $id;
        $dataProvider = $model->createDataProvider();
        Response::ok($dataProvider->data);
    }

    /**
     * 获取用户回复
     *
     * @uri user/{id}/posts
     * @method GET
     *
     * @param integer $id
     */
    public function actionPosts($id)
    {
        $user = $this->loadModel($id);
        $model = new Post();
        $model->creator_id = $id;
        $dataProvider = $model->createDataProvider();
        Response::ok($dataProvider->data);
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
     * 修改密码
     *
     * @param integer $id
     * @param string $password current password
     * @param string $newPassword
     * @param string $confirmPassword
     */
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
