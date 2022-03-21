<?php
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('fpdf/background_global.jpg',0,0);
$pdf->Output();
?>