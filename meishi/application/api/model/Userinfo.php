<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/30 0030
 * Time: 上午 4:05
 */

namespace app\api\model;


use think\Model;

class Userinfo extends Model
{
    protected $hidden = ['delete_time', 'update_time','city'];

    // 根据uid检查是否有info，没有则新增
    public static function uidCheckInfo($uid, $post)
    {
        // post数据
        $nickName = $post["nickName"];
        $avatarUrl = $post["avatarUrl"];
        $city = $post["city"];
        $gender = $post["gender"];

        $data = self::get(['user_id' => $uid]);
        if (!$data) {
            $data = self::create(['user_id' => $uid, 'nick_name' => $nickName, 'avatar_url' => $avatarUrl, 'city' => $city, 'gender' => $gender]);
        }
        return $data;
    }

    // 检查info的nickname,avatar_url,不一样就更新
    public static function checkInfo($data, $post)
    {
        // post数据
        $nickName = $post["nickName"];
        $avatarUrl = $post["avatarUrl"];
        $city = $post["city"];
        $gender = $post["gender"];

        if ($post["nickName"] === $data["nick_name"] && $post["avatarUrl"] === $data["avatar_url"]) {
            return $data;
        }

        $update = self::update(['nick_name' => $nickName, 'avatar_url' => $avatarUrl, 'city' => $city, 'gender' => $gender], ['id' => $data->id]);
        return $update;
    }


}