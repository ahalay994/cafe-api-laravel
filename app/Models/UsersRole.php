<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UsersRole
 *
 * @property int $user_id
 * @property int $role_id
 * @method static Builder|UsersRole whereRoleId($value)
 * @method static Builder|UsersRole whereUserId($value)
 */
class UsersRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'role_id',
    ];
}
