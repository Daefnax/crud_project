<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Учебный проект')</title>
    <meta name="description" content="@yield('description', 'Описание сайта')">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/vendors.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/skin-master.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa-solid.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa-brands.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fa-regular.css') }}">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
    <a class="navbar-brand d-flex align-items-center fw-500" href="{{ route('users') }}">
        <img alt="logo" class="d-inline-block align-top mr-2" src="{{ asset('img/logo.png') }}"> Учебный проект
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Переключить навигацию">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('users') }}">Главная <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Войти</a>
                </li>
            @else
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link p-0">Выйти</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<main id="js-page-content" role="main" class="page-content mt-3">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('danger'))
        <div class="alert alert-danger">{{ session('danger') }}</div>
    @endif

    @yield('content')

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
</main>

<footer class="page-footer" role="contentinfo">
    <div class="d-flex align-items-center flex-1 text-muted">
        <span class="hidden-md-down fw-700">2020 © Учебный проект</span>
    </div>
    <div>
        <ul class="list-table m-0">
            <li><a href="#" class="text-secondary fw-700">Home</a></li>
            <li class="pl-3"><a href="#" class="text-secondary fw-700">About</a></li>
        </ul>
    </div>
</footer>

<!-- JS -->
<script src="{{ asset('js/vendors.bundle.js') }}"></script>
<script src="{{ asset('js/app.bundle.js') }}"></script>
<script>
    $(document).ready(function () {
        $('input[type=radio][name=contactview]').change(function () {
            if (this.value === 'grid') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                $('#js-contacts .js-expand-btn').addClass('d-none');
                $('#js-contacts .card-body + .card-body').addClass('show');
            } else if (this.value === 'table') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                $('#js-contacts .js-expand-btn').removeClass('d-none');
                $('#js-contacts .card-body + .card-body').removeClass('show');
            }
        });

        if (typeof initApp !== 'undefined') {
            initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        }
    });
</script>
</body>
</html>
