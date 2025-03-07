<?php

/**
 * AuthController class file
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AttributeController class
 *
 * PHP Version 8.3
 *
 * @category Class
 * @package  Api
 * @author   Tayyab <tayyab.hussain.it@gmail.com>
 * @license  https://github.com/tayyabhussainit Private Repo
 * @link     https://github.com/tayyabhussainit/laravel
 */
class AuthController extends Controller
{
    /**
     * Register user
     * 
     * @param Request $request request data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate(
            [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6'
            ]
        );

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response()->json(
            [
                'token' => $user->createToken('API Token')->accessToken
            ]
        );
    }

    /**
     * Login user
     * 
     * @param Request $request request data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json(
                [
                    'token' => Auth::user()->createToken('API Token')->accessToken
                ]
            );
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * Logout user
     * 
     * @param Request $request request data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json(
            [
                'message' => 'Successfully logged out'
            ]
        );

    }
}
