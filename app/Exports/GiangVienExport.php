<?php

namespace App\Exports;
use App\models\teacher;
use DB;
use Response;
use Maatwebsite\Excel\Concerns\FromCollection;


class GiangVienExport implements FromCollection{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function postTeacher() {
        $file = public_path();
        $file_path = "../".$file."File_Export/MAU_THEM_GIANG_VIEN.xlsx";

        return Response::downloand($file,"MAU_THEM_GIANG_VIEN.xlsx");
    }

    public function collection()
    {
        //
         $file = public_path();
        $file_path = "../".$file."File_Export/MAU_THEM_GIANG_VIEN.xlsx";

        return Response::downloand($file,"MAU_THEM_GIANG_VIEN.xlsx");
    }

}
    
