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
                    <th>Station ID</th>
                </tr>
            ';

		$sql = "SELECT distinct(operator_id) from tbl_operator where state = '".$state."' and (emp_status = 1 or emp_status = 2)";
        $result = mysqli_query($con, $sql);
		while($row = mysqli_fetch_row($result)) {
            $opid = $row[0]; 
            $count = 0;
            while($row = mysqli_fetch_row($result))
            {
                $op = $row[0];
                $result_occ =mysqli_query($con ,"SELECT distinct(created_dttm) from tbl_attendance where operator_id = '".$op."' and created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' ");
                $noofrow = mysqli_num_rows($result_occ);
                if($noofrow < 2)
                {
                    $count++;
                    $result_op =mysqli_query($con ,"SELECT distinct state,district,dept,operator_id,username,pec_location,station_id from tbl_operator where  operator_id = '".$op."' ");
                    while($rownew = mysqli_fetch_row($result_op))
                    {
                        $output .= '
                        <tr>
                            <td>'.$rownew[0].'</td>
                            <td>'.$rownew[1].'</td>
                            <td>'.$rownew[2].'</td>
                            <td>'.$rownew[3].'</td>
                            <td>'.$rownew[4].'</td>
                            <td>'.$rownew[5].'</td>
                            <td>'.$rownew[6].'</td>
                        </tr>
                        ';
                    }
                }
            }
        }		
	
        $output .= '</table>';
        
        // Save the spreadsheet
        $filename = $state."_MostOccuredNotReported";
        
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
                </tr>
            ';

		$sql = "SELECT distinct(operator_id) from tbl_operator where state = '".$state."' and district = '".$district."' and (emp_status = 1 or emp_status = 2)";
        $result = mysqli_query($con, $sql);
		while($row = mysqli_fetch_row($result)) {
            $opid = $row[0]; 
            $count = 0;
            while($row = mysqli_fetch_row($result))
            {
                $op = $row[0];
                $result_occ =mysqli_query($con ,"SELECT distinct(created_dttm) from tbl_attendance where operator_id = '".$op."' and created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' ");
                $noofrow = mysqli_num_rows($result_occ);
                if($noofrow < 2)
                {
                    $count++;
                    $result_op =mysqli_query($con ,"SELECT distinct state,district,dept,operator_id,username,pec_location,station_id from tbl_operator where  operator_id = '".$op."' ");
                    while($rownew = mysqli_fetch_row($result_op))
                    {
                        $output .= '
                        <tr>
                            <td>'.$rownew[0].'</td>
                            <td>'.$rownew[1].'</td>
                            <td>'.$rownew[2].'</td>
                            <td>'.$rownew[3].'</td>
                            <td>'.$rownew[4].'</td>
                            <td>'.$rownew[5].'</td>
                            <td>'.$rownew[6].'</td>
                        </tr>
                        ';
                    }
                }
            }
        }		
	
        $output .= '</table>';
        
        // Save the spreadsheet
        $filename = $state."_MostOccuredNotReported";
        
        //alert($filename);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        //$writer->save('php://output');	
            
        echo $output;
	}
	
}

?>