<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Order extends Resource
{

    use CommonTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Order::class;

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

            Text::make('Имя', 'name')
                ->sortable()
                ->readonly(fn () => true),

            Select::make('Тип', 'user_type')->options([
                'person'  => 'Физ лицо',
                'company' => 'Юр лицо',
            ])->displayUsingLabels()
                ->hideFromIndex()
                ->readonly(fn () => true),

            Text::make('Название компании', 'company_name')
                ->hideFromIndex()
                ->sortable()
                ->readonly(fn () => true),

            Text::make('Телефон', 'phone')
                ->sortable()
                ->readonly(fn () => true),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->readonly(fn () => true),

            Text::make('Комментарий', 'note')
                ->sortable()
                ->readonly(fn () => true)
                ->hideFromIndex(),

            Text::make('Цена', 'price')
                ->sortable()
                ->readonly(fn () => true)
                ->hideFromIndex(),

            Text::make('Скидка', 'discount')
                ->sortable()
                ->readonly(fn () => true)
                ->hideFromIndex(),

            Boolean::make('Оплачен', 'paid')
                ->default(fn () => false)
                ->hideFromIndex(),

            Text::make('Статус заказа', 'status'),

            Select::make('Доставка', 'delivery')->options([
                'delivery'  => 'Доставка',
                'pickup'    => 'Самовывоз',
            ])->displayUsingLabels()
                ->readonly(fn () => true)
                ->hideFromIndex(),

            Text::make('Продукты', function () {
                return view('nova.orders', [
                    'products' => json_decode($this->cart, true)
                ])->render();
            })->asHtml()
              ->hideFromIndex(),
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

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Заказы');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Заказ');
    }

    public static $trafficCop = false;
}
