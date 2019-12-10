<?php

require 'connect.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'DATE ENTRÉE EN VIGEUR');
$sheet->setCellValue('C1', 'ROLE');
$sheet->setCellValue('D1', 'NOM');
$sheet->setCellValue('E1', 'PRENOM');
$sheet->setCellValue('F1', 'SEXE');
$sheet->setCellValue('G1', 'TACHE');
$sheet->setCellValue('H1', 'LANGUE');
$sheet->setCellValue('I1', 'DOMAINE');
$sheet->setCellValue('J1', 'DATE DE SORTIE');


$sql = "select * from benevole";
$result = $conn->query($sql);
if($result->num_rows > 0){
	$n = 1;
	while($row = $result->fetch_assoc()){
		$rowNum = $n + 1;
		$sheet->setCellValue('A'.$rowNum, $n);
        $sheet->setCellValue('B'.$rowNum, $row['date_entree']);
        $sheet->setCellValue('C'.$rowNum, $row['role']);
        $sheet->setCellValue('D'.$rowNum, $row['nom']);
        $sheet->setCellValue('E'.$rowNum, $row['prenom']);
        $sheet->setCellValue('F'.$rowNum, $row['sexe']);
        $sheet->setCellValue('G'.$rowNum, $row['tache']);
        $sheet->setCellValue('H'.$rowNum, $row['langue']);
        $sheet->setCellValue('I'.$rowNum, $row['domaine']);
        $sheet->setCellValue('J'.$rowNum, $row['date_sortie']);
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