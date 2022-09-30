<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductsTag
 *
 * @property int $product_id
 * @property int $tag_id
 */

class ProductsTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'tag_id',
    ];
}
