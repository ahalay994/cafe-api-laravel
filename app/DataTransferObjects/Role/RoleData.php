<?php

namespace App\DataTransferObjects\Role;

use Spatie\DataTransferObject\DataTransferObject;

class RoleData extends DataTransferObject
{
    /** @var int */
    public int $id;
    /** @var string */
    public string $name;
    /** @var string */
    public string $slug;
}
