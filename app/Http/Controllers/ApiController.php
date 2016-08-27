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
            return Response::json([
                'error' => true,
                'error_msg' => 'Bad Registration Data',
                'code' => 'u01'

            ], 406);
        } else {
            $password = Input::get('password');
            $name = Input::get('name');
            $email = Input::get('email');
            $uid = uniqid('', true);
            $isUserExist = User::where('email', '=', $email)->get()->toArray();
            if ($isUserExist) {
                return Response::json([
                    'error' => true,
                    'error_msg' => ' Wait a Minute Sparky , That Email is already registered ',
                    'code' => 'u02'
                ]);

            }

            $userCreated = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'unique_id' => $uid,


            ]);
            if (!$userCreated) {
                return Response::json([
                    'error' => true,
                    'error_msg' => 'Hahaha , Something Funny happened!! ',
                    'code' => 'u03'
                ]);

            }
            return Response::json([
                'message' => 'Boom!!  that all,  you can log in to your WAQ account'

            ], 200);
        }
    }


    public function login(Request $request)
    {
        $input = $request->all();
        if (!$token = JWTAuth::attempt($input)) {
            return Response::json([
                'error' => true,
                'error_msg' => 'wrong email or password.',
                'code' => 'u04'

            ], 406);

        }
        $user = JWTAuth::toUser($token);
        return Response::json([
            'user' => $user,
            'token' => $token
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
                'code' => 'u05'

            ]], 406);
        } else {
            $token = Input::get('token');
            $user = JWTAuth::toUser($token);
            return Response::json([
                'user' => $user,
                'token' => $token,
                'error' => false

            ], 200);

        }

    }
}