<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property User[]|null $users
 * @property Access[]|null $accesses
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereSlug($value)
 * @method static paginate()
 * @method static create(array $all)
 * @method static find(int $role_id)
 * @method static findOrFail(int $id)
 */
class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @param array $roles
     * @return string
     */
    public static function getAccess(array $roles): string
    {
        $accesses = [];
        foreach ($roles as $role) {
            $role = Role::whereSlug($role)->first();
            $accesses = array_merge($accesses, $role->accesses->pluck('name')->toArray());
        }
        return implode(',', array_values(array_unique($accesses)));
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UsersRole::getTable());
    }

    /**
     * @return BelongsToMany
     */
    public function accesses(): BelongsToMany
    {
        return $this->belongsToMany(Access::class, RolesAccess::class);
    }
}
