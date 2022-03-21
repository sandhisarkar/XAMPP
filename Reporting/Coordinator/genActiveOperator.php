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
    $state = $_POST['txtSequenceId4'];
    $district = $_POST['txtSequenceId5'];


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
                    <th>Employee Status</th>
                </tr>
            ';
    
        $sql = "SELECT state,district,dept,operator_id,username,pec_location,station_id,emp_status from tbl_operator where state = '".$state."' and (emp_status = 1 or emp_status = 2)";
        $result = mysqli_query($con, $sql);
		while($row = mysqli_fetch_row($result)) {    

            if($row[7] == 1)
            {
                $emp_status = "Existing";
            }
            else
            {
                $emp_status = "New Joinee";
            }

            $output .= '
                        <tr>
                            <td>'.$row[0].'</td>
                            <td>'.$row[1].'</td>
                            <td>'.$row[2].'</td>
                            <td>'.$row[3].'</td>
                            <td>'.$row[4].'</td>
                            <td>'.$row[5].'</td>
                            <td>'.$row[6].'</td>
                            <td>'.$emp_status.'</td>
                        </tr>
                        ';

        }

        $output .= '</table>';
        
        // Save the spreadsheet
        $filename = $state."_WorkingList";
        
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
                    <th>Employee Status</th>
                </tr>
            ';
    
        $sql = "SELECT state,district,dept,operator_id,username,pec_location,station_id,emp_status from tbl_operator where state = '".$state."' and district = '".$district."' and (emp_status = 1 or emp_status = 2)";
        $result = mysqli_query($con, $sql);
		while($row = mysqli_fetch_row($result)) {    

            if($row[7] == 1)
            {
                $emp_status = "Existing";
            }
            else
            {
                $emp_status = "New Joinee";
            }

            $output .= '
                        <tr>
                            <td>'.$row[0].'</td>
                            <td>'.$row[1].'</td>
                            <td>'.$row[2].'</td>
                            <td>'.$row[3].'</td>
                            <td>'.$row[4].'</td>
                            <td>'.$row[5].'</td>
                            <td>'.$row[6].'</td>
                            <td>'.$emp_status.'</td>
                        </tr>
                        ';

        }

        $output .= '</table>';
        
        // Save the spreadsheet
        $filename = $state."_WorkingList";
        
        //alert($filename);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        //$writer->save('php://output');	
            
        echo $output;
    }
    

}

?>