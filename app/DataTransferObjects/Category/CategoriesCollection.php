<?php

namespace App\DataTransferObjects\Category;

use App\Models\Category;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class CategoriesCollection extends DataTransferObject
{
    /** @var Category[] */
    #[CastWith(CategoriesCaster::class)]
    public mixed $collection;
}
