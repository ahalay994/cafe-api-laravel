<?php

namespace App\DataTransferObjects\Position;

use App\DataTransferObjects\Product\ProductData;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class PositionData extends DataTransferObject
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

    #[MapFrom('pivot')]
    #[CastWith(PositionObjectCaster::class)]
    public PositionObject $data;

//    /** @var float|null */
//    #[MapFrom('pivot.price')]
//    public ?float $price;
//
//    /** @var float|null */
//    #[MapFrom('pivot.discount')]
//    public ?float $discount;
//
//    /** @var string|null */
//    #[MapFrom('pivot.image')]
//    public ?string $imageProductPosition;

//    /** @var ProductData[] */
//    #[CastWith(ArrayCaster::class, ProductData::class)]
//    public ?array $products;
}
