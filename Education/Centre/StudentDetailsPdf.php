<?php
require('fpdf/fpdf.php');
$con=mysqli_connect("localhost","root","root","demo");
$db = 'demo';

$sql = "SELECT * from admission_details where student_id = '".$_GET["student_id"]."' ";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
   // $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','U',15);
    // Move to the right
    // Title
    $this->Cell(276,5,'Student Details',0,0,'C');   	
    // Line break
    $this->Ln();
	$this->SetFont('Arial','',10);
    // Move to the right
    // Title
    $this->Cell(276,5,'(Admission Information)',0,0,'C');   	
    // Line break
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

	$sql = "SELECT * from admission_details where student_id = '".$_GET["student_id"]."' ";
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
				
				
	}
	/*$sql_ad = "SELECT * from admission_details where centre_name = '".$_GET["centre_name"]."' and centre_location = '".$_GET["centre_location"]."' and created_dttm >= '".$_GET["start_date"]."' and created_dttm <= '".$_GET["start_end"]."'";
    $result_ad = mysqli_query($con,$sql_ad);
	$res1=mysqli_fetch_assoc($result_ad);
	$cou1 = mysqli_num_rows($result_ad);
	
	for($i= 0; $i< $cou1;$i++)
	{
		 $st_id = $res1["student_id"];
         $date_fetch = $res1["created_dttm"];
		 //$this->Cell(25,10,$st_id,1,0,'C');
		 //$this->Cell(25,10,$date_fetch,1,0,'C');
		 
		 $date_now = date("Y-m-d");
		 
		 if($date_fetch <= $date_now)
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
				
				$sql_fee = "SELECT pay_period from fees_collection where centre_name = '".$_GET["centre_name"]."' and centre_location = '".$_GET["centre_location"]."' and student_id = '".$st_id."' and pay_period = '".$fees_paid_date."'";
				$result_fee = mysqli_query($con,$sql_fee);
				$res2=mysqli_fetch_row($result_fee);
				$cou2 = $res2[0];
				
				if($cou2 == 0)
				{
					$this->Cell(25,10,$st_id,1,0,'C');
					$this->Cell(40,10,$res1["centre_name"],1,0,'C');
					$this->Cell(40,10,$res1["centre_location"],1,0,'C');
					$this->Cell(25,10,$res1["student_name"],1,0,'C');
					$this->Cell(25,10,$res1["student_phone"],1,0,'C');
					$this->Cell(60,10,$res1["student_course"],1,0,'C');
					$this->Cell(25,10,$fees_paid_date,1,0,'C');
					$this->Cell(25,10,'Deu',1,0,'C');
					$this->Ln();
				}
				else{
					$this->Cell(25,10,$st_id,1,0,'C');
					$this->Cell(40,10,$res1["centre_name"],1,0,'C');
					$this->Cell(40,10,$res1["centre_location"],1,0,'C');
					$this->Cell(25,10,$res1["student_name"],1,0,'C');
					$this->Cell(25,10,$res1["student_phone"],1,0,'C');
					$this->Cell(60,10,$res1["student_course"],1,0,'C');
					$this->Cell(25,10,$fees_paid_date,1,0,'C');
					$this->Cell(25,10,'Paid',1,0,'C');
					$this->Ln();
				}
				
			 }
		 }
		 
	}*/
	}

}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);

$pdf->SetFont('Times','B',15);
$pdf->Cell(1);
$pdf->Cell(275,10,'Student Name : '.$row["student_name"],2,0,'C');
$pdf->Ln(20);


$pdf->SetFont('Times','B',12);
$pdf->Cell(1);
$pdf->Cell(50,7,'Student ID : '.$row["student_id"],0,0,'L');
$pdf->Cell(225,7,'Admission Date : '.$row["created_dttm"],0,0,'R');
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(50,7,'Present Address : '.$row["present_add"],0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(63,7,'Contact Number : '.'+91-'.$row["student_phone"],0,0,'L');
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(67,7,'Email ID : '.$row["student_email"],0,0,'L');
$pdf->Ln(20);
//$pdf->headerTable();

$pdf->SetFont('Times','U',15);
$pdf->Cell(1);
$pdf->Cell(50,7,'Personal Information :',0,0,'L');
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(275,7,'Gender : ' .$row["student_gender"],0,0,'C');
$pdf->Ln();
$pdf->Cell(275,7,'Date of Birth : ' .$row["student_dob"],0,0,'C');
$pdf->Ln();
$pdf->Cell(275,7,'Permanent Address : ' .$row["permanent_add"],0,0,'C');
$pdf->Ln();
$pdf->Cell(275,7,'Gurdian Contact No : '.'+91-'.$row["gur_phone"],0,0,'C');
//$pdf->viewTable($con);
$pdf->Ln(20);

$pdf->SetFont('Times','U',15);
$pdf->Cell(1);
$pdf->Cell(50,7,'Educational Information :',0,0,'L');
$pdf->Ln(10);
$pdf->SetFont('Times','U',13);
$pdf->Cell(1);
$pdf->Cell(150,7,'1. Past Qualificaion Details : ',0,0,'C');
$pdf->Ln(7);
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(275,7,'Past Board Name : ' .strtoupper($row["past_board"]),0,0,'C');
$pdf->Ln(8);
$pdf->SetFont('Times','B',12);
$pdf->Cell(1);
$pdf->Cell(150,7,'Marks Obtained(Out of 100):',0,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Times','',12);
$pdf->Cell(200,7,'English : ' .$row["eng_marks"],0,0,'C');
$pdf->Cell(-50,7,'Life Science : ' .$row["ls_marks"],0,0,'C');
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(215,7,'Physical Science : ' .$row["ps_marks"],0,0,'C');
$pdf->Cell(-80,7,'Mathematics : ' .$row["math_marks"],0,0,'C');
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(270,7,'Aggregate : ' .$row["past_edu_agg"].'(%)',0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Times','U',13);
$pdf->Cell(1);
$pdf->Cell(150,7,'2. Present Qualificaion Details : ',0,0,'C');
$pdf->Ln(7);
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(275,7,'Present School Name : ' .strtoupper($row["present_board"]),0,0,'C');
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(275,7,'Present Board Name : ' .strtoupper($row["present_board"]),0,0,'C');
$pdf->Ln(20);

$pdf->SetFont('Times','U',15);
$pdf->Cell(1);
$pdf->Cell(50,7,'Identification Information :',0,0,'L');
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(275,7,'ID Name : ' .$row["id_proof"],0,0,'C');
$pdf->Ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(275,7,'ID Number : ' .$row["additioanl_number"],0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Times','U',15);
$pdf->Cell(1);
$pdf->Cell(50,7,'Course Details :',0,0,'L');
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
$pdf->Cell(1);
$pdf->Cell(275,7,'Course Name : ' .$row["student_course"],0,0,'C');
$pdf->Ln();
$pdf->Cell(275,7,'Admission for Class : ' .$row["student_class"],0,0,'C');
$pdf->Ln();
$pdf->Cell(275,7,'Course Fees : ' .$row["course_fees"].' Rs /-',0,0,'C');
$pdf->Ln();
$pdf->Cell(275,7,'Discount : ' .$row["discount"].' %',0,0,'C');
$pdf->Ln();
$pdf->Cell(275,7,'Paid Amount : ' .$row["net_payment"].' Rs /-',0,0,'C');
$pdf->Ln();
//for($i=1;$i<=40;$i++)
//    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output($row["student_id"].'_profile.pdf','D');

?>

