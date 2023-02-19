<?php

namespace QueueMonitor;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;

class QueueMonitorEventsSubscriber
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            [
                JobProcessing::class,
                JobProcessed::class,
                JobFailed::class,
            ],
            function ($event)
            {
                if (!config('queue_monitor.enabled')) {
                    return;
                }

                if ($event instanceof JobProcessed && $event->job->hasFailed()) {
                    return;
                }

                QueueMonitor::save(QueueMonitorData::make($event)->getData());
            }
        );
    }
}
