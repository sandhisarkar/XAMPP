<?php

session_start();
error_reporting(0);

if (isset($_SESSION["user"])) {
  // only if user is logged in perform this check
  if ((time() - $_SESSION['last_login_timestamp']) > 900) {
    header("location:logout.php");
    exit;
  } else {
    $_SESSION['last_login_timestamp'] = time();
  }
}

include "include/db.php";
include "include/usersession.php";


if(isset($_POST["gen_rep"]))
{
	
	$state = $_SESSION['state'];
	
	$district = $_SESSION['district'];
	
	$datestartapplication = $_SESSION['start_date'];
	$dateendapplication=$_SESSION['end_date'];
	
	if($district != "All")
	{
		$rep_query = "SELECT distinct(a.operator_id) from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.district = '".$district."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."'";
		$result=mysqli_query($con ,$rep_query);
				
		$noofrow = mysqli_num_rows($result);

		if($noofrow > 0)
		{
			$msg = "ok";
			
			$output .= '
				<table class = "table" border = "1">
					<tr>
						<th>State Name</th>
						<th>District Name</th>
						<th>Department</th>
						<th>Operator ID</th>
						<th>Operator Name</th>
						<th>PEC Location</th>
						<th>Station ID (DB)</th>
						<th>Station ID (CSV)</th>
						<th>Update/Correction</th>
						<th>Update / Correction(CSV)</th>
						<th>Update / Correction(Difference)</th>
						<th>New Enrollment</th>
						<th>New Enrollment(CSV)</th>
						<th>New Enrollment(Difference)</th>
						<th>Actual Enrollment</th>
						<th>Enrollment Difference</th>
						<th>Remarks</th>
						<th>Reporting Date</th>
					</tr>
				';	
			
			$sql = "SELECT a.state,a.district,a.dept,a.operator_id,b.username,a.pec_location,a.stid_db,a.stid_csv,a.updatecorrection,a.csv_upco,a.enrollment,a.csv_newen,a.original_enrollment,a.en_diff,a.remarks,date_format(a.created_dttm,'%d-%M-%Y')  from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.district = '".$district."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' order by a.created_dttm";
			$result1 = mysqli_query($con, $sql);
			while($row = mysqli_fetch_row($result1))
			{
				$stname = $row[0];
				$dis = $row[1];
				$dep = $row[2];
				$ope_id = $row[3];
				$opename = $row[4];
				$loc = $row[5];
				$stid = $row[6];
				$stidcsv = $row[7];
				$upcorr = $row[8];
				$upcorrcsv = $row[9];
				$upcodiff = $row[8]-$row[9];
				$newen = $row[10];
				$newencsv = $row[11];
				$newwndiff = $row[10]-$row[11];
				$act = $row[12];
				$diff = $row[13];
				$remk = $row[14];
				$repdate = $row[15];
				
				if($diff == 0)
				{
					$diff = $diff;
					$output .= '
					<tr>
						<td>'.$row[0].'</td>
						<td>'.$row[1].'</td>
						<td>'.$row[2].'</td>
						<td>'.$row[3].'</td>
						<td>'.$row[4].'</td>
						<td>'.$row[5].'</td>
						<td>'.$row[6].'</td>
						<td>'.$row[7].'</td>
						<td>'.$row[8].'</td>
						<td>'.$row[9].'</td>';
						if($upcodiff == 0) 
						{
							$output .= '
							<td>'.$upcodiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($upcodiff).'</td>';
						}	
						$output .= '		
						<td>'.$row[10].'</td>
						<td>'.$row[11].'</td>';
						if($newwndiff == 0) 
						{
							$output .= '
							<td>'.$newwndiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($newwndiff).'</td>';
						}
						$output .= '
						<td>'.$row[12].'</td>	
						<td>'.$diff.'</td>
						<td>'.$row[14].'</td>
						<td>'.$row[15].'</td>
					</tr>
				';
				}	
				else
				{
					$diff = abs($diff);
					$output .= '
					<tr>
						<td>'.$row[0].'</td>
						<td>'.$row[1].'</td>
						<td>'.$row[2].'</td>
						<td>'.$row[3].'</td>
						<td>'.$row[4].'</td>
						<td>'.$row[5].'</td>
						<td>'.$row[6].'</td>
						<td>'.$row[7].'</td>
						<td>'.$row[8].'</td>
						<td>'.$row[9].'</td>';
						if($upcodiff == 0) 
						{
							$output .= '
							<td>'.$upcodiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($upcodiff).'</td>';
						}	
						$output .= '		
						<td>'.$row[10].'</td>
						<td>'.$row[11].'</td>';
						if($newwndiff == 0) 
						{
							$output .= '
							<td>'.$newwndiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($newwndiff).'</td>';
						}
						$output .= '
						<td>'.$row[12].'</td>	
						<td style="color:red;background:yellow;">'.$diff.'</td>
						<td>'.$row[14].'</td>
						<td>'.$row[15].'</td>
					</tr>
				';
				}	
			}
			$output .= '</table>';
			
			// Save the spreadsheet
			$filename = $state."_District";
			
			//alert($filename);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
			header('Cache-Control: max-age=0');
			//$writer->save('php://output');	
				
			echo $output;
		}
		else
		{
			$msg = "not ok";
		}
	}
	else
	{
		$rep_query = "SELECT distinct(a.operator_id) from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' ";
		$result=mysqli_query($con ,$rep_query);
				
		$noofrow = mysqli_num_rows($result);

		if($noofrow > 0)
		{
			$msg = "ok";
			
			$output .= '
				<table class = "table" border = "1">
					<tr>
						<th>State Name</th>
						<th>District Name</th>
						<th>Department</th>
						<th>Operator ID</th>
						<th>Operator Name</th>
						<th>PEC Location</th>
						<th>Station ID (DB)</th>
						<th>Station ID (CSV)</th>
						<th>Update/Correction</th>
						<th>Update / Correction(CSV)</th>
						<th>Update / Correction(Difference)</th>
						<th>New Enrollment</th>
						<th>New Enrollment(CSV)</th>
						<th>New Enrollment(Difference)</th>
						<th>Actual Enrollment</th>
						<th>Enrollment Difference</th>
						<th>Remarks</th>
						<th>Reporting Date</th>
					</tr>
				';	
			
			$sql = "SELECT a.state,a.district,a.dept,a.operator_id,b.username,a.pec_location,a.stid_db,a.stid_csv,a.updatecorrection,a.csv_upco,a.enrollment,a.csv_newen,a.original_enrollment,a.en_diff,a.remarks,date_format(a.created_dttm,'%d-%M-%Y') from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' order by a.created_dttm";
			$result1 = mysqli_query($con, $sql);
			while($row = mysqli_fetch_row($result1))
			{
				$stname = $row[0];
				$dis = $row[1];
				$dep = $row[2];
				$ope_id = $row[3];
				$opename = $row[4];
				$loc = $row[5];
				$stid = $row[6];
				$stidcsv = $row[7];
				$upcorr = $row[8];
				$upcorrcsv = $row[9];
				$upcodiff = $row[8]-$row[9];
				$newen = $row[10];
				$newencsv = $row[11];
				$newwndiff = $row[10]-$row[11];
				$act = $row[12];
				$diff = $row[13];
				$remk = $row[14];
				$repdate = $row[15];
				
				if($diff == 0)
				{
					$diff = $diff;
					$output .= '
					<tr>
						<td>'.$row[0].'</td>
						<td>'.$row[1].'</td>
						<td>'.$row[2].'</td>
						<td>'.$row[3].'</td>
						<td>'.$row[4].'</td>
						<td>'.$row[5].'</td>
						<td>'.$row[6].'</td>
						<td>'.$row[7].'</td>
						<td>'.$row[8].'</td>
						<td>'.$row[9].'</td>';
						if($upcodiff == 0) 
						{
							$output .= '
							<td>'.$upcodiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($upcodiff).'</td>';
						}	
						$output .= '		
						<td>'.$row[10].'</td>
						<td>'.$row[11].'</td>';
						if($newwndiff == 0) 
						{
							$output .= '
							<td>'.$newwndiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($newwndiff).'</td>';
						}
						$output .= '
						<td>'.$row[12].'</td>	
						<td>'.$diff.'</td>
						<td>'.$row[14].'</td>
						<td>'.$row[15].'</td>
					</tr>
				';
				}	
				else
				{
					$diff = abs($diff);
					$output .= '
					<tr>
						<td>'.$row[0].'</td>
						<td>'.$row[1].'</td>
						<td>'.$row[2].'</td>
						<td>'.$row[3].'</td>
						<td>'.$row[4].'</td>
						<td>'.$row[5].'</td>
						<td>'.$row[6].'</td>
						<td>'.$row[7].'</td>
						<td>'.$row[8].'</td>
						<td>'.$row[9].'</td>';
						if($upcodiff == 0) 
						{
							$output .= '
							<td>'.$upcodiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($upcodiff).'</td>';
						}	
						$output .= '		
						<td>'.$row[10].'</td>
						<td>'.$row[11].'</td>';
						if($newwndiff == 0) 
						{
							$output .= '
							<td>'.$newwndiff.'</td>';
						}
						else
						{
							$output .= '
							<td style="color:red;background:yellow;">'.abs($newwndiff).'</td>';
						}
						$output .= '
						<td>'.$row[12].'</td>	
						<td style="color:red;background:yellow;">'.$diff.'</td>
						<td>'.$row[14].'</td>
						<td>'.$row[15].'</td>
					</tr>
				';
				}	
				
			}
			$output .= '</table>';
			
			// Save the spreadsheet
			$filename = $state."_District";
			
			//alert($filename);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
			header('Cache-Control: max-age=0');
			//$writer->save('php://output');	
				
			echo $output;
		}
		else
		{
			$msg = "not ok";
		}
	}
}

?>