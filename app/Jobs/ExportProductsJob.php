<?php

namespace App\Jobs;

use App\Models\ExportProductsQueue;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;

class ExportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $exportProductsQueue;

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
        $exportProductsQueue = ExportProductsQueue::create([
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

    private function handleExport()
    {
        $output='';
        $output.=  implode(';', $this->generateHeader()) . PHP_EOL;

        Product::withoutGlobalScopes()->chunk(100, function ($products) use (&$output) {
            foreach ($products as $row) {
                $output.=  implode(';', $this->generateRow($row)) . PHP_EOL;
            }
        });

        $filename = 'Экспорт товаров ' . date('Y-m-d') . '.csv';

        Storage::disk('public')->put($filename, "\xEF\xBB\xBF" . $output);

        $exportProductsQueue = ExportProductsQueue::first();
        $exportProductsQueue->url = $filename;
        $exportProductsQueue->status = 'finished';
        $exportProductsQueue->save();
    }

    public static function getFieldsMapped(): array
    {
        return [
            ['id'           => 'ID товара'],
            ['integration'  => 'Поставщик'],
            ['category_id'  => 'Категория'],
            ['code'         => 'Код'],
            ['name'         => 'Наименование'],
            ['price'        => 'Цена'],
            ['markup'       => 'Наценка'],
            ['final_price'  => 'Итоговая цена'],
            ['brand'        => 'Бренд'],
            ['manufacturer' => 'Производитель'],
            ['barcode'      => 'Штрих-код'],
            ['vendor_code'  => 'Артикул'],
            ['weight'       => 'Вес'],
            ['volume'       => 'Объем'],
            ['stock'        => 'Остаток'],
            ['is_hit'       => 'Хит продаж'],
            ['is_active'    => 'Активный'],
            ['is_new'       => 'Новинка'],
            ['is_update'    => 'Обновить']
        ];
    }

    public static function mapFields(array $row): array
    {
        $result = [];

        foreach (self::getFieldsLabels() as $index => $label) {
            if (!array_key_exists($index, $row)) {
                continue;
            }
            $result[$label] = $row[$index] === '' ? null : $row[$index];
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

    private function generateRow(Product $product): array
    {
        return [
            $product->id,
            $product->integration,
            $product->category_id,
            $product->code,
            $product->name,
            $product->price,
            $product->markup,
            $product->final_price,
            $product->brand,
            $product->manufacturer,
            $product->barcode,
            $product->vendor_code,
            $product->weight,
            $product->volume,
            $product->stock,
            $product->is_hit,
            $product->is_active,
            $product->is_new,
            0
        ];
    }
}
