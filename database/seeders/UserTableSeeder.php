<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //User::factory()->count(30)->create();
        DB::table('users')->delete();
        DB::table('users')->insert([
            'name' => 'Rabie',
            'email' => 'rabie@gmail.com',
            'password' => Hash::make('11111111'),
        ]);
    }
}
