<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntegrationCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get child categories
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'outer_parent_id', 'outer_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'outer_parent_id', 'outer_id');
    }

    /**
     * Get products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'integration_category_id', 'id');
    }

    /**
     * Get products
     *
     * @return HasMany
     */
    public function newProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'integration_category_id', 'id')->whereNull('category_id');
    }
}
