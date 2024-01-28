<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\ExportCategoriesQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExportCategoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exportCategoriesQueue;

    /**
     * Create a new job instance.
     *
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
        $exportProductsQueue = ExportCategoriesQueue::create([
            'status' => 'pending'
        ]);

        try {
            DB::beginTransaction();
            $this->handleExport();
            DB::commit();
        } catch (\Exception $E) {
            DB::rollBack();

            $exportProductsQueue->message = $E->getMessage();
            $exportProductsQueue->status = 'failed';
            $exportProductsQueue->save();
        }
    }

    public function failed(\Throwable $exception)
    {
        $exportProductsQueue = ExportCategoriesQueue::first();
        $exportProductsQueue->message = $exception->getMessage();
        $exportProductsQueue->status = 'failed';
        $exportProductsQueue->save();
    }

    private function handleExport()
    {
        $output='';
        $output.=  implode(';', $this->generateHeader()) . PHP_EOL;

        Category::chunk(100, function ($categories) use (&$output) {
            foreach ($categories as $row) {
                $output.=  implode(';', $this->generateRow($row)) . PHP_EOL;
            }
        });

        $filename = 'Экспорт категорий ' . date('Y-m-d') . '.csv';

        Storage::disk('public')->put($filename, "\xEF\xBB\xBF" . $output);

        $exportProductsQueue = ExportCategoriesQueue::first();
        $exportProductsQueue->url = $filename;
        $exportProductsQueue->status = 'finished';
        $exportProductsQueue->save();
    }

    public static function getFieldsMapped(): array
    {
        return [
            ['id'         => 'ID товара'],
            ['name'       => 'Наименование'],
            ['parent_id'  => 'Родитель'],
            ['discount'   => 'Скидка'],
            ['is_update'  => 'Обновить']
        ];
    }

    public static function mapFields(array $row): array
    {
        $result = [];

        foreach (self::getFieldsLabels() as $index => $label) {
            if (!array_key_exists($index, $row)) {
                continue;
            }
            $result[$label] = $row[$index];
        }

        return $result;
    }

    public static function getFieldsLabels(): array
    {
        $labels = [];

        foreach (self::getFieldsMapped() as $index => $field) {
            $labelField = null;
            foreach ($field as $label => $name) {
                $labelField = $label;
            }
            $labels[$index] = $labelField;
        }

        return $labels;
    }

    public static function getFieldsValues(): array
    {
        $labels = [];

        foreach (self::getFieldsMapped() as $index => $field) {
            $labelField = null;
            foreach ($field as $name) {
                $labelField = $name;
            }
            $labels[$index] = $labelField;
        }

        return $labels;
    }

    private function generateHeader(): array
    {
        $header = [];

        foreach (self::getFieldsMapped() as $index => $field) {
            $headerField = null;
            foreach ($field as $label => $name) {
                $headerField = $name;
            }
            $header[$index] = $headerField;
        }

        return $header;
    }

    private function generateRow(Category $category): array
    {
        return [
            $category->id,
            $category->name,
            $category->parent_id,
            $category->discount,
            0
        ];
    }
}
