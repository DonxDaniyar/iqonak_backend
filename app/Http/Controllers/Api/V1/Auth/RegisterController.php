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

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function signUp(RegisterRequest $request)
    {
        return $this->userService->registerUser($request->validated());
    }
}
