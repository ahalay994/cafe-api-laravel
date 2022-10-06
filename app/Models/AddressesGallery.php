<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AddressesGallery
 *
 * @property int $id
 * @property int $address_id
 * @property string $image
 * @property int $sort
 * @method static paginate()
 * @method static findOrFail(int $id)
 * @method static create(array $all)
 * @method static find($id)
 * @method static orderBy()
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
