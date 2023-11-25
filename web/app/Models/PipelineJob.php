<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PipelineJob extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'pipeline_step_id',
        'pipeline_event_id',
        'agent_id',
        'output',
        'exit_code',
        'reserved_at',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'exit_code' => 'integer',
        'reserved_at' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function step(): BelongsTo
    {
        return $this->belongsTo(PipelineStep::class, 'pipeline_step_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(PipelineEvent::class, 'pipeline_event_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function isComplete(): bool
    {
        return ! is_null($this->exit_code);
    }

    public function isFailure(): bool
    {
        return $this->exit_code > 0;
    }

    public function isSuccess(): bool
    {
        return $this->exit_code === 0;
    }

    public function scopeIsAvailable(Builder $query): Builder
    {
        return $query->whereNull('reserved_at');
    }

    public function scopeIsReservedButExpired(Builder $query): Builder
    {
        return $query->whereNotNull('reserved_at')
            ->where('reserved_at', '<=', now()->subHour());
    }

    public function scopeIsNotFinished(Builder $query): Builder
    {
        return $query->whereNull('finished_at');
    }
}
