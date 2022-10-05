<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property double $lat
 * @property double $lon
 * @property-read AddressesGallery[] $galleries
 * @property-read AddressesContact[] $contacts
 * @method static findOrFail(int $id)
 * @method static create(array $all)
 * @method static find($id)
 * @method static paginate()
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
