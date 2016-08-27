<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;

class ApiJobController extends Controller
{
    //

    public function index(Request $request){

        return Response::json([
            'token' => $request['token']
        ]);
    }
}
