<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala Dinas
        $kepalaDinas = User::create([
            'name' => 'Kepala Dinas',
            'email' => 'kepala@dinas.com',
            'password' => Hash::make('123456'),
            'jabatan' => 'kepala_dinas',
            'atasan_id' => null
        ]);

        // Kepala Bidang 1
        $kepalaBidang1 = User::create([
            'name' => 'Kepala Bidang 1',
            'email' => 'bidang1@dinas.com',
            'password' => Hash::make('123456'),
            'jabatan' => 'kepala_bidang',
            'atasan_id' => $kepalaDinas->id
        ]);

        // Kepala Bidang 2
        $kepalaBidang2 = User::create([
            'name' => 'Kepala Bidang 2',
            'email' => 'bidang2@dinas.com',
            'password' => Hash::make('123456'),
            'jabatan' => 'kepala_bidang',
            'atasan_id' => $kepalaDinas->id
        ]);

        // Staff
        User::create([
            'name' => 'Staff 1',
            'email' => 'staff1@dinas.com',
            'password' => Hash::make('123456'),
            'jabatan' => 'staff',
            'atasan_id' => $kepalaBidang1->id
        ]);

        User::create([
            'name' => 'Staff 2',
            'email' => 'staff2@dinas.com',
            'password' => Hash::make('123456'),
            'jabatan' => 'staff',
            'atasan_id' => $kepalaBidang2->id
        ]);
    }
}
