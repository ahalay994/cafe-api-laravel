<?php

namespace App\DataTransferObjects\AddressesGallery;

use Spatie\DataTransferObject\DataTransferObject;

class AddressesGalleryData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $image;
}
