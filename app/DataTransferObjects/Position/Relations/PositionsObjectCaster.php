<?php

namespace App\DataTransferObjects\Position\Relations;

use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PositionsObjectCaster implements Caster
{
    /**
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(function (mixed $position): PositionObject {
            $positionResponseData = new PositionResponseObject(['collection' => (is_array($position) ? $position : $position->toArray())]);
            return $positionResponseData->collection;
        },
            $value
        );
    }
}
