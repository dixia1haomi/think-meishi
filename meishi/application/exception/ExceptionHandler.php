<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/11 0011
 * Time: 上午 8:37
 */

namespace app\exception;

use think\Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    //自定义异常Handle里的render方法
    public function render(\Exception $e)
    {
        if($e instanceof BaseException){
            //如果是BaseException类型异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;

        }else{
            // 配置中debug开启时，调用父类render方法返回原始页面异常，生产模式下返回自定义render
            if(config('app_debug')){
               return parent::render($e);
            }else{
                $this->code = 999;
                $this->msg = '服务器内部错误，来自自定义Exception的render方法内';
                $this->errorCode = 999;
                //记录日志
                $this->recordErrorLog($e);
            }
        }

        $result = [
            'code' => $this->code,
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'exception_url' => Request::instance()->url()
        ];

        return json($result,$this->code);
    }

    //记录日志的方法
    protected function recordErrorLog(\Exception $e){
        Log::init([
            'type'  => 'file',
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(),'error');
    }
}