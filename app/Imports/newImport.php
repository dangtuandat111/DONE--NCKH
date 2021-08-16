<?php

namespace App\Imports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use DateTime;

class newImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $arr = [];
    public function model(array $row)
    {   
        if($row[0] > 0){
            $period = explode("Từ", $row[7]);

            for($i = 1; $i < count($period); $i++) {
                $dateRange = explode(":", $period[$i]);
                    $date = explode(" đến ", $dateRange[0]);
                    $dateFormat = DateTime::createFromFormat('d/m/Y', trim($date[0]))->format('Y-m-d');
                    $startDate = Carbon::create($dateFormat);
                    $newformat = DateTime::createFromFormat('d/m/Y', trim($date[1]))->format('Y-m-d');
                    $endDate = Carbon::create($newformat);
                    $dayOfWeek = explode("Thứ", $dateRange[1]);

                    for ($j=1; $j < count($dayOfWeek); $j++) {
                        $studyTime = explode(" tiết ", trim($dayOfWeek[$j]));
                        $lesson = explode(" tại ", trim($studyTime[1]));
                        $startDate = Carbon::create($dateFormat);

                        for ( ; $startDate < $endDate; $startDate->addDays(1)) {
                            if($startDate->dayOfWeek == trim($studyTime[0]) - 1){
                                $data["date"] = $startDate->format('d-m-Y');
                                //->jsonSerialize()
                                $data["class"] = $row[5];
                                $data["lesson"] = $lesson[0];
                                $data["room"] = "N/A";
                                if (isset($lesson[1])) {
                                    $data["room"] = $lesson[1];
                                }
                                array_push($this->arr, $data);
                            };
                        }
                    }
                }
            }
        if($row[0] == 15) {print("<pre>".json_encode($this->arr,true)."</pre>");}
    }
}