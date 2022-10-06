<?php

namespace App\DataTransferObjects\Language;

use App\Models\Language;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class LanguagesCollection extends DataTransferObject
{
    /** @var Language[] */
    #[CastWith(LanguagesCaster::class)]
    public mixed $collection;
}
