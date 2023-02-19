<?php

namespace QueueMonitor;

use Illuminate\Support\Facades\DB;

class QueueMonitor
{
    public static function save(array $payload)
    {
        try {
            DB::table('monitored_queue_jobs')
                ->updateOrInsert(['id' => $payload['id']], $payload);
        } catch (\Exception $e) {
            ray($e);
        }
    }
}
