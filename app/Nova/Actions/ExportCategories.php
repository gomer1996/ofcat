<?php

namespace App\Nova\Actions;

use App\Exports\OrderItemsExport;
use App\Jobs\ExportCategoriesJob;
use App\Models\ExportCategoriesQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\Excel\Facades\Excel;

class ExportCategories extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
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
        $exportCategoriesQueue = ExportCategoriesQueue::first();
        if ($exportCategoriesQueue) {
            $exportCategoriesQueue->delete();
        }

        ExportCategoriesJob::dispatch();

        return Action::redirect(url("/admin/resources/export-categories-queues"));
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
