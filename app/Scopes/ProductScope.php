<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

class ProductScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $userId = auth()->user()->id ?? 0;

        $builder->leftJoin('user_category_discounts as ucd', 'products.category_id', '=', 'ucd.category_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'products.*',
                DB::raw('IF(ucd.user_id = '.$userId.', ROUND(products.price * (1 - ucd.discount / 100), 2), ROUND(products.price * (1 - categories.discount / 100), 2)) as calculated_price')
            ]);
    }
}
