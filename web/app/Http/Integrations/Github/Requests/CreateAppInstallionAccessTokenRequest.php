<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class CreateAppInstallionAccessTokenRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        protected readonly int $installation,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/app/installations/{$this->installation}/access_tokens";
    }
}
