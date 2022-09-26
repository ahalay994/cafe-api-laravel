<?php

namespace App\DataTransferObjects\User;

use App\Models\User;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UsersCaster implements Caster
{
    /**
     * @param mixed $value
     * @return array
     * @throws UnknownProperties
     */
    public function cast(mixed $value): array
    {
        return array_map(
            fn (User $user) => new UserData(...$user->toArray()),
            $value
        );
    }
}
