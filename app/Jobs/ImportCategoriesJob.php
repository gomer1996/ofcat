<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\ImportCategoriesQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportCategoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $queue = ImportCategoriesQueue::first();
        if (!$queue) {
            return;
        }
        $dataR = Storage::disk('local')->get('import/' . $queue->url);

        $csvRows = explode(PHP_EOL, $dataR);

        try {
            DB::beginTransaction();
            $this->handleImport($csvRows);
            $queue->message = null;
            $queue->status = 'finished';
            $queue->save();
            DB::commit();
        } catch (\Throwable $E) {
            DB::rollBack();

            $queue->message = $E->getMessage();
            $queue->status = 'failed';
            $queue->save();
        }
    }

    /**
     * @param array $rows
     * @return void
     * @throws \Exception
     */
    private function handleImport(array $rows): void
    {
        if (!$this->validateCsv($rows)) {
            throw new \Exception('Некорректный csv файл.');
        }

        foreach ($rows as $index => $item) {
            if (!$item || $index === 0) {
                continue;
            }
            $params = str_getcsv($item);

            $row = \App\Jobs\ExportCategoriesJob::mapFields($params);

            if ($row["id"] && $row["is_update"] == 0) {
                continue;
            }

            if (!$row["id"]) {
                $this->create($row);
            } else {
                $this->update($row);
            }
        }
    }

    private function update(array $csvJson): void
    {
        $category = Category::find($csvJson["id"]);

        if (!$category) {
            return;
        }

        unset($csvJson["is_update"]);

        $category->name = !empty($csvJson["name"]) ? $csvJson["name"] : $category->name;
        $category->parent_id = !empty($csvJson["parent_id"]) ? $csvJson["parent_id"] : $category->parent_id;
        $category->tax = !empty($csvJson["tax"]) ? $csvJson["tax"] : $category->tax;
        $category->discount = !empty($csvJson["discount"]) ? $csvJson["discount"] : $category->discount;

        $category->save();
    }

    private function create(array $csvJson): void
    {
        if (!$csvJson["parent_id"]) {
            $csvJson["parent_id"] = null;
        }

        unset($csvJson["id"]);
        unset($csvJson["is_update"]);
        Category::create($csvJson);
    }

    private function validateCsv(array $rows): bool
    {
        return implode(',', ExportCategoriesJob::getFieldsValues()) == str_replace("\r", '', $rows[0]);
    }
}
