<?php

namespace App\DataTransferObjects\Position;

use App\Models\Position;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class PositionsCollection extends DataTransferObject
{
    /** @var Position[] */
    #[CastWith(PositionsCaster::class)]
    public mixed $collection;
}
