<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25 0025
 * Time: 上午 12:23
 */

namespace app\api\model;


use think\Model;

class Huanjing extends Model
{
    protected $hidden = ['delete_time', 'update_time', 'create_time', 'canting_id'];

    // 新增环境
    public static function createHuanjing($param)
    {
        $data = self::create($param);
        return $data;
    }

    // 更新环境
    public static function updateHuanjing($param)
    {
        $data = self::update($param);
        return $data;
    }
}