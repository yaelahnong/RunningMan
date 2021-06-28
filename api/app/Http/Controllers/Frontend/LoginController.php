<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\FoUsers;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
  public function index(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => ['required'],
      'password' => ['required']
    ]);

    if($validator->fails()) {
      return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    
    $hasher = app()->make('hash');
    
    $email = $request->input('email');
    $password = $request->input('password');
    
    try {
      $user = FoUsers::where('fu_email_address', $email)->first();
      if(!$user) {
        return response()->json([
          'success' => false,
          'message' => 'Your email or password incorrect'
        ], 404);
      }
      
      if($hasher->check($password, $user->fu_password)) {
        $token = sha1(time());
        FoUsers::where('fu_id', $user->fu_id)->update(['fu_token' => $token]);
        return response()->json([
          'success' => true,
          'token' => $token,
          'message' => 'Login succeed',
          'user' => $user
        ]);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Your email or password incorrect'
        ], 404);  
      }
    } catch (QueryException $err) {
      return response()->json([
        'success' => false,
        'message' => $err->errorInfo
      ]);
    }
  }
}
