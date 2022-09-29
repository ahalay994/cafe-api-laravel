<?php

namespace App\DataTransferObjects\Addition;

use App\Models\Addition;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AdditionsCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Addition $addition) => new AdditionData(...$addition->toArray()),
            $value
        );
    }
}
