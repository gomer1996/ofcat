<?php

namespace App\Integrations\Relef;

use Illuminate\Support\Facades\Http;

class SyncRelefProducts
{
    /**
     * Prune the stale attachments from the system.
     *
     * @return void
     */
    public function __invoke()
    {
        Http::get('https://webhook.site/c33e6a41-77db-4314-886f-ff23f3b6c48b');
    }
}
