<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRoleAndEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$rol): Response
    {
        $user = $request->user();
        
        // Verificar si el usuario tiene el rol necesario
        if (!in_array($user->rol_id, $rol)) {
            return response()->json(['message' => 'No tienes permiso para acceder a esta ruta.'], 403);
        }
        
        // Verificar si el correo electrónico del usuario ha sido verificado
        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Debes verificar tu correo electrónico antes de poder acceder a esta ruta.'], 403);
        }

        return $next($request);
    }
        
}
