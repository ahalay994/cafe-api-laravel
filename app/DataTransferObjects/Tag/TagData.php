<?php

namespace App\DataTransferObjects\Tag;

use App\DataTransferObjects\Access\AccessData;
use App\Models\Access;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class TagData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $slug;

    /** @var string */
    public string $color;

    /** @var string */
    public string $icon;
}
