<?php

namespace App\DataTransferObjects\Position;

use Spatie\DataTransferObject\DataTransferObject;

class PositionData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $slug;

    /** @var string */
    public string $description;

    /** @var string|null */
    public ?string $image;
}
