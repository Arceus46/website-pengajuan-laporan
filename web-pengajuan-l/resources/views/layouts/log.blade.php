<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul')</title>
    <link rel="stylesheet" href="{{ asset('Assets/CSS/ya.css') }}">
</head>
<body>
    <div class="container">
        <div class="main-content">
            @yield('content')
        </div>
    </div>

    <button id="themeToggle" class="btn" style="position: fixed; top: 15px; right: 15px;">🌙</button>
    <div id="toastRoot" class="toast-container" aria-live="polite" aria-atomic="true"></div>

    {{-- Path JS diperbaiki dengan asset() --}}
    <script src="{{ asset('Assets/JS/ya.js') }}"></script>
</body>
</html>