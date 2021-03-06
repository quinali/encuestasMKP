<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Redirect;

class CkeckAdmin
{
    
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        
        
        $user = $request->user();
        

        if(!$user->isAdmin){

            //Si no es admin, por lo menos que sea el usuario administrando su perfil

            return response('Unauthorized.', 401);
        }


        return $next($request);
    }
  
   
}
