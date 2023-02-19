<?php

namespace QueueMonitor;

use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Bus\BatchRepository;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Notifications\SendQueuedNotifications;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\Arr;
use QueueMonitor\Helpers\ExtractTags;

class QueueMonitorData
{
    protected $event;

    public static function make($event)
    {
        return new static($event);
    }

    public function __construct(object $event)
    {
        $this->event = $event;
    }

    public function getData()
    {
        $job = $this->event->job;
        $payload = $job->payload();

        $data = [
            'id' => $payload['queue_monitor_id'],
            'status' => $this->getStatus(),
            'job_name' => $job->resolveName(),
            'payload' => json_encode($payload),
            'max_tries' => $payload['maxTries'] ?? null,
            'delay' => $payload['delay'] ?? null,
            'timeout' => $payload['timeout'] ?? null,
            'retry_until' => $payload['retryUntil'] ?? null,
            'attempts' => $job->attempts(),
            'connection' => $job->getConnectionName(),
            'queue' => $job->getQueue(),
            'exception' => $this->getException(),
            'pending_jobs' => $this->getQueueSize(),
            'hostname' => gethostname(),
            'php' => phpversion()
        ];

        if ($this->getStatus() === 'processing') {
            $data['started_at'] = (int) now()->getPreciseTimestamp(3);
        } else {
            $data['finished_at'] = (int) now()->getPreciseTimestamp(3);
        }

        return $data;
    }

    protected function getStatus(): string
    {
        if ($this->event instanceof JobProcessing)
            return 'processing';

        if ($this->event instanceof JobProcessed)
            return 'processed';

        if ($this->event instanceof JobFailed)
            return 'failed';

        return '?';
    }

    public function getQueueSize()
    {
        return app()
            ->make(QueueManager::class)
            ->connection($this->event->job->getConnectionName())
            ->size();
    }

    public function getException()
    {
        if (!property_exists($this->event, 'exception')) {
            return null;
        }

        return [
            'name' => get_class($this->event->exception),
            'message' => $this->event->exception->getMessage(),
            'file' => str_replace(base_path(), '', $this->event->exception->getFile()),
            'line' => $this->event->exception->getLine(),
            'trace' => str_replace(base_path(), '', $this->event->exception->getTraceAsString()),
        ];
    }
}
