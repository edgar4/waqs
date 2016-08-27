<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Validator;
use JWTAuth;

class APIController extends Controller
{

    public function register(Request $request)
    {
        $rules = array(
            'password' => 'required',
            'name' => 'required',
            'email' => 'required|email',

        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['error' => [
                'message' => 'Bad Registration Data',
                'code' => 'u01'

            ]], 406);
        } else {
            $password = Input::get('password');
            $name = Input::get('name');
            $email = Input::get('email');
            $uid = uniqid('', true);
            $userCreated = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'unique_id' => $uid,


            ]);
            if (!$userCreated) {
                return Response::json(['error' => [
                    'message' => 'Hahaha , Something Funny happened!! ',
                    'code' => 'u02'
                ]]);

            }
            return Response::json(['data' => [
                'message' => 'Boom!!  that all,  you can log in to your WAQ account'

            ]], 200);
        }
    }


    public function login(Request $request)
    {
        $input = $request->all();
        if (!$token = JWTAuth::attempt($input)) {
            return Response::json(['error' => [
                'message' => 'wrong email or password.',
                'code' => 'u03'

            ]], 406);

        }
        $user = JWTAuth::toUser($token);
        return Response::json([
            'data' => [
                'user' => $user,
                'token' => $token
            ]

        ], 200);
    }


    public function get_user_details(Request $request)
    {
        $rules = array(
            'token' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(['error' => [
                'message' => 'Bad Authentication Data',
                'code' => 'u04'

            ]], 406);
        } else {
            $token = Input::get('token');
            $user = JWTAuth::toUser($token);

        }

    }
}