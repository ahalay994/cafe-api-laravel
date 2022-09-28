<?php

namespace App\DataTransferObjects\Product;

use App\Models\Product;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Product */
    public Product $product;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $product = new ProductData($this->product->toArray());
        return $this->responseSuccess($this->message, $product);
    }
}
