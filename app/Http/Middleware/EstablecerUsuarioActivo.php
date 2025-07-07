<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstablecerUsuarioActivo
{
    public function handle(Request $request, Closure $next)
    {
        $usuario = Auth::user();

        if ($usuario && $usuario->hijos()->exists()) {
            
            $hijoId = $request->query('hijo_id');

            if ($hijoId && $usuario->hijos->contains('id', $hijoId)) {
                // Si el hijo existe, lo establecemos como usuario activo
                session(['usuarioActivo' => $usuario->hijos->firstWhere('id', $hijoId)]);
            } elseif (!session()->has('usuarioActivo')) {
                // Si no hay usuarioActivo aún, lo establecemos como el padre
                session(['usuarioActivo' => $usuario]);
            }
        } else {
            session(['usuarioActivo' => $usuario]);
        }

        return $next($request);
    }
}
