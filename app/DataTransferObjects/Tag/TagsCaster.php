<?php

namespace App\DataTransferObjects\Tag;

use App\Models\Tag;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TagsCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Tag $tag) => new TagData(...$tag->toArray()),
            $value
        );
    }
}
