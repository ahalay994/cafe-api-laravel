<?php

namespace App\DataTransferObjects\User;

use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var User */
    public User $user;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $user = new UserData($this->user->toArray());
        return $this->responseSuccess($this->message, $user);
    }
}
