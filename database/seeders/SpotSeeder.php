<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\SpotsImport;
use Maatwebsite\Excel\Facades\Excel;

class SpotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new SpotsImport, 'spot.xlsx');
    }
}
