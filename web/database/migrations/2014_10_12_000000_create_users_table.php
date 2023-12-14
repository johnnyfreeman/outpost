<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->string('name');
            $table->string('avatar');
            $table->string('github_id');
            $table->string('github_token');
            $table->string('github_refresh_token');
            $table->timestamps();
        });
    }
};
