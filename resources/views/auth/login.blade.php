<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Войти
    </title>
    <meta name="description" content="Login">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/vendors.bundle.css') }}">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="{{ asset('css/app.bundle.css') }}">
    <link id="myskin" rel="stylesheet" media="screen, print" href="{{ asset('css/skins/skin-master.css') }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="mask-icon" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <link rel="stylesheet" media="screen, print" href="{{ asset('') }}css/page-login-alt.css">
</head>
<body>
<div class="blankpage-form-field">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="{{ asset('img/logo.png') }}" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">Учебный проект</span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
        <form method="POST" action="{{ route('login.post') }}">

            @csrf
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('danger'))
                <div class="alert alert-danger">{{ session('danger') }}</div>
            @endif

            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Эл. адрес" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Пароль</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Пароль" autocomplete="off" required>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-default" aria-label="Войти">Войти</button>
            </div>
        </form>
    </div>
    <div class="blankpage-footer text-center">
        Нет аккаунта? <a href="{{ route('register') }}"><strong>Зарегистрироваться</strong></a>
    </div>
</div>
<video poster="{{ asset('img/backgrounds/clouds.png') }}" id="bgvid" playsinline autoplay muted loop preload="auto">
    <source src="{{ asset('media/video/cc.webm') }}" type="video/webm">
    <source src="{{ asset('media/video/cc.mp4') }}" type="video/mp4">
</video>
<script src="{{ asset('js/vendors.bundle.js') }}"></script>
</body>
</html>
