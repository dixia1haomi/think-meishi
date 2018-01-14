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
    // 关闭时间日期自动输出（客户端需要：月-日），直接返回时间戳客户端处理
//    protected $dateFormat = false;

    // 关联->user话题表
    public function userhuati()
    {
        return $this->hasMany('userhuati', 'huati_id', 'id');
    }

}