<?php

namespace QueueMonitor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use QueueMonitor\Queries\GetActivity;
use QueueMonitor\Queries\GetJobsOverview;

class DashboardController extends Controller
{
    public function home()
    {
        $timestampPastHour = now()->subHour()->getPreciseTimestamp(3);
        $timestampToday = now()->startOfDay()->getPreciseTimestamp(3);

        $jobsPastHour = DB::table('monitored_queue_jobs')->where('started_at', '>', $timestampPastHour)->count();
        $jobsPerMin = $jobsPastHour / 60;

        $failedJobsToday = DB::table('monitored_queue_jobs')->where('status', 'failed')->where('started_at', '>', $timestampToday)->count();

        $queues = collect(config('queue_monitor.queues'))->map(function($q) use ($timestampPastHour) {
            return [
                'name' => $q,
                'queued' => Queue::size($q),
                'processed' => DB::table('monitored_queue_jobs')->where('queue', $q)->where('started_at', '>', $timestampPastHour)->where('status', 'processed  ')->count(),
                'failed' => DB::table('monitored_queue_jobs')->where('queue', $q)->where('status', 'failed')->where('started_at', '>', $timestampPastHour)->count(),
            ];
        });

        return inertia('Dashboard', compact('jobsPastHour', 'jobsPerMin', 'failedJobsToday', 'queues'));
    }

    public function jobs()
    {
        return inertia('Jobs', [
            'title' => 'Queued Jobs',
            'filters' => true,
            'jobs' => GetJobsOverview::query()
        ]);
    }

    public function activity(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $withSilenced = $request->get('with-silenced');

        return inertia('Activity', [
            'title' => 'Activity',
            'filters' => true,
            'jobs' => GetActivity::query($withSilenced, $search, $status)
        ]);
    }

    public function activityDetails(string $id)
    {
        $job = DB::table('monitored_queue_jobs')->where('id', $id)->first();

        return inertia('ActivityDetails', [
            'title' => 'Activity Details',
            'job' => $job,
        ]);
    }
}