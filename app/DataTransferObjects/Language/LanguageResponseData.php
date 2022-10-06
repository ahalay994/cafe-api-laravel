<?php

namespace App\DataTransferObjects\Language;

use App\Models\Language;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LanguageResponseData extends DataTransferObject implements Responsable
{
    use ResponseTrait;

    /** @var Language */
    public Language $language;

    /** @var string */
    public string $message;

    /**
     * @param $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function toResponse($request): JsonResponse
    {
        $language = new LanguageData($this->language->toArray());
        return $this->responseSuccess($this->message, $language);
    }
}
