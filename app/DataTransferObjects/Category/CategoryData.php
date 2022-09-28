<?php

namespace App\DataTransferObjects\Category;

use App\DataTransferObjects\Product\ProductData;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $slug;

    /** @var string */
    public string $description;

    /** @var int */
    public int $order;

    /** @var CategoryData|null */
    public ?CategoryData $parent;

    /** @var CategoryData[] */
    #[CastWith(ArrayCaster::class, CategoryData::class)]
    public ?array $children;

    /** @var ProductData[] */
    #[CastWith(ArrayCaster::class, ProductData::class)]
    public ?array $products;
}
