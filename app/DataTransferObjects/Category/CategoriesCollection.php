<?php

namespace App\DataTransferObjects\Category;

use App\Models\Role;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class CategoriesCollection extends DataTransferObject
{
    /** @var Role[] */
    #[CastWith(CategoriesCaster::class)]
    public mixed $collection;
}
