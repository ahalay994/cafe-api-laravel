<?php

namespace App\DataTransferObjects\Language;

use App\Models\Language;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LanguagesCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Language $language) => new LanguageData(...$language->toArray()),
            $value
        );
    }
}
