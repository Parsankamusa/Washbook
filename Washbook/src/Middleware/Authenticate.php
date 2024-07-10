<?php
namespace Simcify\Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Simcify\Database;
use Simcify\Auth;

class Authenticate implements IMiddleware {

    /**
     * Redirect the user if they are unautenticated
     * 
     * @param   \Pecee\Http\Request $request
     * @return  \Pecee\Http]Request
     */
    public function handle(Request $request) : void {

        Auth::remember();
        
        if (Auth::check()) {
            $request->user = Auth::user();

        } else {
            $request->setRewriteUrl(url('Auth@get'));
        }
        // return $request;

    }
}
