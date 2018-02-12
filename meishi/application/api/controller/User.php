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

    // 根据uid检查userinfo表中是否有用户信息,有返回errorCode == 0（app.js初始化时调用）
    public function uidCheckInfo(){

        $uid = BaseToken::get_Token_Uid();

        infoModel::uidCheckInfo($uid);
    }


    // 用户登陆(检查是否有info信息，有再对比，不一样更新，没有新增)（app.js appData.loginState为false时调用）
    public function userLogin()
    {
        $uid = BaseToken::get_Token_Uid();
        $post = input('post.');

        infoModel::login($uid,$post);
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