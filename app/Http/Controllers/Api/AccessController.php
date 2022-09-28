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
use Illuminate\Http\Request;
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
    public function show(int $id): NotFoundHttpException|AccessResponseData
    {
        try {
            $access = Access::findOrFail($id);
            return new AccessResponseData(['access' => $access, 'message' => 'Доступ #' . $id . ' успешно получен']);
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

        return new AccessResponseData(['access' => $access, 'message' => 'Доступ успешно создан']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return AccessResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(Request $request, int $id): NotFoundHttpException|AccessResponseData
    {
        try {
            $access = Access::findOrFail($id);
            $access->name = $request->name ?? $access->name;
            $access->comment = $request->slug ?? $access->slug;
            $access->save();

            return new AccessResponseData(['access' => $access, 'message' => 'Доступ успешно обновлён']);
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
            Access::findOrFail($id)->delete();

            return $this->responseSuccess('Доступ успешно удалён');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
