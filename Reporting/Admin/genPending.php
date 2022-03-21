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
						<th>Station ID</th>
						<th>Pending Reporting Date</th>
					</tr>
                ';	
			
                $stdt = strtotime($datestartapplication);
                $enddt = strtotime($dateendapplication);
                $stepVal = '+1 day';
    
                while($stdt <= $enddt)
                {
                    $disdt = date('Y-m-d',$stdt);
    
                    $sql_op = "SELECT distinct(operator_id) from tbl_operator where operator_id NOT IN (select operator_id from tbl_attendance where created_dttm ='".$disdt."' and  state = '".$state."' and district='".$district."') and  state = '".$state."' and district='".$district."' and  (emp_status = 1 or emp_status = 2) ";
                    $result_op = mysqli_query($con, $sql_op);
                    while($row1 = mysqli_fetch_row($result_op)) 
                    {
                        $opid = $row1[0];
    
                        $sql_result = "SELECT Distinct `state`,district,dept,operator_id,username,pec_location,station_id from tbl_operator where operator_id = '".$opid."'";
                        $result_result = mysqli_query($con, $sql_result);
                        
                        while($row2 = mysqli_fetch_row($result_result)) 
                        {
                            
                            $output .= '
                                <tr>
                                    <td>'.$row2[0].'</td>
                                    <td>'.$row2[1].'</td>
                                    <td>'.$row2[2].'</td>
                                    <td>'.$row2[3].'</td>
                                    <td>'.$row2[4].'</td>
                                    <td>'.$row2[5].'</td>
                                    <td>'.$row2[6].'</td>
                                    <td>'.date('d-M-Y',$stdt).'</td>
                                </tr>
                            ';
                        }
                    }
                    $stdt = strtotime($stepVal,$stdt);
                }
                
                $output .= '</table>';
                
                // Save the spreadsheet
                $filename = $state."_Pending";
                
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
						<th>Station ID</th>
						<th>Pending Reporting Date</th>
					</tr>
                ';	
                
            $stdt = strtotime($datestartapplication);
            $enddt = strtotime($dateendapplication);
            $stepVal = '+1 day';

            while($stdt <= $enddt)
            {
                $disdt = date('Y-m-d',$stdt);

                $sql_op = "SELECT distinct(operator_id) from tbl_operator where operator_id NOT IN (select operator_id from tbl_attendance where created_dttm ='".$disdt."' and  state = '".$state."') and  state = '".$state."' and  (emp_status = 1 or emp_status = 2) ";
                $result_op = mysqli_query($con, $sql_op);
                while($row1 = mysqli_fetch_row($result_op)) 
                {
                    $opid = $row1[0];

                    $sql_result = "SELECT Distinct `state`,district,dept,operator_id,username,pec_location,station_id from tbl_operator where operator_id = '".$opid."'";
                    $result_result = mysqli_query($con, $sql_result);
                    
                    while($row2 = mysqli_fetch_row($result_result)) 
                    { 
                        
                        $output .= '
                            <tr>
                                <td>'.$row2[0].'</td>
                                <td>'.$row2[1].'</td>
                                <td>'.$row2[2].'</td>
                                <td>'.$row2[3].'</td>
                                <td>'.$row2[4].'</td>
                                <td>'.$row2[5].'</td>
                                <td>'.$row2[6].'</td>
                                <td>'.date('d-M-Y',$stdt).'</td>
                            </tr>
                        ';
                    }
                }
                $stdt = strtotime($stepVal,$stdt);
            }
			
			$output .= '</table>';
			
			// Save the spreadsheet
			$filename = $state."_Pending";
			
			//alert($filename);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
			header('Cache-Control: max-age=0');
			//$writer->save('php://output');	
				
			echo $output;
		
	}
}

?>