<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Auth\Events\Registered;

class RegisterPostController extends Controller
{
    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function store(RegisterRequest $request)
    {
        try {
            $user = $this->registerService->register($request->validated());

            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Вы зарегистрированы!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Ошибка регистрации']);
        }
    }
}
