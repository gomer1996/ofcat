<?php

namespace App\Nova;

use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class Product extends Resource
{
    use CommonTrait;

    private $categories;

    public function __construct($resource)
    {
        $this->categories = \App\Models\Category::all();
        parent::__construct($resource);
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

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

            Text::make('Наименовние', 'name')
                ->rules('required', 'max:255'),

            DynamicSelect::make('Категория 1 уровень', 'top_category')
                ->options(
                    $this->categories->where('level', '1')->pluck('name', 'id')
                )
                ->withMeta(['ignoreOnSaving'])
                ->rules('required'),

            DynamicSelect::make('Категория 2 уровень', 'middle_category')
                ->dependsOn(['top_category'])
                ->options(function($values) {
                    return $this->categories
                        ->where('level', '2')
                        ->where('parent_id', $values["top_category"])
                        ->pluck('name', 'id');
                })
                ->withMeta(['ignoreOnSaving'])
                ->rules('required'),

            DynamicSelect::make('Категория 3 уровень', 'category_id')
                ->dependsOn(['middle_category'])
                ->options(function($values) {
                    return $this->categories
                        ->where('level', '3')
                        ->where('parent_id', $values["middle_category"])
                        ->pluck('name', 'id');
                })
                ->rules('required'),

            Number::make('Цена', 'price')
                ->step(0.01)
                ->rules('required'),

            Textarea::make('Описание', 'info')
                ->nullable(),

            Number::make('Код', 'code')
                ->rules('required', 'max:255'),

            Images::make('Медиа', 'product_media_collection')
                ->fullSize()
                ->hideFromIndex()
                ->croppable(false),

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
        return [];
    }

    public static function fill(NovaRequest $request, $model)
    {
        return static::fillFields(
            $request, $model,
            (new static($model))->creationFieldsWithoutReadonly($request)->reject(function ($field) use ($request) {
                return in_array('ignoreOnSaving', $field->meta);
            })
        );
    }


    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Продукты');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Продукт');
    }

    public static $trafficCop = false;
}
