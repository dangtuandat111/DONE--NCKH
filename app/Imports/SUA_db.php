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
use App\models\teacher;
use App\models\schedules;
use App\models\module_class;

class ScheduleImport implements ToCollection
{
	public $goc_mahp = "";
	public $goc_malophp ="";
	public $goc_thoigian; // sau khi phan tich
	public $goc_tiet = "";
	public $goc_room = "";
	public $goc_date = ""; // String
	public $N = 21;
	public $goc_thu ;
	public $goc_kieu ;
	public $goc_starttime;
	public $goc_endtime;
		
	

	public function collection(Collection $collection) {
		$r = 0;
		$d1 = 0;
		$d2 = 0;
		$d3 = 0;
		foreach ($collection as $row) {
			if($r < 4) {$r++;continue;}
			else {
				
				if($d1 == 0) {
					$this->goc_malophp = $row[0];
					echo "<br />".$this->goc_malophp."<br />";
					$d1 =1;
				}
				
				else {
					if($row[0] == "Thời gian học :" ){
						$d3 = 1;
						
						
					}
					if($d3 == 1) {
						if($row[2] == null ) {
							$d3 = 0;
							continue;
						}
						else {
							$this->readTime($row);
							continue;
						}
					}
					if($d2 == 2) {
						$dem = 0;
		    			for(;$dem <= $this->N;$dem++) {
		    				if ($row[$dem] != null) { break;}
		    			}
		    			if($dem > $this->N) {
		    				//echo "<br />"."het file ";
		    				break ;
		    			}
		    			else {
		    				$this->dataChange($row);
		    				continue;
		    			}
					}
					if($row[0] == "STT") {
		    			$d2 = 1;
		    			continue;
		    		}
		    		if($row[0] == null && $d2 == 1) {
		    			$d2 = 2;
		    			continue;
		    		}

				}
			}
		}	
	}


	public function readTime(Collection $row) {
		$str = $row[2];
		
		$tt[] = explode(" ",$str);
		
		foreach ($tt as $data ) {
			# code...
			
			if($data[0] == "Từ") {
				$this->goc_starttime = $data[1];
				$this->goc_endtime = $data[3];
				$this->goc_starttime = Carbon::createFromFormat('d/m/Y', $this->goc_starttime)->format('d/m/Y');
        		$this->goc_endtime = Carbon::createFromFormat('d/m/Y',$this->goc_endtime)->format('d/m/Y');
        		 $this->goc_starttime = Carbon::createFromFormat('d/m/Y',$this->goc_starttime);
        $this->goc_endtime = Carbon::createFromFormat('d/m/Y', $this->goc_endtime);  
			}
			else {
				$this->goc_thu = $data[1];
				$this->goc_tiet = $data[3];
				
				$this->goc_room = $data[5];
				
			}

		}
		

	}

	public function dataChange(Collection $row) {
		$lop = $row[1];
		$masv = $row[2];
		$ht = $row[3]." ".$row[4];
		$dob = $row[5];

		echo "<br />";
		echo "ten lop: ".$lop." masv ".$masv." ht ".$ht." dob ".$dob;
		echo "<br />";
		echo "tu: ".$this->goc_starttime." den ".$this->goc_endtime." thu: ".$this->goc_thu." tiet: ".$this->goc_tiet." phong: ".$this->goc_room;
		echo "<br />";

		

        // $startTime = Carbon::createFromFormat('d-m-Y', $startTime);
        // $endTime = Carbon::createFromFormat('d-m-Y', $endTime);    

        $thu = (int)($this->goc_thu);
       
        $startTime = $this->goc_starttime->copy();
        
        $dateBegin = $startTime->addDays($this->goc_thu-2);

        $dateEnd = $this->goc_endtime;

        $ca = 0 ;
        if ($this->goc_tiet == "1,2,3") {
						$ca = 1;	
		}
		if ($this->goc_tiet == "4,5,6") {
			$ca = 2;	
		}
		if ($this->goc_tiet == "7,8,9") {
			$ca = 3;	
		}
		if ($this->goc_tiet == "10,11,12") {
			$ca = 4;	
		}
		if ($this->goc_tiet == "13,14,15") {
			$ca = 5;	
		}
		if ($this->goc_tiet== "16,17,18") {
			$ca = 6;	
		}

        while($dateEnd >= $dateBegin ) {
			
			echo "<br />".$dateBegin;
			try {
				DB::table('participate')->insert(
				[	'ID_Module_Class' => $this->goc_malophp,
				 	'ID_Student' => $masv
				 	 ]
				);
			
			}catch(Exception $e) {}
			
			$dateBegin = $startTime->addWeeks(1);
		}
  
	}
}