<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Agent;
use App\Models\PipelineJob;
use Laravel\Sanctum\Sanctum;
use App\Events\PipelineJobStarted;
use App\Events\PipelineJobFinished;
use App\Events\PipelineJobReserved;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PipelineJobTest extends TestCase
{
    use RefreshDatabase;

    public function testJobReserved(): void
    {
        Event::fake([PipelineJobReserved::class]);
        PipelineJob::factory()->create();
        Sanctum::actingAs(
            Agent::factory()->create(),
            ['reserve-job']
        );

        $response = $this->postJson(route('api.pipeline-jobs.reserve'));

        $response->assertOk();
        Event::assertDispatched(PipelineJobReserved::class);
    }

    public function testJobStarted(): void
    {
        Event::fake([PipelineJobStarted::class]);
        $job = PipelineJob::factory()->create();
        Sanctum::actingAs(
            Agent::factory()->create(),
            ['update-job']
        );

        $response = $this->postJson(route('api.pipeline-jobs.update', ['job' => $job]), [
            'started_at' => now(),
        ]);

        $response->assertOk();
        Event::assertDispatched(PipelineJobStarted::class);
    }

    public function testJobFinished(): void
    {
        Event::fake([PipelineJobFinished::class]);
        $job = PipelineJob::factory()->create();
        Sanctum::actingAs(
            Agent::factory()->create(),
            ['update-job']
        );

        $response = $this->postJson(route('api.pipeline-jobs.update', ['job' => $job]), [
            'finished_at' => now(),
        ]);

        $response->assertOk();
        Event::assertDispatched(PipelineJobFinished::class);
    }
}
