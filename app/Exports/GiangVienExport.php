<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class GiangVienExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$collection = new Collection();
         $head = ['ID_Teacher','Name_Teacher','DoB_Teacher','Phone_Teacher','University_Teacher_Degree','Permission','User_Name_Teacher','Password_Teacher','',
         		'Email_Teacher','ID_Department','IS_Delete'];
         $collection->push($head);
         return $collection;
    }
}

    

