<?php

namespace App\Nova;

use Hubertnnn\LaravelNova\Fields\DynamicSelect\DynamicSelect;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use function PHPUnit\Framework\isNull;

class Product extends Resource
{
    use CommonTrait;

    private $categories;

    public function __construct($resource)
    {
        $this->categories = \App\Models\Category::whereIn('level', ['4', '5'])->get();
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

            // todo: check categories for proper work

            Select::make('Категория', 'category_id')->options(
                $this->categories->pluck('name', 'id')
            )->searchable()
             ->rules('required')
             ->help('Категории 3 уровня')
             ->displayUsingLabels(),

//            BelongsToMany::make('Категории', 'categories', 'App\Nova\Category'), todo del

            Number::make('Цена', 'price')
                ->step(0.01)
                ->rules('required'),

            Textarea::make('Описание', 'description')
                ->nullable(),

            Number::make('Код', 'code')
                ->hideFromIndex()
                ->rules('max:255'),

            Images::make('Медиа', 'product_media_collection')
                ->fullSize()
                ->hideFromIndex()
                ->croppable(false),

            Text::make('Бренд', 'brand')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255'),

            Text::make('Производитель', 'manufacturer')
                ->hideFromIndex()
                ->nullable()
                ->rules('max:255'),

            Number::make('Вес', 'weight')
                ->hideFromIndex()
                ->step(0.01)
                ->nullable(),

            Number::make('Объем', 'volume')
                ->hideFromIndex()
                ->step(0.01)
                ->nullable(),

            Boolean::make('Активен', 'is_active')
                ->hideFromIndex()
                ->default(fn() => true),

            Boolean::make('Хит продаж', 'is_hit')
                ->hideFromIndex()
                ->default(fn() => false),

            Text::make('Штрихкод', 'barcode')
                ->hideFromIndex()
                ->creationRules([function($attribute, $value, $fail) {
                    if ($value){
                        $exists = \App\Models\Product::where($attribute, $value)->exists();
                        if ($exists) {
                            return $fail('Такой штрихкод уже существует.');
                        }
                    }
                    return true;
                }])
                ->readonly(function($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                })
                ->nullable(),

            Text::make('Артикул', 'vendor_code')
                ->hideFromIndex()
                ->creationRules([function($attribute, $value, $fail) {
                    if ($value){
                        $exists = \App\Models\Product::where($attribute, $value)->exists();
                        if ($exists) {
                            return $fail('Такой артикул уже существует.');
                        }
                    }
                    return true;
                }])
                ->readonly(function($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                })
                ->nullable()
                ->rules('max:255'),

            Text::make('Внешний ID', 'outer_id')
                ->hideFromIndex()
                ->readonly()
                ->creationRules('unique:products,outer_id')
                ->updateRules('unique:products,outer_id,{{resourceId}}')
                ->nullable()
                ->rules('max:255'),

//            Text::make('Рельеф ID', 'relef_guid') todo del
//                ->hideFromIndex()
//                ->readonly()
//                ->creationRules('unique:products,relef_guid')
//                ->updateRules('unique:products,relef_guid,{{resourceId}}')
//                ->nullable()
//                ->rules('max:255'),
//
//            Number::make('Самсон ID', 'samson_sku')
//                ->hideFromIndex()
//                ->step(0.01)
//                ->readonly()
//                ->creationRules('unique:products,samson_sku')
//                ->updateRules('unique:products,samson_sku,{{resourceId}}')
//                ->nullable(),

            KeyValue::make('Характеристики', 'properties')
                ->hideFromIndex()
                ->keyLabel('Свойство')
                ->valueLabel('Значение')
                ->actionText('Добавить'),

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
