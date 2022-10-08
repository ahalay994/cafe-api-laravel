<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Partner
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Partner whereId($value)
 * @method static Builder|Partner whereName($value)
 * @method static Builder|Partner whereImage($value)
 * @method static Builder|Partner whereCreatedAt($value)
 * @method static Builder|Partner whereUpdatedAt($value)
 * @method static Builder|Partner whereDeletedAt($value)
 */
class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
