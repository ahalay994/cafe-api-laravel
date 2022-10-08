<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Gallery
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Gallery whereId($value)
 * @method static Builder|Gallery whereProductId($value)
 * @method static Builder|Gallery whereImage($value)
 * @method static Builder|Gallery whereOrder($value)
 * @method static Builder|Gallery whereCreatedAt($value)
 * @method static Builder|Gallery whereUpdatedAt($value)
 * @method static Builder|Gallery whereDeletedAt($value)
 */
class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'image',
        'order',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
