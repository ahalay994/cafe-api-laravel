<?php

namespace App\DataTransferObjects\Addition;

use App\Models\Addition;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class AdditionsCollection extends DataTransferObject
{
    /** @var Addition[] */
    #[CastWith(AdditionsCaster::class)]
    public mixed $collection;
}
