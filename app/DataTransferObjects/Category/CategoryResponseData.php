<?php

namespace App\DataTransferObjects\Category;

use App\Models\Category;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CategoryResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Category */
    public Category $category;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $category = new CategoryData($this->category->toArray());
        return $this->responseSuccess($this->message, $category);
    }
}
