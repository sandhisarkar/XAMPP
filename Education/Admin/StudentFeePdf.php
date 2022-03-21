<?php
require('fpdf/fpdf.php');
$con=mysqli_connect("localhost","root","root","demo");
$db = 'demo';
$start_date = $_GET["start_date"];
$end_date = $_GET["start_end"];
$head_line = "Date From (".$start_date.") To (".$end_date.")";
$type = $_GET["file_type"];

if($type == 'pdf')
{
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
   // $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    // Title
    $this->Cell(276,5,'Fees Collection',0,0,'C');   	
    // Line break
    $this->Ln();
	$this->SetFont('Times','',10);
    $this->Cell(276,5,'(Student Wise)',0,0,'C'); 
	$this->Ln(10);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function headerTable()
{
	$this->SetFont('Arial','B',8);
	$this->Cell(30,10,'Fees ID',1,0,'C');
	$this->Cell(50,10,'Centre Name',1,0,'C');
	$this->Cell(40,10,'Centre Location',1,0,'C');
	
	$this->Cell(30,10,'Course ID',1,0,'C');
	$this->Cell(30,10,'Fees',1,0,'C');
	$this->Cell(20,10,'Dis(%)',1,0,'C');
	$this->Cell(30,10,'Net Payment',1,0,'C');
	$this->Cell(30,10,'Pay Period',1,0,'C');
	$this->Ln();
}

function viewTable($con)
{
	$this->SetFont('Arial','',8);
	//mysqli_select_db( $con,"admission_details");

	$sql = "SELECT * from fees_collection where student_id = '".$_GET["student_id"]."'";
    $result = mysqli_query($con, $sql);
	
	if (mysqli_num_rows($result) > 0) {																// output data of each row
    while($row = mysqli_fetch_assoc($result)) {
			
				$this->Cell(30,10,$row["id"],1,0,'C');
				$this->Cell(50,10,$row["centre_name"],1,0,'C');
				$this->Cell(40,10,$row["centre_location"],1,0,'C');
				
				$this->Cell(30,10,$row["course_id"],1,0,'C');
				$this->Cell(30,10,$row["course_fees"].' '.'Rs /-',1,0,'C');
				$this->Cell(20,10,$row["discount"],1,0,'C');
				$this->Cell(30,10,$row["total_pay_amount"].' '.'Rs /-',1,0,'C');
				$this->Cell(30,10,$row["pay_period"],1,0,'C');
				$this->Ln();
	}
	}
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);

$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(276,10,$head_line,2,0,'C');
$pdf->Ln(20);

$pdf->SetFont('Times','B',12);
$pdf->Cell(1);
$pdf->Cell(276,10,'Student ID : '.$_GET["student_id"],2,0,'C');
$pdf->Ln(20);

$pdf->headerTable();

$pdf->viewTable($con);
$pdf->Ln();
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output('Student_Fee_'.$_GET["student_id"].'.pdf','D');
}
if($type == 'csv')
{
	$sql = "SELECT * from fees_collection where student_id = '".$_GET["student_id"]."'";
    $result = mysqli_query($con, $sql);
	
	$filename = "Student_Fee_".$_GET["student_id"].".csv";
	
	
    $output = fopen('php://memory', 'w');
	
	fputcsv($output, array('','','','','Fees Collection','','','','',''));
	fputcsv($output, array('','','','','(Student Wise)','','','',''));
	fwrite($output,"\n");
	fputcsv($output, array($head_line));
	fwrite($output,"\n");
	fputcsv($output, array('Student ID : '.$_GET["student_id"]));
	fwrite($output,"\n");
	
	fputcsv($output, array('Fees ID','Centre Name','Centre Location','Course ID','Fees','Dis(%)','Net Payment','Pay Period'));

	$values = array();
	if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $values[] = $row;
    }
	}
	
	if (count($values) > 0) {
    foreach ($values as $row) {
        fputcsv($output, array($row["id"],$row["centre_name"],$row["centre_location"],$row["course_id"],$row["course_fees"]." "."Rs/-",$row["discount"],$row["total_pay_amount"]." "."Rs/-",$row["pay_period"]));
    }
	
	fseek($output, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($output);
}
else
{
	fputcsv($output,array(''));
	fseek($output, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($output);
}
}
exit;
?>

