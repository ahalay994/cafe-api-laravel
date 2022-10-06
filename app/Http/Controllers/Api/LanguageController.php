<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Language\LanguageResponseData;
use App\DataTransferObjects\Language\LanguagesCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LanguageController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $languages = Language::paginate();

        return new ResponsePaginationData([
            'paginator' => $languages,
            'collection' => new LanguagesCollection(['collection' => $languages->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return LanguageResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): LanguageResponseData|NotFoundHttpException
    {
        try {
            $language = Language::findOrFail($id);

            return new LanguageResponseData(['language' => $language, 'message' => __('controller.language.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param LanguageRequest $request
     * @return LanguageResponseData
     * @throws UnknownProperties
     */
    public function create(LanguageRequest $request): LanguageResponseData
    {
        $language = Language::create($request->all());

        return new LanguageResponseData(['language' => $language, 'message' => __('controller.language.create')]);
    }

    /**
     * @param LanguageRequest $request
     * @param int $id
     * @return LanguageResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(LanguageRequest $request, int $id): LanguageResponseData|NotFoundHttpException
    {
        try {
            $language = Language::findOrFail($id);
            $language->key = $request->key ?? $language->key;
            $language->name = $request->name ?? $language->name;
            $language->blocked = $request->blocked ?? $language->blocked;
            $language->save();

            return new LanguageResponseData(['language' => $language, 'message' => __('controller.language.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): JsonResponse|NotFoundHttpException
    {
        try {
            Language::destroy($id);

            return $this->responseSuccess(__('controller.language.delete', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function restore(int $id): JsonResponse|NotFoundHttpException
    {
        try {
            Language::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.language.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
