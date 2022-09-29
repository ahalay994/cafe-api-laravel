<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Addition
 *
 * @property int $id;
 * @property string $name;
 * @property string $slug;
 * @property string $description;
 * @property string $image;
 * @property double $price;
 * @property int $discount;
 * @property double $old_price;
 * @property double $actual_price;
 * @property-read Product[] $products
 */
class Addition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'discount',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = ['old_price', 'actual_price'];

    /**
     * @return float
     */
    public function getOldPriceAttribute(): float
    {
        $addition = static::first();
        return floatval($addition->price);
    }

    /**
     * @return float
     */
    public function getActualPriceAttribute(): float
    {
        $addition = static::first();
        return $addition->discount > 0 ?
            floatval($addition->price - ($addition->price * $addition->discount / 100)) :
            floatval($addition->price);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, ProductsAddition::class);
    }
}
