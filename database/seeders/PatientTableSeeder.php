<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Patients = new Patient();
        $Patients->email = 'patient@yahoo.com';
        $Patients->password = Hash::make('11111111');
        $Patients->Date_Birth = '1988-12-01';
        $Patients->Phone = '123456789';
        $Patients->Gender = 1;
        $Patients->Blood_Group = 'A+';
        $Patients->save();

        //insert trans
        $Patients->name = 'محمد السيد';
        $Patients->Address = 'القاهرة';
        $Patients->save();
    }
}
