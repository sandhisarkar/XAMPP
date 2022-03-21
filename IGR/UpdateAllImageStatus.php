<html>
<?php

session_start();
error_reporting(0);


$con=mysqli_connect("localhost","root","root","dsr_murshidabad");
$q=mysqli_query($con,"select user_name from ac_user where user_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['user_name'];
$id=$_SESSION['user'];
$error = "";
$success = "";

date_default_timezone_set('Asia/Kolkata'); 
$datetime = date("Y-m-d H:i:s"); // time in India

$sql_Update_all_image_status = "update image_master set status=".$_POST['PAGE_EXCEPTION']." , modified_by='".$id."',modified_dttm='".$datetime."' where proj_key=".$_POST['proj_key']." and batch_key=".$_POST['batch_key']." and box_number='".$_POST['box_number']."' and policy_number='".$_POST['policy']."' and (status <> ".$_POST['PAGE_DELETED']." and status <> ".$_POST['PAGE_ON_HOLD']." and status <> ".$_POST['PAGE_RESCANNED_NOT_INDEXED']." and status<>".$_POST['PAGE_EXPORTED'].")";
				
if (!mysqli_query($con,$sql_Update_all_image_status))
{
  
}
else
{
	
}

?>
</html>