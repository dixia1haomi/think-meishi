﻿<?php
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
Route::post('api/canting/detail', 'api/canting/getDetail');                   // 获取餐厅详细信息，接受餐厅表ID
Route::post('api/canting/createCanting', 'api/canting/createCanting');        // 新增餐厅
Route::post('api/canting/updateCanting', 'api/canting/updateCanting');        // 更新餐厅
Route::post('api/canting/deleteCanting', 'api/canting/deleteCanting');        // 删除餐厅
Route::post('api/canting/zan', 'api/canting/dianzanCanting');                 // 点赞餐厅+1


// 留言
Route::post('api/liuyan/list', 'api/liuyan/liuyanList');                // 查询留言列表（根据餐厅ID）
Route::post('api/liuyan/create', 'api/liuyan/createLiuyan');            // 新增留言（接受餐厅id,留言内容,uid内部获取）
//Route::post('api/liuyan/myliuyan', 'api/liuyan/getMyLiuyan');           // 查询我的留言（根据uid-客户端我的页-我的留言）
Route::post('api/liuyan/delete', 'api/liuyan/deleteLiuyan');            // 删除留言（内部获取uid，接受id-客户端我的页-我的留言）



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
Route::post('api/token/verify', 'api/token/verifyToken');   // 检查Token是否有效

Route::post('api/token/app', 'api/token/getAppToken');    //第三方登录获取token


// User
Route::post('api/user/login', 'api/user/userLogin');             // 用户登陆（获取userInfo）
Route::post('api/user/huati', 'api/user/userHuatiList');         // 获取用户参与的话题列表
Route::post('api/user/check', 'api/user/uidCheckInfo');          // 根据uid检查userinfo表中是否有用户信息
//Route::post('api/user/all', 'api/user/userWithAll');             // userWithAll
Route::post('api/user/myliuyan', 'api/user/getMyLiuyan');        // 查询我的留言（根据uid-客户端我的页-我的留言）
Route::post('api/user/myhuati', 'api/user/getMyHuati');          // 查询我的话题（根据uid查询）（我的页-我的话题）


// 话题
//Route::post('api/huati/create', 'api/huati/createHuati');             // 新增话题（admin）
//Route::post('api/huati/update', 'api/huati/updateHuati');             // 更新话题（admin）
//Route::post('api/huati/delete', 'api/huati/deleteHuati');             // 删除话题（admin）
//Route::post('api/huati/list', 'api/huati/getHuatiList');              // 查询话题列表（话题页）
//Route::post('api/huati/createhuati', 'api/huati/createUserHuati');    // 用户参与话题,新增user话题（话题页-点击话题进入话题详情页）
//Route::post('api/huati/detail', 'api/huati/getHuatiDetail');          // 查询话题内容（根据话题ID）（话题页-点击话题进入话题详情页）查询关联的所有数据
//Route::post('api/huati/deletehuati', 'api/huati/deleteUserHuati');    // 删除用户参与的话题（admin，客户端暂不开放）



// 客服
Route::get('api/kefu/getkefu', 'api/kefu/getKefu');             // *客服接口  gzh_accsee_token
Route::post('api/kefu/gzhacc', 'api/Kefu/gzh_accsee_token');
Route::post('api/kefu/code', 'api/Kefu/jiemi_opencard_code');

// 卡劵
Route::post('api/kajuan/select', 'api/Kajuan/select_Kajuan');                             // 查询优惠商家列表
Route::post('api/kajuan/find', 'api/Kajuan/find_Kajuan');                                 // 查询指定卡劵(客户端卡劵页用，接受卡劵ID)
Route::post('api/kajuan/shengyushuliang', 'api/Kajuan/update_shengyushuliang');           // 更新卡劵剩余数量
Route::post('api/kajuan/code', 'api/Kajuan/jiemi_code');                                  // 解密wx.addCard成功后返回的code(接受加密code,用于wx.openCard)
Route::post('api/kajuan/signature', 'api/Kajuan/get_kajuan_signature');                   // 获取卡劵signature（后续用于调用wx.addcard）
Route::post('api/kajuan/log', 'api/Kajuan/user_card_log');                                // 卡劵领取记录(接受卡劵ID)


// 测试专用
Route::post('api/ceshi/index', 'api/ceshi/index');
//cardExt
//:
//"{"timestamp": "1517986420", "signature":"6fee520ff3f6df19002ab42a02a502abaca8339d"}"
//cardId
//:
//"pQ7pM1gccLWeQjOBkDN60PxClnFQ"
//code
//:
//"bhCeO1eaJaTF1GgpVPxIn8ckYFjmp9Brs0iQRU07iqc="
//isSuccess
//:
//true