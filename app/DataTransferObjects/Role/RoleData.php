<?php

namespace App\DataTransferObjects\Role;

use App\DataTransferObjects\Access\AccessData;
use App\Models\Access;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class RoleData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $slug;

    /** @var AccessData[] */
    #[CastWith(ArrayCaster::class, AccessData::class)]
    public ?array $accesses;
}
