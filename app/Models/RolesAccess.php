<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $role_id
 * @property int $access_id
 * @method static Builder|RolesAccess whereRoleId($value)
 * @method static Builder|RolesAccess whereAccessId($value)
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
