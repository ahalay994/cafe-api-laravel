<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $short_description
 * @property string $description
 * @property double $price
 * @property int $discount
 * @property bool $hidden
 * @property int $category_id
 * @property-read Category $category
 * @property-read Addition[] $additions
 * @property-read Position[] $positions
 */

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'discount',
        'hidden',
        'category_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function additions(): BelongsToMany
    {
        return $this->belongsToMany(Addition::class, ProductsAddition::class);
    }

    /**
     * @return BelongsToMany
     */
    public function positions(): BelongsToMany
    {
        return $this
            ->belongsToMany(Position::class, ProductsPosition::class)
            ->withPivot(['image', 'price', 'discount']);
    }
}
