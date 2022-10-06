<?php

namespace App\DataTransferObjects\Language;

use Spatie\DataTransferObject\DataTransferObject;

class LanguageData extends DataTransferObject
{
    /** @var int */
    public int $id;

    /** @var string */
    public string $key;

    /** @var string */
    public string $name;

    /** @var bool */
    public bool $blocked;
}
