<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Language\LanguageResponseData;
use App\DataTransferObjects\Language\LanguagesCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LanguageController extends Controller
{
    protected $model = Language::class;
    protected $translatePath = 'controller.language';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $languages = $this->model::paginate();

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
            $language = $this->model::findOrFail($id);

            return new LanguageResponseData(['language' => $language, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $language = $this->model::create($request->all());

        return new LanguageResponseData(['language' => $language, 'message' => __($this->translatePath . '.create')]);
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
            /** @var Language $language */
            $language = $this->model::findOrFail($id);
            $language->key = $request->key ?? $language->key;
            $language->name = $request->name ?? $language->name;
            $language->blocked = $request->blocked ?? $language->blocked;
            $language->save();

            return new LanguageResponseData(['language' => $language, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
