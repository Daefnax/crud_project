@extends('layouts.app')

@section('content')

<div class="subheader">
    <h1 class="subheader-title">
        <i class="subheader-icon fal fa-sun"></i> Установить статус
    </h1>
</div>

<form method="POST" action="{{ route('update.status', $user) }}">
    @csrf

    <div class="row">
        <div class="col-xl-6">
            <div id="panel-1" class="panel">
                <div class="panel-container">
                    <div class="panel-hdr">
                        <h2>Установка текущего статуса</h2>
                    </div>
                    <div class="panel-content">
                        <div class="form-group">
                            <label class="form-label" for="status">Выберите статус</label>
                            <select class="form-control" id="status" name="status">
                                <option value="online" {{ ($current_status ??
                                '') === 'online' ? 'selected' : '' }}>Онлайн</option>
                                <option value="away" {{ ($current_status ??
                                '') === 'away' ? 'selected' : '' }}>Отошел</option>
                                <option value="do_not_disturb" {{ ($current_status ??
                                '') === 'do_not_disturb' ? 'selected' : '' }}>Не беспокоить</option>
                            </select>
                        </div>
                        <div class="d-flex flex-row-reverse mt-3">
                            <button type="submit" class="btn btn-warning">Установить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
