<?php

namespace App\Console;

class BaseCommand extends \Illuminate\Console\Command
{
    public function infoLog($message)
    {
        $this->infoCommand($message);
    }

    public function infoCommand($message)
    {
        $message = is_string($message)?(datetime() . ' ' . $message):json_encode($message, JSON_UNESCAPED_UNICODE);
        $this->output->info($message);

        \App\Tools\Common\LogDailyManager::log_daily($message, class_basename($this), 'info', 'command');
    }

    public function alterCommand($message)
    {
        $message = is_string($message)?(datetime() . ' ' . $message):json_encode($message, JSON_UNESCAPED_UNICODE);
        $this->output->warning($message);

        \App\Tools\Common\LogDailyManager::log_daily_alert($message, class_basename($this), 'command');
    }

    public function errorCommand($message)
    {
        $message = is_string($message)?(datetime() . ' ' . $message):json_encode($message, JSON_UNESCAPED_UNICODE);
        $this->output->error($message);

        \App\Tools\Common\LogDailyManager::log_daily_error($message, class_basename($this), 'command');
    }

    /**
     * @param \Throwable $throwable
     * @param $moreData
     * @return void
     */
    public function errorThrowableCommand($throwable, $moreData = [])
    {

        $this->output->error(json_encode([$moreData, get_exception_laravel_array($throwable)], JSON_UNESCAPED_UNICODE));

        \App\Tools\Common\LogDailyManager::log_daily_exception($moreData, $throwable, class_basename($this), 'command');

    }

}
