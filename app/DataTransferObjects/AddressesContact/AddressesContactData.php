<?php

namespace App\DataTransferObjects\AddressesContact;

use Spatie\DataTransferObject\DataTransferObject;

class AddressesContactData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $type;

    /** @var string */
    public string $value;
}
