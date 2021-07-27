<?php

namespace App\Nova;

use App\Nova\Actions\MergeIntegrationProducts;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ActionRequest;

class IntegrationCategory extends Resource
{
    use CommonTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\IntegrationCategory::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        $query->where('level', '3')
            ->withCount(['newProducts' => function($q){
                $q->withoutGlobalScopes();
            }])
            ->whereHas('newProducts', function ($q) {
                $q->withoutGlobalScopes();
            })
            ->with('parent.parent');
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        $query->withCount(['newProducts' => function($q){
                $q->withoutGlobalScopes();
            }])
            ->whereHas('newProducts', function ($q) {
                $q->withoutGlobalScopes();
            })
            ->with('parent.parent');
    }

    /**
     * Run actions even when update policy denies
     *
     * @param Request $request
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        return $request instanceof ActionRequest;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make('Категории', function () {
                return ($this->parent && $this->parent->parent ? $this->parent->parent->name : null)
                    . "<br> -"
                    . ($this->parent ? $this->parent->name : null)
                    . "<br> --"
                    . $this->name;

            })->asHtml(),

            Text::make('Товаров', 'new_products_count'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new MergeIntegrationProducts()
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Интеграции');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Интеграция');
    }

    public static $trafficCop = false;
}
