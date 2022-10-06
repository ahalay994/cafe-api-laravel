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
    public function show(int $id): RoleResponseData|NotFoundHttpException
    {
        try {
            $role = Role::findOrFail($id);

            return new RoleResponseData(['role' => $role, 'message' => __('controller.role.show', ['id' => $id])]);
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

        return new RoleResponseData(['role' => $role, 'message' => __('controller.role.create')]);
    }

    /**
     * @param RoleRequest $request
     * @param int $id
     * @return RoleResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function update(RoleRequest $request, int $id): RoleResponseData|NotFoundHttpException
    {
        try {
            $role = Role::findOrFail($id);
            $role->name = $request->name ?? $role->name;
            $role->slug = $request->slug ?? $role->slug;
            $role->save();

            return new RoleResponseData(['role' => $role, 'message' => __('controller.role.update', ['id' => $id])]);
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
            Role::destroy($id);

            return $this->responseSuccess(__('controller.role.delete', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|NotFoundHttpException
     */
    public function restore(int $id): JsonResponse|NotFoundHttpException
    {
        try {
            Role::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.role.restore', ['id' => $id]));
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

        $rolesAccess = RolesAccess::firstWhere(['role_id' => $request->role_id, 'access_id' => $request->access_id]);
        if (is_null($rolesAccess)) {
            RolesAccess::create($request->all());
            return $this->responseSuccess(__('controller.role.addAccessSuccess', ['roleName' => $role->name, 'accessName' => $access->name]));
        } else {
            return $this->responseError(__('controller.role.addAccessError', ['roleName' => $role->name, 'accessName' => $access->name]));
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

        return $this->responseSuccess(__('controller.role.removeAccess', ['roleName' => $role->name, 'accessName' => $access->name]));
    }
}
