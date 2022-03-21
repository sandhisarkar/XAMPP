<?php
session_start();

include "include/db.php";

$msg = "";

$head = "Login";
if(isset($_REQUEST["u_sub"]))
{

 $usr=$_POST['u_user'];
 $pwd=$_POST['u_ps'];
 if($usr!=''&&$pwd!='')
 {
   //$query=mysqli_query($con ,"select * from ac_user a, ac_user_role_map b where a.user_id='".$usr."' and a.user_pwd='".$pwd."' and a.user_id = b.user_id and b.role_id = '2'");
   //$res=mysqli_fetch_row($query);
   $query1=mysqli_query($con ,"select a.user_id from ac_user a, ac_user_role_map b where a.user_id='".$usr."' and a.user_pwd='".$pwd."' and a.user_id = b.user_id and b.role_id = '8' or b.role_id = '2'");
   $res1=mysqli_fetch_row($query1);
   
   /*
   if($res)
   {
    $_SESSION['user']=$usr;
	
    header('location:Home.php');
   }
   else
   {
    
    echo '<script>';
    $msg = 'Invalid username or password';
    echo '</script>';
   }
   */
   if($res1)
   {
    $_SESSION['user']=$usr;
    header('location:Audit.php');
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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="css/login.css"></link>
        <!--link rel="stylesheet" href="bootstrap/bootstrap.min.css"-->
         <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
         <script src="bootstrap/jquery.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css">
        <title>CHC Audit</title>
        
		<!-- Favicons -->
		<link href="images/Nevaeh.ico" rel="icon">
		<link href="images/Nevaeh.ico" rel="apple-touch-icon">
        
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/5.10.2/css/font-awesome.min.css"-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
		
		<script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		
		<link href='https://fonts.googleapis.com/css?family=PT+Sans+Caption:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
		
    </head>
    <body  style="background-image:url('./images/my work 4.gif'); background-size: cover; background-repeat: no-repeat; background-position:center;" >
        <form id="index" action="" method="post">
            
            <div class="container-fluid">    
                <div class="row">
                  <div class="col-sm-12">
                    <img src="" width="100%" style="box-shadow: 1px 5px 14px #999999; "></img>
                  </div>
                 </div>                  
                <div  id="divtop">
                  <div id="dmain" style="margin-top: 25%;"> 
                      <br>
                      <center><h1  width="120px" height="100px" style= "color:aliceblue;"><?php echo $head; ?></h1></center>
                      <br>
                      <center><h4 style="color:red; text-align: center; font-size:large;"> 
                      <?php echo $msg; ?>
                      </h4></center>

                      <center><input type="text" id="u_id" name="u_user" class="form-control" style="width:320px;"  placeholder="Enter Your Username" style = "text-transform: uppercase;"><br></center>
                      <center><input type="password" id="u_ps" name="u_ps" class="form-control" style="width:320px;" placeholder="Enter Your Password"><br><br></center>
                      <center><input type="submit" onclick="openOverlay()" id="u_sub" name="u_sub" value="Login" class="toggle btn btn-primary" style="width:120px;"><br><br></center>
                    <!--a href="/education" style="margin-left: 155px; color: blanchedalmond;"><b>Back to Main Page</b></a-->
                  </div>         
                </div>
					 
					  <div id="overlay">	  
              <div class="load-icon center" style= "text-align:center;">
                <span></span>
                <span></span>
                <span></span>
              </div>
					  </div>
					 
                    </div>
               </div>
            </div>  
            </div>
        </form>  
		<script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
		<script language ="javascript">
		function openOverlay()
		{
			document.getElementById("overlay").style.display = "block";
			//window.location.href = 'Operator.php';

				return true;
			//}
			//	document.getElementById("demo").innerHTML = txt;
			
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
