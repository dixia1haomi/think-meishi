<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/27 0027
 * Time: 下午 6:21
 */

namespace app\api\controller;

use app\api\model\Caipin as caipinModel;
use app\exception\QueryDbException;

class Caipin
{
    // 新增菜品 (废弃)
//    public function createCaipin()
//    {
//        // canting_id由后台组织到post里一起传来
//        $param = input('post.');
//        // 参数验证（*）
//        $data = caipinModel::createCaipin($param);
//        if($data === false){
//            throw new QueryDbException();
//        }
//        return $data;
//    }
//
//
//    // 更新菜品
//    public function updateCaipin(){
//        $param = input('post.');
//        // 参数验证（*）
//
//        // 参数中必须有id
//        $data = caipinModel::updateCaipin($param);
//        if ($data === false) {
//            throw new QueryDbException();
//        }
//        return $data;
//    }
//
//
//    // 删除菜品
//    public function deleteCaipin(){
//        $id = input('post.id');
//        // 参数验证（*）
//
//        $data = caipinModel::destroy($id);
//        if ($data === 0) {
//            throw new QueryDbException();
//        }
//        return $data;
//    }

}