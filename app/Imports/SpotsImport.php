<?php

namespace App\Imports;

use App\Models\Spot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SpotsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['spot'])) {
            return null;
        }
            
        $data = Spot::find($row['spot_id']);
        
        if(empty($data)){
            return new Spot([
                'name' => $row['spot'],
                'info' => $row['info'],
                'address' => $row['address'],
                'image' => $row['image'],
                'city_id' => $row['city_id'],
            ]);
        }
    }
}
