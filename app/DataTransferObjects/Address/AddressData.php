<?php

namespace App\DataTransferObjects\Address;

use App\DataTransferObjects\AddressesContact\AddressesContactData;
use App\DataTransferObjects\AddressesGallery\AddressesGalleryData;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class AddressData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $description;

    /** @var double */
    public float $lat;

    /** @var double */
    public float $lon;

    /** @var AddressesGalleryData[] */
    #[CastWith(ArrayCaster::class, AddressesGalleryData::class)]
    public ?array $galleries;

    /** @var AddressesContactData[] */
    #[CastWith(ArrayCaster::class, AddressesContactData::class)]
    public ?array $contacts;
}
