<?php
session_start();
error_reporting(0);

require('fpdf/fpdf.php');

$con=mysqli_connect("localhost","root","root","demo");
$q=mysqli_query($con,"select cen_id from centre_details where cen_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['cen_id'];
$id=$_SESSION['user'];
$msgNav = "";

$sta=mysqli_query($con,"select cen_id,user_name,cen_name,cen_location from centre_details where cen_id='".$_SESSION['user']."'");
$stat=  mysqli_fetch_assoc($sta);
$stcen_id = $stat['cen_id'];
$cen_name = $stat["cen_name"];
$cen_location = $stat["cen_location"];
$cen_per = $stat["user_name"];

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
    $this->Cell(276,5,'Admission List',0,0,'C');   	
    // Line break
    $this->Ln();
	$this->SetFont('Times','',10);
    $this->Cell(276,5,'(Admission Details with Fees,Course)',0,0,'C'); 
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
	$this->SetFont('Arial','B',12);
	$this->Cell(21,10,'Student ID',1,0,'C');
	
	$this->Cell(65,10,'Student Name',1,0,'C');
	$this->Cell(15,10,'D.O.B',1,0,'C');
	$this->Cell(16,10,'Gender',1,0,'C');
	$this->Cell(21,10,'Contact',1,0,'C');
	$this->Cell(34,10,'Gurdian Contact',1,0,'C');
	$this->Cell(12,10,'Class',1,0,'C');
	$this->Cell(40,10,'Course',1,0,'C');
	$this->Cell(12,10,'Fees',1,0,'C');
	$this->Cell(16,10,'Dis(%)',1,0,'C');
	$this->Cell(28,10,'Net Payment',1,0,'C');
	$this->Ln();
}

function viewTable($con)
{
	$this->SetFont('Arial','',8);
	mysqli_select_db( $con,"admission_details");
	
	$q=mysqli_query($con,"select cen_id from centre_details where cen_id='".$_SESSION['user']."'");
	$n=  mysqli_fetch_assoc($q);
	$stname= $n['cen_id'];
	$id=$_SESSION['user'];
	
	$sta=mysqli_query($con,"select cen_id,user_name,cen_name,cen_location from centre_details where cen_id='".$_SESSION['user']."'");
	$stat=  mysqli_fetch_assoc($sta);
	$stcen_id = $stat['cen_id'];
	$cen_name = $stat["cen_name"];

	$sql = "SELECT * FROM admission_details where centre_id = '".$stcen_id."' and created_dttm >= '".$_GET["start_date"]."' and created_dttm <= '".$_GET["start_end"]."'";
    $result = mysqli_query($con, $sql);
	
	if (mysqli_num_rows($result) > 0) {																// output data of each row
    while($row = mysqli_fetch_assoc($result)) {
			
				$this->Cell(21,10,$row["student_id"],1,0,'C');
				
				$this->Cell(65,10,$row["student_name"],1,0,'C');
				$this->Cell(15,10,$row["student_dob"],1,0,'C');
				$this->Cell(16,10,$row["student_gender"],1,0,'C');
				$this->Cell(21,10,$row["student_phone"],1,0,'C');
				$this->Cell(34,10,$row["gur_phone"],1,0,'C');
				$this->Cell(12,10,$row["student_class"],1,0,'C');
				$this->Cell(40,10,$row["student_course"],1,0,'C');
				$this->Cell(12,10,$row["course_fees"],1,0,'C');
				$this->Cell(16,10,$row["discount"],1,0,'C');
				$this->Cell(28,10,$row["net_payment"],1,0,'C');
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
$pdf->Cell(275,10,$head_line,2,0,'C');
$pdf->Ln(20);

$pdf->SetFont('Times','B',12);
$pdf->Cell(1);
$pdf->Cell(275,5,'Centre Name : '.$cen_name,2,0,'C');
$pdf->Ln(10);

$pdf->SetFont('Times','B',12);
$pdf->Cell(1);
$pdf->Cell(275,5,'Centre Location : '.$cen_location,2,0,'C');
$pdf->Ln(20);

$pdf->headerTable();

$pdf->viewTable($con);
$pdf->Ln();
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output('Admission_'.$cen_location.'-'.$cen_name.'.pdf','D');
}
if($type == 'csv')
{
	$q=mysqli_query($con,"select cen_id from centre_details where cen_id='".$_SESSION['user']."'");
	$n=  mysqli_fetch_assoc($q);
	$stname= $n['cen_id'];
	$id=$_SESSION['user'];
	
	$sta=mysqli_query($con,"select cen_id,user_name,cen_name,cen_location from centre_details where cen_id='".$_SESSION['user']."'");
	$stat=  mysqli_fetch_assoc($sta);
	$stcen_id = $stat['cen_id'];
	$cen_name = $stat["cen_name"];
	
	$query = "SELECT * FROM admission_details where centre_id = '".$stcen_id."' and created_dttm >= '".$_GET["start_date"]."' and created_dttm <= '".$_GET["start_end"]."'";
	
	$filen = "Admission_".$cen_location."-".$cen_name.".csv";
    $output = fopen('php://memory', 'w');
	
	fputcsv($output, array('','','','','Admission List','','','','',''));
	fputcsv($output, array('','','','','(Admission Details with Fees,Course)','','','',''));
	fputcsv($output, array(''));
	fputcsv($output, array($head_line));
	
	fputcsv($output, array(''));
	fputcsv($output, array('Centre Name : '.$cen_name));
	fputcsv($output, array(''));
	fputcsv($output, array('Centre Location : '.$cen_location));
	fputcsv($output, array(''));
	
	fputcsv($output, array('Student ID','Student Name','D.O.B','Gender','Contact','Gurdian Contact','Class','Course','Fees','Dis(%)','Net Payment'));
	
	
	
	if (!$result = mysqli_query($con, $query)) {
    exit(mysqli_error($con));
	}
 
	$values = array();
	if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $values[] = $row;
    }
	}
	$plus = "91-";
	if (count($values) > 0) {
    foreach ($values as $row) {
        fputcsv($output, array($row["student_id"],$row["student_name"],$row["student_dob"],$row["student_gender"],$plus.$row["student_phone"],$plus.$row["gur_phone"],$row["student_class"],$row["student_course"],$row["course_fees"],$row["discount"],$row["net_payment"]));
    }
	
	fseek($output,0);
	
	header('Content-Type: text/csv');  
    header('Content-Disposition: attachment; filename="'.$filen.'";');  
	
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
exit;
}

?>

