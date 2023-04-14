<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseTrait;


    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @OA\Get(
     *     path="/api/profile",
     *     tags={"Authentication"},
     *     summary="User profile",
     *     description="User profile",
     *     operationId="show",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthennticated"
     *     )
     * )
     */
    public function profile()
    {
        try {
            return $this->responseSuccess(Auth::guard()->user(), 'User profile data !');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="User logout",
     *     description="User logout",
     *     operationId="logout",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::guard()->user()->token()->revoke();
           return $this->responseSuccess('', 'User Logged out successfully !');
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage());
        }
    }
}
