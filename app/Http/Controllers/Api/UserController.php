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
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return UserResponseData|Exception|NotFoundHttpException
     * @throws UnknownProperties
     */
    public function show(int $id): NotFoundHttpException|Exception|UserResponseData
    {
        try {
            $user = User::findOrFail($id);
            return new UserResponseData(['user' => $user, 'message' => 'Пользователь #' . $id . ' успешно получен']);
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
        return new UserResponseData(['user' => $user, 'message' => 'Пользователь успешно создан']);
    }

    /**
     * @param int $id
     * @param UserRequest $request
     * @return Exception|NotFoundHttpException|UserResponseData
     * @throws UnknownProperties
     */
    public function update(UserRequest $request, int $id): NotFoundHttpException|Exception|UserResponseData
    {
        try {
            $user = User::findOrFail($id);
            $user->email = $request->email ?? $user->email;
            $user->blocked = $request->blocked ?? $user->blocked;
            $user->password = isset($request->password) ? Hash::make($request->password) : $user->password;
            $user->save();

            return new UserResponseData(['user' => $user, 'message' => 'Пользователь успешно обновлён']);
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
            User::findOrFail($id)->delete();

            return $this->responseSuccess('Пользователь успешно удалён');
        } catch (NotFoundHttpException $exception) {
            return $exception;
        }
    }
}
