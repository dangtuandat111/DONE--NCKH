<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements  WithMultipleSheets 
{
   
    public function sheets(): array
    {
        return [
            'Worksheet 1' => new FirstSheetImport(),
            'Worksheet 2' => new SecondSheetImport(),
        ];
    }
}