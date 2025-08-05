@extends('layouts.app')

@section('content')
    <h2>Edit Log Harian</h2>

    {{-- Tampilkan validasi --}}
    @if ($errors->any())
        <div style="color:red;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('log.update', $log->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 10px;">
            <label for="tanggal">Tanggal:</label><br>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $log->tanggal) }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="kegiatan">Kegiatan:</label><br>
            <textarea name="kegiatan" id="kegiatan" rows="4" style="width: 100%;" required>{{ old('kegiatan', $log->kegiatan) }}</textarea>
        </div>

        <button type="submit">Update</button>
        <a href="{{ route('log.index') }}">Batal</a>
    </form>
@endsection
