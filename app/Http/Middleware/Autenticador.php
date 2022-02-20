<?php
namespace App\Http\Middleware;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class Autenticador
{
    public function handle(Request $request, \Closure $next)
    {
        try {
            if (!$request->hasHeader('Authorization')) {
                throw new \Exception();
            }
            $authorizationHeader = $request->header('Authorization');
            $token =  str_replace('Bearer ', '', $authorizationHeader);
            $key = new Key(env('JWT_KEY'), 'HS256');


            $dadosAutenticacao = JWT::decode($token, $key);

            $user = User::where('email', $dadosAutenticacao->email)
                ->first();
            if (is_null($user)) {
                throw new \Exception();
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 401);
        }
    }
}
