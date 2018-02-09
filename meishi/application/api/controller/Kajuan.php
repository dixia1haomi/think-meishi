<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9 0009
 * Time: 上午 9:02
 */

namespace app\api\controller;

use app\api\model\Kajuan as KajuanModel;
use app\api\model\Usercard;
use app\api\service\BaseToken;
use app\api\service\kajuan\CheckCardDetail;
use app\api\service\kajuan\GzhAccseeToken;
use app\api\service\kajuan\JiemiCode;
use app\api\service\kajuan\Ticket;
use app\exception\QueryDbException;
use think\Exception;

class Kajuan
{

    // 查询卡劵列表(客户端index页用)
    public function select_Kajuan(){
        $kajuanModel = new KajuanModel();
        $data = $kajuanModel->where('state',1)->select();
        if(!$data){
            throw new QueryDbException(['msg'=>'查询卡劵列表失败，kajuan/select_kajuan']);
        }
        return $data;
    }


    // 领取卡劵
    public function get_Kajuan(){
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
        $kajuanModel = new KajuanModel();
        $data = $kajuanModel->update(['shengyushuliang'=>$shengyushuliang,'id'=>$id]);
        if(!$data){
            throw new QueryDbException(['msg'=>'更新卡劵数量失败，kajuan/update_shengyushuliang']);
        }
        return $data;
    }


    // 用户领取成功后 -> 储存卡劵信息到用户名下,需要uid，卡劵ID，加密code
    public function create_kajuan_in_user(){
        // 需要uid，卡劵ID，加密code
        $uid = BaseToken::get_Token_Uid();

        $card_id = input('post.cardId');
        $code = input('post.code');

        // 先解密，在储存
        $jiemicode = new JiemiCode();
        $jiemi_code = $jiemicode->go($code);

        // 储存到数据库
        $params = ['user_id'=>$uid,'card_id'=>$card_id,'code'=>$jiemi_code];

        $usercard = new Usercard();
        $data = $usercard->create($params);

        if(!$data){
            throw new QueryDbException(['msg'=>'储存解密后的卡劵信息到用户名下失败，kajuan/create_kajuan_in_user']);
        }

        return $data;
    }


    // 我的卡劵（查询用户名下已领取的所有卡劵,用于客户端调用后打开卡包）需要UID
    public function my_kajuan(){
        // 用户ID
        $uid = BaseToken::get_Token_Uid();

        // 查询数据库
        $usercard = new Usercard();
        $data = $usercard->where('user_id',$uid)->select();

        if(!$data){
            throw new QueryDbException(['msg'=>'查询用户名下已领取的所有卡劵失败，kajuan/my_kajuan']);
        }
        return $data;
    }



}