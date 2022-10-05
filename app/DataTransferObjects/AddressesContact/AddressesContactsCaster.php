<?php

namespace App\DataTransferObjects\AddressesContact;

use App\Models\AddressesContact;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AddressesContactsCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (AddressesContact $addressesContact) => new AddressesContactData(...$addressesContact->toArray()),
            $value
        );
    }
}
