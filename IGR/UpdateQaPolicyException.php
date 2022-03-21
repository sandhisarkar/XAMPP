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

$sql= "update lic_qa_log set missing_img_exp= '".$_POST['missing_img']."',crop_clean_exp= '".$_POST['crop_clean']."',poor_scan_exp= '".$_POST['poor_scan']."',wrong_indexing_exp=".$_POST['indexing'].",linked_policy_exp=".$_POST['wrong_prop'].",decision_misd_exp=".$_POST['spel'].",extra_page_exp=".$_POST['extra_page'].",rearrange_exp=".$_POST['rearrange'].",other_exp=".$_POST['other'].",move_to_respective_policy_exp=".$_POST['move'].",modified_by='".$id."',modified_dttm='".$datetime."',SOLVED=".$_POST['solved'].",comments='".$_POST['comments']."' where proj_key= ".$_POST['proj_key']." and box_number= ".$_POST['box_number']." and policy_number='".$_POST['policy']."' and batch_key= '".$_POST['batch_key']."' ";
//echo $sql;

if (!mysqli_query($con,$sql))
{

}
else
{

}
?>
</html>