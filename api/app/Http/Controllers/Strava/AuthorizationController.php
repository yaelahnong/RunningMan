<?php

namespace App\Http\Controllers\Strava;

use App\Http\Controllers\Controller;
use App\Models\FoStravaAuth;
use App\Models\FoUsers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
  public function store(Request $request) {
    $client = new \GuzzleHttp\Client();
    $authCode = $request->input('auth_code');
    $response = $client->request('POST', 'https://www.strava.com/oauth/token?client_id=67714&client_secret=b67b1cc92e62f9474665d1b411e76f4f8ba4aec3&code='. $authCode .'&grant_type=authorization_code');
    $responseJson = json_decode($response->getBody()->getContents());
    
    try {
      $id = FoStravaAuth::create([
        'fsa_fu_id' => $request->input('fu_id'),
        'fsa_token_type' => $responseJson->token_type,
        'fsa_expires_at' => $responseJson->expires_at,
        'fsa_expires_in' => $responseJson->expires_in,
        'fsa_refresh_token' => $responseJson->refresh_token,
        'fsa_access_token' => $responseJson->access_token,
      ])->id;

      FoUsers::where('fu_id', $request->input('fu_id'))->update([
        'fu_fsa_id' => $id,
        'fu_athlete_id' => $responseJson->athlete->id
      ]);

      return response()->json([
        'success' => true,
        'message' => 'Strava auth created',
      ]);
    } catch (QueryException $err) {
      return response()->json([
        'success' => false,
        'message' => $err->errorInfo
      ]);
    }
  }

  public function destroy($id) {
    $user = FoUsers::where('fu_id', $id)->first();
    if (!$user) { 
      return response()->json([
        'success' => false,
        'message' => 'User not found'
      ]);
    } else {
      try {
        FoStravaAuth::where('fsa_id', $user->fu_fsa_id)->delete();
        FoUsers::where('fu_id', $id)->update([
          'fu_fsa_id' => null,
          'fu_athlete_id' => null
        ]);
        return response()->json([
          'success' => false,
          'message' => 'Strava auth deleted'
        ]);
      } catch (QueryException $err) {
        return response()->json([
          'success' => false,
          'message' => $err->errorInfo
        ]);
      } 
    }
  }
}
