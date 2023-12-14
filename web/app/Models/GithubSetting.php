<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GithubSetting extends Model
{
    use HasFactory;
    use HasUlids;

    public $timestamps = false;

    protected $fillable = [
        'pipeline_id',
        'trigger_on_push',
        'filter_enabled',
        'filter_condition',
        'skip_builds_for_existing_commits',
        'build_pull_requests',
        'pull_request_branch_filter_enabled',
        'pull_request_branch_filter_configuration',
        'skip_pull_request_builds_for_existing_commits',
        'build_pull_request_ready_for_review',
        'build_pull_request_labels_changed',
        'build_pull_request_forks',
        'prefix_pull_request_fork_branch_names',
        'build_branches',
        'build_tags',
        'cancel_deleted_branch_builds',
        'publish_commit_status',
        'publish_blocked_as_pending',
        'publish_commit_status_per_step',
        'separate_pull_request_statuses',
    ];

    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }
}
