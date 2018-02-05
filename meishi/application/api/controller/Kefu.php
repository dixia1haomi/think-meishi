<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/3 0003
 * Time: 上午 6:32
 */

namespace app\api\controller;


use app\api\service\AccessToken;
use think\Log;

class Kefu
{

    // 客服消息，上线后测试......
    public function getKefu()
    {

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = 'dixia2haomi';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            // 此处不加这个配置不成功，加了可以配置成功，后续的接受微信数据一直测试不成功，上线后再测试
            // ob_clean();
            echo $_GET["echostr"];
        }else{
            return false;
        }

    }
// http://www.cnblogs.com/objects/p/7889088.html
//        public function getKefu(){
//
//            if (isset($_GET['echostr'])) {
//
//                $this->valid();
//            }else{
//
//                $this->responseMsg();
//            }
//
//        }
//
//        public function valid()
//        {
//            $echoStr = $_GET["echostr"];
//            if($this->checkSignature()){
//                header('content-type:text');
//                echo $echoStr;
//                exit;
//            }else{
//                echo $echoStr.'+++'.'Tokenerr';
//                exit;
//            }
//        }
//
//        //签名校验
//        private function checkSignature()
//        {
//            //微信加密签名
//            $signature = $_GET["signature"];
//            //时间戳
//            $timestamp = $_GET["timestamp"];
//            //随机数
//            $nonce = $_GET["nonce"];
//            //服务端配置的TOKEN
//            $token = 'dixia2haomi';
//            //将token,时间戳,随机数进行字典排序
//            $tmpArr = array($token, $timestamp, $nonce);
//            sort($tmpArr, SORT_STRING);
//            //拼接字符串
//            $tmpStr = implode( $tmpArr );
//            $tmpStr = sha1( $tmpStr );
//
//            if( $tmpStr == $signature ){
//                return true;
//            }else{
//                return false;
//            }
//        }
//
//
//
//    public function responseMsg()
//    {
//        //接收来自小程序的客户消息JSON
//        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//        if (!empty($postStr) && is_string($postStr)){
//
//            //$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
//            $postArr = json_decode($postStr,true);
//            if(!empty($postArr['MsgType']) && $postArr['MsgType'] == 'text'){   //文本消息
//                $fromUsername = $postArr['FromUserName'];   //发送者openid
//                $toUserName = $postArr['ToUserName'];       //小程序id
//                $textTpl = array(
//                    "ToUserName"=>$fromUsername,
//                    "FromUserName"=>$toUserName,
//                    "CreateTime"=>time(),
//                    "MsgType"=>"transfer_customer_service",
//                );
//                exit(json_encode($textTpl));
//            }elseif(!empty($postArr['MsgType']) && $postArr['MsgType'] == 'image'){ //图文消息
//                $fromUsername = $postArr['FromUserName'];   //发送者openid
//                $toUserName = $postArr['ToUserName'];       //小程序id
//                $textTpl = array(
//                    "ToUserName"=>$fromUsername,
//                    "FromUserName"=>$toUserName,
//                    "CreateTime"=>time(),
//                    "MsgType"=>"transfer_customer_service",
//                );
//                exit(json_encode($textTpl));
//            }elseif($postArr['MsgType'] == 'event' && $postArr['Event']=='user_enter_tempsession'){ //进入客服动作
//                    $fromUsername = $postArr['FromUserName'];   //发送者openid
//                    $content = '您好，有什么能帮助你?';
//                    $data=array(
//                        "touser"=>$fromUsername,
//                        "msgtype"=>"text",
//                        "text"=>array("content"=>$content)
//                    );
//                    $json = json_encode($data,JSON_UNESCAPED_UNICODE);  //php5.4+
//
//                    $acc = new AccessToken();
//                    $access_token = $acc->get();
//
//                    /*
//                     * POST发送https请求客服接口api
//                     */
//                    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
//                    //以'json'格式发送post的https请求
//                    $curl = curl_init();
//                    curl_setopt($curl, CURLOPT_URL, $url);
//                    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
//                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
//                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
//                    if (!empty($json)){
//                        curl_setopt($curl, CURLOPT_POSTFIELDS,$json);
//                    }
//                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//                    //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
//                    $output = curl_exec($curl);
//                    if (curl_errno($curl)) {
//                        echo 'Errno'.curl_error($curl);//捕抓异常
//                    }
//                    curl_close($curl);
//                    if($output == 0){
//                        echo 'success';exit;
//                    }
//
//                }else{
//                    exit('aaa');
//                }
//        }else{
//            echo "";
//            exit;
//        }
//    }







}