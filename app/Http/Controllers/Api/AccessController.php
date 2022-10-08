<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\Access\AccessesCollection;
use App\DataTransferObjects\Access\AccessResponseData;
use App\DataTransferObjects\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccessRequest;
use App\Models\Access;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccessController extends Controller
{
    protected $model = Access::class;
    protected $translatePath = 'controller.access';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $accesses = $this->model::paginate();

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
            $access = $this->model::findOrFail($id);

            return new AccessResponseData(['access' => $access, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $access = $this->model::create($request->all());

        return new AccessResponseData(['access' => $access, 'message' => __($this->translatePath . '.create')]);
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
            /** @var Access $access */
            $access = $this->model::findOrFail($id);
            $access->name = $request->name ?? $access->name;
            $access->comment = $request->comment ?? $access->comment;
            $access->save();

            return new AccessResponseData(['access' => $access, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
