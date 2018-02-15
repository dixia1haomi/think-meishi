<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/11 0011
 * Time: 上午 9:30
 */

namespace app\api\model;


use app\exception\QueryDbException;
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
    public function cantingname()
    {
        return $this->hasOne('canting', 'id', 'canting_id')->bind(['name']);
    }

    // 关联->userinfo
//    public function userinfo()
//    {
//        return $this->hasOne('userinfo', 'user_id', 'user_id');
//    }




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


    // 查询留言分页列表（根据餐厅ID,客户端餐厅详情页-查看全部留言）
    public static function liuyanList_Model($post_id,$post_page){


        $data = self::where('canting_id',$post_id)->with(['liuyanuserinfo'])->order('create_time desc')->page($post_page,20)->select();
        if(!$data){
            // ****** 查询留言分页列表失败，日志，返回
        }
        throw new Success(['data'=>$data]);
//        $count = $liuyanModel->where('canting_id',$post_id)->count();
//        if(!$data || !$count){
//            throw new QueryDbException(['msg'=>' 根据餐厅ID查询留言列表失败，Liuyan/liuyanList()']);
//        }
//        $res['data'] = $data;
//        $res['count'] = $count;
//        return $res;
    }


    // 查询我的留言（接受uid,分页20条）
    public static function getMyLiuyan_Model($uid,$post_page){

        // 根据uid查留言分页20条关联餐厅名
        $data = self::where('user_id',$uid)->with(['cantingname'])->order('create_time desc')->page($post_page,20)->select();
        // 根据uid统计有多少条留言
        $count = self::where('user_id',$uid)->count();
        // 查询失败
        if($data === false && $count === false){
            throw new QueryDbException(['errorCode'=>1,'msg'=>'查询我的留言失败，Liuyan/getMyLiuyan()']);
        }
        // 拼接数据
        $res['data'] = $data;
        $res['count'] = $count;
        // 成功返回
        throw new Success(['data' => $res]);
    }
}