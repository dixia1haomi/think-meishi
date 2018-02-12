<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/24 0024
 * Time: 下午 5:17
 */

namespace app\api\model;


use app\exception\Success;
use think\Model;

class Canting extends Model
{
//    protected $hidden = ['delete_time', 'update_time', 'create_time'];

    // 获取餐厅列表(where条件)
    public static function cantingList($post)
    {

        // 没有where条件的先从redis获取
        if(!$post){
            $cantingList = cache('cantingList');
            // 缓存中没有餐厅列表,去数据库获取后再缓存
            if(!$cantingList){
                $data = self::select();
                if(!$data){
                    // *如果从数据库获取失败，记录日志
                }
                // 获取成功，缓存
                $cache = cache('cantingList',json_encode($data));
                if(!$cache){
                    // *如果缓存失败，记录日志
                }
                // 返回客户端
                throw new Success(['data'=>$data]);
            }else{
                // 缓存中有cantingList，直接返回
                throw new Success(['data'=>json_decode($cantingList,true)]);
            }
        }else{
            // 有where条件，查数据库
            $data = self::where($post)->select();
            if(!$data){
                // *如果从数据库获取失败，记录日志返回错误码
            }
            throw new Success(['data'=>$data]);
        }
    }


    // 获取餐厅详细信息：关联->留言，文章 || Redis
    public static function cantingDetail($id)
    {
        // 先从redis获取
        $cantingDetail = cache('cantingDetail-'.$id);
        // 缓存中没有,去数据库获取后再缓存
        if(!$cantingDetail){
            // 从数据库获取
            $data = self::with(['liuyan','wenzhang'])->find($id);
            if(!$data){
                // *如果从数据库获取失败，记录日志
            }
            // 缓存
            $cache = cache('cantingDetail-'.$id,json_encode($data));
            if(!$cache){
                // *如果缓存失败，记录日志
            }
            throw new Success(['data'=>$data]);
        }else{
            throw new Success(['data'=>json_decode($cantingDetail,true)]);
        }

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
//    public function caipin()
//    {
//        return $this->hasMany('caipin', 'canting_id', 'id');
//    }
//
//    // 关联->环境
//    public function huanjing()
//    {
//        return $this->hasMany('huanjing', 'canting_id', 'id');
//    }

    // 关联->文章
    public function wenzhang()
    {
        return $this->hasOne('wenzhang', 'canting_id', 'id');
    }

    // 关联->留言->关联userinfo
    public function liuyan()
    {
        return $this->hasMany('liuyan', 'canting_id', 'id')->order('create_time desc')->limit(5)->with(['liuyanuserinfo']);
    }

}




