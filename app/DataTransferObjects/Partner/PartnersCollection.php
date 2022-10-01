<?php

namespace App\DataTransferObjects\Partner;

use App\Models\Partner;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class PartnersCollection extends DataTransferObject
{
    /** @var Partner[] */
    #[CastWith(PartnersCaster::class)]
    public mixed $collection;
}
