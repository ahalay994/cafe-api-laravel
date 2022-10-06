<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property string $icon
 * @method static find(int $tag_id)
 * @method static paginate()
 * @method static findOrFail(int $id)
 * @method static create(array $all)
 */

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'icon',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
