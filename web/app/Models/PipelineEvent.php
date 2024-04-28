<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PipelineEvent extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'description',
        'url',
        'ref',
    ];

    public function pipeline(): BelongsTo
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(PipelineJob::class);
    }

    public function isComplete(): bool
    {
        return $this->jobs->every->isComplete();
    }

    public function isFailure(): bool
    {
        return $this->jobs->some->isFailure();
    }

    public function isSuccess(): bool
    {
        return $this->jobs->every->isSuccess();
    }
}
