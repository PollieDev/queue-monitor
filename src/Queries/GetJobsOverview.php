<?php

namespace QueueMonitor\Queries;

use Illuminate\Support\Facades\DB;

class GetJobsOverview
{

    public static function query()
    {
        $results = DB::select("
            SELECT 
            t1.job_name, 
            t1.status, 
            t1.connection,
            t1.queue,
            t1.max_tries,
            t2.processed, 
            t2.processing, 
            t2.failed, 
            t2.avg_time, 
            t2.avg_attempts, 
            t2.last_started_at 
            FROM monitored_queue_jobs t1
            INNER JOIN (
                SELECT 
                job_name,
                SUM( CASE WHEN `status` = 'processed' then 1 else 0 END ) as processed,
                SUM( CASE WHEN `status` = 'processing' then 1 else 0 END ) as processing,
                SUM( CASE WHEN `status` = 'failed' then 1 else 0 END ) as failed,
                AVG( finished_at - started_at ) as avg_time,
                AVG( attempts ) as avg_attempts,
                MAX( started_at ) as last_started_at
                FROM monitored_queue_jobs
                GROUP BY job_name
            ) t2 ON t1.job_name = t2.job_name AND t1.started_at = t2.last_started_at
            ORDER BY t1.job_name
        ");

        $silencedJobs = config('queue_monitor.silenced_jobs');

        foreach ($results as $result) {
            $result->silenced = in_array($result->job_name, $silencedJobs);
        }

        return $results;
    }

}