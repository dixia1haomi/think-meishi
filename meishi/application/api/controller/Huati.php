<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3 0003
 * Time: 下午 9:09
 */

namespace app\api\controller;

use app\api\model\Huati as huatiModel;
use app\api\model\Userhuati as userhuatiModel;
use app\api\service\BaseToken;
use app\exception\QueryDbException;
use app\exception\Success;

class Huati
{
    // -------------------------------------------话题------------------------------------------------------
    // 新增话题，Huati表（admin）|| redis
    public function createHuati()
    {
        // 新增话题删除redis话题列表数据

        // 接受title,miaoshu
        $post = input('post.');
        huatiModel::createHuati_Model($post);
    }


    // 更新话题，Huati表（admin）|| redis
    public function updateHuati()
    {
        // 接受话题ID，更新的内容
        $post = input('post.');
        huatiModel::updateHuati_Model($post);
    }


    // 删除话题，Huati表（admin）## 删除前应先删除话题下的用户记录 || ****redis
    public function deleteHuati()
    {
        // *权限 为管理员才能删除

        // 接受话题ID
        $post_id = input('post.id');
        $data = huatiModel::destroy($post_id);
        if (!$data) {
            throw new QueryDbException(['msg' => '删除话题失败，Huati/deleteHuati']);
        }
        return $data;
    }


    // 查询话题列表,Huati表（话题页） || redis
    public function getHuatiList()
    {
        // 关联查询话题的参与条数
        huatiModel::getHuatiList_Model();
    }


    // 查询话题详情,Huati表->关联userHuati表（话题页-点击一个话题进入话题详情页）|| 分页太复杂放弃redis
    public function getHuatiDetail()
    {
        // 接受话题ID，关联userhuati表
        $post_id = input('post.id');

        $huatiModel = new huatiModel();

        $data = $huatiModel->with(['userhuati' => function ($query) {
            $post_page = input('post.page');
            $query->with('userinfo')->order('create_time desc')->page($post_page, 20);
        }])->withCount(['userhuati'])->find($post_id);


        if (!$data) {
            // ****** 日志
            throw new QueryDbException(['msg' => '查询话题下的所有留言，Huati/getHuatiDetail']);
        }

        throw new Success(['data'=>$data]);
    }




    // userHuati表，新增，用户参与话题（话题详情页）
    public function createUserHuati()
    {
        // 接受用户ID(Token)，## 话题ID，内容(post)
        $uid = BaseToken::get_Token_Uid();
        $post = input('post.');
        $post['user_id'] = $uid;
        $data = userhuatiModel::create($post);
        if (!$data) {
            throw new QueryDbException(['msg' => '用户参与话题失败，Huati/createUserHuati']);
        }
        return $data;
    }





    // 查询我的话题（根据uid查询->关联话题表，要话题名）（排序-根据创建时间，分页-20条）（我的页-我的话题）
//    public function getMyHuati()
//    {
//        $uid = BaseToken::get_Token_Uid();
//        $post_page = input('post.page');
//
//        $userModel = new userhuatiModel();
//
//        $data = $userModel->where('user_id', $uid)->with(['userhuatiToHuati'])->order('create_time desc')->page($post_page, 20)->select();
//        $count = $userModel->where('user_id', $uid)->count();
//        if (!$data || !$count) {
//            throw new QueryDbException(['msg' => '查询我的话题失败，Huati/getMyHuati()']);
//        }
//        $res['data'] = $data;
//        $res['count'] = $count;
//        return $res;
//
//    }


    // userHuati表，删除用户参与的(我的话题)（客户端暂时不开放，验证数据是不是自己的，admin）
    public function deleteUserHuati()
    {
        // 接受userhuati表id
        $uid = BaseToken::get_Token_Uid();
        $post_id = input('post.id');

        // 自己才可以删除自己的数据（uid=user_id,证明是自己的，防止直接恶意调用api）
        $data = userhuatiModel::get($post_id);
        if (!$data) {
            throw new QueryDbException(['msg' => '删除用户参与的话题时查询数据失败,可能已经删除，没有这条数据']);
        }

        // 如果话题数据的user_id不等于uid，不是自己的，可能是恶意调用，抛出异常.
        if ($data['user_id'] != $uid) {
            throw new QueryDbException(['msg' => '这条数据不是你的.']);
        }

        // 执行删除
        $delete = userhuatiModel::destroy($post_id);
        if (!$delete) {
            throw new QueryDbException(['msg' => '删除用户参与的话题失败，Huati/deleteUserHuati']);
        }
        return $delete;

    }
}