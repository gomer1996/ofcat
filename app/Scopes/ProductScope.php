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
        // todo delete
        $add = 10;
        if (auth()->user()) {
            $add = 100;
        }
//        $builder->join('categories', 'products.category_id', '=', 'categories.id')
//            ->select([
//                'products.*',
//                DB::raw('ROUND(products.price * (1 - categories.discount / 100), 2) as new_price')
//            ]);
    }
}
