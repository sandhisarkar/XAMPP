<html>
<?php

session_start();
error_reporting(0);
//header( "url=/Bihar_PEC/" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];
$error = "";
$success = "";

//echo $_POST["monthyear"];

$query ="SELECT DISTINCT(TRIM(district_name)) FROM monthly_attendence WHERE month_year = '" . $_POST["monthyear"]."' and status = 'Created'";
    
	
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