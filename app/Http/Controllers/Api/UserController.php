<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\ResponsePaginationData;
use App\DataTransferObjects\User\UserResponseData;
use App\DataTransferObjects\User\UsersCollection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserController extends Controller
{
    use ResponseTrait;

    const USER_RELATIONS = [
        'roles',
        'contacts',
    ];

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
     * @return UserResponseData|JsonResponse
     * @throws UnknownProperties
     */
    public function show(int $id): JsonResponse|UserResponseData
    {
        try {
            $user = User::findOrFail($id);
            return new UserResponseData(['user' => $user, 'message' => 'Пользователь #' . $id . ' успешно получен']);
        } catch (ModelNotFoundException $exception) {
            return $this->responseError($exception->getMessage());
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
        return new UserResponseData(['user' => $user, 'message' => 'Пользователь успешно создан']);
    }

    /**
     * @param int $id
     * @param UserRequest $request
     * @return UserResponseData|JsonResponse
     * @throws UnknownProperties
     */
    public function update(UserRequest $request, int $id): JsonResponse|UserResponseData
    {
        try {
            $user = User::findOrFail($id);
            $user->email = $request->email ?? $user->email;
            $user->blocked = $request->blocked ?? $user->blocked;
            $user->password = isset($request->password) ? Hash::make($request->password) : $user->password;
            $user->save();

            return new UserResponseData(['user' => $user, 'message' => 'Пользователь успешно обновлён']);
        } catch (ModelNotFoundException $exception) {
            return $this->responseError($exception->getMessage());
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        try {
            User::findOrFail($id)->delete();

            return $this->responseSuccess('Пользователь успешно удалён');
        } catch (ModelNotFoundException $exception) {
            return $this->responseError($exception->getMessage());
        }
    }
}
