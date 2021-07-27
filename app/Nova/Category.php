<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use \App\Models\Category as CategoryModel;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Epartment\NovaDependencyContainer\HasDependencies;

class Category extends Resource
{
    use CommonTrait, HasDependencies;

    private $categories;

    public function __construct($resource)
    {
        $this->categories = CategoryModel::where('level', '!=', '3')->orWhere('level', null)->get();
        parent::__construct($resource);
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Category::class;

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

//            BelongsTo::make('Родитель', 'parent', 'App\Nova\Category')
//                ->nullable(),

            Select::make('Родитель', 'parent_id')->options(
                $this->categories->pluck('name', 'id')
            )->searchable()
             ->displayUsingLabels()
             ->hideFromIndex(),

            Select::make('Уровень', 'level')->options([
                '1'  => 'Первый',
                '2'  => 'Второй',
                '3'  => 'Третий',
                '4'  => 'Четвертый',
            ])->nullable()
              ->displayUsingLabels(),

            Image::make('Картинка', 'img')
                ->disk('categories')
                ->prunable(),

            NovaDependencyContainer::make([
                Number::make('Процент сверху', 'tax')
                    ->max(99)
                    ->default(0)
                    ->help('в процентах')
                    ->hideFromIndex()
            ])->dependsOn('level', 3)
              ->dependsOn('level', 4)
              ->dependsOn('level', 5),

            NovaDependencyContainer::make([
                Number::make('Скидка', 'discount')
                    ->max(99)
                    ->default(0)
                    ->help('в процентах')
                    ->hideFromIndex()
            ])->dependsOn('level', 3)
              ->dependsOn('level', 4)
              ->dependsOn('level', 5),


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
        return __('Категории');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Категория');
    }

    public static $trafficCop = false;
}
