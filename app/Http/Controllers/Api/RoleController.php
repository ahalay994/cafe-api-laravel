<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ResponsePaginationData;
use App\DataTransferObjects\Role\RoleResponseData;
use App\DataTransferObjects\Role\RolesCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoleController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $roles = Role::paginate();

        return new ResponsePaginationData([
            'paginator' => $roles,
            'collection' => new RolesCollection(['collection' => $roles->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return RoleResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): NotFoundHttpException|RoleResponseData
    {
        try {
            $role = Role::findOrFail($id);
            return new RoleResponseData(['role' => $role, 'message' => 'Роль #' . $id . ' успешно получена']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param RoleRequest $request
     * @return RoleResponseData
     * @throws UnknownProperties
     */
    public function create(RoleRequest $request): RoleResponseData
    {
        $role = Role::create($request->all());

        return new RoleResponseData(['role' => $role, 'message' => 'Роль успешно создана']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RoleResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(Request $request, int $id): NotFoundHttpException|RoleResponseData
    {
        try {
            $role = Role::findOrFail($id);
            $role->name = $request->name ?? $role->name;
            $role->slug = $request->slug ?? $role->slug;
            $role->save();

            return new RoleResponseData(['role' => $role, 'message' => 'Роль успешно обновлена']);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return Exception|JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): NotFoundHttpException|JsonResponse|Exception
    {
        try {
            Role::findOrFail($id)->delete();

            return $this->responseSuccess('Роль успешно удалена');
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
            Role::withTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess('Роль успешно восстановлена');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
