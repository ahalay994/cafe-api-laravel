<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Position\PositionResponseData;
use App\DataTransferObjects\Position\PositionsCollection;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PositionController extends Controller
{
    protected $model = Position::class;
    protected $translatePath = 'controller.position';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $positions = $this->model::paginate();

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
    public function show(int $id): PositionResponseData|NotFoundHttpException
    {
        try {
            $position = $this->model::findOrFail($id);

            return new PositionResponseData(['position' => $position, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $position = $this->model::create($request->all());

        return new PositionResponseData(['position' => $position, 'message' => __($this->translatePath . '.create')]);
    }

    /**
     * @param PositionRequest $request
     * @param int $id
     * @return PositionResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(PositionRequest $request, int $id): PositionResponseData|NotFoundHttpException
    {
        try {
            /** @var Position $position */
            $position = $this->model::findOrFail($id);
            $position->name = $request->name ?? $position->name;
            $position->slug = $request->slug ?? $position->slug;
            $position->description = $request->description ?? $position->description;
            $position->image = $request->image ?? $position->image;
            $position->save();

            return new PositionResponseData(['position' => $position, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
