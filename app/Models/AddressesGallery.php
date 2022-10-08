<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\AddressesGallery
 *
 * @property int $id
 * @property int $address_id
 * @property string|null $image
 * @property int $sort
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|AddressesGallery whereId($value)
 * @method static Builder|AddressesGallery whereAddressId($value)
 * @method static Builder|AddressesGallery whereImage($value)
 * @method static Builder|AddressesGallery whereSort($value)
 * @method static Builder|AddressesGallery whereCreatedAt($value)
 * @method static Builder|AddressesGallery whereUpdatedAt($value)
 * @method static Builder|AddressesGallery whereDeletedAt($value)
 */

class AddressesGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'image',
        'sort',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
