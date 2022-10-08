<?php

namespace App\Models;

use App\Enum\AddressesContactTypesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\AddressesContact
 *
 * @property int $id
 * @property int $address_id
 * @property string $type
 * @property string $value
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|AddressesContact whereId($value)
 * @method static Builder|AddressesContact whereAddressId($value)
 * @method static Builder|AddressesContact whereType($value)
 * @method static Builder|AddressesContact whereValue($value)
 * @method static Builder|AddressesContact whereDescription($value)
 * @method static Builder|AddressesContact whereCreatedAt($value)
 * @method static Builder|AddressesContact whereUpdatedAt($value)
 * @method static Builder|AddressesContact whereDeletedAt($value)
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
