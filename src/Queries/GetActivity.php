<?php

namespace QueueMonitor\Queries;

use Illuminate\Support\Facades\DB;

class GetActivity
{
    public static function query($withSilenced = false, $search = null, $status = null, $jobName = null)
    {
        return DB::table('monitored_queue_jobs')
            ->when($jobName, function ($query, $jobName) {
                return $query->where('job_name', $jobName);
            })
            ->unless($withSilenced, function ($query) {
                $query->whereNotIn('job_name', config('queue_monitor.silenced_jobs'));
            })
            ->when($search, function ($query, $search) {
                return $query->where('job_name', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('started_at', 'desc')
            ->paginate(10);
    }
}