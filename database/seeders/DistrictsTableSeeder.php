<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([ 'district_name' => 'Barguna',     'division_id' => '1' ]);
        DB::table('districts')->insert([ 'district_name' => 'Barishal',    'division_id' => '1' ]);
        DB::table('districts')->insert([ 'district_name' => 'Bhola',       'division_id' => '1' ]);
        DB::table('districts')->insert([ 'district_name' => 'Jhalokati',   'division_id' => '1' ]);
        DB::table('districts')->insert([ 'district_name' => 'Patuakhali',  'division_id' => '1' ]);
        DB::table('districts')->insert([ 'district_name' => 'Pirojpur',    'division_id' => '1' ]);

        DB::table('districts')->insert([ 'district_name' => 'Bandarban',   'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Brahmanbaria','division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Chandpur',    'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Chattogram',  'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Coxs Bazar',  'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Cumilla',     'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Feni',        'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Khagrachhari','division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Lakshmipur',  'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Noakhali',    'division_id' => '2' ]);
        DB::table('districts')->insert([ 'district_name' => 'Rangamati',   'division_id' => '2' ]);

        DB::table('districts')->insert([ 'district_name' => 'Dhaka',      'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Faridpur',   'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Gazipur',    'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Gopalganj',  'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Kishoreganj', 'division_id' => '5' ]);
        DB::table('districts')->insert([ 'district_name' => 'Madaripur',  'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Manikganj',  'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Munshiganj', 'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Narayanganj','division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Narsingdi',  'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Rajbari',    'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Shariatpur', 'division_id' => '3' ]);
        DB::table('districts')->insert([ 'district_name' => 'Tangail',    'division_id' => '3' ]);

        DB::table('districts')->insert([ 'district_name' => 'Bagerhat',    'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Chuadanga',   'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Jashore',     'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Jhenaidah',   'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Khulna',      'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Kushtia',     'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Magura',      'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Meherpur',    'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Narail',      'division_id' => '4' ]);
        DB::table('districts')->insert([ 'district_name' => 'Satkhira',    'division_id' => '4' ]);

        DB::table('districts')->insert([ 'district_name' => 'Jamalpur',    'division_id' => '5' ]);
        DB::table('districts')->insert([ 'district_name' => 'Mymensingh',  'division_id' => '5' ]);
        DB::table('districts')->insert([ 'district_name' => 'Netrakona',   'division_id' => '5' ]);
        DB::table('districts')->insert([ 'district_name' => 'Sherpur',     'division_id' => '5' ]);

        DB::table('districts')->insert([ 'district_name' => 'Bogura',     'division_id' => '6' ]);
        DB::table('districts')->insert([ 'district_name' => 'Chapai Nawabganj', 'division_id' => '6' ]);
        DB::table('districts')->insert([ 'district_name' => 'Joypurhat',  'division_id' => '6' ]);
        DB::table('districts')->insert([ 'district_name' => 'Naogaon',    'division_id' => '6' ]);
        DB::table('districts')->insert([ 'district_name' => 'Natore',     'division_id' => '6' ]);
        DB::table('districts')->insert([ 'district_name' => 'Pabna',      'division_id' => '6' ]);
        DB::table('districts')->insert([ 'district_name' => 'Rajshahi',   'division_id' => '6' ]);
        DB::table('districts')->insert([ 'district_name' => 'Sirajganj',  'division_id' => '6' ]);

        DB::table('districts')->insert([ 'district_name' => 'Dinajpur',   'division_id' => '7' ]);
        DB::table('districts')->insert([ 'district_name' => 'Gaibandha',  'division_id' => '7' ]);
        DB::table('districts')->insert([ 'district_name' => 'Kurigram',   'division_id' => '7' ]);
        DB::table('districts')->insert([ 'district_name' => 'Lalmonirhat','division_id' => '7' ]);
        DB::table('districts')->insert([ 'district_name' => 'Nilphamari', 'division_id' => '7' ]);
        DB::table('districts')->insert([ 'district_name' => 'Panchagarh', 'division_id' => '7' ]);
        DB::table('districts')->insert([ 'district_name' => 'Rangpur',    'division_id' => '7' ]);
        DB::table('districts')->insert([ 'district_name' => 'Thakurgaon', 'division_id' => '7' ]);

        DB::table('districts')->insert([ 'district_name' => 'Habiganj',    'division_id' => '8' ]);
        DB::table('districts')->insert([ 'district_name' => 'Moulvibazar', 'division_id' => '8' ]);
        DB::table('districts')->insert([ 'district_name' => 'Sunamganj',   'division_id' => '8' ]);
        DB::table('districts')->insert([ 'district_name' => 'Sylhet',      'division_id' => '8' ]);
    }
}
