<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pipeline extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'name',
        'description',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(PipelineStep::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(PipelineEvent::class);
    }

    public function latestEvent(): HasOne
    {
        return $this->hasOne(PipelineEvent::class)
            ->latestOfMany();

    }

    public function githubSettings(): HasOne
    {
        return $this->hasOne(GithubSetting::class);

    }

    public function run(string $description = null): Collection
    {
        $event = $this->events()->create([
            'description' => $description,
        ]);

        return $this->steps->map(fn ($step) => $step->jobs()->create([
            'pipeline_event_id' => $event->getKey(),
        ]));
    }
}
