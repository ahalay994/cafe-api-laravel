<?php

namespace App\DataTransferObjects\Access;

use Spatie\DataTransferObject\DataTransferObject;

class AccessData extends DataTransferObject
{
    /** @var int */
    public int $id;
    /** @var string */
    public string $name;
    /** @var string */
    public string $comment;
}
