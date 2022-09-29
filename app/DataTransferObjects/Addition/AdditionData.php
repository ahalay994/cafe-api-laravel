<?php

namespace App\DataTransferObjects\Addition;

use App\DataTransferObjects\Product\ProductData;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class AdditionData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $slug;

    /** @var string */
    public string $description;

    /** @var string|null */
    public ?string $image;

    /** @var float */
    #[MapFrom('actual_price')]
    public float $price;

    /** @var float */
    #[MapFrom('old_price')]
    public float $oldPrice;

    /** @var int */
    public int $discount;

    /** @var ProductData[] */
    #[CastWith(ArrayCaster::class, ProductData::class)]
    public ?array $products;
}
