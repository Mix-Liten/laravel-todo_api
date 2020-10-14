<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenStoreRequest;
use App\Services\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * Instantiate a new controller instance.
     *
     * @param  AuthService  $authService
     */
    public function __construct(
        AuthService $authService
    ) {
        $this->authService = $authService;
    }

    /**
     * @param  TokenStoreRequest  $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function store(TokenStoreRequest $request)
    {
        $token = $this->authService->createToken(
            $request->input('email'),
            $request->input('password'),
        );

        if (! $token) {
            throw new AuthenticationException();
        }

        return response()->json([
            'access_token' => $token,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function destroy()
    {
        $this->authService->destroyTokens();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}