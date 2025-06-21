@extends('layouts.app')

@section('content')

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-image"></i> Загрузить аватар
        </h1>
    </div>

    <form method="POST" action="{{ route('upload.avatar', $user) }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Текущий аватар</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <img src="{{ $avatarUrl ?: asset('img/demo/avatars/avatar-m.png') }}" alt="avatar" class="img-responsive" width="200">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="image">Выберите аватар</label>
                                <input type="file" id="image" name="image" class="form-control-file" required>
                            </div>

                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Загрузить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
