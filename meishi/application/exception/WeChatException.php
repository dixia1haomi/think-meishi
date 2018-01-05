<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28 0028
 * Time: 下午 6:33
 */

namespace app\exception;


class WeChatException extends BaseException
{
    public $code = 400;

    public $msg = 'WeChatException';

    public $errorCode = 30000;
}


// 参数错误 $errorCode = 10000

// 数据库错误 $errorCode = 20000

// 微信方面错误 $errorCode = 30000

// Token错误 $errorCode = 40000