<?php

namespace Database\Seeders;

use App\Models\Pipeline;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $pipeline = Pipeline::factory()->create([
            'name' => 'CI',
            'description' => 'Every push to any branch. Run tests, code formating, linting, etc',
        ]);

        $pipeline->steps()->create([
            'name' => 'Cargo check',
            'script' => <<<'SCRIPT'
                cargo check
                SCRIPT,
        ]);

        $pipeline->steps()->create([
            'name' => 'Cargo fmt',
            'script' => <<<'SCRIPT'
                cargo fmt
                SCRIPT,
        ]);

        $pipeline->steps()->create([
            'name' => 'Cargo clippy',
            'script' => <<<'SCRIPT'
                cargo clippy
                SCRIPT,
        ]);

        $pipeline->steps()->create([
            'name' => 'Info',
            'script' => <<<'SCRIPT'
                pwd
                ls -al
                SCRIPT,
        ]);

        $pipeline->steps()->create([
            'name' => 'Format code',
            'current_directory' => '/home/john/projects/bilbo/web',
            'script' => <<<'SCRIPT'
                vendor/bin/pint
                SCRIPT,
        ]);

        $pipeline->steps()->create([
            'name' => 'NPM (re)Install',
            'current_directory' => '/home/john/projects/bilbo/web',
            'script' => <<<'SCRIPT'
                rm -rf node_modules
                npm install
                SCRIPT,
        ]);

        $pipeline = Pipeline::factory()->create([
            'name' => 'System Update',
            'description' => 'Updates OS',
        ]);

        $pipeline->steps()->create([
            'name' => 'Apt upgrade/update',
            'script' => <<<'SCRIPT'
                sudo apt update
                sudo apt upgrade -y
                SCRIPT,
        ]);
    }
}
