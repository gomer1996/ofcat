<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Category;
use App\Models\UserCategoryDiscount as UCDModel;

class UserCategoryDiscount extends Resource
{
    use CommonTrait;

    private $categories;
    private $users;

    public function __construct($resource)
    {
        $this->categories = \App\Models\Category::whereIn('level', ['3', '4'])->get();
        $this->users = \App\Models\User::where('type', 'company')->get();
        parent::__construct($resource);
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\UserCategoryDiscount::class;

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

//            BelongsTo::make('Пользователь', 'user', 'App\Nova\User')
//                ->rules('required', function($attribute, $value, $fail) use ($request){
//                    $exists = UCDModel::where(['user_id' => $value, 'category_id' => $request->category_id])->exists();
//                    if ($exists) {
//                        return $fail('Для этого пользователя уже есть скидка на эту категории');
//                    }
//                })->readonly(function($request) {
//                    return $request->isUpdateOrUpdateAttachedRequest();
//                }),

            Select::make('Пользователь', 'user_id')->options(
                $this->users->pluck('name', 'id')
            )->searchable()
                ->displayUsingLabels()
                ->rules('required', function($attribute, $value, $fail) use ($request){
                    $exists = UCDModel::where(['user_id' => $value, 'category_id' => $request->category_id])->exists();
                    if ($exists) {
                        return $fail('Для этого пользователя уже есть скидка на эту категории');
                    }
                })
                ->readonly(function($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),

            Select::make('Категория', 'category_id')->options(
                $this->categories->pluck('name', 'id')
            )->searchable()
                ->displayUsingLabels()
                ->nullable()
                ->readonly(function($request) {
                    return $request->isUpdateOrUpdateAttachedRequest();
                }),

            Number::make('Скидка', 'discount')
                ->max(99)
                ->default(0)
                ->help('в процентах')
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
        return __('Индивидуальные скидки');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Индивидуальная скидка');
    }

    public static $trafficCop = false;
}
