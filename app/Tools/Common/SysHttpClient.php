<?php

namespace App\Tools\Common;

abstract class SysHttpClient extends HttpClient
{

    protected function init()
    {
        parent::init();

        $this->addMiddleware(function ($next, ...$args){
            try{


                $result = null;
                try{
                    $result = $next(...$args);
                }catch (\Throwable $throwable){

                }

                \App\Tools\Common\LogDailyManager::logDaily([
                    '请求参数和返回结果',
                    '$args' => $args,
                    'class' => get_class($this),
                    'response' => $this->response,
                ], class_basename($this));

                if (!empty($throwable)) {
                    throw $throwable;
                }


                return $result;
            }catch (\Throwable $throwable){
                \App\Tools\Common\LogDailyManager::logDailyException([
                    '请求第三方接口异常',
                    '$requestExceptionMsg' => static::$requestExceptionMsg,
                    '$requestExceptionBody' => static::$requestExceptionBody,
                    'class' => get_class($this),
                    ...$args,
//                    ...compact('url', 'option')
                ], $throwable, class_basename($this));
                ;

                throw $throwable;
            }
        }, 'requestUrl');
    }
}
