<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            session()->flash('warning', 'Silakan masuk (login) terlebih dahulu untuk mengerjakan kuis harian, mengakses modul belajar inti, atau bermain gamifikasi.');
            return route('login');
        }
    }
}
