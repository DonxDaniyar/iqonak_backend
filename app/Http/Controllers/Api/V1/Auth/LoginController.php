<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Auth\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ApiResponseHelpers;
    private $userService;
    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Sign in method
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function signIn(LoginRequest $request): JsonResponse
    {
        try {
            return $this->respondWithSuccess([
                'access_token' => $this->userService->login($request->validated())
            ]);
        }catch (\Exception $e) {
            report($e);
            return $this->respondError($e->getMessage());
        }
    }

    /**
     * Sign out method
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return $this->respondWithSuccess();
    }

    /**
     * Get User Information
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondWithSuccess(UserResource::make(User::with('roles')
                ->where('id', auth()->id())
                ->first()));
    }
}
