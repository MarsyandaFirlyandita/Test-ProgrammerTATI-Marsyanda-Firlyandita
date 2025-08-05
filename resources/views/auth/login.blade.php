@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 400px; margin-top: 50px;">
    <h2>Login</h2>

    {{-- Menampilkan pesan error --}}
    @if ($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom: 10px;">
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width: 100%;">
        </div>

        <div style="margin-bottom: 10px;">
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" required style="width: 100%;">
        </div>

        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>

</div>
@endsection
