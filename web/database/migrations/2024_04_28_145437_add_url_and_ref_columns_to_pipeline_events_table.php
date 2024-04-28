<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumns('pipeline_events', ['url', 'ref'])) {
            Schema::table('pipeline_events', function (Blueprint $table) {
                $table->string('url')->nullable();
                $table->string('ref')->nullable();
            });
        }
    }
};
