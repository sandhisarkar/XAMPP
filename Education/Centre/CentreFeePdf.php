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
    $this->Cell(276,5,'Fees Collection',0,0,'C');   	
    // Line break
    $this->Ln();
	$this->SetFont('Times','',10);
    $this->Cell(276,5,'(Centre Wise)',0,0,'C'); 
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
	$this->Cell(20,10,'Student ID',1,0,'C');
	$this->Cell(25,10,'Centre Name',1,0,'C');
	$this->Cell(30,10,'Centre Location',1,0,'C');
	$this->Cell(30,10,'Student Name',1,0,'C');
	$this->Cell(20,10,'D.O.B',1,0,'C');
	$this->Cell(15,10,'Gender',1,0,'C');
	$this->Cell(20,10,'Contact',1,0,'C');	
	$this->Cell(10,10,'Class',1,0,'C');
	$this->Cell(50,10,'Course',1,0,'C');
	$this->Cell(10,10,'Fees',1,0,'C');
	$this->Cell(10,10,'Dis(%)',1,0,'C');
	$this->Cell(18,10,'Net Payment',1,0,'C');
	$this->Cell(15,10,'Pay Period',1,0,'C');
	$this->Ln();
}

function viewTable($con)
{
	$this->SetFont('Arial','',8);
	//mysqli_select_db( $con,"admission_details");

	$q=mysqli_query($con,"select cen_id from centre_details where cen_id='".$_SESSION['user']."'");
	$n=  mysqli_fetch_assoc($q);
	$stname= $n['cen_id'];
	$id=$_SESSION['user'];
	
	$sta=mysqli_query($con,"select cen_id,user_name,cen_name,cen_location from centre_details where cen_id='".$_SESSION['user']."'");
	$stat=  mysqli_fetch_assoc($sta);
	$stcen_id = $stat['cen_id'];
	$cen_name = $stat["cen_name"];
	
	$sql = "SELECT a.student_id,a.centre_name,a.centre_location,b.student_name,b.student_dob,b.student_gender,b.student_phone,b.student_class,b.student_course,a.course_fees,a.discount,a.total_pay_amount,a.pay_period FROM fees_collection a,admission_details b where a.centre_id = '".$stcen_id."' and a.created_dttm >= '".$_GET["start_date"]."' and a.created_dttm <= '".$_GET["start_end"]."' and a.student_id = b.student_id";
    $result = mysqli_query($con, $sql);
	
	if (mysqli_num_rows($result) > 0) {																// output data of each row
    while($row = mysqli_fetch_assoc($result)) {
			
				$this->Cell(20,10,$row["student_id"],1,0,'C');
				$this->Cell(25,10,$row["centre_name"],1,0,'C');
				$this->Cell(30,10,$row["centre_location"],1,0,'C');
				$this->Cell(30,10,$row["student_name"],1,0,'C');
				$this->Cell(20,10,$row["student_dob"],1,0,'C');
				$this->Cell(15,10,$row["student_gender"],1,0,'C');
				$this->Cell(20,10,$row["student_phone"],1,0,'C');
				$this->Cell(10,10,$row["student_class"],1,0,'C');
				$this->Cell(50,10,$row["student_course"],1,0,'C');
				$this->Cell(10,10,$row["course_fees"],1,0,'C');
				$this->Cell(10,10,$row["discount"],1,0,'C');
				$this->Cell(18,10,$row["total_pay_amount"],1,0,'C');
				$this->Cell(15,10,$row["pay_period"],1,0,'C');
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
$pdf->Output('Centre_Fee_'.$cen_location.'-'.$cen_name.'.pdf','D');
}
if($type == 'csv')
{
	mysqli_select_db( $con,"admission_details");

	
	$filename = "Centre_Fee_".$cen_location.'-'.$cen_name.".csv";
	
	
    $output = fopen('php://memory', 'w');
	
	fputcsv($output, array('','','','','Fees Collection','','','','',''));
	fputcsv($output, array('','','','','(Centre Wise)','','','',''));
	fwrite($output,"\n");
	fputcsv($output, array($head_line));
	fwrite($output,"\n");
	fputcsv($output, array('Centre Name : '.$cen_name));
	fwrite($output,"\n");
	fputcsv($output, array('Centre Location : '.$cen_location));
	fwrite($output,"\n");
	
	fputcsv($output, array('Student ID','Centre Name','Centre Location','Student Name','D.O.B','Gender','Contact','Class','Course','Fees','Dis(%)','Net Payment','Pay Period'));
	
	$q=mysqli_query($con,"select cen_id from centre_details where cen_id='".$_SESSION['user']."'");
	$n=  mysqli_fetch_assoc($q);
	$stname= $n['cen_id'];
	$id=$_SESSION['user'];
	
	$sta=mysqli_query($con,"select cen_id,user_name,cen_name,cen_location from centre_details where cen_id='".$_SESSION['user']."'");
	$stat=  mysqli_fetch_assoc($sta);
	$stcen_id = $stat['cen_id'];
	$cen_name = $stat["cen_name"];
	
	$sql = "SELECT a.student_id,a.centre_name,a.centre_location,b.student_name,b.student_dob,b.student_gender,b.student_phone,b.student_class,b.student_course,a.course_fees,a.discount,a.total_pay_amount,a.pay_period FROM fees_collection a,admission_details b where a.centre_id = '".$stcen_id."' and a.created_dttm >= '".$_GET["start_date"]."' and a.created_dttm <= '".$_GET["start_end"]."' and a.student_id = b.student_id";
    $result = mysqli_query($con, $sql);
	
	$values = array();
	if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $values[] = $row;
    }
	}
	$plus = "91-";
	if (count($values) > 0) {
    foreach ($values as $row) {
        fputcsv($output, array($row["student_id"],$row["centre_name"],$row["centre_location"],$row["student_name"],$row["student_dob"],$row["student_gender"],$plus.$row["student_phone"],$row["student_class"],$row["student_course"],$row["course_fees"]." "."Rs/-",$row["discount"],$row["total_pay_amount"]." "."Rs/-",$row["pay_period"]));
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

