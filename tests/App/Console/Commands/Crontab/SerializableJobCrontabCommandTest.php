<?php

namespace App\Console\Commands\Crontab;


class SerializableJobCrontabCommandTest extends \Tests\TestCase
{

    public static function testPushJob()
    {
        $func = function (){
            echo time();

            return 11;
        };
        $a = \App\Console\Commands\Crontab\SerializableJobCrontabCommand::pushJob($func);

        var_dump($a);

        self::assertIsInt($a);

    }

    public static function test__SerializableJobCrontabCommand()
    {
        static::testPushJob();

        static::commandRun(\App\Console\Commands\Crontab\SerializableJobCrontabCommand::class);
        self::assertTrue(true);

    }
}
