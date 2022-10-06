<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property bool $blocked
 * @method static paginate()
 * @method static findOrFail(int $id)
 * @method static create(array $all)
 */

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'blocked',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}