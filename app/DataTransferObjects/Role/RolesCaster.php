<?php

namespace App\DataTransferObjects\Role;

use App\Models\Role;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RolesCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (Role $role) => new RoleData(...$role->toArray()),
            $value
        );
    }
}
