<?php

namespace App\DataTransferObjects\Position\Relations;

use Spatie\DataTransferObject\Caster;

class PositionObjectCaster implements Caster
{
    public function cast(mixed $value): PositionObject
    {
        $image = isset($value['pivot']) && !is_null($value['pivot']['image']) ? $value['pivot']['image'] : $value['image'];
        $price = isset($value['pivot']) ? ($value['pivot']['price'] - ($value['pivot']['price'] * $value['pivot']['discount'] / 100)) : null;
        $oldPrice = isset($value['pivot']) ? $value['pivot']['price'] : null;

        return new PositionObject(
            id: $value['id'],
            name: $value['name'],
            slug: $value['slug'],
            description: $value['description'],
            image: $image,
            price: $price,
            oldPrice: $oldPrice,
            discount: isset($value['pivot']) ? $value['pivot']['discount'] : null,
        );
    }
}
