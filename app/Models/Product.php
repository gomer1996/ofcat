<?php

namespace App\Models;

use App\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory,  InteractsWithMedia;

    protected $guarded = [];

    protected $appends = [
        'thumbnail'
    ];

    protected $casts = [
        'properties' => 'json',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPropertiesParsedAttribute(): array
    {
        if ($this->attributes['properties']) {
            return json_decode($this->attributes['properties'], true);
        }
        return [];
    }

    public function getThumbnailAttribute()
    {
        $img = $this->getMedia('product_media_collection')->first() ?? null;
        return $img ? $img->getFullUrl() : null;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')->singleFile();
        $this->addMediaCollection('product_media_collection');
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getUniqueBrands($categoryId)
    {
        return Cache::get('category_product_unique_brands_'.$categoryId, function () use ($categoryId) {
            $brands = self::withoutGlobalScopes()->where('products.category_id', $categoryId)->whereNotNull('brand')->distinct('brand')->get('brand')->pluck('brand');
            Cache::put('category_product_unique_brands_'.$categoryId, $brands, 86400);
            return $brands;
        });
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ProductScope);
    }
}
