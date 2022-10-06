<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Access\AccessesCollection;
use App\DataTransferObjects\Access\AccessResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccessRequest;
use App\Models\Access;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccessController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $accesses = Access::paginate();

        return new ResponsePaginationData([
            'paginator' => $accesses,
            'collection' => new AccessesCollection(['collection' => $accesses->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return AccessResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): AccessResponseData|NotFoundHttpException
    {
        try {
            $access = Access::findOrFail($id);

            return new AccessResponseData(['access' => $access, 'message' => __('controller.access.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param AccessRequest $request
     * @return AccessResponseData
     * @throws UnknownProperties
     */
    public function create(AccessRequest $request): AccessResponseData
    {
        $access = Access::create($request->all());

        return new AccessResponseData(['access' => $access, 'message' => __('controller.access.create')]);
    }

    /**
     * @param AccessRequest $request
     * @param int $id
     * @return AccessResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(AccessRequest $request, int $id): AccessResponseData|NotFoundHttpException
    {
        try {
            $access = Access::findOrFail($id);
            $access->name = $request->name ?? $access->name;
            $access->comment = $request->slug ?? $access->slug;
            $access->save();

            return new AccessResponseData(['access' => $access, 'message' => __('controller.access.update', ['id' => $id])]);
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
            Access::destroy($id);

            return $this->responseSuccess(__('controller.access.delete'));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
