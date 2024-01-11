<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
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
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * Get products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return BelongsTo
     */
    public function linkedCategory(): BelongsTo
    {
        return $this->belongsTo(LinkedCategory::class, 'id', 'linked_category_id');
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function getLinkedCategory(Category $category): self
    {
        $category->load('linkedCategory', 'linkedCategory.category');

        return $category->getRelation('linkedCategory')->getRelation('category');
    }

    /**
     * csv support
     */
    public function getNameAttribute()
    {
        return str_replace(';', ':', $this->attributes['name']);
    }
}
