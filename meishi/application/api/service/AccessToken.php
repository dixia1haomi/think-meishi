<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/3/5
 * Time: 13:32
 */

namespace app\api\service;


use think\Exception;

class AccessToken
{

    // 获取AccessToken
    // 使用方法:实例化后调用get方法就行了.
    // $Access = new AccessToken();
    // $AccessToken = $Access->get();

    private $tokenUrl;
    const TOKEN_CACHED_KEY = 'access';
    const TOKEN_EXPIRE_IN = 7000;

    function __construct()
    {
        $url = config('wx_config.access_token_url');
        $url = sprintf($url, config('wx_config.appid'), config('wx_config.secret'));
        $this->tokenUrl = $url;
    }

    // 建议用户规模小时每次直接去微信服务器取最新的token
    // 但微信access_token接口获取是有限制的 2000次/天
    public function get()
    {
        $token = $this->getFromCache();
        if(!$token){
            return $this->getFromWxServer();
        }
        else{
            return $token;
        }
    }

    // 去缓存中检查acc_token是否还有效
    private function getFromCache(){
        $token = cache(self::TOKEN_CACHED_KEY);
        // 如果缓存中有acc_token,直接返回（这种自己修改过，原代码可能是错误的）
        if($token){
            return $token['access_token'];
        }
        return null;
    }

    // 去微信的接口获取acc_token
    private function getFromWxServer()
    {
        $token = curl_get($this->tokenUrl);
        $token = json_decode($token, true);
        if (!$token)
        {
            throw new Exception('获取AccessToken异常');
        }
        if(!empty($token['errcode'])){
            throw new Exception($token['errmsg']);
        }
        // 保存到缓存
        $this->saveToCache($token);
        return $token['access_token'];
    }

    // 保存到缓存
    private function saveToCache($token){
        cache(self::TOKEN_CACHED_KEY, $token, self::TOKEN_EXPIRE_IN);
    }

    //    private function accessIn
}