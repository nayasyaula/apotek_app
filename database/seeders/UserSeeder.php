<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Administrator",
            "email" => "admin@gmail.com",
            // Hash : enkripsi agar password tersimpan berisi teks acak agar tidak bisa dipredikdi/ dibaca orang lain
            // hash -> bcrypt
            "password" => Hash::make('adminapotek'),
            "role" => "admin",
        ]);
        User::create ([
            "name" => "Kasir Apotek",
            "email" => "kasir@gmail.com",
            "password" => Hash::make("kasirapotek"),
            "role" => "cashier",
        ]);
    }
}
