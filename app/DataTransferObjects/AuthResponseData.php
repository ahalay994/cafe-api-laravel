<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\User\UserData;
use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;

class AuthResponseData extends DataTransferObject implements Responsable
{
    /** @var User */
    public User $user;

    /**
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $userAccesses = [];
        foreach ($this->user->roles as $role) {
            $accessNames = $role->accesses->pluck('name')->toArray();
            $userAccesses = array_merge($userAccesses, $accessNames);
        }
        // собираем все полномочия для текущего пользователя
        $userAccesses = array_values(array_unique($userAccesses));
        return response()->json(
            [
                'user' => new UserData($this->user->toArray()),
                'token' => $this->user->createToken(env('APP_TOKEN'), $userAccesses)->plainTextToken,
            ],
            Response::HTTP_OK
        );
    }
}
