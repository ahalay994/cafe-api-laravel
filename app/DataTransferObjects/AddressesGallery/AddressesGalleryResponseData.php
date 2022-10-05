<?php

namespace App\DataTransferObjects\AddressesGallery;

use App\Models\AddressesGallery;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AddressesGalleryResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var AddressesGallery */
    public AddressesGallery $addressesGallery;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $addressesGallery = new AddressesGalleryData($this->addressesGallery->toArray());
        return $this->responseSuccess($this->message, $addressesGallery);
    }
}
