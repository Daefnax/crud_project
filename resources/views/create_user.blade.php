@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif


    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-plus-circle"></i> Добавить пользователя
        </h1>
    </div>

    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-6">
                <div class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Общая информация</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <label class="form-label" for="username">Имя</label>
                                <input type="text" id="username" name="username" class="form-control"
                                       value="{{ old('username') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="job_title">Место работы</label>
                                <input type="text" id="job_title" name="job_title" class="form-control"
                                       value="{{ old('job_title') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="phone">Номер телефона</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                       value="{{ old('phone') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="address">Адрес</label>
                                <input type="text" id="address" name="address" class="form-control"
                                       value="{{ old('address') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Безопасность и Медиа</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                       value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Пароль</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="status">Выберите статус</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="online">Онлайн</option>
                                    <option value="away">Отошел</option>
                                    <option value="do_not_disturb">Не беспокоить</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="image">Загрузить аватар</label>
                                <input type="file" id="image" name="image" class="form-control-file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Социальные сети</h2>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                            <i class="fab fa-vk" style="color:#4680C2;"></i>
                                        </span>
                                        </div>
                                        <input type="text" id="vk" name="vk"
                                               class="form-control border-left-0 bg-transparent pl-0" placeholder="VK"
                                               value="{{ old('vk') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                            <i class="fab fa-telegram" style="color:#38A1F3;"></i>
                                        </span>
                                        </div>
                                        <input type="text" id="telegram" name="telegram"
                                               class="form-control border-left-0 bg-transparent pl-0"
                                               placeholder="Telegram"
                                               value="{{ old('telegram') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                            <i class="fab fa-instagram" style="color:#E1306C;"></i>
                                        </span>
                                        </div>
                                        <input type="text" id="instagram" name="instagram"
                                               class="form-control border-left-0 bg-transparent pl-0"
                                               placeholder="Instagram"
                                               value="{{ old('instagram') }}">
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-success">Добавить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
