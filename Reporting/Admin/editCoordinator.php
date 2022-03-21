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

$q=mysqli_query($con,"select user_name from tbl_admin where user_name='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$username= $n['user_name'];
$id=$_SESSION['user'];

$error = "";
$success = "";

date_default_timezone_set('Asia/Kolkata'); 
$datetime = date("Y-m-d H:i:s"); // time in India

$sql_edit = "UPDATE tbl_coordinator set username = '".$_POST["username"]."',activity_status= '".$_POST["activity"]."' WHERE co_id = '".$_POST["coId"]."' ";

if (!mysqli_query($con,$sql_edit))
{
  
}
else
{
    //echo $sql_edit;
	echo "Coordinator is updated successfully...";
}

?>
</html>