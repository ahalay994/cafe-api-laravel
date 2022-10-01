<?php

namespace App\DataTransferObjects\Tag;

use App\Models\Tag;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class TagsCollection extends DataTransferObject
{
    /** @var Tag[] */
    #[CastWith(TagsCaster::class)]
    public mixed $collection;
}
