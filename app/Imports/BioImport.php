<?php

namespace App\Imports;

use App\Models\Biometrics;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class BioImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct($from, $to){
        $this->from =  date('Y-m-d', strtotime($from));
        $this->to =  date('Y-m-d', strtotime($to));
    }

    public function model(array $row){

        $bio_id = $row['enno'];
        $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['antipass'])->format('Y-m-d');
        $time = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['antipass'])->format('H:i');

        if(($this->from <= $date) && ($this->to >= $date)){

            $checkBio = Biometrics::where('bio_id', $bio_id)->where('date', $date)->first();

            if($checkBio){

                if ($checkBio->morning_in == '') {
                    $bio = array(
                        'morning_in' => $time
                    );

                    Biometrics::where('bio_id', $bio_id)->update($bio);

                } elseif ($checkBio->morning_out == '') {
                    $bio = array(
                        'morning_out' => $time
                    );

                    Biometrics::where('bio_id', $bio_id)->update($bio);

                } elseif ($checkBio->afternoon_in == '') {
                    $bio = array(
                        'afternoon_in' => $time
                    );

                    Biometrics::where('bio_id', $bio_id)->update($bio);
                }else{
                    $bio = array(
                        'afternoon_out' => $time
                    );

                    Biometrics::where('bio_id', $bio_id)->update($bio);
                }

            }else{

                $bio = array(
                    'bio_id' => $bio_id,
                    'date' => $date,
                    'morning_in' => $time
                );

                Biometrics::create($bio);
            }
        }
        
    }
    public function batchSize(): int{
        return 1000;
    }
}
