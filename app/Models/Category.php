<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int $parent_id
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Category|null $parent
 * @property-read Category[]|null $children
 * @property-read Product[]|null $products
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @method static create(array $all)
 * @method static find($id)
 * @method static findOrFail(int $id)
 * @method static where(null[] $array)
 */

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $relations = [
        'parent',
        'children',
    ];

    protected $with = [
        'products',
        'children.products',
    ];

    /**
     * @return HasOne
     */
    public function parent(): HasOne
    {
        return $this->hasOne($this, 'id', 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    public function products(): HasMany {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
