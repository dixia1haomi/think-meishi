<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/24 0024
 * Time: 下午 5:17
 */

namespace app\api\model;


use think\Model;

class Canting extends Model
{
    protected $hidden = ['delete_time', 'update_time', 'create_time'];

    // 获取餐厅列表(where条件)
    public static function cantingList($post)
    {
        $data = self::where($post)->select();
        return $data;
    }


    // 获取餐厅详细信息：关联->菜品，环境，文章
    public static function cantingDetail($id)
    {
        $data = self::with(['caipin', 'huanjing', 'wenzhang'])->find($id);
        return $data;
    }

    // 新增餐厅
    public static function createCanting($param)
    {
        $data = self::create($param);
        return $data;
    }

    // 更新餐厅
    public static function updateCanting($param)
    {
        $data = self::update($param);
        return $data;
    }

    // 删除餐厅


    // 关联->菜品
    public function caipin()
    {
        return $this->hasMany('caipin', 'canting_id', 'id');
    }

    // 关联->环境
    public function huanjing()
    {
        return $this->hasMany('huanjing', 'canting_id', 'id');
    }

    // 关联->文章
    public function wenzhang()
    {
        return $this->hasMany('wenzhang', 'canting_id', 'id');
    }

}




