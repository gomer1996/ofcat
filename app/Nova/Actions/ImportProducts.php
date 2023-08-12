<?php

namespace App\Nova\Actions;

use App\Jobs\ImportProductsJob;
use App\Models\ImportProductsQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Text;

class ImportProducts extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Импорт';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $filename = 'importProducts.csv';
        $fields->importFile->storeAs(
            'import', $filename, 'local'
        );

        $importProductsQueue = ImportProductsQueue::first();

        if (!$importProductsQueue) {
            $importProductsQueue = ImportProductsQueue::create([
                'status' => 'pending'
            ]);
        }
        $importProductsQueue->url = $filename;
        $importProductsQueue->status = 'pending';
        $importProductsQueue->save();

        ImportProductsJob::dispatch();

        return Action::redirect(url("/admin/resources/import-products-queues"));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('Файл импорта', 'importFile')
                ->acceptedTypes('.csv')
                ->required(true)
        ];
    }
}
