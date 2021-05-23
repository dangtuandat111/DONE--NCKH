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


class ScheduleImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    //Neu dong duoi bi merge thi van con du lieu dung
    public $goc_malophp = "";
    public $goc_mahp= "";
    public $goc_tenhp= "";
    public $goc_dkien= "";
    public $goc_dki= "";
   	public $goc_kieu= "";
    public $goc_gv= "";
   
    public $goc_thoigian= "";
   	public $goc_sotinchi = "";
   	public $goc_lop= "";
    public $goc_khoa= "";
    private $N = 26;

    public $kind = 1;
    public function collection(Collection $collection)
    {
    	$i = 0;
    	$e = 0;
    	foreach($collection as $row) {
    		if($i == 2) {
    			$dem = 0;
    			for(;$dem <= $this->N;$dem++) {
    				if ($row[$dem] != null) {;break;}
    			}
    			if($dem > $this->N) {
    				
                    break;
    			}
    			else {
    				try {
                        $this->dataChange($row);
                        
                    }catch(Exeption $ex) {
                        return back()->withErrors($ex->getMessage());
                        break;
                    }
    			}
    		}
    		if($row[1] == "STT") {
    			$i = 1;
    			continue;
    		}
    		if($row[1] == null && $i == 1) {
    			$i = 2;
    			continue;
    		}
    		
    	}
    	//return back()->with('thongbao',' Them thanh cong');
    }

    //Phien ban 1
    public function dataChange(Collection $row){
    	
    	$mahp = $row[2];
    	$sotinchi = $row[3];
    	$tenhp = $row[4];
    	$dukien = $row[5];
    	$dangki = $row[6];
    	$kieu = $row[7];
    	$tengv = $row[8];
    	$thoigian = $row[9];
    	$thu[] = [$row[11],$row[13],$row[15],$row[17],$row[19],$row[21],$row[23] ];
    	$room[] = [$row[12],$row[14],$row[16],$row[18],$row[20],$row[22],$row[24] ];
    	$lop = $row[25];
    	$khoa = $row[26];

    	if($mahp == null) {
    		$mahp = $this->goc_mahp;
    		$this->kind ++;
    	}
    	else {
    		$this->kind = 1;
    	}
    	if($sotinchi == null ) {
    		$sotinchi = $this->goc_sotinchi;
    	}
    	if($tenhp == null) {
    		$tenhp = $this->goc_tenhp;
    	}
    	if($dukien == null) {
    		$dukien = $this->goc_dkien;
    	}
    	if($dangki == null ) {
    		$dangki = $this->goc_dki;
    	}
    	if($thoigian == null) {
    		$thoigian = $this->goc_thoigian;
    	}
    	if($kieu == null) {
    		$kieu = $this->goc_kieu;
    	}
    
        try {
            $startTime = explode("-",$thoigian)[0];
            $endTime = explode("-",$thoigian)[1];

            $day_endTime = explode("/",$endTime)[0];
            $month_endTime = explode('/',$endTime)[1];
            $year_endTime = explode('/',$endTime)[2];
            $year_endTime = "20".$year_endTime;
            $endTime = $day_endTime."/".$month_endTime."/".$year_endTime;
            $startTime .= "/";
            $startTime .= $year_endTime;
            $day_startTime = explode("/",$startTime)[0];
            $month_startTime = explode('/',$startTime)[1];
            $year_startTime = explode('/',$startTime)[2];
            $startTime = $day_startTime."/".$month_startTime."/".$year_startTime;
        }catch(Exception $e) {
            return back()->withErrors('Lỗi file ngày tháng');
        }
    	
        //Doc ca hoc
		$ngay = 2; 
		$ca = 0;
		foreach($thu as $ptthu) {
			foreach($ptthu as $tiet){
				if($tiet != null) {
					if ($tiet == "1,2,3") {
						$ca = 1;	
					}
					if ($tiet == "4,5,6") {
						$ca = 2;	
					}
					if ($tiet == "7,8,9") {
						$ca = 3;	
					}
					if ($tiet == "10,11,12") {
						$ca = 4;	
					}
					if ($tiet == "13,14,15") {
						$ca = 5;	
					}
					if ($tiet == "16,17,18") {
						$ca = 6;	
					}
					break;
				}
				else {
					$ngay = $ngay+1;
				}
			}
		}
        //Doc phong hoc
		$phong = null ;
		foreach ($room as $ptroom) {
			# code...
			foreach($ptroom as $ptroom2) {
				if($ptroom2 != null ) {
					$phong = $ptroom2;
					break;
				}
			}
		}

        $startTime = Carbon::createFromFormat('d/m/Y', $startTime)->format('d-m-Y');
        $endTime = Carbon::createFromFormat('d/m/Y', $endTime)->format('d-m-Y');

        $startTime = Carbon::createFromFormat('d-m-Y', $startTime);
        $endTime = Carbon::createFromFormat('d-m-Y', $endTime);    

        $dateBegin = $startTime->addDays($ngay-2);
        $dateEnd = $endTime;

        try{
            $tenmon = explode("-",$tenhp)[0];
            $kihoc = explode("-",$tenhp)[1];
            $nam = explode("-",$tenhp)[2];
            $kieukt = explode(" ",$nam)[1];
            $nam = explode(" ",$nam)[0];
        }catch(Exception $e) {
            return back()->withErrors('Lỗi tên học phần');
        }

        $ID_Module_Class = $mahp."-".$kihoc."-".$nam." ".$kieukt;
        $ID_Module_Class_2 = $ID_Module_Class;
        $Module_Class_Name = $tenhp;
        $Number_Plan =  $dukien;
        $Number_Reality = $dangki;
        $School_Year = $kihoc."-".$nam;
        $ID_Module = $mahp;
        $ID_Teacher = $tengv;

        $this->goc_malophp = $ID_Module_Class;
        $this->goc_tenhp =$Module_Class_Name;
        $this->goc_dkien = $Number_Plan ;
        $this->goc_dki = $Number_Plan;
        $this->goc_school = $School_Year;
        $this->goc_mahp =$ID_Module;
        $this->goc_gv =  $ID_Teacher;
        $this->goc_thoigian = $thoigian;

        $md = new module_class();
        $md = DB::table('module_class')->where('ID_Module_Class','=', $ID_Module_Class)->get();
        $count_md = DB::table('module_class')->where('ID_Module_Class','=', $ID_Module_Class)->count();


        if($count_md > 0) {

        	DB::table('module_class')->update(
				 [	
				 	'Module_Class_Name' => $Module_Class_Name,
				 	'Number_Plan' => $Number_Plan,
				 	'Number_Reality' => $Number_Reality,
				 	'School_Year' => $School_Year,
				 	'ID_Module' => $mahp,
				 	'ID_Teacher' => NULL ]
			);
        }
        else {
            try {
                DB::table('module_class')->insert(
                [  'ID_Module_Class' => $ID_Module_Class,
                    'Module_Class_Name' => $Module_Class_Name,
                    'Number_Plan' => $Number_Plan,
                    'Number_Reality' => $Number_Reality,
                    'School_Year' => $School_Year,
                    'ID_Module' => $ID_Module,
                    'ID_Teacher' => NULL ]
                );
            }catch(Exception $ex) {
                 return back()->withErrors('Có lỗi');
            }
        }

		while($dateEnd >= $dateBegin ) {
			if(trim($phong) == null ) {
				$sch = new schedules();
                $nb_sch = DB::table('schedules')->where('ID_Module_Class','=', $ID_Module_Class_2)->where('ID_Room' ,'= ' ,$phong)->where('Shift_Schedules','=',$ca)->where('Day_Schedules','=', $dateBegin)->count();
                if($nb_sch > 0) {
                    return back()->withErrors('Da ton tai');
                }
				DB::table('schedules')->insert(
				[	'ID_Module_Class' => $ID_Module_Class_2,
				 	'ID_Room' => $phong,
				 	'Shift_Schedules' => $ca,
				 	
				 	'Day_Schedules' => $dateBegin,
				 	'Number_Student' => NULL ]
				);
				
				
			}
			else {
				try {
                    DB::table('schedules')->insert(
                        [   'ID_Module_Class' => $ID_Module_Class_2,
                            'ID_Room' => $phong,
                            'Shift_Schedules' => $ca,
                            
                            'Day_Schedules' => $dateBegin,
                            'Number_Student' => NULL ]
                        );
                }catch(Exception $ex) {
                     return back()->withErrors('Có lỗi');
                }
				
			}
			$dateBegin = $startTime->addWeeks(1);
		}

    }

}
