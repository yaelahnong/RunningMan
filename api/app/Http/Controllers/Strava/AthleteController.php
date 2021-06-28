<?php

namespace App\Http\Controllers\Strava;

use App\Http\Controllers\Controller;
use App\Models\FoStravaAuth;
use Illuminate\Database\QueryException;

class AthleteController extends Controller
{
  public function index($id) 
  {
    $client = new \GuzzleHttp\Client();
    try {
      $user = FoStravaAuth::where('fsa_fu_id', $id)->first();
      if(!$user) {
        return response()->json([
          'success' => false,
          'message' => 'user auth not found'
        ]);
      } else {
        // $reAuthorizeResponse = $client->request('POST', 'https://www.strava.com/oauth/token', [
        //   'form_params' => [
        //     'client_id' => env('STRAVA_CLIENT_ID'),
        //     'client_secret' => env('STRAVA_SECRET'),
        //     'refresh_token' => $user->fsa_refresh_token,
        //     'grant_type' => 'refresh_token'
        //   ]
        // ]);
        // $reAuthJson = json_decode($reAuthorizeResponse->getBody()->getContents());
        // return response()->json($reAuthJson);
    
        $response = $client->request('GET', 'https://www.strava.com/api/v3/athlete', [
          'headers' => [
            'Authorization' => 'Bearer ' . $user->fsa_access_token
          ]
        ]);
        $response = json_decode($response->getBody());
        return response()->json($response);
      }
    } catch (QueryException $err) {
      return response()->json([
        'success' => false,
        'message' => $err->errorInfo
      ]);
    }
  }

  public function stats($id) 
  {
    $client = new \GuzzleHttp\Client();

    try {
      $user = FoStravaAuth::where('fsa_fu_id', $id)->first();
      if(!$user) {
        return response()->json([
          'success' => false,
          'message' => 'user auth not found'
        ]);
      } else {
        // $reAuthorizeResponse = $client->request('POST', 'https://www.strava.com/oauth/token', [
        //   'form_params' => [
        //     'client_id' => env('STRAVA_CLIENT_ID'),
        //     'client_secret' => env('STRAVA_SECRET'),
        //     'refresh_token' => $user->fsa_refresh_token,
        //     'grant_type' => 'refresh_token'
        //   ]
        // ]);
        // $reAuthJson = json_decode($reAuthorizeResponse->getBody()->getContents());
    
        $response = $client->request('GET', 'https://www.strava.com/api/v3/athletes/87759690/stats', [
          'headers' => [
            'Authorization' => 'Bearer ' . $user->fsa_access_token
          ]
        ]);
        $response = json_decode($response->getBody());
        return response()->json($response);
      }
    } catch (QueryException $err) {
      return response()->json([
        'success' => false,
        'message' => $err->errorInfo
      ]);
    }
  }
}
