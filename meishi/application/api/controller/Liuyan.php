<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/11 0011
 * Time: 上午 11:34
 */

namespace app\api\controller;

use app\api\model\Liuyan as liuyanModel;
use app\api\service\BaseToken;
use app\exception\QueryDbException;

class Liuyan
{

    // 查询留言列表（根据餐厅ID,客户端餐厅详情页-查看全部留言）
    public function liuyanList(){
        $post_id = input('post.canting_id');
        $post_page = input('post.page');

        $liuyanModel = new liuyanModel();
        $data = $liuyanModel->where('canting_id',$post_id)->with(['liuyanuserinfo'])->order('create_time desc')->page($post_page,20)->select();
        $count = $liuyanModel->where('canting_id',$post_id)->count();
        if(!$data || !$count){
            throw new QueryDbException(['msg'=>' 根据餐厅ID查询留言列表失败，Liuyan/liuyanList()']);
        }
        $res['data'] = $data;
        $res['count'] = $count;
        return $res;
    }


    // 新增留言（客户端餐厅详情页-写留言）
    public function createLiuyan(){
        $uid = BaseToken::get_Token_Uid();
        $params = input('post.');               // 接受餐厅ID，Uid，内容.
        $params['user_id'] = $uid;

        $liuyanModel = new liuyanModel();
        $data = $liuyanModel->create($params);
        if(!$data){
            throw new QueryDbException(['msg'=>'新增留言失败，Liuyan/createLiuyan()']);
        }
        return $data;
    }

    // 查询我的留言（根据uid-客户端我的页-我的留言）(关联餐厅,取餐厅名)（排序-根据创建时间，分页-20条）
    public function getMyLiuyan(){
        $uid = BaseToken::get_Token_Uid();
        $post_page = input('post.page');

        // 根据uid查所有留言
        $liuyanModel = new liuyanModel();

        $data = $liuyanModel->where('user_id',$uid)->with(['canting'])->order('create_time desc')->page($post_page,20)->select();
        $count = $liuyanModel->where('user_id',$uid)->count();
        if(!$data || !$count){
            throw new QueryDbException(['msg'=>'查询我的留言失败，Liuyan/getMyLiuyan()']);
        }
        $res['data'] = $data;
        $res['count'] = $count;
        return $res;
    }


    // 删除留言（admin?）


}