<?php

namespace App\Integrations\Relef;

use App\Models\IntegrationCategory;
use Illuminate\Support\Facades\Http;

class SyncRelefCategories
{
    private $url = 'https://api-sale.relef.ru/api/v1/sections/2fa5c39d-d2fd-11ea-80c2-30e1715c5317/list';

    /**
     * Prune the stale attachments from the system.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->syncCategories($this->url);
    }

    private function syncCategories(string $url)
    {
        $res = Http::withHeaders([
            'apikey' => 'f9f84dcf7bd647389500dc3ee23d6a25'
        ])->get($url);

        $data = $res->json();

        if ($data) {
            foreach ($data["list"] as $category) {
                $found = IntegrationCategory::where([
                    "integration" => "relef",
                    "outer_id" => $category["guid"]
                ])->first();

                $body = [
                    "name" => $category["name"],
                    "level" => $category["level"],
                    "outer_id" => $category["guid"],
                    "outer_parent_id" => $category["parentGuid"] ?? null,
                    "integration" => "relef"
                ];
                if ($found) {
                    $found->update($body);
                } else {
                    IntegrationCategory::create($body);
                }
            }
        }
    }
}
