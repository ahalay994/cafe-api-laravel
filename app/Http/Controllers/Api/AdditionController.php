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
use Illuminate\Http\Request;
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
    public function show(int $id): NotFoundHttpException|AdditionResponseData
    {
        try {
            $additions = Addition::findOrFail($id);
            return new AdditionResponseData(['additions' => $additions, 'message' => 'Дополнение #' . $id . ' успешно получен']);
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

        return new AdditionResponseData(['addition' => $addition, 'message' => 'Дополнение успешно создано']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return AdditionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(Request $request, int $id): NotFoundHttpException|AdditionResponseData
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

            return new AdditionResponseData(['addition' => $addition, 'message' => 'Дополнение успешно обновлено']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): NotFoundHttpException|JsonResponse
    {
        try {
            Addition::findOrFail($id)->delete();

            return $this->responseSuccess('Дополнение успешно удалено');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return NotFoundHttpException|JsonResponse
     */
    public function restore(int $id): NotFoundHttpException|JsonResponse
    {
        try {
            Addition::withTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess('Дополнение успешно восстановлено');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
