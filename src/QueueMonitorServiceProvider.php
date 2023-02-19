<?php

namespace QueueMonitor;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class QueueMonitorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'queue_monitor');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/queue_monitor.php' => config_path('queue_monitor.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../public' => public_path('vendor/queue_monitor'),
            ], 'assets');
        }

        Queue::createPayloadUsing(function ($connection, $queue, $payload) {
            return array_merge($payload, [
                'queue_monitor_id' => Str::uuid(),
            ]);
        });

        Event::subscribe(QueueMonitorEventsSubscriber::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/queue_monitor.php', 'queue_monitor');
    }
}
