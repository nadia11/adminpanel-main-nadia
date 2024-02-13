<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'employee_name' => 'Wajihuddin Ahmed',
            'employee_mobile' => '01740093081',
            'department_id' => 1,
            'designation_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('employees')->insert([
            'employee_name' => 'Md Rabiul Islam',
            'employee_mobile' => '01998369826',
            'department_id' => 4,
            'designation_id' => 13,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('employees')->insert([
            'employee_name' => 'Nasir Uddin Mizi',
            'employee_mobile' => '01921392268',
            'department_id' => 4,
            'designation_id' => 12,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('employees')->insert([
            'employee_name' => 'S Hossain Bahar',
            'employee_mobile' => '01711038606',
            'department_id' => 3,
            'designation_id' => 5,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('employees')->insert([
            'employee_name' => 'Shamim Reza Lalon',
            'employee_mobile' => '01930857710',
            'department_id' => 3,
            'designation_id' => 6,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('employees')->insert([
            'employee_name' => 'Rabiul Islam',
            'employee_mobile' => '01716637050',
            'department_id' => 3,
            'designation_id' => 7,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('employees')->insert([
            'employee_name' => 'Ataur Rahman Titu',
            'employee_mobile' => '01731900707',
            'department_id' => 2,
            'designation_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
