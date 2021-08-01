<?php

namespace App\Exports;
use App\models\User;
use DB;
use Response;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMergeCells;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FileExport implements FromCollection,WithHeadingRow,WithStyles,WithColumnWidths,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public $month ;
    public $STT = 15;
    public function __construct(int $month) {
    	//dd($month);
    	$this->month = $month;
    }



    public function headingRow(): int
    {
        return 6;
    }

    public function registerEvents(): array
    {
        return [
            
            AfterSheet::class    => function(AfterSheet $event) {
                try {
                    $event->sheet
                            ->getPageSetup()
                            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                    $workSheet = $event
                        ->sheet
                        ->getDelegate()
                        ->setMergeCells([
                            'B1:E1',
                            'H1:M1',
                            'B2:E2',
                            'H2:M2',
                            'B3:M3',
                            'K'.(7+$this->STT).':M'.(7+$this->STT),
                        ]);

                    $workSheet->setTitle("Báo cáo");
                    

                    $event->sheet->getDelegate()->getStyle('B4:M4')->applyFromArray(
                        [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                                'inside' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ]
                        ]
                    );

                    $event->sheet->getDelegate()->getStyle('B5:M'.(5+$this->STT))->applyFromArray(
                        [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                                'inside' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => '000000'],
                                ],
                            ]
                        ]
                    );

                    $headers = $workSheet->getStyle('A1:K2');

                    $headers
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER);

                    $headers->getFont()->setSize(12);

                    $headers = $workSheet->getStyle('B3:H3');

                    $headers
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                        ->setVertical(Alignment::VERTICAL_CENTER);

                    $headers->getFont()->setName('Times New Roman')->setBold(true)->setSize(16);

                    $footer = $workSheet->getCell('K'.(7+$this->STT));
                    $footer->setValue('Hà Nội, ngày '.date("d").' tháng '.date("m").' năm '.date("Y"));

                } catch (Exception $exception) {
                    throw $exception;
                }
            },
        ];
    }

    
    public function columnWidths (): array
    {
        return [
          'A' => 1,
          'B' => 5,
          'C' => 20,
          'D' => 20,
          'E' => 20,
          'F' => 20,
          'G' => 15,
          'I' => 15,
          'J' => 20,
          'K' => 25,
          'L' => 15
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2   => ['font' => ['bold' => true]],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function collection()
    {
        $m = $this->month;
        if($this->month <=0 || $this->month > 12) return "Error";
        $this->STT = 0;
        // $data = DB::table('fix')->join('schedules','fix.ID_Schedules','=','schedules.ID_Schedules')
        // ->join('module_class','module_class.ID_Module_Class','=','schedules.ID_Module_Class')
        // ->join('teacher','teacher.ID_Teacher','=','module_class.ID_Teacher')
        // ->where(month('Time_Fix_Request'),'=', $m)
        // ->where(year('Time_Fix_Request'),'=', year(GETDATE()))
        // ->paginate(10,['teacher.ID_Teacher','Name_Teacher','schedules.ID_Module_Class','fix.ID_Room','Shift_Fix','Day_Fix','Time_Fix_Request','Time_Accept_Request','Status_Fix','schedules.Shift_Schedules','schedules.Day_Schedules','ID_Teacher_Option']);

        $data = DB::select("
            Select teacher.Name_Teacher as TenGV,
                    fix.ID_Teacher_Option as MaGV,
                    schedules.ID_Module_Class as YC,
                    Shift_Fix,
                    Day_Fix,
                    Shift_Schedules,
                    Day_Schedules,
                    fix.ID_Room as newRoom, 
                    schedules.ID_Room as oldRoom,
                    Time_Fix_Request,
                    Time_Accept_Request,
                    Status_Fix
            from fix
            inner join schedules on fix.ID_Schedules = schedules.ID_Schedules
            inner join module_class on module_class.ID_Module_Class = schedules.ID_Module_Class
            inner join teacher on teacher.ID_Teacher = module_class.ID_Teacher
            where month(Time_Fix_Request) = ".$m."
            and year(Time_Fix_Request) = year(now())
        ");
        $collection = new Collection();
        //dd($data);
        $heading = [
            '',
            'STT',
            'Tên giảng viên',
            'Mã giảng viên thay thế',
            'Yêu cầu thay đổi',
            'Thời gian cũ',
            'Thời gian mới',
            'Phòng cũ',
            'Phòng mới',
            'Thời gian gửi yêu cầu',
            'Thời gian xác nhận yêu cầu',
            'Tình trạng',
            'Chú thích'
        ];
        $head = ['','BỘ GIÁO DỤC & ĐÀO TẠO','','','','','','CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM'];
        $collection->push($head);
        $head = ['','TRƯỜNG ĐẠI HỌC GIAO THÔNG VẬN TẢI','','','','','','Độc lập - Tự do - Hạnh phúc'];
        $collection->push($head);
        $head = ['','BẢN BÁO CÁO THÁNG '.$m,'',''];
        $collection->push($head);

        $collection->push($heading);
        //dd($data);
        foreach($data as $row) {
        	$this->STT++;
        	$newData = [
                '',
        		$this->STT,
                $row->TenGV,
                $row->MaGV,
                "Ca:".$row->Shift_Fix."Ngày: ".\Carbon\Carbon::parse($row->Day_Fix)->format('d/m/Y'),
                "Ca:".$row->Shift_Schedules."Ngày: ".\Carbon\Carbon::parse($row->Day_Schedules)->format('d/m/Y'),
                $row->oldRoom,
                $row->newRoom,
                \Carbon\Carbon::parse($row->Time_Fix_Request)->format('d/m/Y'),
                \Carbon\Carbon::parse($row->Time_Accept_Request)->format('d/m/Y'),
                $row->Time_Accept_Request,
                $row->Status_Fix

        	];
        	$collection->push($newData);
        }
      	// return new Collection([
       //      [$this->month, 2, 3],
       //      [4, 5, 6]
       //  ]);
        return $collection;
    }
}
