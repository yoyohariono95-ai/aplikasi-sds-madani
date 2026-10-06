<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  ...$roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Silakan masuk (login) terlebih dahulu.');
        }

        $user = Auth::user();

        if (!empty($roles) && !in_array($user->role, $roles)) {
            // Provide human friendly role labels for message
            $labels = [
                'siswa' => 'Siswa',
                'guru' => 'Guru',
                'orang_tua' => 'Orang Tua'
            ];
            $allowedLabels = array_map(function($r) use ($labels) {
                return $labels[$r] ?? $r;
            }, $roles);

            $targetRoute = 'home';
            if ($user->role === 'guru') {
                $targetRoute = 'teacher.index';
            } elseif ($user->role === 'orang_tua') {
                $targetRoute = 'parent.index';
            }

            return redirect()->route($targetRoute)->with('warning', 'Halaman tersebut khusus untuk ' . implode(' / ', $allowedLabels) . '. Anda sedang masuk sebagai ' . $user->role_label . '.');
        }

        return $next($request);
    }
}
