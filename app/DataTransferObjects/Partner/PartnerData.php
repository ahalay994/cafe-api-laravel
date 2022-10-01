<?php

namespace App\DataTransferObjects\Partner;

use Spatie\DataTransferObject\DataTransferObject;

class PartnerData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $image;
}
