<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'admin'
            ],
            [
                'id' => 2,
                'name' => 'Alvi Kh',
                'email' => 'alvi@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user'
            ],
            [
                'id' => 3,
                'name' => 'Dina IK',
                'email' => 'dina@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user'
            ],
            [
                'id' => 4,
                'name' => 'Rayya RR',
                'email' => 'rayya@gmail.com',
                'password' => Hash::make('123'),
                'role' => 'user'
            ],
        ]);

        DB::table('models')->insert([
            [
                'id' => 1,
                'users_id' => 2,
                'gambar' => 'assets/img/labeled_images/Alvi Kh/1.jpg'
            ],
            [
                'id' => 2,
                'users_id' => 2,
                'gambar' => 'assets/img/labeled_images/Alvi Kh/2.jpg'
            ],
            ////
            [
                'id' => 3,
                'users_id' => 4,
                'gambar' => 'assets/img/labeled_images/Rayya RR/1.jpg'
            ],
            [
                'id' => 4,
                'users_id' => 4,
                'gambar' => 'assets/img/labeled_images/Rayya RR/2.jpg'
            ],
            [
                'id' => 5,
                'users_id' => 4,
                'gambar' => 'assets/img/labeled_images/Rayya RR/3.jpg'
            ],
            [
                'id' => 6,
                'users_id' => 4,
                'gambar' => 'assets/img/labeled_images/Rayya RR/4.jpg'
            ],
            [
                'id' => 7,
                'users_id' => 4,
                'gambar' => 'assets/img/labeled_images/Rayya RR/5.jpg'
            ],
            [
                'id' => 8,
                'users_id' => 3,
                'gambar' => 'assets/img/labeled_images/Dina IK/1.jpg'
            ],
            [
                'id' => 9,
                'users_id' => 3,
                'gambar' => 'assets/img/labeled_images/Dina IK/2.jpg'
            ],
        ]);

        //////////////

        DB::table('jadwal')->insert([
            [
                'id' => 1,
                'nama_hari' => 'Senin',
                'status' => 'aktif',
                'waktu_masuk' => '07:30:00',
                'waktu_keluar' => '12:30:00',
            ],
            [
                'id' => 2,
                'nama_hari' => 'Selasa',
                'status' => 'aktif',
                'waktu_masuk' => '07:00:00',
                'waktu_keluar' => '12:00:00',
            ],
            [
                'id' => 3,
                'nama_hari' => 'Rabu',
                'status' => 'aktif',
                'waktu_masuk' => '07:00:00',
                'waktu_keluar' => '11:45:00',
            ],
            [
                'id' => 4,
                'nama_hari' => 'Kamis',
                'status' => 'aktif',
                'waktu_masuk' => '07:15:00',
                'waktu_keluar' => '12:15:00',
            ],
            [
                'id' => 5,
                'nama_hari' => 'Jumat',
                'status' => 'aktif',
                'waktu_masuk' => '07:30:00',
                'waktu_keluar' => '11:30:00',
            ],
        ]);

        ///

        DB::table('gedung')->insert([
            [
                'id' => 1,
                'nama_gedung' => 'JTI',
            ],
            [
                'id' => 2,
                'nama_gedung' => 'GSC',
            ],
        ]);

        ///

        DB::table('ruang')->insert([
            [
                'id' => 1,
                'gedung_id' => 1,
                'nama_ruang' => 'Rekayasa Perangkat Lunak',
            ],
            [
                'id' => 2,
                'gedung_id' => 2,
                'nama_ruang' => 'Data Science',
            ],
        ]);
    }
}
