<?php

namespace App\DataTransferObjects\User;

use App\Models\User;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class UsersCollection extends DataTransferObject
{
    /** @var User[] */
    #[CastWith(UsersCaster::class)]
    public mixed $collection;
}
