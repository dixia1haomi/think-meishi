<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28 0028
 * Time: 下午 6:39
 */

namespace app\api\controller;

use app\api\model\User as userModel;
use app\api\service\BaseToken;
use app\api\model\Userinfo as infoModel;
use app\exception\QueryDbException;

class User
{
    // 用户登陆
    public function userLogin()
    {
        $uid = BaseToken::get_Token_Uid();
        $post = input('post.');
        // 查询info表有没有对应的数据(根据uid查询info表user_id)
        // 没有，新增
        $data = infoModel::uidCheckInfo($uid, $post);
        if (!$data) {
            throw new QueryDbException(['msg' => '根据uid检查info表时出错，uidCheckInfo']);
        }
        // 有，对比nickname,url,一样返回.
        // 不一样，更新，返回
        $check = infoModel::checkInfo($data, $post);
        if (!$check) {
            throw new QueryDbException(['msg' => '对比info数据时出错，checkInfo']);
        }
        return $check;
    }



    // 查询用户参与发表的话题（接受uid，客户端-我的-话题）
    public function userHuatiList()
    {
        $uid = BaseToken::get_Token_Uid();
        $userModel = new userModel();

        $data = $userModel->with(['userToUserhuati'=>function($query){
            $query->with(['userhuatiToHuati']);
        }])->find($uid);
        if (!$data) {
            throw new QueryDbException(['msg' => '查询用户参与发表的话题失败，User/userHuatiList']);
        }
        return $data;
    }

}