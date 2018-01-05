<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3 0003
 * Time: 下午 9:45
 */

namespace app\api\model;


use think\Model;

class Userhuati extends Model
{

    // 关联->userinfo
    public function userinfo()
    {
        return $this->hasOne('userinfo', 'user_id', 'user_id');
    }

    // 关联->huati表
    public function userhuatiToHuati()
    {
        return $this->hasOne('huati', 'id', 'huati_id');
    }

}