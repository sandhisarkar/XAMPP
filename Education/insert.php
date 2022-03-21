<html>

<body>

 

 

<?php

$con = mysqli_connect("localhost","root","root");

if (!$con)

  {

  die('Could not connect: ' . mysql_error());

  }

 

mysqli_select_db( $con,"demo");
$centre_name=$_POST['centre_name'];
 

$sql="INSERT INTO centre_details (cen_name)

VALUES

($_POST['centre_name'])";

 

if (!mysqli_query($con,$sql))

  {

  die('Error: ');

  }

echo "1 record added";

 

mysqli_close($con)

?>

</body>

</html>