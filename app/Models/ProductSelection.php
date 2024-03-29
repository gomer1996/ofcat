<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSelection extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function productSelectionCategory(): BelongsTo
    {
        return $this->belongsTo(ProductSelectionCategory::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
