<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property bool $blocked
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereKey($value)
 * @method static Builder|Language whereName($value)
 * @method static Builder|Language whereBlocked($value)
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @method static Builder|Language whereDeletedAt($value)
 */

class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key',
        'name',
        'blocked',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
