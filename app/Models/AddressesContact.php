<?php

namespace App\Models;

use App\Enum\AddressesContactTypesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\AddressesContact
 *
 * @property int $id
 * @property int $address_id
 * @property string $type
 * @property string $value
 * @method static paginate()
 * @method static findOrFail(int $id)
 * @method static create(array $all)
 * @method static find($id)
 */

class AddressesContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address_id',
        'type',
        'value',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'type' => AddressesContactTypesEnum::class,
    ];
}
