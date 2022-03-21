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

$query ="SELECT DISTINCT TRIM(batch_code) FROM batch_master WHERE run_no = '" . $_POST["runno"]."' and status = '66' AND TRIM(batch_code) NOT IN (select batch_code from audit_backup)";
    echo $query;
	
    $result = mysqli_query($con, $query);
	?>
    <option disabled selected value="">Select Any...</option>

<?php
    while($row2=mysqli_fetch_row($result)){
		?>
        //var_dump($row2);
       
            <option value="<?php echo  $row2[0]; ?> "><?php echo  $row2[0]; ?> </option>
<?php
         }
     
?>
</html>