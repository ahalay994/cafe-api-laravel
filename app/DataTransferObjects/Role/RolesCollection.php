<?php

namespace App\DataTransferObjects\Role;

use App\Models\Role;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class RolesCollection extends DataTransferObject
{
    /** @var Role[] */
    #[CastWith(RolesCaster::class)]
    public mixed $collection;
}
