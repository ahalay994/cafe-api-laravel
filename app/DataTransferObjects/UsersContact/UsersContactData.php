<?php

namespace App\DataTransferObjects\UsersContact;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class UsersContactData extends DataTransferObject
{
    /** @var string|null */
    #[MapFrom('first_name')]
    public ?string $firstName;

    /** @var string|null */
    #[MapFrom('last_name')]
    public ?string $lastName;

    /** @var string|null */
    #[MapFrom('patronymic_name')]
    public ?string $patronymicName;

    /** @var string|null */
    public ?string $phone;

    /** @var string|null */
    #[MapFrom('date_birthday')]
    public ?string $dateBirthday;
}
