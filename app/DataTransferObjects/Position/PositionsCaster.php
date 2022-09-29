<?php

namespace App\DataTransferObjects\Position;

use App\Models\Position;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PositionsCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        dd($value);
        return array_map(
            fn (Position $position) => new PositionData(...$position->toArray()),
            $value
        );
    }
}
