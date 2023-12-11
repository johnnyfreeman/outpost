<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid();
            $table->string('name');
            $table->string('github_id');
            $table->string('github_token');
            $table->string('github_refresh_token');
            $table->timestamps();
        });
    }
};
