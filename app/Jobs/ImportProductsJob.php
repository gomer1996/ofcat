<?php

namespace App\Jobs;

use App\Integrations\Relef\SyncRelefProducts;
use App\Integrations\Samson\SyncSamsonProducts;
use App\Models\ImportProductsQueue;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var SyncSamsonProducts
     */
    private $syncSamsonProducts;

    /**
     * @var SyncRelefProducts
     */
    private $syncRelefProducts;

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
    public function handle(SyncSamsonProducts $syncSamsonProducts, SyncRelefProducts $syncRelefProducts)
    {
        $this->syncSamsonProducts = $syncSamsonProducts;
        $this->syncRelefProducts = $syncRelefProducts;

        $queue = ImportProductsQueue::first();
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

            $row = \App\Jobs\ExportProductsJob::mapFields($params);

            if ($row["id"] && $row["is_update"] == 0) {
                continue;
            }

            if (!$row["id"] && !$row["code"]) {
                $this->createNewProduct($row);
            }

            if (!$row["id"] && $row["code"]) {
                if ($row["integration"] == "samson") {
                    $this->fetchSamsonSku($row["code"], (int)$row["category_id"], (float)$row["markup"]);
                }

                if ($row["integration"] == "relef") {
                    $this->fetchRelefProduct($row["code"], (int)$row["category_id"], (float)$row["markup"]);
                }
            }


            if ($row["id"]) {
                $this->updateProduct($row);
            }

            usleep(500);
        }
    }

    private function fetchSamsonSku(?string $code, ?int $categoryId, ?float $markup): void
    {
        if (!$code || !$categoryId) {
            return;
        }

        $product = Product::where([
            'integration' => 'samson',
            'code' => $code,
            'category_id' => $categoryId
        ])->first();

        if ($product) {
            return;
        }

        $this->syncSamsonProducts->fetchSku($code, $categoryId, $markup);
    }

    private function fetchRelefProduct(?string $code, ?int $categoryId, ?float $markup): void
    {
        if (!$code || !$categoryId) {
            return;
        }

        $product = Product::where([
            'integration' => 'relef',
            'code' => $code,
            'category_id' => $categoryId
        ])->first();

        if ($product) {
            return;
        }

        $this->syncRelefProducts->fetchProduct($code, $categoryId, $markup);
    }

    private function updateProduct(array $productCsvJson): void
    {
        $product = Product::find($productCsvJson["id"]);

        if (!$product) {
            return;
        }

        $product->category_id = $productCsvJson["category_id"] ?: $product->category_id;
        $product->code = $productCsvJson["code"] ?: $product->code;
        $product->name = $productCsvJson["name"] ?: $product->name;
        $product->price = $productCsvJson["price"] ?: $product->price;
        $product->markup = $productCsvJson["markup"] ?: $product->markup;
        $product->brand = $productCsvJson["brand"] ?: $product->brand;
        $product->manufacturer = $productCsvJson["manufacturer"] ?: $product->manufacturer;
        $product->barcode = $productCsvJson["barcode"] ?: $product->barcode;
        $product->vendor_code = $productCsvJson["vendor_code"] ?: $product->vendor_code;
        $product->stock = $productCsvJson["stock"] ?: $product->stock;
        $product->is_hit = $productCsvJson["is_hit"] ?: $product->is_hit;
        $product->is_active = $productCsvJson["is_active"] ?: $product->is_active;
        $product->is_new = $productCsvJson["is_new"] ?: $product->is_new;

        $product->save();
    }

    private function createNewProduct(array $productCsvJson): void
    {
        $productCsvJson["integration"] = null;
        unset($productCsvJson["id"]);
        unset($productCsvJson["is_update"]);
        unset($productCsvJson["final_price"]);

        $data = [];

        foreach ($productCsvJson as $field => $value) {
            if (is_null($value)) {
                continue;
            }
            $data[$field] = $value;
        }

        Product::create($data);
    }

    private function validateCsv(array $rows): bool
    {
        return implode(',', ExportProductsJob::getFieldsValues()) == str_replace("\r", '', $rows[0]);
    }
}
