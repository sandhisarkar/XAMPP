<html>
<?php

session_start();
error_reporting(0);


include "include/db.php";
$q=mysqli_query($con,"select user_name from ac_user where user_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['user_name'];
$id=$_SESSION['user'];
$error = "";
$success = "";

date_default_timezone_set('Asia/Kolkata'); 
$datetime = date("Y-m-d H:i:s"); // time in India

$sql_update_batch_status = "update bundle_master set status = '7' where bundle_code = '".$_POST['runno']."' and proj_code = '".$_POST['Proj']."' and bundle_key = '".$_POST['Bundle']."'";
				
if (!mysqli_query($con,$sql_update_batch_status))
{
  
}
else
{
	$insert_sql="insert into tbl_uat_info(percent_checked,run_no,cretaed_by,created_dttm) values ('".$_POST['percent']."','".$_POST['runno']."','".$id."','".$datetime."')";

	if (!mysqli_query($con,$insert_sql))
	{	  

	}
	else
	{
		
	}
}

?>
</html>