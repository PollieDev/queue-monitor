<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monitored_queue_jobs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->string('job_name');
            $table->json('payload')->nullable();
            $table->integer('max_tries')->nullable();
            $table->integer('delay')->nullable();
            $table->integer('timeout')->nullable();
            $table->bigInteger('retry_until')->nullable();
            $table->integer('attempts');
            $table->string('connection');
            $table->string('queue');
            $table->json('exception')->nullable();
            $table->integer('pending_jobs');
            $table->string('hostname');
            $table->string('php');
            $table->bigInteger('started_at')->nullable();
            $table->bigInteger('finished_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitored_queue_jobs');
    }
};
