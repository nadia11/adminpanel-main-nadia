<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([ 'branch_name' => 'Barguna',     'division_id' => '1' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Barishal',    'division_id' => '1' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Bhola',       'division_id' => '1' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Jhalokati',   'division_id' => '1' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Patuakhali',  'division_id' => '1' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Pirojpur',    'division_id' => '1' ]);

        DB::table('branches')->insert([ 'branch_name' => 'Bandarban',   'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Brahmanbaria','division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Chandpur',    'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Chattogram',  'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Coxs Bazar',  'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Cumilla',     'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Feni',        'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Khagrachhari','division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Lakshmipur',  'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Noakhali',    'division_id' => '2' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Rangamati',   'division_id' => '2' ]);

        DB::table('branches')->insert([ 'branch_name' => 'Dhaka',      'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Faridpur',   'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Gazipur',    'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Gopalganj',  'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Kishoreganj', 'division_id' => '5' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Madaripur',  'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Manikganj',  'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Munshiganj', 'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Narayanganj','division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Narsingdi',  'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Rajbari',    'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Shariatpur', 'division_id' => '3' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Tangail',    'division_id' => '3' ]);

        DB::table('branches')->insert([ 'branch_name' => 'Bagerhat',    'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Chuadanga',   'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Jashore',     'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Jhenaidah',   'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Khulna',      'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Kushtia',     'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Magura',      'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Meherpur',    'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Narail',      'division_id' => '4' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Satkhira',    'division_id' => '4' ]);

        DB::table('branches')->insert([ 'branch_name' => 'Jamalpur',    'division_id' => '5' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Mymensingh',  'division_id' => '5' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Netrakona',   'division_id' => '5' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Sherpur',     'division_id' => '5' ]);

        DB::table('branches')->insert([ 'branch_name' => 'Bogura',     'division_id' => '6' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Chapai Nawabganj', 'division_id' => '6' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Joypurhat',  'division_id' => '6' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Naogaon',    'division_id' => '6' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Natore',     'division_id' => '6' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Pabna',      'division_id' => '6' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Rajshahi',   'division_id' => '6' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Sirajganj',  'division_id' => '6' ]);

        DB::table('branches')->insert([ 'branch_name' => 'Dinajpur',   'division_id' => '7' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Gaibandha',  'division_id' => '7' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Kurigram',   'division_id' => '7' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Lalmonirhat','division_id' => '7' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Nilphamari', 'division_id' => '7' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Panchagarh', 'division_id' => '7' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Rangpur',    'division_id' => '7' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Thakurgaon', 'division_id' => '7' ]);

        DB::table('branches')->insert([ 'branch_name' => 'Habiganj',    'division_id' => '8' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Moulvibazar', 'division_id' => '8' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Sunamganj',   'division_id' => '8' ]);
        DB::table('branches')->insert([ 'branch_name' => 'Sylhet',      'division_id' => '8' ]);
    }
}
