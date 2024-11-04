<?php

namespace App\Console;

abstract class BaseProCommand extends BaseCommand
{


    /**
     * 0=成功
     *
     * @return int
     */
    public function handle()
    {
        try{
            $this->infoCommand('开始');
            $result = $this->handlePro()??0;

            $this->infoCommand('结束');

            return $result;
        }catch (\Throwable $throwable){

            $this->errorThrowableCommand($throwable);

        }

        return 1;
    }

    protected abstract function handlePro();

}
