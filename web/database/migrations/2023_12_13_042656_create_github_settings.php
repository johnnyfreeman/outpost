<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('github_settings', function (Blueprint $table) {
            $table->ulid('id')->unique();
            $table->foreignUlid('pipeline_id')->references('id')->on('pipelines');
            $table->boolean('trigger_on_push')->default(false);
            $table->boolean('filter_enabled')->default(false);
            $table->string('filter_condition')->default('');
            $table->boolean('skip_builds_for_existing_commits')->default(false);
            $table->boolean('build_pull_requests')->default(false);
            $table->boolean('pull_request_branch_filter_enabled')->default(false);
            $table->boolean('pull_request_branch_filter_configuration')->default(false);
            $table->boolean('skip_pull_request_builds_for_existing_commits')->default(false);
            $table->boolean('build_pull_request_ready_for_review')->default(false);
            $table->boolean('build_pull_request_labels_changed')->default(false);
            $table->boolean('build_pull_request_forks')->default(false);
            $table->boolean('prefix_pull_request_fork_branch_names')->default(false);
            $table->boolean('build_branches')->default(false);
            $table->boolean('build_tags')->default(false);
            $table->boolean('cancel_deleted_branch_builds')->default(false);
            $table->boolean('publish_commit_status')->default(false);
            $table->boolean('publish_blocked_as_pending')->default(false);
            $table->boolean('publish_commit_status_per_step')->default(false);
            $table->boolean('separate_pull_request_statuses')->default(false);
        });
    }
};
