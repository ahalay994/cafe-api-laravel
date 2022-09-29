<?php

namespace App\DataTransferObjects\Position;

use Spatie\DataTransferObject\Caster;

class PositionObjectCaster implements Caster
{
    /**
     * @param array|mixed $value
     *
     * @return mixed
     */
    public function cast(mixed $value): PositionObject
    {
        return new PositionObject(
            image: $value['image'],
            price: $value['price'],
            discount: $value['discount'],
        );
    }
}

