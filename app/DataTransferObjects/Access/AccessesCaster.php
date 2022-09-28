<?php

namespace App\DataTransferObjects\Access;

use App\Models\Access;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AccessesCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Access $access) => new AccessData(...$access->toArray()),
            $value
        );
    }
}
