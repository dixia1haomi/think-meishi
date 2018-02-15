<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3 0003
 * Time: 下午 9:45
 */

namespace app\api\model;


use app\exception\QueryDbException;
use app\exception\Success;
use think\Model;

class Userhuati extends Model
{
    // 关闭时间日期自动输出（客户端需要：月-日），直接返回时间戳客户端处理
//    protected $dateFormat = false;

    // 关联->userinfo
    public function userinfo()
    {
        return $this->hasOne('userinfo', 'user_id', 'user_id');
    }

    // 关联->huati表
    public function userhuatiToHuati()
    {
        return $this->hasOne('huati', 'id', 'huati_id')->bind(['title']);
    }


    // 查询我的话题（接受uid,分页20条）
    public static function getMyHuati_Model($uid,$post_page){

        // 根据uid查留言分页20条关联餐厅名
        $data = self::where('user_id',$uid)->with(['userhuatiToHuati'])->order('create_time desc')->page($post_page,20)->select();
        // 根据uid统计有多少条留言
        $count = self::where('user_id',$uid)->count();
        // 查询失败
        if($data === false && $count === false){
            throw new QueryDbException(['errorCode'=>1,'msg'=>'查询我的话题失败，Huati/getMyHuati()']);
        }
        // 拼接数据
        $res['data'] = $data;
        $res['count'] = $count;
        // 成功返回
        throw new Success(['data' => $res]);
    }
}