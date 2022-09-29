<?php

namespace App\DataTransferObjects\Position;

use App\Models\Position;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PositionResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Position */
    public Position $position;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $position = new PositionData($this->position->toArray());
        return $this->responseSuccess($this->message, $position);
    }
}
