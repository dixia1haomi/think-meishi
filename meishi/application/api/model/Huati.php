<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3 0003
 * Time: 下午 9:45
 */

namespace app\api\model;


use app\exception\Success;
use think\Cache;
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


    // 更新话题，Huati表（admin）|| redis
    public static function updateHuati_Model($post)
    {
        $data = self::update($post);
        if(!$data){
            // ****** 更新失败，日志，返回错误码
        }
        // 更新成功，删除redis相应数据
        // 删除话题列表
        $huatiList = Cache::rm('huatiList');
        if(!$huatiList){
            // ****** 删除redis话题列表失败，日志，返回错误码
        }
        // 返回
        throw new Success(['data'=>$data]);

    }


    // 查询话题列表,Huati表（话题页）|| redis
    public static function getHuatiList_Model()
    {
        // 先查redis
        $huatiList = cache('huatiList');
        if(!$huatiList){
            // 如果redis里没有数据，查mysql
            $data = self::with(['userhuati'])->select();
            if(!$data){
                // ****** 从mysql里查询话题列表失败，记录日志，返回错误码
            }
            // 写入redis
            $cache = cache('huatiList',$data);
            if(!$cache){
                // ****** 写入redis失败，记录日志，返回错误码
            }
            // 返回
            throw new Success(['data'=>$data]);
        }else{
            // 如果redis有数据，直接返回
            throw new Success(['data'=>$huatiList]);
        }

    }


    // 新增话题 || redis
    public static function createHuati_Model($post){

        $data = self::create($post);
        if (!$data) {
            // ****** mysql新增失败，日志
        }
        // 删除redis话题列表数据
        $huatiList = Cache::rm('huatiList');
        if(!$huatiList){
            // ****** 删除redis失败，日志
        }
        // 返回
        throw new Success(['data'=>$data]);
    }


}