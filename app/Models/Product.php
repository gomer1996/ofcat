<?php

namespace App\Models;

use App\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected $attributes = [
        'is_hit' => 0,
        'is_new' => 0,
        'is_active' => 0,
        'stock' => 0,
        'ignore_tax' => 0,
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

    /**
     * csv support
     */
    public function getNameAttribute()
    {
        return str_replace(';', ':', $this->attributes['name']);
    }

    public function getBrandAttribute()
    {
        return str_replace(';', ':', $this->attributes['brand']);
    }

    public function getManufacturerAttribute()
    {
        return str_replace(';', ':', $this->attributes['manufacturer']);
    }

    public function getThumbnailAttribute()
    {
        $img = $this->getMedia('product_media_collection')->first() ?? null;
        return $img ? $img->getFullUrl() : null;
    }

    public function getFinalPriceAttribute(): float
    {
        $price = $this->attributes['price'];
        $markup = $this->attributes['markup'];

        $markup = $price * ($markup / 100);

        return round($price + $markup, 2);
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

    public function getLink(?Category $linkedCategory = null): string
    {
        $params = [$this->getAttribute('id')];

        if ($linkedCategory) {
            $params['cat'] = $linkedCategory->getAttribute('id');
        }

        return route(
            'products.show',
            $params
        );
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
