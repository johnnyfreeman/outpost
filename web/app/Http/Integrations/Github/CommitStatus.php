<?php

namespace App\Http\Integrations\Github;

class CommitStatus
{
    public function __construct(
        public readonly string $state,
        public readonly ?string $target_url,
        public readonly ?string $description,
        public readonly string $context,
    ) {
    }
}
