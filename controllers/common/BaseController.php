<?php
/**
 * Created by PhpStorm.
 * User: trina
 * Date: 18-9-18
 * Time: 下午1:59
 */

namespace app\controllers\common;

use app\models\User;
use app\services\UrlService;
use Yii;
use yii\web\Controller;

/**
 * 所有控制器的基类，并且集成常用公用方法
 * Class BaseController
 * @package app\controllers\common
 * User: trina
 */
class BaseController extends Controller
{
    protected $auth_cookie_name = 'imguowei_888';
    protected $current_user = null;//当前登录人信息
    protected $allowAllAction = [
        'user/login',
        'user/v-login'
    ];
    public $ignore_url = [
        'error/forbidden' ,
        'user/v-login',
        'user/login'
    ];

    /**
     * 登录之后才可以访问
     * @param $action
     * @return bool
     * @throws \yii\base\ExitException
     * User: trina
     */
    public function beforeAction($action)
    {
        $login_status = $this->checkLoginStatus();
        if (!$login_status && !in_array($action->uniqueId, $this->allowAllAction)) {
            if (Yii::$app->request->isAjax) {
                $this->renderJson([], "未登录，请返回用户中心", -302);
            } else {
                $this->redirect(UrlService::buildUrl("/user/login"));
            }
            return false;
        }

        return true;
    }

    /**
     * 验证登录是否有效，返回 true or  false
     * @return bool
     * User: trina
     */
    protected function checkLoginStatus(){
        $request = Yii::$app->request;
        $cookies = $request->cookies;
        $auth_cookie = $cookies->get($this->auth_cookie_name);
        if(!$auth_cookie){
            return false;
        }
        list($auth_token,$uid) = explode("#",$auth_cookie);
        if(!$auth_token || !$uid){
            return false;
        }
        if( $uid && preg_match("/^\d+$/",$uid) ){
            $userinfo = User::findOne([ 'id' => $uid ]);
            if(!$userinfo){
                return false;
            }
            //校验码
            if($auth_token != $this->createAuthToken($userinfo['id'],$userinfo['name'],$userinfo['email'],$_SERVER['HTTP_USER_AGENT'])){
                return false;
            }
            $this->current_user = $userinfo;
            $view = Yii::$app->view;
            $view->params['current_user'] = $userinfo;
            return true;
        }
        return false;
    }

    /**
     * 设置登录态cookie
     * @param $userinfo
     * User: trina
     */
    public  function createLoginStatus($userinfo){
        $auth_token = $this->createAuthToken($userinfo['id'],$userinfo['name'],$userinfo['email'],$_SERVER['HTTP_USER_AGENT']);
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => $this->auth_cookie_name,
            'value' => $auth_token."#".$userinfo['id'],
        ]));
    }

    /**
     * 用户相关信息生成加密校验码函数
     * @param $uid
     * @param $name
     * @param $email
     * @param $user_agent
     * @return string
     * User: trina
     */
    public function createAuthToken($uid,$name,$email,$user_agent){
        return md5($uid.$name.$email.$user_agent);
    }

    /**
     * 统一获取post参数的方法
     * @param $key
     * @param string $default
     * @return array|mixed
     * User: trina
     */
    public function post($key, $default = '')
    {
        return Yii::$app->request->post($key, $default);
    }

    /**
     * 统一获取get参数的方法
     * @param $key
     * @param string $default
     * @return array|mixed
     * User: trina
     */
    public function get($key, $default = '')
    {
        return Yii::$app->request->get($key, $default);
    }

    /**
     * 封装json返回值， 主要用于js/ajax和后端交互返回格式
     * @param array $data
     * @param string $message
     * @param int $code
     * @throws \yii\base\ExitException
     * User: trina
     */
    protected function renderJson($data = [], $message = 'ok', $code = 200)
    {
        header('Content-type: application/json');//设置头部内容格式
        echo json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data,
            'req_id' => uniqid()
        ]);
        return Yii::$app->end();//终止请求直接返回
    }
}