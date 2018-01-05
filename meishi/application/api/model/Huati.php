<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3 0003
 * Time: 下午 9:45
 */

namespace app\api\model;


use think\Model;

class Huati extends Model
{
    // 关联->user话题表
    public function userhuati()
    {
        return $this->hasMany('userhuati', 'huati_id', 'id');
    }

}