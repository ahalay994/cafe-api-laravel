<?php

namespace App\DataTransferObjects\Product;

use App\Models\Product;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductsCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Product $product) => new ProductData(...$product->toArray()),
            $value
        );
    }
}
