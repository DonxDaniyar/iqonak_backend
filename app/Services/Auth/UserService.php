<?php
namespace App\Services\Auth;

use App\Contracts\Auth\UserServiceContract;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceContract
{
    /**
     * Method returns registered user with role
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->roles()->sync([2]);
        return $user;
    }

    /**
     * Method returns access token to user
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function login(array $data): string
    {
        $user = User::where('phone_number', $data['phone_number'])
            ->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new \Exception("Данные не совпадают!");
        }
        return $user->createToken('login')->plainTextToken;
    }
}
