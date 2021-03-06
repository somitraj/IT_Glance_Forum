<?php

namespace IT_Glance_Forum\Http\Controllers\Api;

use IT_Glance_Forum\ExceptionCode;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Http\Request;
use IT_Glance_Forum\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class LoginController
 * @package IT_Glance_Forum\Http\Controllers\Api
 */
class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function Login(Request $request)
    {
        //return $request->username;
        //return $request->all();
        $credentials = $request->only(['username', 'password']);
        $validator = Validator::make($credentials, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationHttpException($validator->errors()->all());
        }

        $user = \IT_Glance_Forum\Models\Users::where('username', '=', $request->username)->first();
        //return $user;

        if (!$user) {
            throw new \Exception('Invalid username', ExceptionCode::INVALID_USER);
        } elseif (!Hash::check($request->password, $user->password)) {
            throw new \Exception('Invalid Password', ExceptionCode::INVALID_PASSWORD);
        }
        //return $user;

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized();
            }
        } catch (JWTException $e) {
            return $this->response->error('could_not_create_token', 500);
        }
        //return $user;
        $user = \IT_Glance_Forum\Models\Users::where('username', '=', $request->username)
            ->where('status_id', '=', 1)
            ->first()->toArray();  //database bata data tanna
        //return $user;
        return response()->json(compact('user', 'token'));

    }
}
