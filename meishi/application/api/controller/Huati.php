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

class Huati
{
    // -------------------------------------------话题------------------------------------------------------
    // 新增话题（admin）
    public function createHuati()
    {
        // 接受title,miaoshu
        $post = input('post.');
        $data = huatiModel::create($post);
        if (!$data) {
            throw new QueryDbException(['msg' => '新增话题失败，Huati/createHuati']);
        }
        return $data;
    }

    // 更新话题（admin）
    public function updateHuati()
    {
        // 接受话题ID，更新的内容
        $post = input('post.');
        $data = huatiModel::update($post);
        if (!$data) {
            throw new QueryDbException(['msg' => '更新话题失败，Huati/updateHuati']);
        }
        return $data;
    }

    // 删除话题（admin）
    public function deleteHuati()
    {
        // 接受话题ID, ## 删除前应先删除话题下的用户记录
        $post_id = input('post.id');
        $data = huatiModel::destroy($post_id);
        if (!$data) {
            throw new QueryDbException(['msg' => '删除话题失败，Huati/deleteHuati']);
        }
        return $data;
    }

    // 删除用户参与的话题（admin）
    public function deleteUserHuati()
    {
        // 接受userhuati表id
        $post_id = input('post.id');
        $data = userhuatiModel::destroy($post_id);
        if (!$data) {
            throw new QueryDbException(['msg' => '删除用户参与的话题失败，Huati/deleteUserHuati']);
        }
        return $data;
    }

    // 用户参与话题
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

    // 查询话题列表
    public function getHuatiList()
    {
        // 关联查询话题的参与条数
        $huatiModel = new huatiModel();
        $data = $huatiModel->with(['userhuati'])->select();
        if (!$data) {
            throw new QueryDbException(['msg' => '查询话题列表失败，Huati/getHuatiList']);
        }
        return $data;
    }

    // 查询话题详情
    public function getHuatiDetail()
    {
        // 接受话题ID，关联userhuati表
        $post_id = input('post.id');
        $huatiModel = new huatiModel();

        $data = $huatiModel->with(['userhuati' => function ($query) {
            $query->with('userinfo');
        }])->find($post_id);

        if (!$data) {
            throw new QueryDbException(['msg' => '查询话题详情失败，Huati/getHuatiDetail']);
        }
        return $data;
    }
}