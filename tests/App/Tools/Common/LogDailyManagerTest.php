<?php

namespace Tests\App\Tools\Common;

use PHPUnit\Framework\TestCase;

class LogDailyManagerTest extends TestCase
{

    public static function testLog_push_daily_exception()
    {
        try{
            [][1];
        }catch (\Throwable $throwable){

        }

        \App\Tools\Common\LogDailyManager::log_push_daily_exception('主动异常', $throwable);
        self::assertIsObject($throwable);
        self::assertTrue(true);


    }
}
