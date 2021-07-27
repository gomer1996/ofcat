<?php

namespace App\Nova\Actions;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class MergeIntegrationProducts extends Action
{
    use InteractsWithQueue, Queueable;

    private $categories;

    public function __construct()
    {
        $this->categories = \App\Models\Category::whereDoesntHave('children')
            ->whereIn('level', ['3', '5', '4'])
            ->get();
    }

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Слить с другой категорией';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Product::withoutGlobalScopes()->whereIn('integration_category_id', $models->pluck('id'))
                    ->update([
                        'category_id' => $fields->category_id
                    ]);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make('Категория', 'category_id')->options(
                $this->categories->pluck('name', 'id')
            )->searchable()
                ->rules('required')
                ->help('Категории 3 уровня')
                ->displayUsingLabels(),
        ];
    }
}
