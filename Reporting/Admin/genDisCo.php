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
    $msg = "ok";
			
    $output .= '
        <table class = "table" border = "1">
            <tr>
                <th>Serial No</th>
                <th>State Name</th>
                <th>District Name</th>
                <th>Coordinator ID</th>
                <th>Password</th>
                <th>Coordinator Name</th>
            </tr>
        ';	

    $sql = "SELECT state,district,co_id,password,username from tbl_coordinator where activity_status = 1 and role_id = 2 order by slno asc";
    $result1 = mysqli_query($con, $sql);
    $count = 0;
    while($row = mysqli_fetch_row($result1))
    {    
        $count++;
        $output .= '
                    <tr>
                        <td>'.$count.'</td>
                        <td>'.$row[0].'</td>
                        <td>'.$row[1].'</td>
                        <td>'.$row[2].'</td>
                        <td>'.$row[3].'</td>
                        <td>'.$row[4].'</td>
                    </tr>
                ';
    }
    $output .= '</table>';
			
    // Save the spreadsheet
    $filename = "ActiveDistrictCo";
    
    //alert($filename);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename= "'.$filename.'.xls"');
    header('Cache-Control: max-age=0');
    //$writer->save('php://output');	
        
    echo $output;
}



?>