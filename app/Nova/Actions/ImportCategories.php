<?php

namespace App\Nova\Actions;

use App\Jobs\ImportCategoriesJob;
use App\Jobs\ImportProductsJob;
use App\Models\ImportCategoriesQueue;
use App\Models\ImportProductsQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CategoriesImport;

class ImportCategories extends Action
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
        $filename = 'importCategories.csv';
        $fields->importFile->storeAs(
            'import', $filename, 'local'
        );

        $importCategoriesQueue = ImportCategoriesQueue::first();

        if (!$importCategoriesQueue) {
            $importCategoriesQueue = ImportCategoriesQueue::create([
                'status' => 'pending'
            ]);
        }
        $importCategoriesQueue->url = $filename;
        $importCategoriesQueue->status = 'pending';
        $importCategoriesQueue->save();

        ImportCategoriesJob::dispatch();

        return Action::redirect(url("/admin/resources/import-categories-queues"));
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
