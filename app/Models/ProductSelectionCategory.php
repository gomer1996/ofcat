<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSelectionCategory extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function productSelections(): HasMany
    {
        return $this->hasMany(ProductSelection::class, 'product_selection_category_id', 'id');
    }
}
