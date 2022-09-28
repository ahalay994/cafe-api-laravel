<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Access
 *
 * @property string $name
 * @property string $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Access whereId($value)
 * @method static Builder|Access whereName($value)
 * @method static Builder|Access whereComment($value)
 */

class Access extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'comment',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
