<?php

namespace App\Http\Controllers;

use App\Models\LogHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogHarianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->jabatan, ['kepala_dinas', 'kepala_bidang'])) {
            $logs = LogHarian::whereIn('user_id', $user->bawahan->pluck('id'))->get();
        } else {
            $logs = $user->logHarians;
        }

        return view('log.index', compact('logs'));
    }

    public function create()
    {
        return view('log.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
        ]);

        LogHarian::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'status' => 'pending',
        ]);

        return redirect()->route('log.index')->with('success', 'Log berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $log = LogHarian::findOrFail($id);

        if ($log->user_id != Auth::id()) {
            abort(403);
        }

        return view('log.edit', compact('log'));
    }

    public function update(Request $request, $id)
    {
        $log = LogHarian::findOrFail($id);

        if ($log->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string',
        ]);

        $log->update([
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
        ]);

        return redirect()->route('log.index')->with('success', 'Log berhasil diupdate.');
    }

    public function destroy($id)
    {
        $log = LogHarian::findOrFail($id);

        if ($log->user_id != Auth::id()) {
            abort(403);
        }

        $log->delete();

        return redirect()->route('log.index')->with('success', 'Log berhasil dihapus.');
    }

    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $log = LogHarian::findOrFail($id);

        if ($log->user->atasan_id != Auth::id()) {
            abort(403);
        }

        $log->update([
            'status' => $request->status,
        ]);

        return redirect()->route('log.index')->with('success', 'Log berhasil diverifikasi.');
    }
}
