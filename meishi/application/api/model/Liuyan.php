<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/11 0011
 * Time: 上午 9:30
 */

namespace app\api\model;


use app\exception\Success;
use think\Cache;
use think\Model;

class Liuyan extends Model
{
//    protected $hidden = ['delete_time', 'update_time'];

    // 关联->userinfo(只要昵称，头像绑定到调用它的表上-餐厅Model/liuyan（）调用)
    public function liuyanuserinfo()
    {
        return $this->hasOne('userinfo', 'user_id', 'user_id')->bind(['nick_name','avatar_url']);
    }


    // 关联->canting(只要餐厅名)
    public function canting()
    {
        return $this->hasOne('canting', 'id', 'canting_id')->bind(['name']);
    }


    // 新增留言 || redis
    public static function createLiuyan_Model($params){

        $data = self::create($params);
        if(!$data){
            // ******mysql新增留言失败，日志，返回
        }

        // 删除redis中餐厅详情
        $id = $params['canting_id'];
        $cantingDetail = Cache::rm('cantingDetail-'.$id);
        if(!$cantingDetail){
            // ****** redis删除餐厅详情失败，记录日志
        }

        // 删除redis中餐厅列表(不需要删除餐厅列表，因为列表不显示留言的数据)
//        $cantingList = Cache::rm('cantingList');
//        if(!$cantingList){
//            // ****** redis删除餐厅列表失败，记录日志
//        }

        throw new Success(['data'=>$data]);
    }
}