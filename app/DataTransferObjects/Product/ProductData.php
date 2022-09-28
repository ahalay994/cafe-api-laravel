<?php

namespace App\DataTransferObjects\Product;

use App\DataTransferObjects\Category\CategoryData;
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
    public string $short_description;

    /** @var string */
    public string $description;

    /** @var float */
    public float $price;

    /** @var float|null */
    public ?float $old_price;

    /** @var int */
    public int $discount;

    /** @var bool */
    public bool $hidden;

    /** @var int */
    public int $category_id;

    /** @var CategoryData|null */
    public ?CategoryData $category;
}
