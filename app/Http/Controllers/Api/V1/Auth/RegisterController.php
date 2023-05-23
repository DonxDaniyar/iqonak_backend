<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Contracts\Auth\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $userService;

    /**
     * @param UserServiceContract $userService
     */
    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Method returns sign up of this project
     * @param RegisterRequest $request
     * @return User
     */
    public function signUp(RegisterRequest $request)
    {
        return $this->userService->registerUser($request->validated());
    }
}
