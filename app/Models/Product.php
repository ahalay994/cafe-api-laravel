<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $short_description
 * @property string|null $description
 * @property string|null $image
 * @property bool $hidden
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Category $category
 * @property-read Addition[] $additions
 * @property-read Position[] $positions
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereShortDescription($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereImage($value)
 * @method static Builder|Product whereHidden($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereDeletedAt($value)
 */

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'image',
        'hidden',
        'category_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = [
        'category',
        'additions',
        'positions',
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
