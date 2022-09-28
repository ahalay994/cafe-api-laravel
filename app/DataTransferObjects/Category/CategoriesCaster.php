<?php

namespace App\DataTransferObjects\Category;

use App\Models\Category;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CategoriesCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Category $category) => new CategoryData(...$category->toArray()),
            $value
        );
    }
}
