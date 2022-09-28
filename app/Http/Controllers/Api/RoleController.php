<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ResponsePaginationData;
use App\DataTransferObjects\Role\RoleResponseData;
use App\DataTransferObjects\Role\RolesCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RolesAccessRequest;
use App\Models\Access;
use App\Models\Role;
use App\Models\RolesAccess;
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
     * @return JsonResponse|NotFoundHttpException
     */
    public function delete(int $id): NotFoundHttpException|JsonResponse
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

    /**
     * @param RolesAccessRequest $request
     * @return JsonResponse
     */
    public function addAccess(RolesAccessRequest $request): JsonResponse
    {
        $role = Role::find($request->role_id);
        $access = Access::find($request->access_id);

        $rolesAccess = RolesAccess::where(['role_id' => $request->role_id, 'access_id' => $request->access_id])->first();
        if (is_null($rolesAccess)) {
            RolesAccess::create($request->all());
            return $this->responseSuccess('Роли "' . $role->name . '" присвоено право "' . $access->name . '"');
        } else {
            return $this->responseError('Роли "' . $role->name . '" уже присвоено право "' . $access->name . '"');
        }
    }

    /**
     * @param RolesAccessRequest $request
     * @return JsonResponse
     */
    public function removeAccess(RolesAccessRequest $request): JsonResponse
    {
        RolesAccess::where(['role_id' => $request->role_id, 'access_id' => $request->access_id])->delete();
        $role = Role::find($request->role_id);
        $access = Access::find($request->access_id);

        return $this->responseSuccess('У роли "' . $role->name . '" удалено право "' . $access->name . '"');
    }
}
