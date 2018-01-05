<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/15 0015
 * Time: 下午 6:00
 */

return [

    //微信获取openid配置信息
    'appid' => 'wxc5c3c565cfe8cf9f',
    'secret' => '8707a374776462e19c26a84295bff185',
    'login_url' => 'https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code',

    //token过期时间
    'token_expire' => 7200,

    //token->key的加密 盐
    'token_salt' => 'dixia2haomi'
];