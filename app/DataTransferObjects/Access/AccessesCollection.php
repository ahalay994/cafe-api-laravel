<?php

namespace App\DataTransferObjects\Access;

use App\Models\Role;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class AccessesCollection extends DataTransferObject
{
    /** @var Role[] */
    #[CastWith(AccessesCaster::class)]
    public mixed $collection;
}
