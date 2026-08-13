<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Exception;

class SSOMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('token') && !Auth::check()) {
            try {
                $payload = json_decode(Crypt::decryptString($request->token), true);
                
                if (isset($payload['timestamp']) && time() - $payload['timestamp'] <= 300) {
                    
                    $user = User::where('email', $payload['email'])->first();
                    
                    if (!$user) {
                        $user = User::create([
                            'name' => $payload['name'] ?? 'User',
                            'email' => $payload['email'],
                            'password' => bcrypt(uniqid()),
                        ]);
                    }
                    
                    Auth::login($user);
                    
                    return redirect($request->url());
                }
            } catch (Exception $e) {
                // Token không hợp lệ
            }
        }
        
        return $next($request);
    }
}