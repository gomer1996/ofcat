<?php

namespace App\Scopes;

use App\Models\UserCategoryDiscount;
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

        $userDiscountForAll = $userId ? UserCategoryDiscount::where(['user_id' => $userId])
                                                ->whereNull('category_id')->first() : null;

        $discount = $userDiscountForAll ? $userDiscountForAll->discount : 0;

        $userDiscount = 'ROUND((products.price + IF(products.ignore_tax = 1, 0, (products.price * (categories.tax / 100))))  * (1 - IF(ucd.discount > 0,ucd.discount,'.$discount.') / 100), 2)';
        $categoryDiscount = 'ROUND((products.price + IF(products.ignore_tax = 1, 0, (products.price * (categories.tax / 100)))) * (1 - categories.discount / 100), 2)';

        $builder->leftJoin('user_category_discounts as ucd', 'products.category_id', '=', 'ucd.category_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'products.*',
                DB::raw('IF(ucd.user_id = '.$userId.' OR '.$discount.' > 0 , '.$userDiscount.', '.$categoryDiscount.') as calculated_price')
            ]);
    }
}
