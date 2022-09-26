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
        return response()->json(
            [
                'user' => new UserData($this->user->toArray()),
                'token' => $this->user->createToken(env('APP_TOKEN'))->plainTextToken,
            ],
            Response::HTTP_OK
        );
    }
}
