@extends('layouts.app')

@section('content')

    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-user"></i> {{ $user->information->username ?? '' }}
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-6 col-xl-6 m-auto">
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                            <img src="{{ !empty($user->media->image) ? '/uploads/' . $user->media->image : '/img/demo/avatars/avatar-m.png' }}"
                                 class="rounded-circle shadow-2 img-thumbnail" alt="" width="150">
                            <h5 class="mb-0 fw-700 text-center mt-3">
                                {{ $user->information->username ?? '' }}
                                <small class="text-muted mb-0">{{ $user->information->job_title ?? '' }}</small>
                            </h5>

                            <div class="mt-4 text-center demo">
                                @if(!empty($user->socials->instagram))
                                    <a href="{{ $user->socials->instagram }}" class="fs-xl" style="color:#C13584">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if(!empty($user->socials->vk))
                                    <a href="{{ $user->socials->vk }}" class="fs-xl" style="color:#4680C2">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                @endif
                                @if(!empty($user->socials->telegram))
                                    <a href="{{ $user->socials->telegram }}" class="fs-xl" style="color:#0088cc">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="p-3 text-center">
                            <a href="tel:{{ $user->phone ?? '' }}" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mobile-alt text-muted mr-2"></i> {{ $user->information->phone ?? '' }}
                            </a>
                            <a href="mailto:{{ $user->email ?? '' }}" class="mt-1 d-block fs-sm fw-400 text-dark">
                                <i class="fas fa-mouse-pointer text-muted mr-2"></i> {{ $user->email ?? '' }}
                            </a>
                            <address class="fs-sm fw-400 mt-4 text-muted">
                                <i class="fas fa-map-pin mr-2"></i> {{ $user->information->address ?? '' }}
                            </address>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
