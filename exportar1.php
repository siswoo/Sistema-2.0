<?php
include('script/conexion2.php');
require 'resources/Spreadsheet/autoload.php';
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$fecha_inicio = date('Y-m-d');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Nombre');
$sheet->setCellValue('B1', 'Documento Numero');
$sheet->setCellValue('C1', 'Documento Tipo');
$sheet->setCellValue('D1', 'Estatus');

$fila = 2;

$sql1 = "SELECT * FROM modelos WHERE sede = ''";
$consulta1 = mysqli_query($conexion2,$sql1);

while($row1 = mysqli_fetch_array($consulta1)) {
	$modelo_id = $row1['id'];
	$documento_numero = $row1['documento_numero'];
	$documento_tipo = $row1['documento_tipo'];
	$modelo_nombre_completo = $row1['nombre1']." ".$row1['nombre2']." ".$row1['apellido1']." ".$row1['apellido2'];
	$estatus = $row1['estatus'];

	$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(60);
	$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);

	$sheet->setCellValue('A'.$fila, $modelo_nombre_completo);
	$spreadsheet->getActiveSheet()->getCell('B'.$fila)->setValue($documento_numero);
	$spreadsheet->getActiveSheet()->getStyle('B'.$fila)->getNumberFormat()->setFormatCode('00');
	$sheet->setCellValue('C'.$fila, $documento_tipo);
	$sheet->setCellValue('D'.$fila, $estatus);

	$fila = $fila+1;
}

$fecha_inicio1 = date('Y-m-d');
$writer = new Xlsx($spreadsheet);
$writer->save('Modelos sin Sede '.$fecha_inicio1.'.xlsx');
header("Location: Modelos sin Sede ".$fecha_inicio1.".xlsx");

?>