<?php

namespace App\DataTransferObjects\AddressesGallery;

use App\Models\AddressesContact;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AddressesGalleriesCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (AddressesContact $addressesGallery) => new AddressesGalleryData(...$addressesGallery->toArray()),
            $value
        );
    }
}
