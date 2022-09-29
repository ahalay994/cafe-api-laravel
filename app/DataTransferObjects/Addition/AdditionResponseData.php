<?php

namespace App\DataTransferObjects\Addition;

use App\Models\Addition;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AdditionResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Addition */
    public Addition $addition;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $addition = new AdditionData($this->addition->toArray());
        return $this->responseSuccess($this->message, $addition);
    }
}
