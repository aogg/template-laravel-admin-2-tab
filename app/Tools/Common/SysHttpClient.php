<?php

namespace App\Tools\Common;

abstract class SysHttpClient extends HttpClient
{

    protected function init()
    {
        parent::init();

        $this->addMiddleware(function ($next, ...$args){
            try{

                $result = $next(...$args);


                if (!is_pro()) {
                    \App\Tools\Common\LogDailyManager::log_daily([
                        '$args' => $args,
                        'class' => get_class($this),
                        'response' => $this->response,
                    ], class_basename($this));
                }

                return $result;
            }catch (\Throwable $throwable){
                \App\Tools\Common\LogDailyManager::log_daily_exception([
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
