<?php
/**
 * OpenIdController
 *
 * @link      http://github.com/tlikai/teaconf
 * @author    likai<youyuge@gmail.com>
 * @license   http://www.teaconf.com/license New BSD License
 */

class OpenIdController extends Controller
{
    protected $oAuthChina;

    public function beforeAction($action)
    {
        Yii::import('ext.OAuthChina.OAuthChina');
        $this->oAuthChina = new OAuthChina(array(
            'sina' => array(
                'id' => '3914439538',
                'secret' => '0967424329e900f432074f600b3da30c',
                'redirectUri' => Yii::app()->createAbsoluteUrl('openid/login/sina'),
            ),
            'tencent' => array(
                'id' => '100404721',
                'secret' => '23350cabe1ac7f5d02ae721dc5e060c0',
                'redirectUri' => Yii::app()->createAbsoluteUrl('openid/login/tencent'),
            ),
            'douban' => array(
                'id' => '00d0ee8a9d1e8a8b0272cb9fd75b9fa1',
                'secret' => '4d200e11eb1c65b6',
                'redirectUri' => Yii::app()->createAbsoluteUrl('openid/login/douban'),
            ),
        ));

        return parent::beforeAction($action);
    }

    /**
     * 跳转到授权页面
     *
     * @param string $provider
     */
    public function actionAuth($provider)
    {
        $adapter = $this->oAuthChina->getAdapter($provider);
        header('Location: ' . $adapter->getAuthorizeUrl());
    }

    /**
     * 授权回调
     *
     * @param string $provider
     */
    public function actionLogin($provider)
    {
        $adapter = $this->oAuthChina->getAdapter($provider);
        $adapter->authenticate();
        $adapter->getAccessToken($_GET['code']);

        $identity = new OpenIdUserIdentity($provider, $adapter->token);
        if($identity->authenticate())
            Yii::app()->user->login($identity);
        else
        {
            $user  = new User();
            $auth = new UserAuth();
            $profile = $adapter->getProfile();

            $user->name = $profile['name'];
            $user->avatar_small = $user->avatar_middle = $user->avatar_large = $profile['avatar'];
            $user->save();

            $auth->attributes = array_merge(array(
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $adapter->token['provider_id'],
            ), $adapter->token, $profile);
            $auth->save();
            if($identity->authenticate())
                Yii::app()->user->login($identity);
        }
        echo <<<EOF
<script type="text/javascript">
    opener.document.location.reload();
    window.close();
</script>
EOF;
    }
}
