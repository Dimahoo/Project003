<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();

require 'connect.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'ID INTERVENANT');
$sheet->setCellValue('C1', 'INTERVENANT');
$sheet->setCellValue('D1', 'DATE CREATION');
$sheet->setCellValue('E1', 'DATE CLOTURE');
$sheet->setCellValue('F1', 'DESCRIPTION');
$sheet->setCellValue('G1', 'TYPE APPELANT');
$sheet->setCellValue('H1', 'MODE INTERVENTION');
$sheet->setCellValue('I1', 'TYPE INTERVENTION');
$sheet->setCellValue('J1', 'LANGUE');
$sheet->setCellValue('K1', 'DURÉE');
$sheet->setCellValue('L1', 'DATE ARRIVÉE AU CANADA');
$sheet->setCellValue('M1', 'REFERÉE PAR');
$sheet->setCellValue('N1', 'SEXE');
$sheet->setCellValue('O1', 'AGE');
$sheet->setCellValue('P1', 'SITUATION FINANCIÈRE');
$sheet->setCellValue('Q1', 'ORIGINE');
$sheet->setCellValue('R1', 'STATUS CANADA');
$sheet->setCellValue('S1', 'PROBLÈME MENTALE');
$sheet->setCellValue('T1', 'ÉTAT CIVIL');
$sheet->setCellValue('U1', 'NOMBRE ENFANT');
$sheet->setCellValue('V1', 'ÉTAT PSYCHOLOGIQUE AVANT INTERVENTION');
$sheet->setCellValue('W1', 'ÉTAT PSYCHOLOGIQUE APRÈS INTERVENTION');
$sheet->setCellValue('X1', 'MOTIF CONSULTATION');


if($_SESSION['admin'] == 1) {

    $sql = "select * from client";
} else {

    $id_interv = $_SESSION['id'];
    $sql = "select * from client WHERE id_interv='$id_interv'";
}
$result = $conn->query($sql);
if($result->num_rows > 0){
	$n = 1;
	while($row = $result->fetch_assoc()){
		$rowNum = $n + 1;
		$sheet->setCellValue('A'.$rowNum, $n);
        $sheet->setCellValue('B'.$rowNum, $row['id_interv']);
        $sheet->setCellValue('C'.$rowNum, $row['interv']);
        $sheet->setCellValue('D'.$rowNum, $row['date_creation']);
        $sheet->setCellValue('E'.$rowNum, $row['date_cloture']);
        $sheet->setCellValue('F'.$rowNum, $row['description']);
        $sheet->setCellValue('G'.$rowNum, $row['type_appelant']);
        $sheet->setCellValue('H'.$rowNum, $row['mode_interv']);
        $sheet->setCellValue('I'.$rowNum, $row['type_interv']);
        $sheet->setCellValue('J'.$rowNum, $row['langue']);
        $sheet->setCellValue('K'.$rowNum, $row['duree']);
        $sheet->setCellValue('L'.$rowNum, $row['ref_par']);
        $sheet->setCellValue('M'.$rowNum, $row['date_arrivee']);
        $sheet->setCellValue('N'.$rowNum, $row['sexe']);
        $sheet->setCellValue('O'.$rowNum, $row['age']);
        $sheet->setCellValue('P'.$rowNum, $row['situ_finance']);
        $sheet->setCellValue('Q'.$rowNum, $row['origine']);
        $sheet->setCellValue('R'.$rowNum, $row['status_canada']);
        $sheet->setCellValue('S'.$rowNum, $row['prob_mentale']);
        $sheet->setCellValue('T'.$rowNum, $row['etat_civil']);
        $sheet->setCellValue('U'.$rowNum, $row['nbr_enfant']);
        $sheet->setCellValue('V'.$rowNum, $row['psy_apres_interv']);
        $sheet->setCellValue('W'.$rowNum, $row['psy_avant_interv']);
        $sheet->setCellValue('X'.$rowNum, $row['motif_consult']);

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