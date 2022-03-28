<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\AuthService;

class AuthController extends Controller{
    /**
     * Get a JWT via given credentials.
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(){
        $credentials = request(['email', 'password', 'gt']);
        $auth_type = $credentials['gt'] ?? null;
        unset($credentials['gt']);
        $login_result = AuthService::getInstance($auth_type)->login($credentials);

        return response()->json($login_result);
    }

    /**
     * Log the user out (Invalidate the token).
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        $auth_type = request('gt');
        $auth_type = $auth_type ?? null;

        $logout_result = AuthService::getInstance($auth_type)->logout();

        return response()->json($logout_result);
    }

    /**
     * Refresh a token.
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(){
        $auth_type = request('gt');
        $auth_type = $auth_type ?? null;

        $refresh_result = AuthService::getInstance($auth_type)->refresh();

        return response()->json($refresh_result);
    }

    /**
     * Get the current authenticate user(admin or user)
     * @return $mixed
     */
    public function profile(){
        $auth_type = request('gt');
        $auth_type = $auth_type ?? null;
        $user_profile = AuthService::getInstance($auth_type)->user();

        dd($user_profile);
    }
}
