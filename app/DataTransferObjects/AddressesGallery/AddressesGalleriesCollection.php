<?php

namespace App\DataTransferObjects\AddressesGallery;

use App\Models\AddressesGallery;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class AddressesGalleriesCollection extends DataTransferObject
{
    /** @var AddressesGallery[] */
    #[CastWith(AddressesGalleriesCaster::class)]
    public mixed $collection;
}
