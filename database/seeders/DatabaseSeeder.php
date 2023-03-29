<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'position' => 'Administrator'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalapusat@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Pusat'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalacabang@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Cabang'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalalokasi1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Lokasi 1'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalalokasi2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Lokasi 2'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalalokasi3@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Lokasi 3'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalalokasi4@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Lokasi 4'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalalokasi5@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Lokasi 5'
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'kepalalokasi6@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'Approver',
            'position' => 'Kepala Lokasi 6'
        ]);

        DB::table('vehicles')->insert([
            'name' => 'Toyota Avanza',
            'fuel_consumption' => '10',
            'service_range' => '2',
            'service_due' => '2023-04-10',
            'owner' => 'Perusahaan'
        ]);

        DB::table('vehicles')->insert([
            'name' => 'Mitsubishi Fuso',
            'fuel_consumption' => '12',
            'service_range' => '2',
            'service_due' => '2023-04-10',
            'owner' => 'PT. Sewa Abadi'
        ]);

        DB::table('employees')->insert([
            'name' => 'John Doe',
            'position' => 'Teknisi'
        ]);

        DB::table('employees')->insert([
            'name' => 'Lorem Ipsum',
            'position' => 'Teknisi'
        ]);
    }
}
