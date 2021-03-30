<?php

namespace App\Models;

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

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    public static function getUniqueBrands()
    {
        return Cache::get('product_unique_brands', function () {
            $brands = self::whereNotNull('brand')->distinct('brand')->get('brand')->pluck('brand');
            Cache::put('product_unique_brands', $brands, 86400);
            return $brands;
        });

    }
}
