<?php

namespace App\DataTransferObjects\User;

use App\DataTransferObjects\Role\RoleData;
use App\DataTransferObjects\UsersContact\UsersContactData;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    /**@var int */
    public int $id;

    /** @var string */
    public string $email;

    /** @var string|null */
    #[MapFrom('email_verified_at')]
    public ?string $emailVerifiedAt;

    /** @var bool */
    public ?bool $blocked;

    /** @var RoleData[] */
    #[CastWith(ArrayCaster::class, RoleData::class)]
    public ?array $roles;

    /** @var UsersContactData|null */
    public ?UsersContactData $contacts;
}
