<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FoUsers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
  public function register(Request $request) 
  {
    $validator = Validator::make($request->all(), [
      'fname' => ['required'],
      'email' => ['required'],
      'password' => ['required']
    ]);
    
    if ($validator->fails()) {
      return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    
    $hasher = app()->make('hash');
    $fname = $request->input('fname');
    $email = $request->input('email');
    $password = $hasher->make($request->input('password'));
    
    if (FoUsers::where('fu_email_address', $email)->first()) {
      return response()->json([
        'success' => false,
        'message' => 'email is already exists'
      ]);
    }

    
    try {
      FoUsers::create([
        'fu_full_name' => $fname,
        'fu_email_address' => $email,
        'fu_password' => $password
      ]);

      return response()->json([
        'success' => true,
        'message' => 'User created'
      ]);
    } catch (QueryException $err) {
      return response()->json([
        'success' => false,
        'message' => $err->errorInfo
      ]);
    }

  }
}
