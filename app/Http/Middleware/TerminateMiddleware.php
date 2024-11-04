<?php

namespace App\Http\Middleware;

use App\Tools\Common\LogDailyManager;

/**
 * @see fastcgi_finish_request
 */
class TerminateMiddleware
{
    public function handle(\Illuminate\Http\Request $request, \Closure $next)
    {
        return $next($request);
    }

    /**
     * @see \Illuminate\Foundation\Http\Kernel::terminate
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function terminate($request, $response)
    {

        try{

            event('terminate');
        }catch (\Throwable $throwable){
            LogDailyManager::logDailyException(['terminate异常', $request->all()], $throwable);
        }

    }

}
