<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class Authenticate extends Middleware {
    protected $JWTAuth;

    /**
     * Authenticate constructor.
     */
    public function __construct (JWTAuth $JWTAuth, Auth $auth) {
        parent::__construct($auth);
        $this->JWTAuth = $JWTAuth;
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */

    protected function redirectTo ($request) {
        return route('login');
    }

    public function handle ($request, Closure $next, ...$guards) {
        if (in_array('api', $guards) && $token = $this->checkToken()) { // $request->ajax()
            return $token;
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }

    private function checkToken () {
        try {
            $this->JWTAuth->parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(JSONError(['expired' => 'Your session is invalidated. Please re-login']));
        } catch (TokenBlacklistedException $e) {
            return response()->json(JSONError(['blacklisted' => 'Your session is invalidated. Please re-login']));
        } catch (TokenInvalidException $e) {
            return response()->json(JSONError(['invalid' => 'Your session is invalidated. Please re-login']));
        } catch (JWTException $e) {
            return response()->json(JSONError(['unauthenticated' => 'Your session is invalidated. Please re-login']));
        }
    }
}
