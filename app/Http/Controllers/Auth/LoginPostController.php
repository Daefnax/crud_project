<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;
use App\Services\Auth\SessionService;
use Illuminate\Http\RedirectResponse;

class LoginPostController extends Controller
{
    protected LoginService $loginService;
    protected SessionService $sessionService;

    public function __construct(LoginService $loginService, SessionService $sessionService)
    {
        $this->loginService = $loginService;
        $this->sessionService = $sessionService;
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $this->loginService->login($request->validated());

        $this->sessionService->regenerateSession($request);

        return redirect()->route('users')->with('success', 'Вы вошли.');

    }
}
