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

//$_POST["runno"];

$sql2 = "select qc_size from image_master where page_index_name ='".$_POST['img']."' and status<>29 ";
$result2 = mysqli_query($con, $sql2);
$n3 = mysqli_fetch_row($result2);
$img_size = number_format($n3[0]);
echo "Image Size : ".$img_size." KB";   
?>
</html>