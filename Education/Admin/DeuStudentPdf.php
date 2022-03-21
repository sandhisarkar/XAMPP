<?php
require('fpdf/fpdf.php');
$con=mysqli_connect("localhost","root","root","demo");
$db = 'demo';
$start_date = $_GET["start_date"];
$end_date = $_GET["start_end"];
$head_line = "Date From (".$start_date.") To (".$end_date.")";

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
    $this->Cell(276,5,'Deu Details Report',0,0,'C');   	
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
	$this->Cell(25,10,'Student ID',1,0,'C');
	$this->Cell(40,10,'Centre Name',1,0,'C');
	$this->Cell(40,10,'Centre Location',1,0,'C');
	$this->Cell(40,10,'Student Name',1,0,'C');
	$this->Cell(25,10,'Contact',1,0,'C');
	$this->Cell(60,10,'Course Name',1,0,'C');
	$this->Cell(25,10,'Pay Period',1,0,'C');
	$this->Cell(20,10,'Pay Status',1,0,'C');
	
	$this->Ln();
}

function viewTable($con)
{
	$this->SetFont('Arial','',8);
	//mysqli_select_db( $con,"admission_details");

	/*$sql = "SELECT * from admission_details where student_id = '".$_GET["student_id"]."'  and created_dttm >= '".$_GET["start_date"]."' and created_dttm <= '".$_GET["start_end"]."'";
    $result = mysqli_query($con, $sql);
	
	if (mysqli_num_rows($result) > 0) {																// output data of each row
    while($row = mysqli_fetch_assoc($result)) {
			
				//$this->Cell(25,10,$row["created_dttm"],1,0,'C');
				
				$admission_date =  $row["created_dttm"];
				$id = $row["student_id"];
				$curr_date = date('Y-m-d');
				
				
				while(strtotime($admission_date) <= strtotime($curr_date))
				{
					
					$admission_date = date("Y-m-d",strtotime("+1 month",strtotime($admission_date)));
					
					$fees_paid = date("m-Y",strtotime($admission_date));
					
					
					$sql_q = "SELECT  pay_period from fees_collection where student_id= '".$id."' and pay_period = '".$fees_paid."'";
					$result_q = mysqli_query($con, $sql_q);
					if (mysqli_num_rows($result_q) > 0) {																// output data of each row
					//while($row1 = mysqli_fetch_assoc($result_q)) {
						
						$this->Cell(25,10,$id,1,0,'C');
						$this->Cell(40,10,$row["centre_name"],1,0,'C');
						$this->Cell(40,10,$row["centre_location"],1,0,'C');
						$this->Cell(40,10,$row["student_name"],1,0,'C');
						$this->Cell(25,10,$row["student_phone"],1,0,'C');
						$this->Cell(60,10,$row["student_course"],1,0,'C');
						$this->Cell(25,10,date("m-Y",strtotime($admission_date)),1,0,'C');
						$this->Cell(20,10,'Paid',1,0,'C');
											
						$this->Ln();
					//}
					}
					else
					{
						$this->Cell(25,10,$id,1,0,'C');
						$this->Cell(40,10,$row["centre_name"],1,0,'C');
						$this->Cell(40,10,$row["centre_location"],1,0,'C');
						$this->Cell(40,10,$row["student_name"],1,0,'C');
						$this->Cell(25,10,$row["student_phone"],1,0,'C');
						$this->Cell(60,10,$row["student_course"],1,0,'C');
						$this->Cell(25,10,date("m-Y",strtotime($admission_date)),1,0,'C');
						$this->Cell(20,10,'Deu',1,0,'C');
						
						$this->Ln();
					}
					}
					
					//date("m-Y",strtotime($admission_date));
					
					
	}
				
				
	}*/
	$sql_ad = "SELECT * from admission_details where student_id = '".$_GET["student_id"]."'  and created_dttm >= '".$_GET["start_date"]."' and created_dttm <= '".$_GET["start_end"]."'";
    $result_ad = mysqli_query($con,$sql_ad);
	//$res1=mysqli_fetch_assoc($result_ad);
	//$cou1 = mysqli_num_rows($result_ad);
	
	if (mysqli_num_rows($result_ad) > 0) {	
	while($res1 = mysqli_fetch_assoc($result_ad))
	{
		 $st_id = $res1["student_id"];
         $date_fetch = $res1["ad_start_date"];
		 //$this->Cell(25,10,$st_id,1,0,'C');
		 //$this->Cell(25,10,$date_fetch,1,0,'C');
		 
		 $date_now = date("Y-m-d");
		 
		 if($date_fetch <= $date_now && $date_now <= $res1["ad_end_date"])
		 {
			 $date_diff = abs(strtotime($date_now)-strtotime($date_fetch));
			 $years = floor($date_diff / (365*60*60*24)); 
			 $months = floor(($date_diff - $years * 365*60*60*24) 
                               / (30*60*60*24));  
			 $ytom = $years*12;
			 $totm = $ytom + $months;
			 
			 //$this->Cell(25,10,$totm,1,0,'C');
			 
			 for($j =0 ;$j<= $totm ; $j++)
			 {
				$date_fetch = date("Y-m-d",strtotime("+1 month",strtotime($date_fetch)));
					
				
				$fees_paid_date = date("m-Y",strtotime($date_fetch));
				
				$sql_fee = "SELECT pay_period from fees_collection where  student_id = '".$st_id."' and pay_period = '".$fees_paid_date."'";
				$result_fee = mysqli_query($con,$sql_fee);
				$res2=mysqli_fetch_row($result_fee);
				$cou2 = $res2[0];
				
				if($cou2 == 0)
				{
						$this->Cell(25,10,$st_id,1,0,'C');
						$this->Cell(40,10,$res1["centre_name"],1,0,'C');
						$this->Cell(40,10,$res1["centre_location"],1,0,'C');
						$this->Cell(40,10,$res1["student_name"],1,0,'C');
						$this->Cell(25,10,$res1["student_phone"],1,0,'C');
						$this->Cell(60,10,$res1["student_course"],1,0,'C');
						$this->Cell(25,10,$fees_paid_date,1,0,'C');
						$this->Cell(20,10,'Deu',1,0,'C');
						$this->Ln();
				}
				else{
						/*$this->Cell(25,10,$st_id,1,0,'C');
						$this->Cell(40,10,$res1["centre_name"],1,0,'C');
						$this->Cell(40,10,$res1["centre_location"],1,0,'C');
						$this->Cell(40,10,$res1["student_name"],1,0,'C');
						$this->Cell(25,10,$res1["student_phone"],1,0,'C');
						$this->Cell(60,10,$res1["student_course"],1,0,'C');
						$this->Cell(25,10,$fees_paid_date,1,0,'C');
						$this->Cell(20,10,'Paid',1,0,'C');
						$this->Ln();*/
				}
				
			 }
		 }
		 
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

$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(276,10,'Student ID : '.$_GET["student_id"],2,0,'C');


$pdf->Ln(20);
$pdf->headerTable();

$pdf->viewTable($con);
$pdf->Ln();
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();

?>

