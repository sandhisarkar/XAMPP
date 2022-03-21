<html>
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

$q=mysqli_query($con,"select username,`state`,district,role_id from tbl_coordinator where co_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$username= $n['username'];
$state= $n['state'];
$district= $n['district'];
$role= $n['role_id'];
$id=$_SESSION['user'];

$error = "";
$success = "";

date_default_timezone_set('Asia/Kolkata'); 

$datetime = date("Y-m-d H:i:s"); // time in India
$totalen = $_POST["updateCorrect"] + $_POST["enrollment"];
$sql_edit = "UPDATE tbl_attendance set updatecorrection= '".$_POST["updateCorrect"]."',enrollment= '".$_POST["enrollment"]."',original_enrollment = '".$totalen."',csv_upco='".$_POST["updateCorrect"]."',csv_newen='".$_POST["enrollment"]."',en_diff='0',remarks= '".$_POST["remarks"]."' WHERE operator_id = '".$_POST["opId"]."' and created_dttm = '".$_POST["reDate"]."' ";

if (!mysqli_query($con,$sql_edit))
{
  
}
else
{
    //echo $sql_edit;
	echo "Reporting is updated successfully...";
}

?>
</html>