@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Register</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Jabatan</label>
            <select name="jabatan" id="jabatan" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="kepala_dinas">Kepala Dinas</option>
                <option value="kepala_bidang">Kepala Bidang</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div id="atasan-group" style="display:none;">
            <label>Atasan</label>
            <select name="atasan_id" id="atasan_id">
                <option value="">-- Pilih Atasan --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" data-jabatan="{{ $user->jabatan }}">{{ $user->name }} ({{ $user->jabatan }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Daftar</button>
    </form>
</div>

<script>
document.getElementById('jabatan').addEventListener('change', function () {
    const jabatan = this.value;
    const atasanGroup = document.getElementById('atasan-group');
    const atasanOptions = document.querySelectorAll('#atasan_id option');

    if (jabatan === 'kepala_dinas') {
        atasanGroup.style.display = 'none';
    } else {
        atasanGroup.style.display = 'block';

        atasanOptions.forEach(option => {
            const jabatanAtasan = option.getAttribute('data-jabatan');
            if (
                (jabatan === 'staff' && jabatanAtasan === 'kepala_bidang') ||
                (jabatan === 'kepala_bidang' && jabatanAtasan === 'kepala_dinas')
            ) {
                option.style.display = 'block';
            } else if (option.value !== '') {
                option.style.display = 'none';
            }
        });
    }
});
</script>
@endsection
