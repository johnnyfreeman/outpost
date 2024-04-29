<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\SoloRequest;
use Saloon\Http\Auth\TokenAuthenticator;

class CreateAppInstallionAccessTokenRequest extends SoloRequest
{
    protected Method $method = Method::POST;

    public function __construct(
        protected readonly string $jwt,
        protected readonly int $installation,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/app/installations/{$this->installation}/access_tokens";
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->jwt);
    }
}
