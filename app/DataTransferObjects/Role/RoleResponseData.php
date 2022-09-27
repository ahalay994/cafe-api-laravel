<?php

namespace App\DataTransferObjects\Role;

use App\Models\Role;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RoleResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Role */
    public Role $role;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $user = new RoleData($this->role->toArray());
        return $this->responseSuccess($this->message, $user);
    }
}
