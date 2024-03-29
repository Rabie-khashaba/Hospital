<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminTableSeeder::class,
            UserTableSeeder::class,
            SectionTableSeeder::class,
            DoctorTableSeeder::class,
            ImageTableSeeder::class,
           // AppointmentTableSeeder::class,
            ServiceTableSeeder::class,
            PatientTableSeeder::class,
            RayEmployeeTableSeeder::class,
        ]);
    }
}
