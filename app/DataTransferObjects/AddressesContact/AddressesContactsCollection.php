<?php

namespace App\DataTransferObjects\AddressesContact;

use App\Models\AddressesContact;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class AddressesContactsCollection extends DataTransferObject
{
    /** @var AddressesContact[] */
    #[CastWith(AddressesContactsCaster::class)]
    public mixed $collection;
}
