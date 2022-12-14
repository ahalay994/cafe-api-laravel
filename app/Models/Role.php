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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property User[]|null $users
 * @property Access[]|null $accesses
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereSlug($value)
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static Builder|Role whereDeletedAt($value)
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
            /** @var Role $role */
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
        return $this->belongsToMany(User::class, UsersRole::class);
    }

    /**
     * @return BelongsToMany
     */
    public function accesses(): BelongsToMany
    {
        return $this->belongsToMany(Access::class, RolesAccess::class);
    }
}
