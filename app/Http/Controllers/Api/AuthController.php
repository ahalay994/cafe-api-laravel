<?php

namespace App\Http\Controllers\Api;

use App\DataTransferObjects\AuthResponseData;
use App\DataTransferObjects\User\UserResponseData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * @param RegisterRequest $request
     * @return AuthResponseData
     * @throws UnknownProperties
     */
    public function register(RegisterRequest $request): AuthResponseData
    {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user = User::find($user->id);

        return new AuthResponseData(['user' => $user]);
    }

    /**
     * @param LoginRequest $request
     * @return AuthResponseData|JsonResponse
     * @throws UnknownProperties
     */
    public function login(LoginRequest $request): AuthResponseData|JsonResponse
    {
        if (auth()->attempt($request->all())) {
            $user = auth()->user();

            return new AuthResponseData(['user' => $user]);
        } else {
            return $this->responseError('Ошибка авторизации', Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @return UserResponseData
     * @throws UnknownProperties
     */
    public function userInfo(): UserResponseData
    {
        $user = auth()->user();

        return new UserResponseData(['user' => $user, 'message' => 'Данные текущего пользователя']);

    }

    /**
     * @param EmailVerificationRequest $request
     * @return JsonResponse
     */
    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        $request->fulfill();
        return $this->responseSuccess('Email успешно подтверждён');
    }
}