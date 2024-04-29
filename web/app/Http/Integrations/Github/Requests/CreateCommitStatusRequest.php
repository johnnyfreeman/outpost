<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Traits\Body\HasJsonBody;
use App\Http\Integrations\Github\CommitStatus;

class CreateCommitStatusRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $owner,
        protected readonly string $repo,
        protected readonly string $ref,
        protected readonly CommitStatus $commitStatus,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/repos/{$this->owner}/{$this->repo}/statuses/{$this->ref}";
    }

    protected function defaultBody(): array
    {
        return (array) $this->commitStatus;
    }
}
