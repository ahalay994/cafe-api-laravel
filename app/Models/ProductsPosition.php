<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductsPosition
 *
 * @property int $id
 * @property int $product_id
 * @property int $position_id
 * @property string|null $image
 * @property double $price
 * @property int $discount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property double $old_price
 * @property double $actual_price
 * @method static Builder|ProductsPosition whereId($value)
 * @method static Builder|ProductsPosition whereProductId($value)
 * @method static Builder|ProductsPosition wherePositionId($value)
 * @method static Builder|ProductsPosition whereImage($value)
 * @method static Builder|ProductsPosition wherePrice($value)
 * @method static Builder|ProductsPosition whereDiscount($value)
 * @method static Builder|ProductsPosition whereCreatedAt($value)
 * @method static Builder|ProductsPosition whereUpdatedAt($value)
 * @method static Builder|ProductsPosition whereDeletedAt($value)
 * @method static Builder|ProductsPosition whereOldPrice($value)
 * @method static Builder|ProductsPosition whereActualPrice($value)
 */

class ProductsPosition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'position_id',
        'image',
        'price',
        'discount',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return float
     */
    public function getOldPriceAttribute(): float
    {
        $productsPosition = static::first();
        return floatval($productsPosition->price);
    }

    /**
     * @return float
     */
    public function getActualPriceAttribute(): float
    {
        $productsPosition = static::first();
        return $productsPosition->discount > 0 ?
            floatval($productsPosition->price - ($productsPosition->price * $productsPosition->discount / 100)) :
            floatval($productsPosition->price);
    }
}
