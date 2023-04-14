<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Repositories\AuthRepository;

class LoginController extends Controller
{
    use ResponseTrait;


    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }
    /**
     * @OA\POST(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login",
     *     description="Login to system.",
     *     operationId="login",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description="User Email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User password",
     *                     type="string"
     *                 ),
     *                 required={"email", "password"}
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->login($request->all());
            return $this->responseSuccess($data, 'Logged in successfully');
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage());
        }
    }
}
