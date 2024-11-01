<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;

/**
 * @see app/Providers/EventServiceProvider.php
 *
     protected $listen = [
        \Illuminate\Database\Events\QueryExecuted::class => [
            \App\Listeners\SqlLogListener::class,
        ],
    ];
 */

/**
 * @see config/logging.php
 *
        'sql_log' => [
            'driver' => 'daily',
            'path' => storage_path('logs/sql/sql.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
            'replace_placeholders' => true,
        ],
 */

/**
 * 记录sql
 */
class SqlLogListener
{



    /**
     * Handle the event.
     *
     * @param QueryExecuted $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        if (!config('app.debug')) { // debug不记录
            return;
        }
        Log::driver("sql_log")->debug($event->sql, ['binding' => $event->bindings, 'time' => $event->time]);

    }
}
