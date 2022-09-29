<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProductsPosition
 *
 * @property int $id
 * @property int $product_id
 * @property int $position_id
 * @property string $image
 * @property double $price
 * @property int $discount
 * @property double $old_price
 * @property double $actual_price
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
