<?php

namespace App\DataTransferObjects\Address;

use App\Models\Address;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AddressResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Address */
    public Address $address;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $address = new AddressData($this->address->toArray());
        return $this->responseSuccess($this->message, $address);
    }
}
