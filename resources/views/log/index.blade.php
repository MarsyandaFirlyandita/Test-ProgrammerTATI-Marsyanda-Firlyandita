@extends('layouts.app')

@section('content')
    <h2>Log Harian</h2>

    {{-- Tampilkan pesan sukses --}}
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    {{-- Tombol tambah log hanya untuk staff --}}
    @if(auth()->user()->jabatan === 'staff')
        <a href="{{ route('log.create') }}">+ Tambah Log</a>
    @endif

    <table border="1" cellpadding="8" cellspacing="0" style="margin-top: 15px; width:100%;">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Kegiatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->tanggal }}</td>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->kegiatan }}</td>
                    <td>{{ ucfirst($log->status) }}</td>
                    <td>
                        {{-- Jika pengguna adalah pemilik log dan status masih pending --}}
                        @if (auth()->id() == $log->user_id && $log->status === 'pending')
                            <a href="{{ route('log.edit', $log->id) }}">Edit</a> |
                            <form action="{{ route('log.destroy', $log->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        @endif

                        {{-- Jika pengguna adalah atasan langsung (kepala bidang atau kepala dinas) --}}
                        @if ($log->user->atasan_id == auth()->id() && $log->status === 'pending')
                            <form action="{{ route('log.verifikasi', $log->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="disetujui">
                                <button type="submit">Setujui</button>
                            </form>
                            <form action="{{ route('log.verifikasi', $log->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit">Tolak</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada log.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
