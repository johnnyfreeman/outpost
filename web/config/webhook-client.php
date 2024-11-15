<?php

use App\Jobs\ProcessGithubWebhookJob;
use App\Webhooks\GithubSignatureValidator;

return [
    'configs' => [
        [
            'name' => 'github',
            'signing_secret' => env('GITHUB_WEBHOOK_SECRET'),
            'signature_header_name' => 'X-Hub-Signature-256',
            'signature_validator' => GithubSignatureValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'store_headers' => [
                'X-GitHub-Event',
            ],
            'process_webhook_job' => ProcessGithubWebhookJob::class,
        ],
    ],

    /*
     * The integer amount of days after which models should be deleted.
     *
     * 7 deletes all records after 1 week. Set to null if no models should be deleted.
     */
    'delete_after_days' => 30,
];
