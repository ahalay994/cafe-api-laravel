<?php

namespace App\DataTransferObjects\AddressesContact;

use App\Models\AddressesContact;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AddressesContactResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var AddressesContact */
    public AddressesContact $addressesContact;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $addressesContact = new AddressesContactData($this->addressesContact->toArray());
        return $this->responseSuccess($this->message, $addressesContact);
    }
}
