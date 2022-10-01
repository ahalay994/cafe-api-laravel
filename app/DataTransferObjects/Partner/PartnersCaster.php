<?php

namespace App\DataTransferObjects\Partner;

use App\Models\Partner;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PartnersCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Partner $partner) => new PartnerData(...$partner->toArray()),
            $value
        );
    }
}
