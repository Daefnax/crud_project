@extends('layouts.app')

@section('content')

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-users"></i> Пользователи
        </h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            @if ($isAdmin)
                <a class="btn btn-success" href="{{ route('users.create') }}">Добавить</a>
            @endif

            <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                <form method="GET">
                    <input type="text" id="search" name="search" class="form-control shadow-inset-2 form-control-lg"
                           placeholder="Найти пользователя" value="{{ request('search') }}">
                </form>
            </div>
        </div>
    </div>

    <div class="row" id="js-contacts">
        @foreach ($users as $user)
            <div class="col-xl-4">
                <div class="card border shadow-0 mb-g shadow-sm-hover"
                     data-filter-tags="{{ $user->information->username ?? '' }}">
                    <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                        <div class="d-flex flex-row align-items-center">
                            @php
                                $status = $user->media->status ?? 'online';
                                $color = match($status) {
                                    'online' => 'success',
                                    'busy' => 'danger',
                                    'away' => 'warning',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="status status-{{ $color }} mr-3">
                        <a href="{{ route('users.profile', $user) }}">
                            <span class="rounded-circle profile-image d-block"
                                  style="background-image:url('{{ !empty($user->media->image) ? asset('/uploads/' . $user->media->image) : asset('/img/demo/avatars/avatar-m.png') }}'); background-size: cover;">
                            </span>
                        </a>
                    </span>

                            <div class="info-card-text flex-1">
                                @if ($isAdmin || (auth()->id() === $user->id))
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info"
                                       data-toggle="dropdown">
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('users.edit', $user) }}"><i
                                                class="fa fa-edit"></i> Редактировать</a>
                                        <a class="dropdown-item" href="{{ route('security', ['id' => $user->id]) }}"><i
                                                class="fa fa-lock"></i> Безопасность</a>
                                        <a class="dropdown-item" href="{{ route('status', ['id' => $user->id]) }}"><i
                                                class="fa fa-sun"></i> Установить статус</a>
                                        <a class="dropdown-item"
                                           href="{{ route('upload.avatar.form', $user) }}">
                                            <i class="fa fa-camera"></i> Загрузить аватар
                                        </a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Удалить пользователя?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                <i class="fa fa-window-close"></i> Удалить
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <span class="text-truncate text-truncate-xl">
                            {{ $user->information->username ?? '' }}
                        </span>
                                <span class="text-truncate text-truncate-xl">
                            {{ $user->information->job_title ?? '' }}
                        </span>
                            </div>

                            <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse"
                                    data-target="{{ $user->id }}" aria-expanded="false">
                                <span class="collapsed-hidden">+</span>
                                <span class="collapsed-reveal">-</span>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0 collapse show">
                        <div class="p-3">
                            <a href="tel:{{ $user->information->phone ?? '' }}"
                               class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i>
                                {{ $user->information->phone ?? '' }}
                            </a>

                            <a href="mailto:{{ $user->email ?? '' }}" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i>
                                {{ $user->email ?? '' }}
                            </a>

                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i>
                                {{ $user->information->address ?? '' }}
                            </address>

                            <div class="d-flex flex-row">
                                @if (!empty($user->socials->vk))
                                    <a href="{{ $user->socials->vk }}" class="mr-2 fs-xxl" style="color:#4680C2"><i
                                            class="fab fa-vk"></i></a>
                                @endif
                                @if (!empty($user->socials->telegram))
                                    <a href="{{ $user->socials->telegram }}" class="mr-2 fs-xxl"
                                       style="color:#38A1F3"><i class="fab fa-telegram"></i></a>
                                @endif
                                @if (!empty($user->socials->instagram))
                                    <a href="{{ $user->socials->instagram }}" class="mr-2 fs-xxl" style="color:#E1306C"><i
                                            class="fab fa-instagram"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endsection
