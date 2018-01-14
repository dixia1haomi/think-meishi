<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/11 0011
 * Time: 上午 9:30
 */

namespace app\api\model;


use think\Model;

class Liuyan extends Model
{
    protected $hidden = ['delete_time', 'update_time'];

    // 关联->userinfo(只要昵称，头像绑定到调用它的表上-餐厅Model/liuyan（）调用)
    public function liuyanuserinfo()
    {
        return $this->hasOne('userinfo', 'user_id', 'user_id')->bind(['nick_name','avatar_url']);
    }


    // 关联->canting(只要餐厅名)
    public function canting()
    {
        return $this->hasOne('canting', 'id', 'canting_id')->bind(['name']);
    }
}