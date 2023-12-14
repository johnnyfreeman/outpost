<?php

namespace Database\Factories;

use App\Models\PipelineStep;
use App\Models\PipelineEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PipelineJob>
 */
class PipelineJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pipeline_step_id' => PipelineStep::factory(),
            'pipeline_event_id' => PipelineEvent::factory(),
        ];
    }
}
