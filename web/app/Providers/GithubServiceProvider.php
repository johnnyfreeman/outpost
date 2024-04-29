<?php

namespace App\Providers;

use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Http\Integrations\Github\GithubConnector;
use Illuminate\Contracts\Support\DeferrableProvider;
use App\Http\Integrations\Github\Requests\CreateAppInstallionAccessTokenRequest;

class GithubServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->bind(GithubConnector::class, function ($app) {
            if (is_string($token = $app['cache']->get('github:access_token'))) {
                return new GithubConnector($token);
            }

            $connector = new GithubConnector(
                token: $jwt = JWT::encode([
                    'iss' => $app['config']->get('services.github.id'),
                    'iat' => now()->timestamp,
                    'exp' => now()->addMinutes(5)->timestamp,
                ], config('services.github.private_key'), 'RS256'),
            );
            $response = $connector->send(new CreateAppInstallionAccessTokenRequest(
                installation: 44973831,
            ));

            Log::debug('Generating GitHub access token', [
                'jwt' => $jwt,
                'response' => $response,
            ]);

            $app['cache']->put(
                'github:access_token',
                $token = (string) $response->json('token'),
                new Carbon((string) $response->json('expires_at')),
            );

            return new GithubConnector($token);
        });
    }

    public function provides(): array
    {
        return [GithubConnector::class];
    }
}
