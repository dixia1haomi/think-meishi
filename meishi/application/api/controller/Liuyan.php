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


    // 删除留言（客户端未开放使用，admin先用）
    public function deleteLiuyan(){
        $uid = BaseToken::get_Token_Uid();
//        $uid = input('post.uid');
        $post_id = input('post.id');

        $liuyanModel = new liuyanModel();

        // 自己才可以删除自己的数据（uid=user_id,证明是自己的，防止直接恶意调用api）
        $data = $liuyanModel->get($post_id);
        if(!$data){throw new QueryDbException(['msg'=>'删除留言时查询留言失败,可能已经删除，没有这条数据']);}

        // 如果留言数据的user_id不等于uid，不是自己的，可能是恶意调用，抛出异常.
        if($data['user_id'] != $uid){
            throw new QueryDbException(['msg'=>'这条数据不是你的.']);
        }

        // 执行删除
        $delete = $liuyanModel->destroy($post_id);
        if(!$delete){
            throw new QueryDbException(['msg'=>'删除留言失败']);
        }
        return $delete;

    }


}