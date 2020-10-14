<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @var User
     */
    private User $user;

    /**
     * Instantiate a new service instance.
     *
     * @param  User  $user
     */
    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * @param  string  $email
     * @param  string  $password
     * @return string|null
     */
    public function createToken(string $email, string $password): ?string
    {
        /** @var User $user */
        $user = $this->user->query()->firstWhere('email', $email);

        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }
        $token = $user->createToken($email);
        return $token->plainTextToken;
    }

    /**
     * @return int
     */
    public function destroyTokens(): int
    {
        /** @var User $user */
        $user = Auth::user();

        return $user->tokens()->delete();
    }
}