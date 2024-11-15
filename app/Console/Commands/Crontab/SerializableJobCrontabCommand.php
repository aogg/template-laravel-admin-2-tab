<?php

namespace App\Console\Commands\Crontab;

use App\Console\BaseProCommand;
use Illuminate\Support\Facades\Redis;

class SerializableJobCrontabCommand extends BaseProCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crontab:SerializableJob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '队列-执行序列化-通过crontab';

    #[\Override] protected function handlePro()
    {

        while ($data = Redis::client()->lPop('crontab:SerializableJob')){
            $this->infoLog('运行一次job');
            $startTime = microtime(true);

            $data = json_decode($data, true);

            if (empty($data)) {
                $this->alterLog([
                    '队列-json_decode 空',
                ]);
                continue;
            }

            if (empty($data['SerializableClosure'])) {
                $this->alterLog([
                    '队列-结构异常SerializableClosure',
                ]);
                continue;
            }
            try{

                /** @var \Opis\Closure\SerializableClosure $wrapper */
                $wrapper = unserialize($data['SerializableClosure']);
                if (empty($wrapper) || !($wrapper instanceof \Opis\Closure\SerializableClosure)) {
                    $this->alterLog([
                        '队列-反序列化--失败',
                    ]);
                    continue;
                }

                if ($wrapper->getClosure()($data) === false) {
                    $data['run_num'] += 1;
                    Redis::client()->rPush('crontab:SerializableJob', $data);
                }

            }catch (\Throwable $throwable){
                $this->errorThrowableLog($throwable, ['队列--异常']);
                $data['throwable'] = get_exception_laravel_array($throwable);
                $data['last_run_time'] = datetime();

                Redis::client()->rPush('crontab:SerializableJob', $data);
            }

            $this->infoLog([
                '运行一次job--结束',
                '时间秒' => round(microtime(true) - $startTime, 4),
                'push_time' => data_get($data, 'push_time'),
            ]);
        }
        ;

    }

    public static function pushJob($func)
    {
        $str = new \Opis\Closure\SerializableClosure($func);
        return Redis::client()->rPush('crontab:SerializableJob', json_encode([
            'SerializableClosure' => serialize($str),
            'push_time' => datetime(),
            'run_num' => 1, // 1开始
        ]));

    }

}
