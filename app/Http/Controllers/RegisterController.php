<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Repositories\AuthRepository;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    use ResponseTrait;


    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }


    /**
     * @OA\POST(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register",
     *     description="Register to system.",
     *     operationId="register",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="User Name",
     *                     type="string",
     *                     example="Aayan Abdullah"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description="User Email",
     *                     type="string",
     *                     example="abdullah@admin.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User password",
     *                     type="string",
     *                     example="123456"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     description="User confirm password",
     *                     type="string",
     *                     example="123456"
     *                 ),
     *                 required={"name", "email", "password", "password_confirmation"}
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
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->auth->register($request->all());
            return $this->responseSuccess($data, 'User registered successfully');
        } catch (Exception $e) {
            return $this->responseError([], $e->getMessage());
        }
    }
}
