<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Addition\AdditionResponseData;
use App\DataTransferObjects\Addition\AdditionsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Models\Addition;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdditionController extends Controller
{
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
}
