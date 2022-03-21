<?php
session_start();

include "include/db.php";

$msg = "";
if(isset($_REQUEST["u_sub"]))
{

  $usr=$_POST['InputUserId'];
  $pwd=$_POST['InputPassword'];
  
  if($usr!=''&&$pwd!='')
  {
    $query=mysqli_query($con ,"select * from tbl_admin where user_name='".$usr."' and password='".$pwd."'");
    $res=mysqli_fetch_row($query);
    $query1=mysqli_query($con ,"select * from tbl_operator where operator_id='".$usr."' and password='".$pwd."' and (emp_status = 1 or emp_status =2)");
    $res1=mysqli_fetch_row($query1);
    $query2=mysqli_query($con ,"select * from tbl_coordinator where co_id='".$usr."' and password='".$pwd."' and activity_status = 1 ");
    $res2=mysqli_fetch_row($query2);
    if($res)
    {
      $_SESSION['user']=$usr;
	    $_SESSION['last_login_timestamp'] = time();
      header('location: ./Admin/');
    }
    elseif ($res1) {
      # code...
      $_SESSION['user']=$usr;
	    $_SESSION['last_login_timestamp'] = time();
      header('location: ./Operator/');
    }
    elseif ($res2) {
      # code...
      $_SESSION['user']=$usr;
	    $_SESSION['last_login_timestamp'] = time();
      header('location: ./Coordinator/');
    }
    else
    {
      
      echo '<script>';
      $msg = 'Invalid username or password';
      echo '</script>';
    }
  }
  else
  {
      echo '<script>';
      $msg = 'Enter both username and password';
      echo '</script>';
  
  }
}

?>
<html>
<head>
 
   <!-- Required meta tags -->
   <title>Reporting Portal</title>
        
    <!-- Favicons -->
    <link href="images/Nevaeh.ico" rel="icon">
    <link href="images/Nevaeh.ico" rel="apple-touch-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    
  <!-- Bootstrap CSS -->

 <link rel="stylesheet" href="css/login_style.css">
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
 
<body style="background-image:url('./images/01.jpg'); background-size: unset; background-repeat: no-repeat; background-position:center;height: 100%;">
  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- Login form creation starts-->
  <section class="container-fluid">
    <!-- row and justify-content-center class is used to place the form in center -->
    <section class="row justify-content-center">
      <section class="col-12 col-sm-6 col-md-4">
        <form class="form-container" method="post" action="">
        <h4 class="text-center font-weight-bold" style="color: aliceblue"> Login </h4>
        <div class="form-group">
          
          
            <h4 style="color:red; text-align: center; font-size:large;"> 
              <?php echo $msg; ?>
            </h4>
          

          <label for="InputUserId" style="color: aliceblue">User Id</label>
           <input type="text" class="form-control" id="InputUserId" name="InputUserId"  placeholder="Enter User Id"><!--aria-describeby="emailHelp"-->
          </div>
          <div class="form-group">
            <label for="InputPassword" style="color: aliceblue">Password</label>
            <input type="password" class="form-control" id="InputPassword1"  name="InputPassword" placeholder="Enter Password">
          </div></br>
          <div class="form-group">
              <input type="submit" value="Submit" id="u_sub" name="u_sub" class="btn btn-primary btn-block" onclick="openOverlay()"></input>
          </div>
        </form>
      </section>
    </section>
  </section>

  <div id="overlay">	  
    <div class="load-icon center" style= "text-align:center;">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
<!-- Login form creation ends -->
<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script language ="javascript">
		function openOverlay()
		{
			document.getElementById("overlay").style.display = "block";

				return true;

		}
	</script>
	<script>
		function on() {
		  document.getElementById("overlay").style.display = "block";
		}

		function off() {
		  document.getElementById("overlay").style.display = "none";
		}
		</script>
</body>
</html>