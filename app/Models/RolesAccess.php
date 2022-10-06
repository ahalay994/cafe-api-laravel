<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(array $array)
 * @method static create(array $all)
 * @method static firstWhere(array $array)
 */
class RolesAccess extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'access_id',
    ];
}
