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
 * @method static Builder|UsersRole newModelQuery()
 * @method static Builder|UsersRole newQuery()
 * @method static Builder|UsersRole query()
 * @method static Builder|UsersRole whereRoleId($value)
 * @method static Builder|UsersRole whereUserId($value)
 * @method static create(array $all)
 * @method static where(array $array)
 * @method static firstWhere(array $array)
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
