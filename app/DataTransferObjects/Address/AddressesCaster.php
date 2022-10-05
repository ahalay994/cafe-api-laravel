<?php

namespace App\DataTransferObjects\Address;

use App\Models\Address;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AddressesCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Address $address) => new AddressData(...$address->toArray()),
            $value
        );
    }
}
