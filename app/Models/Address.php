<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property double $lat
 * @property double $lon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read AddressesGallery[] $galleries
 * @property-read AddressesContact[] $contacts
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereName($value)
 * @method static Builder|Address whereDescription($value)
 * @method static Builder|Address whereLat($value)
 * @method static Builder|Address whereLon($value)
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereDeletedAt($value)
 */

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'lat',
        'lon',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @return HasMany
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(AddressesGallery::class, 'address_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(AddressesContact::class, 'address_id', 'id');
    }
}
