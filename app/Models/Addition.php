<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Addition
 *
 * @property int $id;
 * @property string $name;
 * @property string $slug;
 * @property string|null $description;
 * @property string|null $image;
 * @property double $price;
 * @property int $discount;
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property double|null $old_price;
 * @property double|null $actual_price;
 * @property-read Product[] $products
 * @method static Builder|Addition whereId($value)
 * @method static Builder|Addition whereName($value)
 * @method static Builder|Addition whereSlug($value)
 * @method static Builder|Addition whereDescription($value)
 * @method static Builder|Addition whereImage($value)
 * @method static Builder|Addition wherePrice($value)
 * @method static Builder|Addition whereDiscount($value)
 * @method static Builder|Addition whereCreatedAt($value)
 * @method static Builder|Addition whereUpdatedAt($value)
 * @method static Builder|Addition whereDeletedAt($value)
 * @method static Builder|Addition whereOldPrice($value)
 * @method static Builder|Addition whereActualPrice($value)
 * @method static first()
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

    protected $appends = [
        'old_price',
        'actual_price'
    ];

    protected $with = [
        'products',
    ];

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
