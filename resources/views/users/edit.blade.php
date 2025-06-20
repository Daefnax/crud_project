@extends('layouts.app')

@section('content')

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-plus-circle"></i> Редактировать пользователя
        </h1>
    </div>

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Общая информация</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <label class="form-label" for="username">Имя</label>
                                <input type="text" id="username" name="username" class="form-control"
                                       value="{{ old('username', $user->information->username ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="job_title">Место работы</label>
                                <input type="text" id="job_title" name="job_title" class="form-control"
                                       value="{{ old('job_title', $user->information->job_title ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="phone">Номер телефона</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                       value="{{ old('phone', $user->information->phone ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="address">Адрес</label>
                                <input type="text" id="address" name="address" class="form-control"
                                       value="{{ old('address', $user->information->address ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="vk">VK</label>
                                <input type="text" id="vk" name="vk" class="form-control"
                                       value="{{ old('vk', $user->socials->vk ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="telegram">Telegram</label>
                                <input type="text" id="telegram" name="telegram" class="form-control"
                                       value="{{ old('telegram', $user->socials->telegram ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="instagram">Instagram</label>
                                <input type="text" id="instagram" name="instagram" class="form-control"
                                       value="{{ old('instagram', $user->socials->instagram ?? '') }}">
                            </div>

                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                @can('update', $user)
                                    <button type="submit" class="btn btn-warning">Редактировать</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
