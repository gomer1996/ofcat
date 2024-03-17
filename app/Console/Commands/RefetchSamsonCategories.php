<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RefetchSamsonCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:refetch-samson-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categories = Category::where('level', '!=', 4)->where('img', null)->whereNotNull('samson_id')->get();

        $res = Http::get('https://api.samsonopt.ru/v1/category/?api_key=e6f2f9ce0d1bfe7ed8a1fd8658921470');
        $data = $res->json();
        $affected = [];

        foreach ($categories as $category) {
            $categoryJson = $this->getCategoryFromArray($category->samson_id, $data["data"]);
            if (empty($categoryJson["photo_list"][0])) {
                continue;
            }
            $contents = file_get_contents($categoryJson["photo_list"][0]);
            $img = md5(microtime().$category->id).'.jpg';
            Storage::put('public/categories/'.$img, $contents);
            $category->update(['img' => $img]);
            $affected[] = $category->id;
        }

        $this->info('Affected categories' . implode(',', $affected));
    }

    private function getCategoryFromArray(int $id, array $list): ?array
    {
        $result = null;

        foreach ($list as $item) {
            if ($item["id"] == $id) {
                $result = $item;
            }
        }

        return $result;
    }
}
