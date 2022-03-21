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

//echo $_POST["monthyear"];

$query ="SELECT DISTINCT(TRIM(district)) FROM tbl_operator WHERE state = '" . $_POST["state"]."' ";
    
	
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