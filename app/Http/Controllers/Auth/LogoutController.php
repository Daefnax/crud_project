<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\Auth\SessionService;

class LogoutController extends Controller
{
    protected SessionService $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function destroy(Request $request): RedirectResponse
    {
        $this->sessionService->logout($request);

        return redirect()->route('login')->with('success', 'Вы вышли.');
    }
}
