<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\CitiesImport;
use Maatwebsite\Excel\Facades\Excel;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new CitiesImport, 'spot.xlsx');
    }
}
