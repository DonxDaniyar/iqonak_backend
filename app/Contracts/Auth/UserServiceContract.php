<?php

namespace App\Contracts\Auth;

use App\Models\User;

interface UserServiceContract
{
    public function registerUser(array $data): User;
    public function login(array $data): string;
}
