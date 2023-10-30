<?php

namespace Database\Seeders;

use App\Models\Pipeline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PipelineSeeder extends Seeder
{
    public function run(): void
    {
        Pipeline::factory()->create([
            'name' => 'CI',
            'description' => 'Every push to any branch. Run tests, code formating, linting, etc'
        ]);

        Pipeline::factory()->create([
            'name' => 'Deploy export to production',
            'description' => 'When PRs are merged into `main`.'
        ]);

        Pipeline::factory()->create([
            'name' => 'Check disk space',
            'description' => 'Nightly.'
        ]);

        Pipeline::factory()->create([
            'name' => 'System updates',
            'description' => 'Weekends.'
        ]);

        Pipeline::factory()->create([
            'name' => 'Install software',
            'description' => 'Nginx, php, etc'
        ]);

        Pipeline::factory()->create([
            'name' => 'File permissions',
            'description' => '`/storage`, etc'
        ]);

        Pipeline::factory()->create([
            'name' => 'Update `.env` files',
            'description' => 'Find/replace env values'
        ]);

        Pipeline::factory()->create([
            'name' => 'Deploy measure to production',
            'description' => 'When PRs are merged into `main`.'
        ]);

        Pipeline::factory()->create([
            'name' => 'Create new customer portal',
            'description' => 'Requires `name` and `branch` arguments.'
        ]);

        Pipeline::factory()->create([
            'name' => 'Create new feature portal',
            'description' => 'Requires `name` and `branch` arguments. Creates new feature portal, halts for approval, then deletes feature portal.'
        ]);

        Pipeline::factory()->create([
            'name' => 'Refresh demo data',
            'description' => 'Reseed data for demo environment.'
        ]);

        Pipeline::factory()->create([
            'name' => 'Deploy engage to production',
            'description' => 'When PRs are merged into `main`.'
        ]);
    }
}
