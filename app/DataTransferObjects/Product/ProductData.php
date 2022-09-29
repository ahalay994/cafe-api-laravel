<?php

namespace App\DataTransferObjects\Product;

use App\DataTransferObjects\Addition\AdditionData;
use App\DataTransferObjects\Category\CategoryData;
use App\DataTransferObjects\Position\PositionData;
use App\DataTransferObjects\Position\test\PositionResponseData;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class ProductData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $name;

    /** @var string */
    public string $slug;

    /** @var string */
    #[MapFrom('short_description')]
    public string $shortDescription;

    /** @var string */
    public string $description;

    /** @var bool */
    public bool $hidden;

    /** @var int */
    public int $category_id;

    /** @var CategoryData|null */
    public ?CategoryData $category;

    /** @var AdditionData[] */
    #[CastWith(ArrayCaster::class, AdditionData::class)]
    public ?array $additions;

    /** @var PositionData[] */
    #[CastWith(ArrayCaster::class, PositionResponseData::class)]
    public ?array $positions;
}
