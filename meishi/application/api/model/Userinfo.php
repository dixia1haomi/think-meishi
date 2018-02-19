<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30 0030
 * Time: 上午 4:05
 */

namespace app\api\model;


use app\api\service\BaseToken;
use app\exception\QueryDbException;
use app\exception\Success;
use think\Model;

class Userinfo extends Model
{
//    protected $hidden = ['delete_time', 'update_time'];




    // 根据uid检查是否有info，没有则新增
//    public static function uidCheckInfo($uid, $post)
//    {
//        // post数据
//        $nickName = $post["nickName"];
//        $avatarUrl = $post["avatarUrl"];
//        $city = $post["city"];
//        $gender = $post["gender"];
//
//        $data = self::get(['user_id' => $uid]);
//        if (!$data) {
//            $data = self::create(['user_id' => $uid, 'nick_name' => $nickName, 'avatar_url' => $avatarUrl, 'city' => $city, 'gender' => $gender]);
//        }
//        return $data;
//    }

    // 检查info的nickname,avatar_url,不一样就更新
//    public static function checkInfo($data, $post)
//    {
//        // post数据
//        $nickName = $post["nickName"];
//        $avatarUrl = $post["avatarUrl"];
//        $city = $post["city"];
//        $gender = $post["gender"];
//
//        if ($post["nickName"] === $data["nick_name"] && $post["avatarUrl"] === $data["avatar_url"]) {
//            return $data;
//        }
//
//        $update = self::update(['nick_name' => $nickName, 'avatar_url' => $avatarUrl, 'city' => $city, 'gender' => $gender], ['id' => $data->id]);
//        return $update;
//    }

    /**
     *  未记录日志
     *  未理过逻辑
     */


    // 根据uid检查userinfo表中是否有用户信息(有：返回errorCode = 0和查到的用户信息,没有：返回errorCode=1)
    public static function uidCheckInfo($uid){
        // 查询数据库
        $data = self::where('user_id',$uid)->find();

        if(!$data){
            throw new QueryDbException(['msg' => '根据uid检查userinfo表中是否有用户信息失败，User/uidCheckInfo','errorCode'=>1]);
        }

        throw new Success(['data'=>$data]);
    }


    // 用户登陆 post == userinfo
    public static function login($uid,$post){
        // 查询数据库
        $find = self::where('user_id',$uid)->find();

        if(!$find){
            // 没有查到，新增返回0
            self::createUserInfo($uid,$post);
        }else{
            // 查到，对比，一样返回0，不一样，更新返回0
            if ($find["nick_name"] === $post["nickName"] && $find["avatar_url"] === $post["avatarUrl"] && $find["city"] === $post["city"] && $find["gender"] === $post["gender"])
            {
                throw new Success();
            }else{
                // 不一样，更新
                self::updateUserInfo($find["id"],$post);
            }
        }
    }

    // 新增用户信息
    public static function createUserInfo($uid,$post){
        // post数据
        $res = [
            'user_id' => $uid,
         'nick_name' => $post["nickName"],
        'avatar_url' => $post["avatarUrl"],
        'city' => $post["city"],
        'gender' => $post["gender"],
        ];

        $data = self::create($res);

        // 这里应该抛出写入错误日志的错误
        if($data === false){
            Log::mysql_log('mysql/User/createUserInfo','新增用户信息失败');
        }
        throw new Success();
    }

    // 更新用户信息
    public static function updateUserInfo($id,$post){
        // post数据
        $res = [
            'id' => $id,
            'nick_name' => $post["nickName"],
            'avatar_url' => $post["avatarUrl"],
            'city' => $post["city"],
            'gender' => $post["gender"],
        ];

        $data = self::update($res);

        // 这里应该抛出写入错误日志的错误
        if($data === false){
            Log::mysql_log('mysql/User/updateUserInfo','更新用户信息失败');
        }
        throw new Success();
    }


    // 查询用户信息（接受uid）
//    public static function userWithAll_Model($uid){
////        $data = self::where('user_id',$uid)->withCount(['userhuati','userliuyan'])->find();
//        $data = self::where('user_id',$uid)->find();
//        if(!$data){
//            // ****** 查询失败，日志，返回错误码
//        }
//        throw new Success(['data'=>$data]);
//    }

    // userinfo关联->userhuati
    public function userhuati()
    {
        return $this->hasMany('userhuati', 'user_id', 'user_id');
    }

    // userinfo关联->liuyan
    public function userliuyan()
    {
        return $this->hasMany('liuyan', 'user_id', 'user_id');
    }

}