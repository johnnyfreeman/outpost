<?php

namespace App\Jobs;

use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class ProcessGithubWebhookJob extends ProcessWebhookJob
{
	public function handle()
	{
		// $this->webhookCall
	}
}
