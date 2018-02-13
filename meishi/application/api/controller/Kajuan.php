<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9 0009
 * Time: 上午 9:02
 */

namespace app\api\controller;

use app\api\model\Kajuan as KajuanModel;
use app\api\model\Usercardlog;
use app\api\service\BaseToken;
use app\api\service\kajuan\CheckCardDetail;
use app\api\service\kajuan\GzhAccseeToken;
use app\api\service\kajuan\JiemiCode;
use app\api\service\kajuan\Ticket;
use app\exception\QueryDbException;
use app\exception\Success;
use think\Exception;


class Kajuan
{

    // 查询卡劵列表(客户端index页用)
    public function select_Kajuan(){
        KajuanModel::select_Kajuan_Model();
    }


    // 查询指定卡劵(客户端卡劵页用，接受卡劵ID(表id))
    public function find_Kajuan(){
        // 卡劵ID
        $id = input('post.card_id');
        KajuanModel::find_Kajuan_Model($id);
    }


    // 获取卡劵signature（后续用于调用wx.addcard）
    public function get_kajuan_signature(){
        // 获取card_id
        $card_id = input('post.card_id');

        // 获取公众号accsee_Token
        $gzh_accsee = new GzhAccseeToken();
        $gzh_accsee_token = $gzh_accsee->get();

        // 获取ticket
        $ticketM = new Ticket($gzh_accsee_token);
        $ticket = $ticketM->get();

        // 签名
        $timestamp = time();

        $sign['api_ticket'] = $ticket;
        $sign['timestamp'] = $timestamp;
        $sign['card_id'] = $card_id;

        // 组装参数（数组的每一项作为字符串处理）
        asort($sign, SORT_STRING);
        // 拼接
        $sortString = "";
        foreach($sign as $temp){
            $sortString = $sortString.$temp;
        }
        // sha1加密
        $signature = sha1($sortString);
        // 返回要用的数据
        $cardArry = array(
            'timestamp' => $sign['timestamp'],
            'signature' => $signature,
            'cardId' => $sign['card_id'],
//            'ticket' => $sign['api_ticket'],
        );
        return $cardArry;
    }



    // 用户领取成功后 -> 调用微信API获取当前卡劵详细信息（只取库存） -> 更新卡劵数据库（用于显示还剩多少张）
    public function update_shengyushuliang(){

        // 先查卡劵详细信息（里面包含库存）
        $card_id = input('post.card_id');   // 卡劵ID
        $id = input('post.id');             // 当前领取的卡劵在数据库里的ID

        // 调用微信API获取当前卡劵详细信息
        $checkcard = new CheckCardDetail();
        $card_detail = $checkcard->go($card_id);

        // 取剩余库存(card后面的根据卡型不一样，键也不一样，所以要根据卡型转化后放进去)
        $card_type = $card_detail['card']['card_type'];
        $shengyushuliang = $card_detail['card'][strtolower($card_type)]['base_info']['sku']['quantity'];    // strtolower该函数将传入的字符串参数所有的字符都转换成小写,并以小定形式放回这个字

        // 更新剩余数量
        KajuanModel::update_Kajuan_Shengyushuliang_Model($id,$shengyushuliang);
    }


    // 用户领取成功后 -> 接受加密code
    public function jiemi_code(){

        $code = input('post.code');

        // new解密类 -> go方法解密
        $jiemicode = new JiemiCode();
        $jiemi_code = $jiemicode->go($code);
        return $jiemi_code;
    }


    // 卡劵领取记录(接受卡劵ID)
    public function user_card_log(){
        // uid,card_id
        $uid = BaseToken::get_Token_Uid();
        $card_id = input('post.card_id');

        // 写入记录
        $data = Usercardlog::create(['user_id'=>$uid,'card_id'=>$card_id]);
        if(!$data){
            // ******写入失败记录日志
            throw new QueryDbException(['msg'=>'asdasd']);
        }
        throw new Success();
    }


    // 我的卡劵（查询用户名下已领取的所有卡劵,用于客户端调用后打开卡包）需要UID
//    public function my_kajuan(){
//        // 用户ID
//        $uid = BaseToken::get_Token_Uid();
//
//        // 查询数据库
//        $usercard = new Usercard();
//        $data = $usercard->where('user_id',$uid)->select();
//
//        if(!$data){
//            throw new QueryDbException(['msg'=>'查询用户名下已领取的所有卡劵失败，kajuan/my_kajuan']);
//        }
//        return $data;
//    }



}