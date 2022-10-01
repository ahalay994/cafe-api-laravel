<?php

namespace App\DataTransferObjects\Partner;

use App\Models\Partner;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PartnerResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Partner */
    public Partner $partner;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $partner = new PartnerData($this->partner->toArray());
        return $this->responseSuccess($this->message, $partner);
    }
}
