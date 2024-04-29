<?php

namespace App\Providers;

use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Http\Integrations\Github\GithubConnector;
use App\Http\Integrations\Github\Requests\CreateAppInstallionAccessTokenRequest;

class GithubServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(GithubConnector::class, function ($app) {
            if (is_string($token = $app['cache']->get('github:access_token'))) {
                return new GithubConnector($token);
            }

            $response = (new CreateAppInstallionAccessTokenRequest(
                jwt: $jwt = JWT::encode([
                    'iss' => $app['config']->get('services.github.id'),
                    'iat' => now()->timestamp,
                    'exp' => now()->addMinutes(5)->timestamp,
                ], config('services.github.private_key'), 'RS256'),
                installation: 44973831,
            ))->send();

            Log::debug('Generating GitHub access token', [
                'jwt' => $jwt,
                'response' => $response,
            ]);

            $app['cache']->put(
                'github:access_token',
                $token = $response->json('token'),
                new Carbon($response->json('expires_at')),
            );

            return $token;
        });
    }
}
