<?php

namespace App\Http\Controllers\Strava;

use App\Http\Controllers\Controller;
use App\Models\FoStravaAuth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Date;

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
        // isExpired = Expires_at < Current Time
        $isExpired = date('Y/m/d H:i:s', $user->fsa_expires_at) < date('Y/m/d H:i:s');
        if(!$isExpired) {
          $response = $client->request('GET', 'https://www.strava.com/api/v3/athlete', [
            'headers' => [
              'Authorization' => 'Bearer ' . $user->fsa_access_token
            ]
          ]);
          $response = json_decode($response->getBody());
          return response()->json($response);
        } else {
          $response = $client->request('POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
              'client_id' => env('STRAVA_CLIENT_ID'),
              'client_secret' => env('STRAVA_SECRET'),
              'grant_type' => 'refresh_token',
              'refresh_token' => $user->fsa_refresh_token
            ]
          ]);
          $responseJson = json_decode($response->getBody()->getContents());
          try {
            FoStravaAuth::where('fsa_fu_id', $id)->update([
              'fsa_token_type' => $responseJson->token_type,
              'fsa_expires_at' => $responseJson->expires_at,
              'fsa_expires_in' => $responseJson->expires_in,
              'fsa_refresh_token' => $responseJson->refresh_token,
              'fsa_access_token' => $responseJson->access_token
            ]);

            $response = $client->request('GET', 'https://www.strava.com/api/v3/athlete', [
              'headers' => [
                'Authorization' => 'Bearer ' . $responseJson->access_token
              ]
            ]);
            $response = json_decode($response->getBody());
            return response()->json($response);
          } catch (QueryException $err) {
            return response()->json([
              'success' => false,
              'message' => $err->errorInfo
            ]);
          }
        }

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
        // isExpired = Expires_at < Current Time
        $isExpired = date('Y/m/d H:i:s', $user->fsa_expires_at) < date('Y/m/d H:i:s');
        if(!$isExpired) {
          $response = $client->request('GET', 'https://www.strava.com/api/v3/athletes/' . $user->fsa_athlete_id . '/stats', [
            'headers' => [
              'Authorization' => 'Bearer ' . $user->fsa_access_token
            ]
          ]);
          $response = json_decode($response->getBody());
          return response()->json($response);
        } else {
          return 'expired_token';
        }
      }
    } catch (QueryException $err) {
      return response()->json([
        'success' => false,
        'message' => $err->errorInfo
      ]);
    }
  }

  public function refresh_token($id) {
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


    $fsa_user = FoStravaAuth::where('fsa_fu_id', $id)->first();

    // is Expires_at < Current Time
    $isExpired = date('d/m/Y H:i:s', 1624902146) < date('d/m/Y H:i:s');

    return response()->json([
      'success' => true,
      'expires_in' => $fsa_user->fsa_expires_in,
      'expires_at' => $fsa_user->fsa_expires_at,
      'refresh_token' => $fsa_user->fsa_refresh_token,
      'access_token' => $fsa_user->fsa_access_token,
      'Expires date' => date('d/m/Y H:i:s', 1624902146),
      'Current Date' => date('d/m/Y H:i:s'),
      'isExpired' => $isExpired
    ]);
  }
}
