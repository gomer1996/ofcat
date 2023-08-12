<?php

namespace App\Nova\Actions;

use App\Jobs\ExportProductsJob;
use App\Models\ExportProductsQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ExportProducts extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Экспорт';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $exportProductsQueue = ExportProductsQueue::first();
        if ($exportProductsQueue) {
            $exportProductsQueue->delete();
        }

        ExportProductsJob::dispatch();

        return Action::redirect(url("/admin/resources/export-products-queues"));
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
