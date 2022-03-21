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

$sql_qa_solved = "update lic_qa_log set SOLVED= ".$_POST['solved']." where proj_key= ".$_POST['proj_key']." and box_number= ".$_POST['box_number']." and policy_number='".$_POST['policy']."' and batch_key= '".$_POST['batch_key']."' and solved <> '7'";
				
if (!mysqli_query($con,$sql_qa_solved))
{
  
}
else
{
	
}

$sql_qa_status = "update lic_qa_log set qa_status= ".$_POST['qa_status']." where proj_key= ".$_POST['proj_key']." and box_number= ".$_POST['box_number']." and policy_number='".$_POST['policy']."' and batch_key= '".$_POST['batch_key']."' ";

if (!mysqli_query($con,$sql_qa_status))
{
  
}
else
{
	
}
?>
</html>