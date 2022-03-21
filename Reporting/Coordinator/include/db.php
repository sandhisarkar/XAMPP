

<?php
$user = "root"; 
$password = "root"; 
$host = "localhost"; 
$dbase = "attendance_db"; 


//Block 3
$con= mysqli_connect ($host, $user, $password,$dbase);
if (!$con)
{
    echo "Database Not Found";
    header("Location: 404.php");
    die ('Could not connect:' . mysql_error());
}
mysqli_select_db($con,$dbase);



?>
