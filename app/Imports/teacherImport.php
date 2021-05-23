<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;
use DateTime;
use DB;
Use Exception;
use App\models\modules;
use App\models\module_class;
use App\models\teacher;
use App\models\schedules;


class teacherImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
     public function collection(Collection $collection)
    {

    	$i = 0 ;
    	foreach ($collection as $row) {
    		# code...
    		if($i<3) {
    			$i++;
    			continue;
    			//echo "day bi loi ";
    		}
    		else {
    			dd($row);
    			$magv = $row[0];
    			$tengv = $row[1];
    			$dob = $row[2];
    			$phone = $row[3];
    			$degree = $row[4];
    			$permission = $row[5];
    			$pass = $row[6];
    			$email = $row[7];
    			$dp = $row[8];
    		}
    	}
    	

    }
}
