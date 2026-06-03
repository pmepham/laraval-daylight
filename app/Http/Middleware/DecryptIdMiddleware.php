<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class DecryptIdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $encryptedId = $request->route('id');
        if($encryptedId){
            try{
                $decryptedId = _decrypt($encryptedId);
            }catch(Throwable $e){
                return response()->json(['error' => 'invalid id'], 400);
            }
            $request->attributes->set('encrypted_id', $encryptedId);
            $request->attributes->set('decrypted_id', $decryptedId);
        }
        return $next($request);
    }
}
