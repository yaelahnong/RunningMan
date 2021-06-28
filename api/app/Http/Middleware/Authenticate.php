<?php

namespace App\Http\Middleware;

use App\Models\FoUsers;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
      if ($this->auth->guard($guard)->guest()) {
        if ($request->has('fu_token')) {
          $token = $request->input('fu_token');
          $check_token = FoUsers::where('fu_token', $token)->first();
          if ($check_token == null) {
            $res['success'] = false;
            $res['message'] = 'Permission not allowed!';
            
            return response($res);
          }
        } else {
          $res['success'] = false;
          $res['message'] = 'Login please!';

          return response($res);
        }
      }

      return $next($request);
    }
}
