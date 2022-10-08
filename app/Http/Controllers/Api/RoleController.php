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
use Illuminate\Http\JsonResponse;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoleController extends Controller
{
    protected $model = Role::class;
    protected $translatePath = 'controller.role';

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $roles = $this->model::paginate();

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
            $role = $this->model::findOrFail($id);

            return new RoleResponseData(['role' => $role, 'message' => __($this->translatePath . '.show', ['id' => $id])]);
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
        $role = $this->model::create($request->all());

        return new RoleResponseData(['role' => $role, 'message' => __($this->translatePath . '.create')]);
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
            /** @var Role $role */
            $role = $this->model::findOrFail($id);
            $role->name = $request->name ?? $role->name;
            $role->slug = $request->slug ?? $role->slug;
            $role->save();

            return new RoleResponseData(['role' => $role, 'message' => __($this->translatePath . '.update', ['id' => $id])]);
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
        /** @var Role $role */
        $role = $this->model::find($request->role_id);
        /** @var Access $access */
        $access = Access::find($request->access_id);

        $rolesAccess = RolesAccess::firstWhere(['role_id' => $request->role_id, 'access_id' => $request->access_id]);
        if (is_null($rolesAccess)) {
            RolesAccess::create($request->all());
            return $this->responseSuccess(__($this->translatePath . '.addAccessSuccess', ['roleName' => $role->name, 'accessName' => $access->name]));
        } else {
            return $this->responseError(__($this->translatePath . '.addAccessError', ['roleName' => $role->name, 'accessName' => $access->name]));
        }
    }

    /**
     * @param RolesAccessRequest $request
     * @return JsonResponse
     */
    public function removeAccess(RolesAccessRequest $request): JsonResponse
    {
        RolesAccess::where(['role_id' => $request->role_id, 'access_id' => $request->access_id])->delete();
        /** @var Role $role */
        $role = $this->model::find($request->role_id);
        /** @var Access $access */
        $access = Access::find($request->access_id);

        return $this->responseSuccess(__($this->translatePath . '.removeAccess', ['roleName' => $role->name, 'accessName' => $access->name]));
    }
}
