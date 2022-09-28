<?php

namespace App\DataTransferObjects\Product;

use App\Models\Product;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class ProductsCollection extends DataTransferObject
{
    /** @var Product[] */
    #[CastWith(ProductsCaster::class)]
    public mixed $collection;
}
