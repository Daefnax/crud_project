<?php

namespace Tests\Feature\Session;

use App\Services\Auth\SessionService;
use Illuminate\Http\Request;
use Tests\TestCase;

class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;

    public function setUp(): void
    {
        parent::setUp();
        $this->sessionService = app()->make(SessionService::class);
    }

    public function test_session_regenerate_after_login(): void
    {
        $request = Request::create('login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $request->setLaravelSession($this->app['session.store']);

        $oldSessionId = $request->session()->getId();

        $this->sessionService->regenerateSession($request);

        $newSessionId = $request->session()->getId();

        $this->assertNotSame($oldSessionId, $newSessionId);
    }
}
