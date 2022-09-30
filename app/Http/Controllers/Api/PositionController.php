<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Position\PositionResponseData;
use App\DataTransferObjects\Position\PositionsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Traits\ResponseTrait;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PositionController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $positions = Position::paginate();

        return new ResponsePaginationData([
            'paginator' => $positions,
            'collection' => new PositionsCollection(['collection' => $positions->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return PositionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): NotFoundHttpException|PositionResponseData
    {
        try {
            $position = Position::findOrFail($id);
            return new PositionResponseData(['position' => $position, 'message' => 'Позиция #' . $id . ' успешно получена']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
