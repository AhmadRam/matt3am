<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\BaseController;
use App\Repositories\RegisterDeviceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{

    /**
     * Login a user and generate a JWT token.
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
            // $user_res = new UserResource($user);
            // $success = $user_res->toArray([]);

            $success['token'] =  $jwtToken;
            if (isset($request->fcm_token)) {
                $registerd_device_data = [
                    'user_id'        => $user->id,
                    'fcm_token'      => $request->fcm_token,
                    'os'             => $request->os,
                ];
                $registerDeviceRepository = app(RegisterDeviceRepository::class);
                $registerDevice = $registerDeviceRepository->findOneWhere($registerd_device_data);

                if (!$registerDevice) {
                    $registerDevice = $registerDeviceRepository->create($registerd_device_data);
                }
            }

            return $this->sendResponse($success, __('app.login.successully_logged'));
        } else {

            return $this->sendError(__('app.login.invalid'), ['error' => 'Unauthorized'], 401);
        }
    }
}
