<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Position\PositionResponseData;
use App\DataTransferObjects\Position\PositionsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Models\Position;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    /**
     * @param PositionRequest $request
     * @return PositionResponseData
     * @throws UnknownProperties
     */
    public function create(PositionRequest $request): PositionResponseData
    {
        $position = Position::create($request->all());

        return new PositionResponseData(['position' => $position, 'message' => 'Позиция успешно создана']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return PositionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(Request $request, int $id): NotFoundHttpException|PositionResponseData
    {
        try {
            $position = Position::findOrFail($id);
            $position->name = $request->name ?? $position->name;
            $position->slug = $request->slug ?? $position->slug;
            $position->description = $request->description ?? $position->description;
            $position->image = $request->image ?? $position->image;
            $position->save();

            return new PositionResponseData(['position' => $position, 'message' => 'Позиция успешно обновлена']);
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
            Position::findOrFail($id)->delete();

            return $this->responseSuccess('Позиция успешно удалена');
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
            Position::withTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess('Позиций успешно восстановлена');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
