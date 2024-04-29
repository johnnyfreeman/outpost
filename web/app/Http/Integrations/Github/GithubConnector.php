<?php

namespace App\Http\Integrations\Github;

use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class GithubConnector extends Connector
{
    use AlwaysThrowOnErrors;

    public function __construct(
        protected readonly string $token,
    ) {
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.github.com';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'X-GitHub-Api-Version' => '2022-11-28',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }
}
