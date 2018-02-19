<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25 0025
 * Time: 上午 1:27
 */

namespace app\api\controller;

use app\api\model\Log;
use app\api\model\Wenzhang as wenzhangModel;
use app\exception\QueryDbException;
use app\exception\Success;

class Wenzhang
{
    // 新增文章
    public function createWenzhang()
    {
        // canting_id由后台组织到post里一起传来
        $param = input('post.');
        // 参数验证（*）
        $data = wenzhangModel::createWenzhang($param);
        if($data === false){
            Log::mysql_log('mysql/Wenzhang/createWenzhang','新增文章失败');
        }
        throw new Success(['data'=>$data]);
    }

    // 更新文章
    public function updateWenzhang(){
        $param = input('post.');
        // 参数验证（*）

        // 参数中必须有id
        $data = wenzhangModel::updateWenzhang($param);
        if ($data === false) {
            Log::mysql_log('mysql/Wenzhang/updateWenzhang','更新文章失败');
        }
        throw new Success(['data'=>$data]);
    }


    // 删除文章
    public function deleteWenzhang(){
        $id = input('post.id');
        // 参数验证（*）

        $data = wenzhangModel::destroy($id);
        if ($data === false) {
            Log::mysql_log('mysql/Wenzhang/deleteWenzhang','删除文章失败');
        }
        throw new Success(['data'=>$data]);
    }
}