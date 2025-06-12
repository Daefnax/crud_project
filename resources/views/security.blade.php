@extends('layouts.app')

@section('content')


    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-lock"></i> Безопасность
        </h1>
    </div>

    <form method="POST" action="{{ route('security.update') }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(auth()->user()->can('admin'))
            <input type="hidden" name="user_id" value="{{ $targetUser->id }}">
        @endif

        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Обновление эл. адреса и пароля</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $targetUser->email) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">Пароль</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Подтверждение пароля</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Изменить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
