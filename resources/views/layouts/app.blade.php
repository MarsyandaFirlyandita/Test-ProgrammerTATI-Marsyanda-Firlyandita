<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Log Harian Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        nav {
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 10px;
        }

        nav form {
            display: inline;
        }
    </style>
</head>
<body>
        <nav>
        <a href="{{ route('log.index') }}">Log Harian</a>

        @auth
            | <span>Halo, {{ auth()->user()->name }}</span>
            | <a href="#" onclick="document.getElementById('logout-form').submit(); return false;">Logout</a>
        @else
            | <a href="{{ route('login') }}">Login</a>
        @endauth
    </nav>

    <!-- Logout form dipindah ke luar nav -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <hr>

    @yield('content')
</body>
</html>
