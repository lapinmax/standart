<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="{{ route('index') }}">{{ config('app.name') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if(auth()->check())
                @can('horoscopes')
                    <li class="nav-item">
                        <a class="nav-link {{ active_check('horoscope*') }}" href="{{ route('index') }}">Horoscopes</a>
                    </li>
                @endcan

                @can('clients')
                    <li class="nav-item">
                        <a class="nav-link {{ active_check('clients*') }}"
                           href="{{ route('clients.index') }}">Clients</a>
                    </li>
                @endcan

                @can('chats')
                    <li class="nav-item">
                        <a class="nav-link {{ active_check('chats*') }}"
                           href="{{ route('chats.index') }}">Chats</a>
                    </li>
                @endcan

                    @can('templates')
                    <li class="nav-item">
                        <a class="nav-link {{ active_check('templates*') }}"
                           href="{{ route('templates.index') }}">Templates</a>
                    </li>
                @endcan

                @can('users')
                    <li class="nav-item">
                        <a class="nav-link {{ active_check('users*') }}"
                           href="{{ route('users.index') }}">Users</a>
                    </li>
                @endcan

                    @can('rules')
                        <li class="nav-item">
                            <a class="nav-link {{ active_check('rules*') }}"
                               href="{{ route('rules.index') }}">Rules</a>
                        </li>
                    @endcan

            @endif
        </ul>
        @if(auth()->check())
            <form class="form-inline" action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn btn-sm btn-danger" type="submit">Logout</button>
            </form>
        @endif
    </div>
</nav>

<div class="container-fluid pt-3 mt-5">
    <div class="row mt-3 mb-3">
        <div class="col-8 mx-auto">
            @yield ('content')
        </div>
    </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>

<script>
    $(document).ready(function () {
        bsCustomFileInput.init()
    })
</script>

@if(count($errors) > 0)
    <script>
        var errors = @json($errors->all());

        notice(errors.join("<br>"), "Error!", 'error');
    </script>
@endif

@if(session('success'))
    <script>
        notice('The operation was successful!', "Success!", 'success');
    </script>
@endif

@yield('scripts')

</body>
</html>
