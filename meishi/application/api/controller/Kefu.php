<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/7 0007
 * Time: 下午 1:33
 */

namespace app\api\controller;



use think\Exception;

class Kefu
{

    // 客服消息，上线后测试......
    // http://www.cnblogs.com/objects/p/7889088.html
//    public function getKefu()
//    {
//
//        $signature = $_GET["signature"];
//        $timestamp = $_GET["timestamp"];
//        $nonce = $_GET["nonce"];
//
//        $token = 'dixia2haomi';
//        $tmpArr = array($token, $timestamp, $nonce);
//        sort($tmpArr, SORT_STRING);
//        $tmpStr = implode( $tmpArr );
//        $tmpStr = sha1( $tmpStr );
//
//        if( $tmpStr == $signature ){
//            // 此处不加这个配置不成功，加了可以配置成功，后续的接受微信数据一直测试不成功，上线后再测试
//            // ob_clean();
//            echo $_GET["echostr"];
//        }else{
//            return false;
//        }
//
//    }




}