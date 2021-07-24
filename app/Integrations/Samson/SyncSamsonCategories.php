<?php

namespace App\Integrations\Samson;

use Illuminate\Support\Facades\Http;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class SyncSamsonCategories
{
    private $url = 'https://api.samsonopt.ru/v1/category/?api_key=60769b17043981a854f4d6ac667e5ac5&pagination_count=100';

    /**
     * Prune the stale attachments from the system.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->syncCategories($this->url);
        $this->setParentIds();
    }

    private function syncCategories(string $url)
    {
        $res = Http::get($url);
        $data = $res->json();

        if ($data) {
            foreach ($data["data"] as $category) {
                $found = Category::where(['samson_id' => $category["id"]])->first();

                $body = [
                    "name" => $category["name"],
                    "level" => $category["depth_level"],
                    "samson_id" => $category["id"],
                    "samson_parent_id" => $category["parent_id"]
                ];
                if ($found) {
                    $found->update($body);
                } else {
                    if ($category["photo_list"][0]) {
                        $contents = file_get_contents($category["photo_list"][0]);
                        $img = md5(microtime().$category["id"]).'.jpg';
                        Storage::put('public/categories/'.$img, $contents);
                        $body["img"] = $img;
                    }
                    Category::create($body);
                }
            }
        }

        if (isset($data["meta"]["pagination"]["next"])) {
            $this->syncCategories($data["meta"]["pagination"]["next"]);
        }
    }

    private function setParentIds()
    {
        Category::whereNotNull('samson_id')
            ->chunkById(100, function ($categories) {
                foreach ($categories as $category) {
                    if ($category->samson_parent_id !== 0) {
                        $found = Category::where('samson_id', $category->samson_parent_id)->first();

                        if ($found) {
                            $category->parent_id = $found->id;
                            $category->save();
                        }
                    }
                }
            }, $column = 'id');
    }
}
