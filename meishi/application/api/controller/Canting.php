<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/27 0027
 * Time: 下午 4:20
 */

namespace app\api\controller;

use app\api\model\Canting as cantingModel;
use app\api\model\Xingping as xingpingModel;
use app\api\service\BaseToken;
use app\exception\QueryDbException;

// ------------
use think\cache\driver\Redis;

class Canting
{



    // 获取餐厅列表(where条件)
    public function getList()
    {
        $post = input('post.');
        $data = cantingModel::cantingList($post);
        if (!$data) {
            throw new QueryDbException();
        }
        return $data;
    }

    // 获取收藏的餐厅列表(我的页面-我的收藏使用)
    public function shoucangCantingList()
    {
        // list 客户端缓存的收藏数组，里面是餐厅ID
        $list = input('post.list');
        $cantingModel = new cantingModel();
        $data = $cantingModel->select($list);
        if (!$data) {
            throw new QueryDbException();
        }
        return $data;
    }

    // 获取餐厅详细信息
    public function getDetail()
    {
        $id = input('post.id');
        $data = cantingModel::cantingDetail($id);
        if (!$data) {
            throw new QueryDbException();
        }
        return $data;
    }

    // 新增餐厅
    public function createCanting()
    {
        $param = input('post.');
        // 参数验证（*）
        $data = cantingModel::createCanting($param);
        if ($data === false) {
            throw new QueryDbException();
        }
        return $data;
    }

    // 更新餐厅
    public function updateCanting()
    {
        $param = input('post.');
        // 参数验证（*）

        // 参数中必须有id
        $data = cantingModel::updateCanting($param);
        if ($data === false) {
            throw new QueryDbException();
        }
        return $data;
    }

    // 删除餐厅 -> 先删除餐厅关联的菜品，环境，文章
    public function deleteCanting()
    {
        $id = input('post.id');
        // 参数验证（*）

        $data = cantingModel::destroy($id);
        if ($data === 0) {
            throw new QueryDbException();
        }
        return $data;
    }


    // 餐厅点赞（由于不对用户做要求，所以没有放到user控制器中，仅餐厅表点赞 +1 ）
    public function dianzanCanting()
    {
        // 接受餐厅ID
        $post_id = input('post.id');
        $cantingModel = new cantingModel();

        $data = $cantingModel->where(['id'=>$post_id])->setInc('zan');
        if(!$data){
            throw new QueryDbException(['msg'=>'餐厅点赞接口写入失败，Canting/dianzanCanting']);
        }
        return $data;
    }


}