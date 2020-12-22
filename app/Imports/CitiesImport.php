<?php

namespace App\Imports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitiesImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['city'])) {
            return null;
        }
            
        $data = City::find($row['city_id']);
        
        if(empty($data)){
            return new City([
                'name' => $row['city'],
                'weather' => $row['weather'],
                'degrees' => $row['degree'],
            ]);
        }
        
    }

}
