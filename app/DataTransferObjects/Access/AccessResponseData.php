<?php

namespace App\DataTransferObjects\Access;

use App\Models\Access;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AccessResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Access */
    public Access $access;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $access = new AccessData($this->access->toArray());
        return $this->responseSuccess($this->message, $access);
    }
}
