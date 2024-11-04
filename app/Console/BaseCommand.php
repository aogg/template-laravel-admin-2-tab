<?php

namespace App\Console;

class BaseCommand extends \Illuminate\Console\Command
{
    public function infoLog($message)
    {
        $message = is_string($message)?(datetime() . ' ' . $message):json_encode($message, JSON_UNESCAPED_UNICODE);
        $this->output->info($message);

        \App\Tools\Common\LogDailyManager::logDaily($message, class_basename($this), 'info', 'command');
    }

    public function alterLog($message)
    {
        $message = is_string($message)?(datetime() . ' ' . $message):json_encode($message, JSON_UNESCAPED_UNICODE);
        $this->output->warning($message);

        \App\Tools\Common\LogDailyManager::logDailyAlert($message, class_basename($this), 'command');
    }

    public function errorLog($message)
    {
        $message = is_string($message)?(datetime() . ' ' . $message):json_encode($message, JSON_UNESCAPED_UNICODE);
        $this->output->error($message);

        \App\Tools\Common\LogDailyManager::logDailyError($message, class_basename($this), 'command');
    }

    /**
     * @param \Throwable $throwable
     * @param $moreData
     * @return void
     */
    public function errorThrowableLog($throwable, $moreData = [])
    {

        $this->output->error(json_encode([$moreData, get_exception_laravel_array($throwable)], JSON_UNESCAPED_UNICODE));

        \App\Tools\Common\LogDailyManager::logDailyException($moreData, $throwable, class_basename($this), 'command');

    }

}
