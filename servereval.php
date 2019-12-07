<?php

require 'connect.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'id_interv');
$sheet->setCellValue('C1', 'interv');
$sheet->setCellValue('D1', 'trimestre');
$sheet->setCellValue('E1', 'year');
$sheet->setCellValue('F1', 'note');
$sheet->setCellValue('G1', 'com');


$sql = "select * from eval";
$result = $conn->query($sql);
if($result->num_rows > 0){
	$n = 1;
	while($row = $result->fetch_assoc()){
		$rowNum = $n + 1;
		$sheet->setCellValue('A'.$rowNum, $n);
        $sheet->setCellValue('B'.$rowNum, $row['id_interv']);
        $sheet->setCellValue('C'.$rowNum, $row['interv']);
        $sheet->setCellValue('D'.$rowNum, $row['trimestre']);
        $sheet->setCellValue('E'.$rowNum, $row['year']);
        $sheet->setCellValue('F'.$rowNum, $row['note']);
        $sheet->setCellValue('G'.$rowNum, $row['com']);
		$n++;
	}
}

$sheet->getStyle('A1:X1')->applyFromArray(array('font' => array('bold' => true)));

$filename = 'sample-'.time().'.xlsx';
// Redirect output to a client's web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
 
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');