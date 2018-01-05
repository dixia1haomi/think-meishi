<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/25 0025
 * Time: 上午 1:21
 */

namespace app\api\controller;

use app\api\model\Huanjing as huanjingModel;
use app\exception\QueryDbException;

class Huanjing
{
    // 新增环境
    public function createHuanjing()
    {
        // canting_id由后台组织到post里一起传来
        $param = input('post.');
        // 参数验证（*）
        $data = huanjingModel::createHuanjing($param);
        if($data === false){
            throw new QueryDbException();
        }
        return $data;
    }


    // 更新环境
    public function updateHuanjing(){
        $param = input('post.');
        // 参数验证（*）

        // 参数中必须有id
        $data = huanjingModel::updateHuanjing($param);
        if ($data === false) {
            throw new QueryDbException();
        }
        return $data;
    }


    // 删除环境
    public function deleteHuanjing(){
        $id = input('post.id');
        // 参数验证（*）

        $data = huanjingModel::destroy($id);
        if ($data === 0) {
            throw new QueryDbException();
        }
        return $data;
    }

}