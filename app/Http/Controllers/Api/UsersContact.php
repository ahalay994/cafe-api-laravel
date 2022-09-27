<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\User\UserResponseData;
use App\Http\Controllers\Controller;
use App\Http\Requests\UsersContactRequest;
use App\Models\User;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UsersContact extends Controller
{
    /**
     * @param $userId
     * @param UsersContactRequest $request
     * @return UserResponseData
     * @throws UnknownProperties
     */
    public function updateOrCreate($userId, UsersContactRequest $request): UserResponseData
    {
        User::find($userId)
            ->contacts()
            ->updateOrCreate(
                ['user_id' => $userId],
                $request->all()
            );
        $user = User::with(['contacts'])->find($userId);

        return new UserResponseData(['user' => $user, 'message' => 'Данные пользователя успешно обновлены']);
    }
}
