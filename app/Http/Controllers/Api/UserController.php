<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ResponsePaginationData;
use App\DataTransferObjects\User\UserResponseData;
use App\DataTransferObjects\User\UsersCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UsersRoleRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\UsersRole;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    use ResponseTrait;

    /**
     * @return ResponsePaginationData
     * @throws UnknownProperties
     */
    public function store(): ResponsePaginationData
    {
        $users = User::paginate();

        return new ResponsePaginationData([
            'paginator' => $users,
            'collection' => new UsersCollection(['collection' => $users->items()]),
        ]);
    }

    /**
     * @param int $id
     * @return UserResponseData|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): UserResponseData|NotFoundHttpException
    {
        try {
            $user = User::findOrFail($id);

            return new UserResponseData(['user' => $user, 'message' => __('controller.user.show', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param RegisterRequest $request
     * @return UserResponseData
     * @throws UnknownProperties
     */
    public function create(RegisterRequest $request): UserResponseData
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user = User::find($user->id);
        return new UserResponseData(['user' => $user, 'message' => __('controller.user.create')]);
    }

    /**
     * @param int $id
     * @param UserRequest $request
     * @return NotFoundHttpException|UserResponseData
     * @throws UnknownProperties
     */
    public function update(UserRequest $request, int $id): NotFoundHttpException|UserResponseData
    {
        try {
            $user = User::findOrFail($id);
            $user->email = $request->email ?? $user->email;
            $user->blocked = $request->blocked ?? $user->blocked;
            $user->password = isset($request->password) ? Hash::make($request->password) : $user->password;
            $user->save();

            return new UserResponseData(['user' => $user, 'message' => __('controller.user.update', ['id' => $id])]);
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param int $id
     * @return NotFoundHttpException|JsonResponse
     */
    public function delete(int $id): NotFoundHttpException|JsonResponse
    {
        try {
            User::destroy($id);

            return $this->responseSuccess(__('controller.user.delete', ['id' => $id]));
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
            User::onlyTrashed()->findOrFail($id)->restore();

            return $this->responseSuccess(__('controller.user.restore', ['id' => $id]));
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }

    /**
     * @param UsersRoleRequest $request
     * @return JsonResponse
     */
    public function addRole(UsersRoleRequest $request): JsonResponse
    {
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        $usersRole = UsersRole::firstWhere(['user_id' => $request->user_id, 'role_id' => $request->role_id]);
        if (is_null($usersRole)) {
            UsersRole::create($request->all());
            return $this->responseSuccess(__('controller.user.addRoleSuccess', ['userEmail' => $user->email, 'roleName' => $role->name]));
        } else {
            return $this->responseError(__('controller.user.addRoleError', ['userEmail' => $user->email, 'roleName' => $role->name]));
        }
    }

    /**
     * @param UsersRoleRequest $request
     * @return JsonResponse
     */
    public function removeRole(UsersRoleRequest $request): JsonResponse
    {
        UsersRole::where(['user_id' => $request->user_id, 'role_id' => $request->role_id])->delete();
        $user = User::find($request->user_id);
        $role = Role::find($request->role_id);

        return $this->responseSuccess(__('controller.user.removeRole', ['userEmail' => $user->email, 'roleName' => $role->name]));
    }
}
