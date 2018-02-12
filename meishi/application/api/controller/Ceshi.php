<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/12 0012
 * Time: 下午 8:42
 */

namespace app\api\controller;


class Ceshi
{

    public function index(){
//        $a = ['id'=>1,'name'=>2];
////        return $a;
//        $b = json_encode($a);
////        return cache('3',$b);
//         $c = cache('4');
////        return json_decode($c,true);
//        return $c;
        return microtime(true);
    }
}