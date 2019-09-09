<?php

require 'connect.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'Intervenant');
$sheet->setCellValue('C1', 'Client');
$sheet->setCellValue('D1', 'Date inscription');
$sheet->setCellValue('E1', 'Description');
$sheet->setCellValue('F1', 'Type appelant');
$sheet->setCellValue('G1', 'Mode intervention');
$sheet->setCellValue('H1', 'Type intervention');
$sheet->setCellValue('I1', 'Langue');
$sheet->setCellValue('J1', 'Duree');
$sheet->setCellValue('K1', 'Date arrivee au Canada');
$sheet->setCellValue('L1', 'Referee par');
$sheet->setCellValue('M1', 'Sexe');
$sheet->setCellValue('N1', 'Age');
$sheet->setCellValue('O1', 'Situation financiere');
$sheet->setCellValue('P1', 'Origine');
$sheet->setCellValue('Q1', 'Status au Canada');
$sheet->setCellValue('R1', 'Probleme mentale');
$sheet->setCellValue('S1', 'Etat civil');
$sheet->setCellValue('T1', 'Nombre enfant');
$sheet->setCellValue('U1', 'Etat psychologique avant intervention');
$sheet->setCellValue('V1', 'Etat psychologique apres intervention');
$sheet->setCellValue('W1', 'Motif consultation');

$sql = "select * from rdv";
$result = $conn->query($sql);
if($result->num_rows > 0){
	$n = 1;
	while($row = $result->fetch_assoc()){
		$rowNum = $n + 1;
		$sheet->setCellValue('A'.$rowNum, $n);
        $sheet->setCellValue('B'.$rowNum, $row['id_interv']);
        $sheet->setCellValue('C'.$rowNum, $row['id_cli']);
        $sheet->setCellValue('D'.$rowNum, $row['date_inscription']);
        $sheet->setCellValue('E'.$rowNum, $row['description']);
        $sheet->setCellValue('F'.$rowNum, $row['type_appelant']);
        $sheet->setCellValue('G'.$rowNum, $row['mode_interv']);
        $sheet->setCellValue('H'.$rowNum, $row['type_interv']);
        $sheet->setCellValue('I'.$rowNum, $row['langue']);
        $sheet->setCellValue('J'.$rowNum, $row['duree']);
        $sheet->setCellValue('K'.$rowNum, $row['ref_par']);
        $sheet->setCellValue('L'.$rowNum, $row['date_arrivee']);
        $sheet->setCellValue('M'.$rowNum, $row['sexe']);
        $sheet->setCellValue('N'.$rowNum, $row['age']);
        $sheet->setCellValue('O'.$rowNum, $row['situ_finance']);
        $sheet->setCellValue('P'.$rowNum, $row['origine']);
        $sheet->setCellValue('Q'.$rowNum, $row['status_canada']);
        $sheet->setCellValue('R'.$rowNum, $row['prob_mentale']);
        $sheet->setCellValue('S'.$rowNum, $row['etat_civil']);
        $sheet->setCellValue('T'.$rowNum, $row['nbr_enfant']);
        $sheet->setCellValue('U'.$rowNum, $row['psy_apres_interv']);
        $sheet->setCellValue('V'.$rowNum, $row['psy_avant_interv']);
        $sheet->setCellValue('W'.$rowNum, $row['motif_consult']);
		$n++;
	}
}

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