<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Carbon\Carbon;
use DateTime;
use DB;
Use Exception;
use App\models\modules;
use App\models\module_class;
use App\models\teacher;
use App\models\schedules;
use App\models\rooms;
use Illuminate\Support\Str;


class ScheduleImport implements ToCollection,WithMultipleSheets,SkipsUnknownSheets
{
    use WithConditionalSheets; 
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
    //Một dòng có 26 cột
    private $N = 26;

    public $kind = 1;
    
    //Hiển thị số dòng thêm thành công
    public $numberSuccess = 0;
    public $numberBlank = 0 ;

    public $arraySchedules = [];
    public $arrayModuleClass = [];
    public $sheet = 1;

   //xảy ra lỗi khi không đủ file
    public function conditionalSheets(): array
    {
        return [
            'CPM' =>  new ScheduleImport(),
            'KHM' =>  new ScheduleImport(),
            'MHT' =>  new ScheduleImport(),
            'CNT' =>  new ScheduleImport(),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }

    public function collection(Collection $collection)
    {
       
    	$i = 0;
    	$e = 0;
        $dong = 0 ;
        $isError = 0;
        $status = '';

        //Bắt đầu đọc file khi thấy STT
        //Cách 1 dòng và bắt đầu đọc
        //Kết thúc đọc file khi gặp dòng toàn là khoảng trống
    	foreach($collection as $row) {
            
            $dong++;
    		if($i == 2) {
    			$dem = 0;
    			for(;$dem <= $this->N;$dem++) {
    				if ($row[$dem] != null) {;break;}
    			}
    			if($dem > $this->N) {
                    break;
    			}
    			else {
                    $status = $this->dataChange($row,$dong);
                    
    				if($status != 'Thành công') {
                        $isError = 1;
                        //echo "<br />".$status." ".$dong;
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
        
        $this->sheet ++;
        if($isError == 1) {
            return back()->withErrors($status.": Dòng ".$dong." - Sheet: ".($this->sheet-1))->with('thongbao','Số trường thêm thành công: '.$this->numberSuccess.' Số học phần chưa có ngày học: '.$this->numberBlank);
        }
    	else {
            // echo $this->numberBlank."<br >";
            // echo $this->numberSuccess;
            // echo '<pre>'; print_r($this->arraySchedules); echo '</pre>'; 
            // echo '<pre>'; print_r($this->arrayModuleClass); echo '</pre>';  echo "DHet";

            DB::table('module_class')->insert($this->arrayModuleClass);
            DB::table('schedules')->insert($this->arraySchedules);
            
            return back()->with('thongbao','Số trường thêm thành công: '.$this->numberSuccess.' Số học phần chưa có ngày học: '.$this->numberBlank);
        }
    }

    public function dataChange(Collection $row,$dong){
       
        
        $arrayB = [];
        //Lay toan bo thong tin tai dong
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
        //ket thuc lay toan bo thong tin 

        //Neu gap dong bi merge thi lay thong tin cua dong truoc do
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
        //Ket thuc neu
        $this->goc_tenhp =$tenhp;
        $this->goc_kieu = $kieu;
        $this->goc_dkien = $dukien ;
        $this->goc_dki = $dangki;
        $this->goc_mahp =$mahp;
        $this->goc_thoigian = $thoigian;
        $this->goc_sotinchi = $sotinchi;

        //Lay thoi gian 
        //Khong kiem tra thoi gian co hop le hay khong
        $startTime = explode("-",$thoigian)[0];
        $endTime = explode("-",$thoigian)[1];

        $day_endTime = explode("/",$endTime)[0];
        $day_endTime_number = (int)$day_endTime;

        $month_endTime = explode('/',$endTime)[1];
        $month_endTime_number = (int)$month_endTime;

        $year_endTime = explode('/',$endTime)[2];
        $year_endTime = "20".$year_endTime;
        $year_endTime_number = (int)$year_endTime;

        $endTime = $day_endTime."/".$month_endTime."/".$year_endTime;

        $day_startTime = explode("/",$startTime)[0];

        $month_startTime = explode('/',$startTime)[1];
        $month_startTime_number = (int)$month_endTime;

        if($month_endTime_number < $month_startTime_number) {
            $year_startTime = (string)($year_endTime_number+1);
        }
        else $year_startTime = (string)($year_endTime_number);

        $startTime = $day_startTime."/".$month_startTime."/".$year_startTime;

        $startTime = Carbon::createFromFormat('d/m/Y', $startTime)->format('d-m-Y');
        $endTime = Carbon::createFromFormat('d/m/Y', $endTime)->format('d-m-Y');

        $startTime = Carbon::createFromFormat('d-m-Y', $startTime);
        $endTime = Carbon::createFromFormat('d-m-Y', $endTime);

        //Het lay thoi gian
    	
        //Doc ca hoc va ngay hoc
        //Kiem tra tu 0 - 6 
        //Nếu ngày tạo không có tiết thì đến ngày mới và ngày (thứ) +1
        //Đã đọc trường hợp 2 ca học trong cùng 1 khoảng thời gian
		$ngay = 0; 
		$ca = NULL;

                    
        // if ($tiet == "1,2,3") {
        //     $ca = 1;    
        // }
        // if ($tiet == "4,5,6") {
        //     $ca = 2;    
        // }
        // if ($tiet == "7,8,9") {
        //     $ca = 3;    
        // }
        // if ($tiet == "10,11,12") {
        //     $ca = 4;    
        // }
        // if ($tiet == "13,14,15") {
        //     $ca = 5;    
        // }
        // if ($tiet == "16,17,18") {
        //     $ca = 6;    
        // }
        // break;
        
		foreach($thu as $ptthu) {
			foreach($ptthu as $tiet){
				if($tiet != null) {
                    if ($tiet == "1,2,3") {
                        $ca = 1;    
                    }
                    elseif ($tiet == "4,5,6") {
                        $ca = 2;    
                    }
                    elseif ($tiet == "7,8,9") {
                        $ca = 3;    
                    }
                    elseif ($tiet == "10,11,12") {
                        $ca = 4;    
                    }
                    elseif ($tiet == "13,14,15,16") {
                        $ca = 5;    
                    }
                    elseif ($tiet == "13,14,15") {
                        $ca = 5;    
                    }
                    elseif ($tiet == "13,14") {
                        $ca = 5;    
                    }
                    elseif ($tiet == "15,16") {
                        $ca = 5;    
                    }
                    else return 'Lỗi ca học: ';
                    break 2;
				}
				else {
					$ngay = $ngay+1;
				}
			}
		}

        //Het doc ca hoc và ngày học

        //Doc phong hoc
		$phong = null ;
		foreach ($room as $ptroom) {
			foreach($ptroom as $ptroom2) {
				if($ptroom2 != null ) {
					$phong = $ptroom2;
					break;
				}
			}
		}
        //Het doc phong
        //Kiểm tra phòng học 
        
        if(!is_null($phong)) {
            //$checkedRoom = new rooms();
            $count_checkedRoom = DB::table('room')->where('ID_Room','=',$phong)->count();
            if($count_checkedRoom == 0 ) {
                return 'Không tồn tại phòng học: '.$phong;
            }
        }
        //Hết kiểm tra phòng học

        //Ngày bắt đầu học và ngày kêt thúc học
        //Kiem tra xem ngay hoc co bi rong khong
        $dateBegin = $startTime->addDays($ngay);
        $dateEnd = $endTime;
        //Hết ngày bắt đầu học và ngày kêt thúc học

        //Đọc tên lớp học phần
        //Tên học phần-Kì học-Năm học 'Loại học phần'


        try{
            $check = explode("-",$tenhp);
            if(count($check) == 4) {
                // dd($tenhp);
                // Hiện tại: Tên LHP - kì học - năm học (kiểu học phần) 
                // $tenmon = explode("-",$tenhp)[0];
                // $kihoc = explode("-",$tenhp)[1];
                // $nam = explode("-",$tenhp)[2];
                // $dothoc = explode("-",$tenhp)[3];
                
                // $kieukt = explode(" ",$dothoc)[1];
                // $dothoc = explode(" ",$dothoc)[0];

                // File 2021-2022 :Tên LHP - kì học - đợt học - năm học(kiểu học phần)
                $tenmon = explode("-",$tenhp)[0];
                $kihoc = explode("-",$tenhp)[1];
                $dothoc = explode("-",$tenhp)[2];
                $nam = explode("-",$tenhp)[3];

                $kieukt  = explode("(",$nam)[1];
                $nam  = explode("(",$nam)[0];

                $kieukt = "(".$kieukt;

                $ID_Module_Class = $mahp."-".$kihoc."-".$nam."-".$dothoc." ".$kieukt;
                //dd($ID_Module_Class);
                $tenhp = $tenmon."-".$kihoc."-".$nam."-".$dothoc." ".$kieukt;

            }
            elseif (count($check) == 3){
                $tenmon = explode("-",$tenhp)[0];
                $kihoc = explode("-",$tenhp)[1];
                $nam = explode("-",$tenhp)[2];
                //dd($nam);

                $kieukt = explode(" ",$nam)[1];
                $nam = explode(" ",$nam)[0];

                $ID_Module_Class = $mahp."-".$kihoc."-".$nam." ".$kieukt;
                
            }
            else return 'Lỗi tên học phần '.$tenhp;
            
        }catch(Exception $e) {
            return 'Lỗi tên học phần: '.$tenhp;
        }

        
        $ID_Module_Class_2 = $ID_Module_Class;
        $Module_Class_Name = $tenhp;
        //Hết đọc tên lớp học phần

        //Đọc số sinh viên dự kiến
        $Number_Plan =  $dukien;
        //Đọc số sinh viên đăng kí

        $Number_Reality = $dangki;
        //Đọc năm học
        $School_Year = $kihoc."-".$nam;
        //Đọc mã học phần
        $ID_Module = $mahp;
       
        //Đọc mã giảng viên
        //$ID_Teacher = $tengv;
       
        //$this->goc_gv =  $ID_Teacher;

        // echo "<br />"."Dữ liệu 1 dòng là: ";
        // echo $dong;
        // echo "<br />".$ID_Module;
        // echo "<br />".$sotinchi;
        // echo "<br />".$ID_Module_Class;
        // echo "<br />".$Module_Class_Name;
        // echo "<br />".$dukien;
        // echo "<br />".$dangki;
        // echo "<br />".$kieu;
        // echo "<br />".$thoigian;
        // echo "<br />".$ca;
        // echo "<br />".$phong;
        //echo "<br />"."<hr>";

        //Kiểm tra xem tồn tại mã lớp học phần 
        // $hocphan = new modules();
        $hocphan = DB::table('module')->where('ID_Module','=', $ID_Module)->get();
        //dd($hocphan);
        if($hocphan->isEmpty()) {
            return 'Không tồn tại mã học phần '.$ID_Module;
        }
        //Kết thúc kiểm tra mã lớp học phần

        //Lấy thông tin lớp học phần
        //Nếu đã có lớp học phần đó thì bỏ qua
        // $md = new module_class();
        // $md = DB::table('module_class')->where('ID_Module_Class','=', $ID_Module_Class)->get();
        $count_md = DB::table('module_class')->where('ID_Module_Class','=', $ID_Module_Class)->count();
        //Hết lấy thông tin lớp học phần

        //Lưu dữ liệu lớp học phần 'Number_Reality' => $Number_Reality,
        //if($ID_Module_Class == "MHT02.3-1-21 -1  (N24)") return 'loi';
        try {
            if($count_md == 0) {
                DB::table('module_class')->insert(
                [  'ID_Module_Class' => $ID_Module_Class,
                    'Module_Class_Name' => $Module_Class_Name,
                    'Number_Plan' => $Number_Plan,
                    'Number_Reality' => NULL,
                    'School_Year' => $School_Year,
                    'ID_Module' => $ID_Module,
                    ]
                );
                // array_push($this->arrayModuleClass, [
                //     'ID_Module_Class' => $ID_Module_Class,
                //     'Module_Class_Name' => $Module_Class_Name,
                //     'Number_Plan' => $Number_Plan,
                //     'Number_Reality' => $Number_Reality,
                //     'School_Year' => $School_Year,
                //     'ID_Module' => $ID_Module,
                // ]);

                $this->numberSuccess++;
                // echo "<br />"."Dữ liệu lưu bảng module_class";
                // echo "<br />".$ID_Module_Class;
                // echo "<br />".$Module_Class_Name;
                // echo "<br />".$Number_Plan;
                // echo "<br />".$Number_Reality;
                // echo "<br />".$School_Year;
                // echo "<br />".$mahp;
                // echo "<br />"."Thêm mới lớp học phần";
            }
            
        }catch (Exception $e) {
            return 'Lỗi khi thêm học phần '.$ID_Module_Class.' '.$e->getMessage();
        }
        //Hết lưu dữ liệu lớp học phần

        //Kiểm tra $ngày > 7  thì tức là chưa có cụ thể ngày học
        if($ngay > 5 ) {
            $this->numberBlank++;
            return 'Thành công';
        }
        //Hết kiểm tra ngày

        //Lưu trữ dữ liệu schedules
		while($dateEnd >= $dateBegin ) {
			
            //Kiểm tra lịch trình
			//$sch = new schedules();
            //echo "<br />".($ID_Module_Class_2);
            $dateBegin = Carbon::parse($dateBegin)->format('Y-m-d');
            //echo "<br />".$dateBegin;
            $nb_sch = DB::table('schedules')->where('ID_Module_Class','=', $ID_Module_Class_2)->where('Shift_Schedules','=',$ca)->where('Day_Schedules','=', $dateBegin)->count();
            //echo "<br />".($nb_sch);
            //Lịch trình đã trùng cả lớp học phần, ngày học, ca học thì bỏ qua
            if($nb_sch > 0) {
                // return 'Đã tồn tại lịch trình của lớp học phần: '.$ID_Module_Class.'-'.$dateBegin.'-'.'Day_Schedules';
                $dateBegin = $startTime->addWeeks(1);
                
                continue;
            }
            //Không trùng thì insert
            //Kiểm tra xem có thông tin phòng học hay không

            if(is_null($phong)) {
                // DB::table('schedules')->insert(
                // [   'ID_Module_Class' => $ID_Module_Class_2,
                //     'Shift_Schedules' => $ca,
                //     'Day_Schedules' => $dateBegin,
                //     'Number_Student' => NULL ]
                // );
                array_push($this->arraySchedules, [
                    'ID_Module_Class' => $ID_Module_Class_2,
                    'ID_Room' => NULL,
                    'Shift_Schedules' => $ca,
                    'Day_Schedules' => $dateBegin,
                    'Number_Student' => NULL
                ]);
                
                $this->numberSuccess++;
            }
            else {
                // DB::table('schedules')->insert(
                // [   'ID_Module_Class' => $ID_Module_Class_2,
                //     'ID_Room' => $phong,
                //     'Shift_Schedules' => $ca,
                //     'Day_Schedules' => $dateBegin,
                //     'Number_Student' => NULL ]
                // );
                array_push($this->arraySchedules, [
                    'ID_Module_Class' => $ID_Module_Class_2,
                    'ID_Room' => $phong,
                    'Shift_Schedules' => $ca,
                    'Day_Schedules' => $dateBegin,
                    'Number_Student' => NULL,
                ]);
               
                $this->numberSuccess++;
            }

			// echo "<br />"."<br />"."Dữ liệu lưu bảng schedules";
			// echo "<br />".$ID_Module_Class_2;
   //          echo "<br />".$phong;
   //          echo "<br />".$ca;
   //          echo "<br />".$dateBegin;
   //          echo "<br />".$dangki."<hr>";
			
			$dateBegin = $startTime->addWeeks(1);
           
		}
        return 'Thành công';
    }

}
