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

//echo $_POST["monthyear"];

if($district == "All")
{
  $query ="SELECT DISTINCT(TRIM(operator_id)) FROM tbl_attendance WHERE state = '" . $_POST["state"]."'  order by operator_id asc";
    
	
  $result = mysqli_query($con, $query);
?>
  <option disabled selected value="">Select Any...</option>

<?php
  while($row2=mysqli_fetch_row($result)){
  ?>
      //var_dump($row2);
     
          <option style = "color:black;" value="<?php echo  $row2[0]; ?> "><?php echo  $row2[0]; ?> </option>
<?php
       }
   
?>
<?php
}
else
{

  $query ="SELECT DISTINCT(TRIM(operator_id)) FROM tbl_attendance WHERE state = '" . $_POST["state"]."' and district = '".$district."'  order by operator_id asc";
    
	
    $result = mysqli_query($con, $query);
	?>
    <option disabled selected value="">Select Any...</option>

<?php
    while($row2=mysqli_fetch_row($result)){
		?>
        //var_dump($row2);
       
            <option style = "color:black;" value="<?php echo  $row2[0]; ?> "><?php echo  $row2[0]; ?> </option>
<?php
         }
     


}
?>

</html>