<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;
use PhpParser\Node\Expr\FuncCall;

class AuthRepository
{
    public function login(array $data): array
    {
        $user = $this->getUserByEmail($data['email']);

        if (!$user) {
            throw new Exception("Sorry, User does not exist.", 404);
        }

        if (!$this->isValidPassword($user, $data)) {
            throw new Exception("Sorry, Password does not match", 401);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);
    }

    public function register(array $data): array
    {
        $user = User::create($this->prepareDataForRegister($data));

        if (!$user) {
            throw new Exception("Sorry, User does not registered, Please try again.", 500);
        }

        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function isValidPassword(User $user, array $data): bool
    {
        return Hash::check($data['password'], $user->password);
    }

    public function createAuthToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken('authToken');
    }

    public function getAuthData(User $user, PersonalAccessTokenResult $tokenInstance)
    {
        return [
            'user' => $user,
            'access_token' => $tokenInstance->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString()
        ];
    }

    public function prepareDataForRegister(array $data): array
    {
        return [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];
    }
}
