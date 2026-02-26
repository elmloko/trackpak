<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        Log::info('Auth controller: starting login flow', [
            'email' => (string) $request->input('email'),
            'ip' => $request->ip(),
            'session_id_before' => $request->session()->getId(),
            'intended_url' => $request->session()->get('url.intended'),
        ]);

        $request->authenticate();

        $request->session()->regenerate();

        Log::info('Auth controller: session regenerated and user authenticated', [
            'user_id' => Auth::id(),
            'session_id_after' => $request->session()->getId(),
            'redirect_default' => RouteServiceProvider::HOME,
            'intended_url' => $request->session()->get('url.intended'),
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Log::info('Auth controller: logout requested', [
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'session_id' => $request->session()->getId(),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
