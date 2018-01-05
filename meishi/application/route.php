<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//Route::rule('路由表达式','路由地址','请求类型','路由参数（数组）','变量规则（数组）');


use think\Route;

// 餐厅
Route::post('api/canting/list', 'api/canting/getList');                       // 获取餐厅列表 shoucangCantingList
Route::post('api/canting/shoucanglist', 'api/canting/shoucangCantingList');   // 获取收藏的餐厅列表（我的-我的收藏使用）
Route::post('api/canting/detail', 'api/canting/getDetail');                   // 获取餐厅详细信息
Route::post('api/canting/createCanting', 'api/canting/createCanting');        // 新增餐厅
Route::post('api/canting/updateCanting', 'api/canting/updateCanting');        // 更新餐厅
Route::post('api/canting/deleteCanting', 'api/canting/deleteCanting');        // 删除餐厅
Route::post('api/canting/zan', 'api/canting/dianzanCanting');                 // 点赞餐厅+1

// 菜品
Route::post('api/caipin/createcaipin', 'api/caipin/createCaipin');    // 新增菜品
Route::post('api/caipin/updateCaipin', 'api/caipin/updateCaipin');    // 更新菜品
Route::post('api/caipin/deleteCaipin', 'api/caipin/deleteCaipin');    // 删除菜品

// 环境
Route::post('api/huanjing/createhuanjing', 'api/huanjing/createHuanjing');    // 新增环境
Route::post('api/huanjing/updatehuanjing', 'api/huanjing/updateHuanjing');    // 更新环境
Route::post('api/huanjing/deletehuanjing', 'api/huanjing/deleteHuanjing');    // 删除环境

// 文章
Route::post('api/wenzhang/createwenzhang', 'api/wenzhang/createWenzhang');    // 新增文章
Route::post('api/wenzhang/updatewenzhang', 'api/wenzhang/updateWenzhang');    // 更新文章
Route::post('api/wenzhang/deletewenzhang', 'api/wenzhang/deleteWenzhang');    // 删除文章


// cos
Route::post('api/cos/qianmingdanci', 'api/cos/cosQianMingDanci');   // COS签名-单次
Route::post('api/cos/qianmingduoci', 'api/cos/cosQianMingDuoci');   // COS签名-多次
Route::post('api/cos/delete', 'api/cos/cosdelete');                 // 删除


// Token
Route::post('api/token/gettoken', 'api/token/getToken');   // 获取Token
Route::post('api/token/verify','api/token/verifyToken');   // 检查Token是否有效


// User
Route::post('api/user/login', 'api/user/userLogin');             // 用户登陆（获取userInfo）
Route::post('api/user/huati', 'api/user/userHuatiList');         // 获取用户参与的话题列表


// 话题
Route::post('api/huati/create', 'api/huati/createHuati');             // 新增话题（admin）
Route::post('api/huati/update', 'api/huati/updateHuati');             // 更新话题（admin）
Route::post('api/huati/delete', 'api/huati/deleteHuati');             // 删除话题（admin）
Route::post('api/huati/createhuati', 'api/huati/createUserHuati');     // 用户参与话题
Route::post('api/huati/deletehuati', 'api/huati/deleteUserHuati');     // 删除用户参与的话题（admin）
Route::post('api/huati/list', 'api/huati/getHuatiList');              // 查询话题列表
Route::post('api/huati/detail', 'api/huati/getHuatiDetail');          // 查询话题内容


