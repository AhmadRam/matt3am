<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API for user authentication (login, logout)"
 * )
 */
class AuthController extends BaseController
{
    /**
     * @OA\Post(
     *     path="/dashboard/login",
     *     operationId="login",
     *     tags={"Authentication"},
     *     summary="Login a user and generate a JWT token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username", "password"},
     *             @OA\Property(property="username", type="string", example="admin"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged in",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Successfully logged in"),
     *             @OA\Property(property="result", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="array", items=@OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError(null, array_values($validator->errors()->all()));
        }

        $jwtToken = auth()->guard('users')->attempt(['username' => $request->username, 'password' => $request->password])
            ?: auth()->guard('users')->attempt(['email' => $request->username, 'password' => $request->password]);

        if ($jwtToken) {
            $user = auth('users')->user();
            $user->token = $jwtToken;
            JWTAuth::setToken($jwtToken)->authenticate();

            return $this->sendResponse($jwtToken, __('app.login.successully_logged'));
        } else {
            return $this->sendError(__('app.login.invalid'), ['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/dashboard/logout",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     summary="Logout the user",
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - No token provided",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        auth()->guard('users')->logout();

        $this->user->token()->revoke();

        return $this->sendResponse([], __('app.login.logout'));
    }
}
