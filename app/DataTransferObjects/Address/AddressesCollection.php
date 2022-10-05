<?php

namespace App\DataTransferObjects\Address;

use App\Models\Address;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class AddressesCollection extends DataTransferObject
{
    /** @var Address[] */
    #[CastWith(AddressesCaster::class)]
    public mixed $collection;
}
