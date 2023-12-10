<?php

namespace Database\Seeders;

use App\Models\Pipeline;
use Illuminate\Database\Seeder;

class ClinectSeeder extends Seeder
{
    public function run(): void
    {
        $pipeline = Pipeline::factory()->create([
            'name' => 'CI',
            'description' => 'Every push to any branch. Run tests, code formating, linting, etc',
        ]);

        $pipeline->steps()->create([
            'name' => 'Run tests',
            'script' => 'php artisan test',
        ]);

        $pipeline->steps()->create([
            'name' => 'Check test code coverage diff',
            'script' => 'echo "Checking code coverage of the PR diff..."',
        ]);

        $pipeline->steps()->create([
            'name' => 'Check test code coverage total',
            'script' => 'echo "Checking code coverage of the entire repo after merge..."',
        ]);

        $pipeline->steps()->create([
            'name' => 'Format code',
            'script' => 'vendor/bin/pint',
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'Deploy export to production',
            'description' => 'When PRs are merged into `main`.',
        ]);

        $pipeline->steps()->create([
            'name' => 'Git checkout latest',
            'script' => 'git clone git@github.com:clinect/export.git',
        ]);

        $pipeline->steps()->create([
            'name' => 'Build release binary',
            'script' => 'cargo build --release --features journald,sentry',
        ]);

        $pipeline->steps()->create([
            'name' => 'Copy binary to PATH',
            'script' => 'cp target/release/clinect-export /usr/bin',
        ]);

        $pipeline->steps()->create([
            'name' => 'Restart service',
            'script' => 'systemctl restart clinect-export',
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'Check disk space',
            'description' => 'Nightly.',
        ]);

        $pipeline->steps()->create([
            'name' => 'Check disk space',
            'script' => 'df -H',
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'System updates',
            'description' => 'Weekends.',
        ]);

        $pipeline->steps()->create([
            'name' => 'Update Ubuntu',
            'script' => 'sudo apt update/nsudo apt upgrade --yes',
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'Install software',
            'description' => 'Nginx, php, etc',
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'File permissions',
            'description' => '`/storage`, etc',
        ]);

        $pipeline->steps()->create([
            'name' => 'Update Ubuntu',
            'script' => "sudo apt update\nsudo apt upgrade --yes",
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'Update `.env` files',
            'description' => 'Find/replace env values',
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'Deploy measure to production',
            'description' => 'When PRs are merged into `main`.',
        ]);

        $step = $pipeline->steps()->create([
            'name' => 'Git checkout latest',
            'script' => 'git clone git@github.com:clinect/api.git',
        ]);

        $pipeline->steps()->create([
            'name' => 'Composer install',
            'script' => 'composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader --ignore-platform-reqs',
        ]);

        $pipeline->steps()->create([
            'name' => 'NPM install',
            'script' => 'npm ci',
        ]);

        $pipeline->steps()->create([
            'name' => 'NPM run build',
            'script' => 'npm run build',
        ]);

        $pipeline->steps()->create([
            'name' => 'Ensure documentation database is writable',
            'script' => 'chmod 0777 database/documentation.sqlite',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache config',
            'script' => 'php artisan config:cache',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache routes',
            'script' => 'php artisan route:cache',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache views',
            'script' => 'php artisan view:cache',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache events',
            'script' => 'php artisan event:cache',
        ]);

        $event = $pipeline->events()->create();

        $event->jobs()->create([
            'pipeline_step_id' => $step->getKey(),
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'Create new customer portal',
            'description' => 'Requires `name` and `branch` arguments.',
        ]);

        // TODO: run task to determine which server
        // has the most available resources on it
        $pipeline->steps()->create([
            'name' => 'Make directory',
            'script' => 'mkdir',
        ]);
        // update nginx config
        // create database and database user with randomized credentials, save these credentials for later in the pipeline
        // add to crontab
        // php artisan key:generate
        // create .env file with newly created database credentials
        // kickoff the deploy pipeline

        $pipeline = Pipeline::factory()->create([
            'name' => 'Get QA blessing before merging',
            'description' => 'Requires `name` and `branch` arguments. Creates new feature portal, halts for approval, then deletes feature portal.',
        ]);

        // TODO: kickoff pipeline for creating a new customer and pass branch name as the <NAME> argument
        // TODO: HALT! wait for approval to continue
        // TODO: kickoff pipeline for decommissioning a customer and pass branch name as the <NAME> argument

        $pipeline = Pipeline::factory()->create([
            'name' => 'Refresh demo data',
            'description' => 'Reseed data for demo environment.',
        ]);

        $pipeline->steps()->create([
            'name' => 'Refresh seeded data',
            'script' => 'php artisan migrate:fresh --seed',
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'Deploy engage to production',
            'description' => 'When PRs are merged into `main`.',
        ]);

        $pipeline->steps()->create([
            'name' => 'Git checkout latest',
            'script' => 'git clone git@github.com:clinect/forms-engine.git',
        ]);

        $pipeline->steps()->create([
            'name' => 'Composer install',
            'script' => 'composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader --ignore-platform-reqs',
        ]);

        $pipeline->steps()->create([
            'name' => 'NPM install',
            'script' => 'npm ci',
        ]);

        $pipeline->steps()->create([
            'name' => 'NPM run build',
            'script' => 'npm run build',
        ]);

        $pipeline->steps()->create([
            'name' => 'Ensure documentation database is writable',
            'script' => 'chmod 0777 database/documentation.sqlite',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache config',
            'script' => 'php artisan config:cache',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache routes',
            'script' => 'php artisan route:cache',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache views',
            'script' => 'php artisan view:cache',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cache events',
            'script' => 'php artisan event:cache',
        ]);
    }
}
