<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->string('name');
            $table->timestampsTz();
        });

        Schema::create('pipelines', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestampsTz();
        });

        Schema::create('pipeline_events', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->foreignUlid('pipeline_id')->references('id')->on('pipelines');
            $table->longText('description')->nullable();
            $table->timestampsTz();
        });

        Schema::create('pipeline_steps', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->foreignUlid('pipeline_id')->references('id')->on('pipelines');
            $table->string('name');
            $table->longText('script')->nullable();
            $table->timestampsTz();
        });

        Schema::create('pipeline_jobs', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->foreignUlid('pipeline_step_id')->references('id')->on('pipeline_steps');
            $table->foreignUlid('pipeline_event_id')->references('id')->on('pipeline_events');
            $table->foreignUlid('agent_id')->nullable()->references('id')->on('agents');
            $table->longText('output')->nullable();
            $table->integer('exit_code')->nullable();
            $table->timestampsTz();
            $table->timestampTz('reserved_at')->nullable();
            $table->timestampTz('started_at')->nullable();
            $table->timestampTz('finished_at')->nullable();
        });
    }
};
