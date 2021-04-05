<?php

namespace App\Models;

use App\Scopes\ProductScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function scopePriced($query, $category = null)
    {
        if (auth()->user() && $category) {
            $discount = UserCategoryDiscount::where(['user_id' => auth()->user()->id, 'category_id' => $category->id])->first();
            if ($discount) {
                return $query->select([
                    '*',
                    DB::raw('ROUND(products.price * (1 - '. $discount->discount .' / 100), 2) as new_price')]);
            }
        }
        return $query->join('categories', 'products.category_id', '=', 'categories.id')
            ->select([
                'products.*',
                DB::raw('ROUND(products.price * (1 - categories.discount / 100), 2) as new_price')
            ]);
    }

    //---------------------------------------------------------------------------------------------------------

    public static function getUniqueBrands($categoryId)
    {
        return Cache::get('category_product_unique_brands_'.$categoryId, function () use ($categoryId) {
            $brands = self::where('category_id', $categoryId)->whereNotNull('brand')->distinct('brand')->get('brand')->pluck('brand');
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
