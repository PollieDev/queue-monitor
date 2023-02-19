<?php

return [
    'enabled' => env('QUEUE_MONITOR_ENABLED', true),

    'queues' => [
        'default'
    ],

    'silenced_jobs' => [
        'App\\Jobs\\YeeterJob'
    ]
];
