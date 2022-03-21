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
	
	if($district == "All")
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
						<th>Reporting Date</th>
						<th>Out of Time Reporting</th>
						<th>High Risk</th>
					</tr>
				';	
			
			$sql = "SELECT DISTINCT operator_id,created_date FROM `tbl_outrangetime` WHERE created_date BETWEEN '".$datestartapplication."' AND '".$dateendapplication."'  AND operator_id IN (SELECT operator_id FROM tbl_attendance WHERE created_dttm BETWEEN '".$datestartapplication."' AND '".$dateendapplication."' and state = '".$state."') ";
			$result1 = mysqli_query($con, $sql);
			while($row = mysqli_fetch_row($result1))
			{
				
				$sql_new = "SELECT Distinct a.state,a.district,a.dept,b.username,a.pec_location,a.stid_db,a.stid_csv from  tbl_attendance a,tbl_operator b where a.operator_id = b.operator_id and a.operator_id = '".$row[0]."' and  a.created_dttm = '".$row[1]."' and a.state = '".$state."'";
				$result_new = mysqli_query($con, $sql_new);
				while($row1 = mysqli_fetch_row($result_new)) 
				{
				$stname = $row[0];
				$dis = $row[1];
				$dep = $row[2];
				$ope_id = $row[3];
				$opename = $row[4];
				$loc = $row[5];
				$stid = $row[6];
				$stidcsv = $row[7];
				$remk = $row[8];
				$repdate = $row[9];
				
				
				$output .= '
					<tr>
						<td>'.$row1[0].'</td>
						<td>'.$row1[1].'</td>
						<td>'.$row1[2].'</td>
						<td>'.$row[0].'</td>
						<td>'.$row1[3].'</td>
						<td>'.$row1[4].'</td>
						<td>'.$row1[5].'</td>
						<td>'.$row1[6].'</td>
						<td>'.date('d-M-Y',strtotime($row[1])).'</td>
						<td style="color:red;">';
						$sql_new_1 = "SELECT Distinct log_DTTM  from tbl_outrangetime where operator_id = '".$row[0]."' and created_date = '".$row[1]."'  ";
						$result_new_1 = mysqli_query($con, $sql_new_1);
						$norow = mysqli_num_rows($result_new);
						$highrisk = "";
						while($row2 = mysqli_fetch_row($result_new_1)) {
							
							$output .= ''.$row2[0].';&nbsp;&nbsp;';

							
							if(substr($row2[0],0,2) == 23 || substr($row2[0],0,2) < 8)
							{
								
								$highrisk = $highrisk.''.$row2[0].';&nbsp;&nbsp;';
								
							}
							
						}
						if($highrisk == "")
						{
							$output .='</td>
							<td style="color:red;">'.$highrisk.'</td>';
						}
						else
						{
							$output .='</td>
							<td style="color:red;background:yellow;">'.$highrisk.'</td>';
						}
						$output .='	
					</tr>
				';
				}
			}
			$output .= '</table>';
			
			// Save the spreadsheet
			$filename = $state."_Time";
			
			//alert($filename);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
			header('Cache-Control: max-age=0');
			//$writer->save('php://output');	
				
			echo $output;
			
		
	}
	else
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
						<th>Reporting Date</th>
						<th>Out of Time Reporting</th>
						<th>High Risk</th>
					</tr>
				';	
			
				$sql = "SELECT DISTINCT operator_id,created_date FROM `tbl_outrangetime` WHERE created_date BETWEEN '".$datestartapplication."' AND '".$dateendapplication."'  AND operator_id IN (SELECT operator_id FROM tbl_attendance WHERE created_dttm BETWEEN '".$datestartapplication."' AND '".$dateendapplication."' and state = '".$state."' AND district = '".$district."') ";
			$result1 = mysqli_query($con, $sql);
			while($row = mysqli_fetch_row($result1))
			{
				
				$sql_new = "SELECT Distinct a.state,a.district,a.dept,b.username,a.pec_location,a.stid_db,a.stid_csv from  tbl_attendance a,tbl_operator b where a.operator_id = b.operator_id and a.operator_id = '".$row[0]."' and  a.created_dttm = '".$row[1]."' and a.state = '".$state."' AND a.district = '".$district."' ";
				$result_new = mysqli_query($con, $sql_new);
				while($row1 = mysqli_fetch_row($result_new)) 
				{
				$stname = $row[0];
				$dis = $row[1];
				$dep = $row[2];
				$ope_id = $row[3];
				$opename = $row[4];
				$loc = $row[5];
				$stid = $row[6];
				$stidcsv = $row[7];
				$remk = $row[8];
				$repdate = $row[9];
				
				
				$output .= '
					<tr>
						<td>'.$row1[0].'</td>
						<td>'.$row1[1].'</td>
						<td>'.$row1[2].'</td>
						<td>'.$row[0].'</td>
						<td>'.$row1[3].'</td>
						<td>'.$row1[4].'</td>
						<td>'.$row1[5].'</td>
						<td>'.$row1[6].'</td>
						<td>'.date('d-M-Y',strtotime($row[1])).'</td>
						<td style="color:red;">';
						$sql_new_1 = "SELECT Distinct log_DTTM  from tbl_outrangetime where operator_id = '".$row[0]."' and created_date = '".$row[1]."'  ";
						$result_new_1 = mysqli_query($con, $sql_new_1);
						$norow = mysqli_num_rows($result_new);
						$highrisk = "";
						while($row2 = mysqli_fetch_row($result_new_1)) {
							
							$output .= ''.$row2[0].';&nbsp;&nbsp;';

							if(substr($row2[0],0,2) == 23 || substr($row2[0],0,2) < 8)
							{
								
								$highrisk = $highrisk.''.$row2[0].';&nbsp;&nbsp;';
								
							}
						
						}
						if($highrisk == "")
						{
							$output .='</td>
							<td style="color:red;">'.$highrisk.'</td>';
						}
						else
						{
							$output .='</td>
							<td style="color:red;background:yellow;">'.$highrisk.'</td>';
						}
						$output .='	
					</tr>
				';
				}
			}
			$output .= '</table>';
			
			// Save the spreadsheet
			$filename = $state."_Time";
			
			//alert($filename);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
			header('Cache-Control: max-age=0');
			//$writer->save('php://output');	
				
			echo $output;
		
	}
	
}

?>