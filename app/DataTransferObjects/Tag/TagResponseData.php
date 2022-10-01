<?php

namespace App\DataTransferObjects\Tag;

use App\Models\Tag;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TagResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Tag */
    public Tag $tag;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $tag = new TagData($this->tag->toArray());
        return $this->responseSuccess($this->message, $tag);
    }
}
