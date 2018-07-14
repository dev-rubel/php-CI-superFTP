<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Datafacker {

    private $facker;

    public function __construct() {
        // $this->facker = Faker\Factory::create();
    }

    public function string($niddle)
    {   
        if($niddle=='name') {
            return $this->facker->name;
        } 
        elseif($niddle=='address') {
            return $this->facker->address;
        }
        elseif($niddle=='text') {
            return $this->facker->text;
        }
        elseif($niddle=='randomDigit') {
            return $this->facker->randomDigit;
        }
        elseif($niddle=='city') {
            return $this->facker->city;
        }
        elseif($niddle=='email') {
            return $this->facker->email;
        }
        elseif($niddle=='country') {
            return $this->facker->country;
        }
        elseif($niddle=='bankAccountNumber') {
            return $this->facker->bankAccountNumber;
        }
        elseif($niddle=='streetName') {
            return $this->facker->streetName;
        }
    }

    public function excelD($arrayData)
    {   
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()
        ->fromArray(
            $arrayData,  // The data to set
            NULL,        // Array values with this value will not be set
            'A1'         // Top left coordinate of the worksheet range where
                         //    we want to set these values (default is A1)
        );

        $writer = new Xlsx($spreadsheet);
        
        
        $filename = 'name-of-the-generated-file';
 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output'); // download file 
    }
}