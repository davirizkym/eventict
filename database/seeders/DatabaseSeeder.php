<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'amanda@eventict.id'],
            [
                'name' => 'dr. Amanda Putri, Sp.PD',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
                'institution' => 'RSUP Dr. Cipto Mangunkusumo',
                'phone' => '081234567890',
            ]
        );

        User::updateOrCreate(
            ['email' => 'panitia@eventict.id'],
            [
                'name' => 'Sekretariat Panitia Eventict',
                'password' => Hash::make('password123'),
                'role' => 'penyelenggara',
                'institution' => 'PB Ikatan Dokter Indonesia',
                'phone' => '081987654321',
            ]
        );
    }
}
