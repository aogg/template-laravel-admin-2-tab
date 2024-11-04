<?php

namespace App\Tools\Common;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as Monolog;
use Monolog\Processor\PsrLogMessageProcessor;

/**
 * 支持动态日志名
 *
 * @method static \Psr\Log\LoggerInterface driverPath($morePath, $driver = null)
 */
class LogDailyManager extends \Illuminate\Log\LogManager
{
    /**
     * Get a log driver instance.
     * \App\Libs\SysLogManager::app()->driverPath(class_basename($this), 'command')->info($message);
     *
     * @param  string  $morePath
     * @param  string|null  $driver
     * @return \Psr\Log\LoggerInterface
     */
    public function driverPath($morePath, $driver = null)
    {
        $name = $this->parseDriver($driver);
        $config = $this->configurationFor($name);
        if (empty($config['path'])) {
            $config['path'] = storage_path('logs/'.$driver.'.log');
        }
        $config['path'] .= '/' . $morePath . '.log';

        return $this->get($this->parseDriver($driver), $config);
    }

    /**
     * @return $this
     */
    public static function app()
    {
        if (!app()->has('sysLog')) {
            app()->singleton('sysLog', fn($app) => new static($app));
        }

        return app('sysLog');
    }


    ########################## 静态入口 ########################## ########################## ##########################


    /**
     * 每日数据
     *
     * @param string|array|\Throwable $message
     */
    public static function logDaily($message, $morePath = null, $level = 'info', $driver = 'daily_all'){
        $morePath = $morePath??static::get_debug_backtrace_name();

        $unsetArr = [];
        if (is_array($message)) {
            $unsetArr = $message['$unsetArr'];
            unset($message['$unsetArr']);
        }

        event('LogDailyManager', [
            $message,
            $morePath, $level, $driver,
            $unsetArr
        ]);

        $message = json_encode($message, JSON_UNESCAPED_UNICODE);

        if ($level === 'info') {
            static::app()->driverPath($morePath, $driver)->info($message);
        }else{
            static::app()->driverPath($morePath, $driver)->$level($message);
        }
    }

    /**
     * 告警
     *
     * @param $message
     * @param $morePath
     * @param $driver
     * @param $level
     * @return void
     */
    public static function logDailyAlert($message, $morePath = null, $driver = 'daily_all', $level = 'alter')
    {
        static::logDaily($message, $morePath, $level, $driver);
    }

    public static function logDailyError($message, $morePath = null, $driver = 'daily_all', $level = 'error')
    {
        static::logDaily($message, $morePath, $level, $driver);
    }

    public static function logDailyException($message, $exception, $morePath = null, $driver = 'daily_all')
    {
        static::logDailyError([
            '$message' => $message,
            '$exception' => get_exception_laravel_array($exception),
            '$unsetArr' => $exception,
        ], $morePath, $driver);
    }

    public static function get_debug_backtrace_name($limit = 3)
    {
        $list = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, $limit);
        $last = $list[count($list) - 1]??[];
        $name =
            (
            data_get($last, 'object')
                ?(basename(str_replace('\\', '/', get_class(data_get($last, 'object')))))
                :basename(str_replace('\\', '/', data_get($last, 'class')?:''))
            )
            . '-' . str_replace(['{', '}', '\\'], ['', '', '_'], data_get($last, 'function'));

        return trim($name, '-');
    }
}
