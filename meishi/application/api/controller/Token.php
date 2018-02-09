<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28 0028
 * Time: 下午 6:17
 */

namespace app\api\controller;


use app\api\service\AppToken;
use app\api\service\BaseToken;
use app\api\service\UserToken;
use app\exception\TokenException;

class Token
{

    // 获取token接口
    public function getToken($code){

        $ut = new UserToken($code); //接受code，在构造函数中封装微信获取openid的url
        $token = $ut->get_Token_Service();  //返回缓存的key

        return ['token_key' => $token]; //返回一个json对象（直接返回$token是json字符串）
    }


    //检查token是否有效接口
    public function verifyToken($token=''){

        if(!$token){
           throw new TokenException(['msg'=>'检查token时token为空']);
        }
        $valid = BaseToken::verifyToken($token);

        return ['isValid' => $valid];
    }


    // 获取第三方令牌（*）
    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se='')
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET');
//        (new AppTokenValidate())->goCheck();
        $app = new AppToken();
        $token = $app->getThirdAppTokenService($ac, $se);
        return [
            'token' => $token
        ];
    }
}