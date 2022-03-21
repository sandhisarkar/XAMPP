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

$q=mysqli_query($con,"select username,password from tbl_operator where operator_id ='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$username= $n['username'];
$password= $n['password'];
$id=$_SESSION['user'];

$error = "";
$success = "";

date_default_timezone_set('Asia/Kolkata'); 

$datetime = date("Y-m-d H:i:s");
$year = substr($datetime,0,4);
$month = substr($datetime,5,2);
$day = substr($datetime,8,2);
$hour = substr($datetime,11,2);
$min = substr($datetime,14,2);

if(isset($_POST["sub_pass"]))
{
    $oldpassword = $_POST["oldpassword"];
	$newpassword = $_POST["newpassword"];
    $confirmpassword = $_POST['confirmpassword'];
    
    if($oldpassword != "" && $newpassword != "" && $confirmpassword != "")
    {
        if($oldpassword == $password)
        {
            if($oldpassword != $newpassword)
            {
                if($newpassword == $confirmpassword)
                {
                    $sql_password = "update tbl_operator set password= '".$newpassword."' where operator_id = '".$_SESSION['user']."' and password = '".$password."' ";
                    
                    if (!mysqli_query($con,$sql_password))
                    {
                        $error = "Query";
                    }
                    else
                    {
                        $success = "Change";
                    }
                }
                else
                {
                    $error = "Not Match";
                }
            }
            else
            {
                $error = "Try New";
            }
            
        }
        else
        {
            $error = "Old";
        }
    }
    else
    {
        $error = "Blank";
    }
    

}


$result = mysqli_query($con,"SELECT * FROM tbl_operator WHERE operator_id='".$_SESSION['user']."'");
                    
while($row = mysqli_fetch_array($result))
  {

?>

<!DOCTYPE html>
<html>
  <head>
    <link href="images/Nevaeh.ico" rel="icon">
    <link href="images/Nevaeh.ico" rel="apple-touch-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reporting Panel</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="css/grasp_mobile_progress_circle-1.0.0.min.css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/login_style.css">
    <!-- Favicon-->
    <link href="images/Nevaeh.ico" rel="icon">
    <link href="images/Nevaeh.ico" rel="apple-touch-icon">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <!-- Side Navbar -->
    <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info--><!--img src="img/avatar-7.jpg" alt="person" class="img-fluid rounded-circle"-->
          <div class="sidenav-header-inner text-center"><i class="fa fa-user-circle-o" style = "font-size:xxx-large;" aria-hidden="true"></i>
          <h2 class="h5"><?php echo $username; ?></h2><span>(<?php echo $_SESSION['user']; ?>)</span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="./" class="brand-small text-center" > <strong><i class="icon-bars"> </i></strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="./" onclick="openOverlay()"> <i class="icon-home"></i>Home</a></li>
            <!--li><a href="Upload.php" onclick="openOverlay()"> <i class="icon-form"></i>Upload</a></li-->
            <li><a href="Application.php" onclick="openOverlay()"> <i class="fa fa-rocket"></i>Reporting</a></li>
            <li class="active"><a href="Password.php" onclick="openOverlay()"> <i class="fa fa-key"></i>Reset Password</a></li>
            <!--li><a href="login.html"> <i class="icon-interface-windows"></i>Login page                             </a></li>
            <li> <a href="#"> <i class="icon-mail"></i>Demo
                <div class="badge badge-warning">6 New</div></a></li-->
          </ul>
        </div>
        <!--div class="admin-menu">
          <h5 class="sidenav-heading">Second menu</h5>
          <ul id="side-admin-menu" class="side-menu list-unstyled"> 
            <li> <a href="#"> <i class="icon-screen"> </i>Demo</a></li>
            <li> <a href="#"> <i class="icon-flask"> </i>Demo
                <div class="badge badge-info">Special</div></a></li>
            <li> <a href=""> <i class="icon-flask"> </i>Demo</a></li>
            <li> <a href=""> <i class="icon-picture"> </i>Demo</a></li>
          </ul>
        </div-->
      </div>
    </nav>
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
            <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a><a href="./" class="navbar-brand" onclick="openOverlay()">
                  <div class="brand-text d-none d-md-inline-block"><span></span><strong class="text-primary"></strong></div></a></div>
            
                  <div class="navbar-header" style="text-align:center;">
                    <h2 style="color:white;"><img src="img/Nevaeh HD Logo.png" alt="logo" class="icon" style="width:10%;"><span>&nbsp;</span>Online Reporing System (ORS)</h2>
                  </div> 


			  <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Notifications dropdown-->
                <!--li class="nav-item dropdown"> <a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-bell"></i><span class="badge badge-warning">12</span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-envelope"></i>You have 6 new messages </div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-upload"></i>Server Rebooted</div>
                          <div class="notification-time"><small>4 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> 
                        <div class="notification d-flex justify-content-between">
                          <div class="notification-content"><i class="fa fa-twitter"></i>You have 2 followers</div>
                          <div class="notification-time"><small>10 minutes ago</small></div>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-bell"></i>view all notifications                                            </strong></a></li>
                  </ul>
                </li-->
                <!-- Messages dropdown-->
                <!--li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="fa fa-envelope"></i><span class="badge badge-info">10</span></a>
                  <ul aria-labelledby="notifications" class="dropdown-menu">
                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                        <div class="msg-profile"> <img src="img/avatar-1.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h3 class="h5">Jason Doe</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                        <div class="msg-profile"> <img src="img/avatar-2.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h3 class="h5">Frank Williams</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex"> 
                        <div class="msg-profile"> <img src="img/avatar-3.jpg" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="msg-body">
                          <h3 class="h5">Ashley Wood</h3><span>sent you a direct message</span><small>3 days ago at 7:58 pm - 10.06.2014</small>
                        </div></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item all-notifications text-center"> <strong> <i class="fa fa-envelope"></i>Read all messages    </strong></a></li>
                  </ul>
                </li-->
                <!-- Languages dropdown    -->
                <!--li class="nav-item dropdown"><a id="languages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle"><img src="img/flags/16/GB.png" alt="English"><span class="d-none d-sm-inline-block">English</span></a>
                  <ul aria-labelledby="languages" class="dropdown-menu">
                    <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="img/flags/16/DE.png" alt="English" class="mr-2"><span>German</span></a></li>
                    <li><a rel="nofollow" href="#" class="dropdown-item"> <img src="img/flags/16/FR.png" alt="English" class="mr-2"><span>French                                                         </span></a></li>
                  </ul>
                </li-->
                <!-- Log out-->
                <li class="nav-item"><a href="logout.php" class="nav-link logout" onclick="openOverlay()"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item" onclick="openOverlay()"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Reset Password</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
          <h1 class="h3 display">Reset Password . . .</h1>
            <p>(To Change Password)</p>
          </header>
          <div class="row">
            <div class="col-lg-4">
            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                <h4>Password Reset</h4></h4>
                </div>
                <div class="card-body">
                  
                  
                  <form style="border-style: none;" action = "" method ="post"  id = "password" enctype="multipart/form-data">

                            <div class="form-group">
                            <label>Old Password </label>
                            <input type="password" required ="true"
                            placeholder="Enter any your current password" id="oldpassword" name = "oldpassword" class="form-control">
                            </div> 
                            <div class="form-group">
                            <label>New Password </label>
                            <input type="password" required ="true"
                            placeholder="Enter new password" id="newpassword" name = "newpassword" class="form-control">
                            </div>  
                            <div class="form-group">
                            <label>Confirm Password </label>
                            <input type="password" required ="true"
                            placeholder="Confirm new password" id="confirmpassword" name = "confirmpassword" class="form-control">
                            </div>
                            <div class="form-group">       
                            <input type="submit" value="Change Password" style="float: right;"  class="btn btn-primary" id="sub_pass" name = "sub_pass" onclick = "uploadme()">
                            </div>
                            
                  </form>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
            </div>
            <div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
            <?php
                        
						if($error == "" || $success == "")
						{
							
							echo '<label class="text-danger"></label>';
							
						}
						if($error == "Blank")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Please fill all the fields</label>';
							
						}
						if($error == "Old")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Invalid Current Password</label>';
							
						}
						if($error == "Try New")
						{
							//header( "refresh:30;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Please, try new password</label>';
							//echo $output;
							
						}
						if($error == "Not Match")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Password does not match</label>';
							//header( "refresh:3;url=Operator.php" );
                        }
                        if($success == "Change")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Password reset successfully</label>';
							//header( "refresh:3;url=Operator.php" );
						}
					?>
				</div>
          </div>
        </div>
      </section>
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p><img src="images/Nevaeh.ico" alt="logo" class="icon" style="width:3%;">&nbsp;<span>Nevaeh Technology Pvt. Ltd. &copy; 2020</span></p>
            </div>
            <div class="col-sm-6 text-right">
              <p>Design by <a href="https://www.nevaehtech.com" class="external">Nevaeh Technology Pvt. Ltd.</a></p>
              <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions and it helps me to run Bootstrapious. Thank you for understanding :)-->
            </div>
          </div>
        </div>
      </footer>
    </div>
    <div id="overlay">	  
      <div class="load-icon center" style= "text-align:center;">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Main File-->
    <script src="js/front.js"></script>
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
    <script language ="javascript">
		function uploadme()
		{
          //var operator = $("#operator").val();
          var updatecorrect = $("#updatecorrect").val();
          var enrollment = $("#enrollment").val();
          //var datetimepicker2 = $("#datetimepicker2").val();


          if(updatecorrect === "" || enrollment === "" )
          {
            
            document.getElementById("overlay").style.display = "none";
            return false;
          }
          if( updatecorrect !== null || enrollment !== null )
          {
            
            document.getElementById("overlay").style.display = "block";
            window.location.href = './';

            return true;
          }
          
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
    <script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker();
            });
        </script>
  </body>
</html>
<?php 
	  }
	?>