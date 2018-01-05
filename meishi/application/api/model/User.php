<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28 0028
 * Time: 下午 6:39
 */

namespace app\api\model;


use think\Model;

class User extends Model
{
    //查询用户是否存在，通过openid查询
    public static function getByOpenid($openid){
        return self::where('openid','=',$openid)->find();
    }

    //新增用户,返回id
    public static function create_user($openid){
        $user = self::create(['openid'=>$openid]);
        return $user->id;
    }



    // 关联->userhuati表
    public function userToUserhuati()
    {
        return $this->hasMany('userhuati', 'user_id', 'id');
    }
}