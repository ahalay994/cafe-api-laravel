<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Addition\AdditionResponseData;
use App\DataTransferObjects\Addition\AdditionsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionRequest;
use App\Models\Addition;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdditionController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $additions = Addition::with('products')->paginate();

        return new ResponsePaginationData([
            'paginator' => $additions,
            'collection' => new AdditionsCollection(['collection' => $additions->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AdditionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): AdditionResponseData|NotFoundHttpException
    {
        try {
            $additions = Addition::findOrFail($id);

            return new AdditionResponseData(['additions' => $additions, 'message' => __('controller.addition.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AdditionRequest $request
     * @return AdditionResponseData
     * @throws UnknownProperties
     */
    public function create(AdditionRequest $request): AdditionResponseData
    {
        $addition = Addition::create($request->all());

        return new AdditionResponseData(['addition' => $addition, 'message' => __('controller.addition.create')]);
    }

    /**
     * @param AdditionRequest $request
     * @param int $id
     * @return AdditionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AdditionRequest $request, int $id): AdditionResponseData|NotFoundHttpException
    {
        try {
            $addition = Addition::findOrFail($id);
            $addition->name = $request->name ?? $addition->name;
            $addition->slug = $request->slug ?? $addition->slug;
            $addition->description = $request->description ?? $addition->description;
            $addition->image = $request->image ?? $addition->image;
            $addition->price = $request->price ?? $addition->price;
            $addition->discount = $request->discount ?? $addition->discount;
            $addition->save();

            return new AdditionResponseData(['addition' => $addition, 'message' => __('controller.addition.update', ['id' => $id])]);
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
            Addition::destroy($id);

            return $this->responseSuccess(__('controller.addition.delete', ['id' => $id]));
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
            Addition::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.addition.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
