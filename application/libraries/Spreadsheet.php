<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'Spreadsheet\PhpSpreadsheet\PhpSpreadsheet-master\vendor\autoload.php';


use PhpOffice\PhpSpreadsheet\IOFactory;

class Spreadsheet {

    public function readExcel($file_path) {
        $spreadsheet = IOFactory::load($file_path);
        return $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    }

    // Add other methods as needed
}
