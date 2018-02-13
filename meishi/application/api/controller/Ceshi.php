<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/12 0012
 * Time: 下午 8:42
 */

namespace app\api\controller;


use think\Cache;

class Ceshi
{

    public function index(){
        $a = ['id'=>1,'name'=>2];

//        return Cache::rm('a');
//    return Cache::set('b',$a);
        $cache = new Cache();
return $cache->set('b',$a);

    }
}