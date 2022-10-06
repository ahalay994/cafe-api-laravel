<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductsAddition
 *
 * @property int $product_id
 * @property int $addition_id
 * @method static where(array $array)
 * @method static create(array $all)
 * @method static firstWhere(array $array)
 */

class ProductsAddition extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'addition_id',
    ];
}
