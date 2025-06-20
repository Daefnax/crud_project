<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Auth\Events\Registered;

class RegisterPostController extends Controller
{

    public function __construct(private RegisterService $registerService)
    {
    }

    public function store(RegisterRequest $request)
    {
        try {
            $user = $this->registerService->register($request->validated());

            event(new Registered($user));

            return redirect()->route('login')->with('success', 'Вы зарегистрированы!');
        } catch (\Throwable $e) {
            report($e); // логирует в laravel.log

            return back()->withErrors([
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : 'Ошибка регистрации. Попробуйте позже.',
            ])->withInput();
        }
    }
}
