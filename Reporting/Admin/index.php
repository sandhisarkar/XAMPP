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

$query=mysqli_query($con ,"select count(*) from tbl_operator");
$res=mysqli_fetch_row($query);
$totoperator = $res[0];

$query1=mysqli_query($con ,"select Distinct state from tbl_operator");
$res1=mysqli_fetch_row($query1);
$re = $res1[0];
$totstate = mysqli_num_rows($query1);

$queryx=mysqli_query($con ,"select Distinct district from tbl_operator");
$resx=mysqli_fetch_row($queryx);
$re1 = $resx[0];
$totdis = mysqli_num_rows($queryx);

$query2=mysqli_query($con ,"select Count(*) from tbl_operator where emp_status = 0");
$res2=mysqli_fetch_row($query2);
$totnotexists = $res2[0];


$query3=mysqli_query($con ,"select Count(*) from tbl_operator where emp_status = 1");
$res3=mysqli_fetch_row($query3);
$totexists = $res3[0];

$query4=mysqli_query($con ,"select Count(*) from tbl_operator where emp_status = 2");
$res4=mysqli_fetch_row($query4);
$totnew = $res4[0];


$array_string = array();

$result = mysqli_query($con,"SELECT * FROM tbl_admin WHERE user_name='".$_SESSION['user']."'");
                    
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
    <title>Reporing Admin Panel</title>
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
            <h2 class="h5">User : <?php echo $username; ?></h2><span>Admin Team</span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="./" class="brand-small text-center" onclick="openOverlay()"> <strong><i class="icon-bars"> </i></strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li class="active"><a href="./" onclick="openOverlay()"> <i class="icon-home"></i>Home</a></li>
            <li><a href="Upload.php" onclick="openOverlay()"> <i class="icon-form"></i>Upload</a></li>
            <li><a href="#exampledropdownDropdownCo" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-user"></i>Coordinator </a>
              <ul id="exampledropdownDropdownCo" class="collapse list-unstyled ">
                <li><a href="Coordinator.php" onclick="openOverlay()"> <i class="fa fa-user-plus text-success"></i>Create Coordinator</a></li>
                <li><a href="Edit Coordinator.php" onclick="openOverlay()"><i class="fa fa-edit text-warning"></i>Edit Coordinator</a></li>
              </ul>
            </li>
            <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Daily Reporting </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="Application.php" onclick="openOverlay()"> <i class="fa fa-rocket"></i>Reporting</a></li>
                <li><a href="Edit.php" onclick="openOverlay()"><i class="fa fa-edit"></i>Edit Reporting</a></li>
              </ul>
            </li>
            <li><a href="#exampledropdownDropdown1" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-file-excel-o"></i>Report </a>
              <ul id="exampledropdownDropdown1" class="collapse list-unstyled ">
                <li><a href="Range.php" onclick="openOverlay()"> <i class="fa fa-calendar"></i>Date</a></li>
                <li><a href="District.php" onclick="openOverlay()"><i class="fa fa-globe"></i>District</a></li>
                <li><a href="Supervisor.php" onclick="openOverlay()"><i class="fa fa-user-o"></i>Supervisor</a></li>
                <li><a href="Location.php" onclick="openOverlay()"><i class="fa fa-area-chart"></i>PEC Location</a></li>
                <li><a href="Time.php" onclick="openOverlay()"><i class="fa fa-clock-o"></i>Out Of Time</a></li>
	              <li><a href="Department.php" onclick="openOverlay()"><i class="fa fa-building-o"></i>Department</a></li>
                <li><a href="Pending.php" onclick="openOverlay()"><i class="fa fa-exclamation-triangle"></i>Pending</a></li>
                <li><a href="Attendance.php" onclick="openOverlay()"> <i class="fa fa-child"></i>Attendance</a></li>
                <li><a href="#exampledropdownDropdown2" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-user-o"></i>Most Occurred</a>
                  <ul id="exampledropdownDropdown2" class="collapse list-unstyled ">
                    <li><a href="Occured Time.php" onclick="openOverlay()"> <i class="fa fa-calendar text-danger"></i>Out Of Time</a></li>
                    <li><a href="Not Reported.php" onclick="openOverlay()"> <i class="fa fa-envelope text-danger"></i>Not Reported</a></li>
                  </ul>
                </li>	
              </ul>
            </li>
            <li><a href="Password.php" onclick="openOverlay()"> <i class="fa fa-key"></i>Reset Password</a></li>
            
            <!--li><a href="login.html"> <i class="icon-interface-windows"></i>Login page</a></li>
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
                  <div class="brand-text d-none d-md-inline-block"><span></span><strong class="text-primary"></strong></div></a>
			</div>
			  
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
      <!-- Counts Section -->
      
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- To Do List-->
            
            <!-- Pie Chart-->
            
            <!-- Line Chart -->
            <div class="col-lg-12" style="text-align: center;">
                <h1>Summary</h1>
                <h3><u>(State Wise)</u></h3>
            </div>
          </div>
        </div>
      </section>
      <!-- Statistics Section-->
      
      <!-- Updates Section -->
      <?php
        $sql_state = "SELECT distinct(state) from tbl_operator order by state asc";
        $result_state = mysqli_query($con, $sql_state);

        if (mysqli_num_rows($result_state) > 0) {
              $array_string = array();

              $count = 0;
          while($row_state = mysqli_fetch_row($result_state)) {
              $statename = $row_state[0];
              array_push($array_string,$statename);
              $count++;
            ?>
            <div class="col-lg-12 col-md-12">
              <section class="dashboard-counts section-padding">
                <div class="container-fluid">
                  <div class="row border border-dark" style="border-radius:10px; padding:2%;">
                    
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6">
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-globe text-warning" aria-hidden="true"></i></div>
                        <div class="name"><strong class="text-uppercase">State</strong><span></span>
                          <div class="count-number"><?php echo $statename; ?></div>
                        </div>
                      </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6">
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-area-chart text-info" aria-hidden="true"></i></div>
                        <div class="name"><strong class="text-uppercase">District</strong><span></span>
                          <div class="count-number">
                            <?php 
                              
                              $queryd=mysqli_query($con ,"SELECT Distinct district from tbl_operator where state = '".$statename."'");
                              $resd=mysqli_fetch_row($queryx);
                              $totdisstate = mysqli_num_rows($queryd);
                              echo $totdisstate; 
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6">
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-user text-info"></i></div>
                        <div class="name"><strong class="text-uppercase">Total Working Operators</strong><span></span>
                          <div class="count-number">
                          <?php 
                              
                              $query3=mysqli_query($con ,"SELECT Count(*) from tbl_operator where emp_status = 1 and state = '".$statename."'");
                              $res3=mysqli_fetch_row($query3);
                              $totexists = $res3[0];

                              $query4=mysqli_query($con ,"SELECT Count(*) from tbl_operator where emp_status = 2 and state = '".$statename."'");
                              $res4=mysqli_fetch_row($query4);
                              $totnew = $res4[0];
                              echo $totexists + $totnew;
                            ?>
                              <button type="button" onclick =getState(<?php echo "'$statename'" ?>,<?php echo "'$count'" ?>) id = "DailyEnOpen<?php echo $count ?>" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModalExOp<?php echo $count;?>"><i class="fa fa-eye text-info" style="font-size:25px; color: black;"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6" style="margin-top:3%;">
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-rocket"></i></div>
                        <?php $datetoday = date("Y-m-d"); ?>
                        <div class="name"><strong class="text-uppercase">Enrollment on (<?php echo $datetoday; ?>)</strong><span></span>
                          <div class="count-number" style="font-size:inherit;">
                              <button type="button" onclick =getState(<?php echo "'$statename'" ?>,<?php echo "'$count'" ?>) id = "DailyEnOpen<?php echo $count ?>" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModal<?php echo $count;?>"><i class="fa fa-eye text-info" style="font-size:25px; color: black;"></i></button>
                          </div>
                          
                          <div class="card-body text-center">         
                            <!-- Modal-->
                            <div id="myModal<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">Daily Total Enrollment</h5>
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                      <p style="color: black;">State - <b style="color: orange;"><?php echo $statename; ?></b></p>
                                      
                                      <hr>
                                    
                                        
                                        <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                                          <thead class="thead-dark">
                                            <tr>
                                              <th style = 'padding:auto;'>District Name</th>
                                              <th style = 'padding:auto;'>New Enrollment</th>
                                              <th style = 'padding:auto;'>Update / Correction</th>
                                            </tr>
                                          </thead>
                                          <?php
                                          
                                          $sql_summary_count = "SELECT Distinct `district` FROM `tbl_attendance` WHERE `state` = '".$statename."'  ";
                                          $result_dis = mysqli_query($con, $sql_summary_count);
                                          $dailyensum = 0;
                                          $dailyupsum = 0;
                                          while ($rowdis = mysqli_fetch_row($result_dis))
                                          {
                                            $disnew = trim($rowdis[0]);
                                            $sql_sumen = "SELECT SUM(csv_newen),SUM(csv_upco) FROM `tbl_attendance` WHERE `state` = '".$statename."' and district = '".$disnew."' and created_dttm = '".$datetoday."' ";
                                            $result_sumen = mysqli_query($con, $sql_sumen);
                                            while($row_sum = mysqli_fetch_row($result_sumen))
                                            {
                                              ?>
                                              <tbody>
                                                <tr>
                                                  <td><?php echo $disnew ?></td>
                                                  <?php
                                                  if($row_sum[0] == "" || $row_sum[0] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[0] ?></td>
                                                    <?php
                                                  }
                                                  if($row_sum[1] == "" || $row_sum[1] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[1] ?></td>
                                                    <?php
                                                  }
                                                  ?>
                                                </tr>
                                              </tbody>
                                              <?php
                                              $dailyensum = $dailyensum + $row_sum[0];
                                              $dailyupsum = $dailyupsum + $row_sum[1];
                                            }
                                          }
                                          ?>
                                          <tfoot>
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b style="color:orange;"><?php echo $dailyensum; ?></b></td>
                                              <td><b style="color:orange;"><?php echo $dailyupsum; ?></b></td>
                                            </tr>
                                          </tfoot>
                                        </table> 
                                  </div>
                                        
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6" style="margin-top:3%;">
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-rocket"></i></div>
                        <div class="name"><strong class="text-uppercase">Enrollment Till Date</strong><span></span>
                          <div class="count-number" style="font-size:inherit;">
                              <button type="button" onclick =getState(<?php echo "'$statename'" ?>,<?php echo "'$count'" ?>) id = "DailyEnOpen<?php echo $count ?>" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModalCom<?php echo $count;?>"><i class="fa fa-eye text-info" style="font-size:25px; color: black;"></i></button>
                          </div>
                          
                          <div class="card-body text-center">         
                            <!-- Modal-->
                            <div id="myModalCom<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">Comulative Enrollment</h5>
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                      <p style="color: black;">State - <b style="color: orange;"><?php echo $statename; ?></b></p>
                                      
                                      <hr>
                                    
                                        
                                        <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                                          <thead class="thead-dark">
                                            <tr>
                                              <th style = 'padding:auto;'>District Name</th>
                                              <th style = 'padding:auto;'>New Enrollment</th>
                                              <th style = 'padding:auto;'>Update / Correction</th>
                                            </tr>
                                          </thead>
                                          <?php
                                          $datetoday = date("Y-m-d");
                                          $sql_summary_count = "SELECT Distinct `district` FROM `tbl_attendance` WHERE `state` = '".$statename."'  ";
                                          $result_dis = mysqli_query($con, $sql_summary_count);
                                          $dailyensum = 0;
                                          $dailyupsum = 0;
                                          while ($rowdis = mysqli_fetch_row($result_dis))
                                          {
                                            $disnew = trim($rowdis[0]);
                                            $sql_sumen = "SELECT SUM(csv_newen),SUM(csv_upco) FROM `tbl_attendance` WHERE `state` = '".$statename."' and district = '".$disnew."'  ";
                                            $result_sumen = mysqli_query($con, $sql_sumen);
                                            while($row_sum = mysqli_fetch_row($result_sumen))
                                            {
                                              ?>
                                              <tbody>
                                                <tr>
                                                  <td><?php echo $disnew ?></td>
                                                  <?php
                                                  if($row_sum[0] == "" || $row_sum[0] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[0] ?></td>
                                                    <?php
                                                  }
                                                  if($row_sum[1] == "" || $row_sum[1] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[1] ?></td>
                                                    <?php
                                                  }
                                                  ?>
                                                </tr>
                                              </tbody>
                                              <?php
                                              $dailyensum = $dailyensum + $row_sum[0];
                                              $dailyupsum = $dailyupsum + $row_sum[1];
                                            }
                                          }
                                          ?>
                                          <tfoot>
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b style="color:orange;"><?php echo $dailyensum; ?></b></td>
                                              <td><b style="color:orange;"><?php echo $dailyupsum; ?></b></td>
                                            </tr>
                                          </tfoot>
                                        </table> 
                                  </div>
                                        
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6" style="margin-top:3%;">
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-envelope-open-o"></i></div>
                        <?php $datetoday = date("Y-m-d"); ?>
                        <div class="name"><strong class="text-uppercase">Reported on (<?php echo $datetoday;?>)</strong><span></span>
                          <div class="count-number" style="font-size:inherit;">
                              <button type="button" onclick =getState(<?php echo "'$statename'" ?>,<?php echo "'$count'" ?>) id = "DailyEnOpen<?php echo $count ?>" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModalRep<?php echo $count;?>"><i class="fa fa-eye text-info" style="font-size:25px; color: black;"></i></button>
                          </div>
                          
                          <div class="card-body text-center">         
                            <!-- Modal-->
                            <div id="myModalRep<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">Daily Total Reported</h5>
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                      <p style="color: black;">State - <b style="color: orange;"><?php echo $statename; ?></b></p>
                                      
                                      <hr>
                                    
                                        
                                        <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                                          <thead class="thead-dark">
                                            <tr>
                                              <th style = 'padding:auto;'>District Name</th>
                                              <th style = 'padding:auto;'>Reported</th>
                                              
                                            </tr>
                                          </thead>
                                          <?php
                                          $datetoday = date("Y-m-d");
                                          $sql_summary_count = "SELECT Distinct `district` FROM `tbl_attendance` WHERE `state` = '".$statename."'  ";
                                          $result_dis = mysqli_query($con, $sql_summary_count);
                                          $dailyensum = 0;
                                          $dailyupsum = 0;
                                          while ($rowdis = mysqli_fetch_row($result_dis))
                                          {
                                            $disnew = trim($rowdis[0]);
                                            $sql_sumen = "SELECT Count(*) FROM `tbl_attendance` WHERE `state` = '".$statename."' and district = '".$disnew."' and created_dttm = '".$datetoday."' ";
                                            $result_sumen = mysqli_query($con, $sql_sumen);
                                            while($row_sum = mysqli_fetch_row($result_sumen))
                                            {
                                              ?>
                                              <tbody>
                                                <tr>
                                                  <td><?php echo $disnew ?></td>
                                                  <?php
                                                  if($row_sum[0] == "" || $row_sum[0] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[0] ?></td>
                                                    <?php
                                                  }
                                                  
                                                  ?>
                                                </tr>
                                              </tbody>
                                              <?php
                                              $dailyensum = $dailyensum + $row_sum[0];
                                             
                                            }
                                          }
                                          ?>
                                          <tfoot>
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b style="color:orange;"><?php echo $dailyensum; ?></b></td>
                                              
                                            </tr>
                                          </tfoot>
                                        </table> 
                                  </div>
                                        
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div> 
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6" >
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-envelope text-danger"></i></div>
                        <?php $datetoday = date("Y-m-d"); ?>
                        <div class="name"><strong class="text-uppercase">Not Reported on (<?php echo $datetoday;?>)</strong><span></span>
                          <div class="count-number" style="font-size:inherit;">
                              <button type="button" onclick =getState(<?php echo "'$statename'" ?>,<?php echo "'$count'" ?>) id = "DailyEnOpen<?php echo $count ?>" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModalNotRep<?php echo $count;?>"><i class="fa fa-eye text-info" style="font-size:25px; color: black;"></i></button>
                          </div>
                          
                          <div class="card-body text-center">         
                            <!-- Modal-->
                            <div id="myModalNotRep<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">Daily Total Not Reported</h5>
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                      <p style="color: black;">State - <b style="color: orange;"><?php echo $statename; ?></b></p>
                                      
                                      <hr>
                                    
                                        
                                        <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                                          <thead class="thead-dark">
                                            <tr>
                                              <th style = 'padding:auto;'>District Name</th>
                                              <th style = 'padding:auto;'>Not Reported</th>
                                              
                                            </tr>
                                          </thead>
                                          <?php
                                          $datetoday = date("Y-m-d");
                                          $sql_summary_count = "SELECT Distinct `district` FROM `tbl_operator` WHERE `state` = '".$statename."'  ";
                                          $result_dis = mysqli_query($con, $sql_summary_count);
                                          $dailyensum = 0;
                                          $dailyupsum = 0;
                                          while ($rowdis = mysqli_fetch_row($result_dis))
                                          {
                                            $disnew = trim($rowdis[0]);
                                            $sql_sumen = "SELECT Count(operator_id) FROM tbl_operator WHERE operator_id NOT IN(SELECT operator_id from tbl_attendance where created_dttm = '".$datetoday."') and `state` = '".$statename."' and district = '".$disnew."'  and  (emp_status = 1 or emp_status = 2)  ";
                                            $result_sumen = mysqli_query($con, $sql_sumen);
                                            while($row_sum = mysqli_fetch_row($result_sumen))
                                            {
                                              ?>
                                              <tbody>
                                                <tr>
                                                  <td><?php echo $disnew ?></td>
                                                  <?php
                                                  if($row_sum[0] == "" || $row_sum[0] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[0] ?></td>
                                                    <?php
                                                  }
                                                  
                                                  ?>
                                                </tr>
                                              </tbody>
                                              <?php
                                              $dailyensum = $dailyensum + $row_sum[0];
                                             
                                            }
                                          }
                                          ?>
                                          <tfoot>
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b style="color:orange;"><?php echo $dailyensum; ?></b></td>
                                              
                                            </tr>
                                          </tfoot>
                                        </table> 
                                  </div>
                                        
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-6" >
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-calendar text-danger"></i></div>
                        <?php $datetoday = date("Y-m-d"); ?>
                        <div class="name"><strong class="text-uppercase">Out of Time on (<?php echo $datetoday; ?>)</strong><span></span>
                          <div class="count-number" style="font-size:inherit;">
                              <button type="button" onclick =getState(<?php echo "'$statename'" ?>,<?php echo "'$count'" ?>) id = "DailyEnOpen<?php echo $count ?>" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModaldailyout<?php echo $count;?>"><i class="fa fa-eye text-info" style="font-size:25px; color: black;"></i></button>
                          </div>
                          
                          <div class="card-body text-center">         
                            <!-- Modal-->
                            <div id="myModaldailyout<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">Daily Total Out of Time</h5>
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                      <p style="color: black;">State - <b style="color: orange;"><?php echo $statename; ?></b></p>
                                      
                                      <hr>
                                    
                                        
                                        <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                                          <thead class="thead-dark">
                                            <tr>
                                              <th style = 'padding:auto;'>District Name</th>
                                              <th style = 'padding:auto;'>Out of Time</th>
                                              
                                            </tr>
                                          </thead>
                                          <?php
                                          $datetoday = date("Y-m-d");
                                          $sql_summary_count = "SELECT Distinct `district` FROM `tbl_attendance` WHERE `state` = '".$statename."'  ";
                                          $result_dis = mysqli_query($con, $sql_summary_count);
                                          $dailyensum = 0;
                                          $dailyupsum = 0;
                                          while ($rowdis = mysqli_fetch_row($result_dis))
                                          {
                                            $disnew = trim($rowdis[0]);
                                            $sql_sumen = "SELECT Count(a.operator_id) FROM tbl_outrangetime a, tbl_attendance b WHERE a.operator_id = b.operator_id and b.`state` = '".$statename."' and b.district = '".$disnew."'  and  a.created_date = '".$datetoday."'  ";
                                            $result_sumen = mysqli_query($con, $sql_sumen);
                                            while($row_sum = mysqli_fetch_row($result_sumen))
                                            {
                                              ?>
                                              <tbody>
                                                <tr>
                                                  <td><?php echo $disnew ?></td>
                                                  <?php
                                                  if($row_sum[0] == "" || $row_sum[0] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[0] ?></td>
                                                    <?php
                                                  }
                                                  
                                                  ?>
                                                </tr>
                                              </tbody>
                                              <?php
                                              $dailyensum = $dailyensum + $row_sum[0];
                                             
                                            }
                                          }
                                          ?>
                                          <tfoot>
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b style="color:orange;"><?php echo $dailyensum; ?></b></td>
                                              
                                            </tr>
                                          </tfoot>
                                        </table> 
                                  </div>
                                        
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Count item widget--> 
                    <div class="col-xl-4 col-md-4 col-6" >
                      <div class="wrapper count-title d-flex">
                        <div class="icon"><i class="fa fa-calendar text-danger"></i></div>
                        <div class="name"><strong class="text-uppercase">Out of Time Till Date</strong><span></span>
                          <div class="count-number" style="font-size:inherit;">
                              <button type="button" onclick =getState(<?php echo "'$statename'" ?>,<?php echo "'$count'" ?>) id = "DailyEnOpen<?php echo $count ?>" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModalcomout<?php echo $count;?>"><i class="fa fa-eye text-info" style="font-size:25px; color: black;"></i></button>
                          </div>
                          
                          <div class="card-body text-center">         
                            <!-- Modal-->
                            <div id="myModalcomout<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                <div role="document" class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 id="exampleModalLabel" class="modal-title">Comulative Out of Time</h5>
                                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                      <p style="color: black;">State - <b style="color: orange;"><?php echo $statename; ?></b></p>
                                      
                                      <hr>
                                    
                                        
                                        <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                                          <thead class="thead-dark">
                                            <tr>
                                              <th style = 'padding:auto;'>District Name</th>
                                              <th style = 'padding:auto;'>Out of Time</th>
                                              
                                            </tr>
                                          </thead>
                                          <?php
                                          $datetoday = date("Y-m-d");
                                          $sql_summary_count = "SELECT Distinct `district` FROM `tbl_attendance` WHERE `state` = '".$statename."'  ";
                                          $result_dis = mysqli_query($con, $sql_summary_count);
                                          $dailyensum = 0;
                                          $dailyupsum = 0;
                                          while ($rowdis = mysqli_fetch_row($result_dis))
                                          {
                                            $disnew = trim($rowdis[0]);
                                            $sql_sumen = "SELECT Count(a.operator_id) FROM tbl_outrangetime a, tbl_attendance b WHERE a.operator_id = b.operator_id and b.`state` = '".$statename."' and b.district = '".$disnew."'  ";
                                            $result_sumen = mysqli_query($con, $sql_sumen);
                                            while($row_sum = mysqli_fetch_row($result_sumen))
                                            {
                                              ?>
                                              <tbody>
                                                <tr>
                                                  <td><?php echo $disnew ?></td>
                                                  <?php
                                                  if($row_sum[0] == "" || $row_sum[0] == null)
                                                  {
                                                    ?>
                                                    <td><?php echo 0 ?></td>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    ?>
                                                    <td><?php echo $row_sum[0] ?></td>
                                                    <?php
                                                  }
                                                  
                                                  ?>
                                                </tr>
                                              </tbody>
                                              <?php
                                              $dailyensum = $dailyensum + $row_sum[0];
                                             
                                            }
                                          }
                                          ?>
                                          <tfoot>
                                            <tr>
                                              <td><b>Total</b></td>
                                              <td><b style="color:orange;"><?php echo $dailyensum; ?></b></td>
                                              
                                            </tr>
                                          </tfoot>
                                        </table> 
                                  </div>
                                        
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                      </div>
                    </div>                              
                  </div>
                </div>

              </section>
              <div class="card-body text-center"> 
              <div id="myModalExOp<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
              <div role="document" class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">Working Operators List for State - <span style="color:orange;"><?php echo $statename;?></h5>
                   
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                  </div>
                  
              <!--section class="mt-30px mb-30px">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-lg-12 col-md-12"-->
                      <!-- Recent Updates Widget          -->
                      <!--div id="new-updates" class="card updates recent-updated"-->
                        <!--div id="updates-header" class="card-header d-flex justify-content-between align-items-center">
                          <h2 class="h5 display"><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box_<?php echo $statename;?>" aria-expanded="true" aria-controls="updates-box_<?php echo $statename;?>">State : <u><b><?php echo $statename; ?></b></u></a></h2><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box_<?php echo $statename;?>" aria-expanded="true" aria-controls="updates-box_<?php echo $statename;?>"><i class="fa fa-angle-down"></i></a>
                        </div-->
                        <div id="updates-boxzzz_<?php echo $statename;?>" >
                          <form style="border-style: none;" action = "genActiveOperator.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
                            <div class="form-group">
                              <input type="hidden"  id="txtSequenceId4" name="txtSequenceId4" value="<?php echo $statename; ?>"/>
                            </div>
                            <div class="form-group">
                              <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                              <button id="gen_rep" name ="gen_rep" type="submit" style="float: right;" class="btn btn-primary"> <i class="fa fa-file-excel-o"></i><span>&nbsp;</span>Generate List</button>
                            </div>
                          </form>  
                            <!-- Item-->
                            <?php

                            $sql = "select sl_no,state,dept,district,Operator_id,username,pec_location,station_id,emp_status from tbl_operator where state = '".$statename."' ORDER BY sl_no";
                            $result = mysqli_query($con, $sql);
                            $cenID = "";
                            if (mysqli_num_rows($result) > 0) {
                              ?>
                              <!--div class="input-group mb-3">
                                  <input id="myInput" type="text" class="form-control" placeholder="Search.." >
                                  <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search" style="font-size: x-large;" aria-hidden="true"></i></span>
                                  </div>
                              </div-->
                              <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: 8px;">
                              <thead class="thead-dark">
                                <tr>
                                  <!--th style = 'padding:auto;'>Sl. No.</th-->
                                  <!--th style = 'padding:auto;'>State</th-->
						                      <th style = 'padding:auto;'>Department</th>
                                  <th style = 'padding:auto;'>District</th>
                                  <th style = 'padding:auto;'>Operator ID</th>
                                  <th style = 'padding:auto;'>Operator Name</th>
                                  <th style = 'padding:auto;'>PEC Location</th>
                                  <th style = 'padding:auto;'>Station ID</th>
                                  <!--th style = 'padding:auto;'>Activity Status</th-->
                                </tr>
                              </thead>
                                <?php
                              while($row = mysqli_fetch_assoc($result)) {
                                  ?>
                                  <tbody id="myTable">
                                          <tr>
                                            <!--td style = "padding: auto;"></td-->
                                            <!--td style = "padding: auto;"></td-->
								                            <td style = "padding: auto;"><?php echo  $row["dept"]?></td>		
                                            <td style = "padding: auto;"><?php echo  $row["district"]?></td>
                                            <td style = "padding: auto;"><?php echo  $row["Operator_id"]?></td>
                                            <td style = "padding: auto;"><?php echo  $row["username"]?></td>
                                            <td style = "padding: auto;"><?php echo  $row["pec_location"]?></td>
                                            <td style = "padding: auto;"><?php echo  $row["station_id"]?></td>
                                            <?php
                                              if( $row["emp_status"] == 0 )
                                              {
                                                  ?>
                                                  <!--td style = "padding: auto;">Not Working</td-->
                                                  <?php
                                              }
                                              elseif($row["emp_status"] == 1)
                                              {
                                                  ?>
                                                  <!--td style = "padding: auto;">Existing</td-->
                                                  <?php
                                              }
                                              else
                                              {
                                                ?>
                                                <!--td style = "padding: auto;">New Joining</td-->
                                                <?php
                                              }
                                              ?>
                                            </tr>
                                <?php
                              }
                              ?>
                              </table>
                              <?php
                            }
                            else
                            {
                                ?>
                                <ul class="news list-unstyled">
                                <li class=" justify-content-between"> 
                                  <div class="left-col d-flex">
                                    <!--div class="icon"><i class="icon-rss-feed"></i></div-->
                                    <div class="col-lg-12 col-md-12">
                                      <div class="title" Style="text-align:center;"><strong>No Result Found </strong>
                                        <p>No operator is added ...</p>
                                      </div>
                                    </div>
                                  </div>
                                  <!--div class="right-col text-right">
                                    <div class="update-date">24<span class="month">Jan</span></div>
                                  </div-->
                                </li>
                                </ul>
                              <?php
                            }
                            ?>
                            
                          
                          
                        </div>
                      <!--/div-->
                      <!-- Recent Updates Widget End-->
                    <!--/div>
                    
                    
                  </div>
                </div>
              </section-->
              
              </div>
              </div>
              </div>
              </div>

              </div>
              <?php
              
          }
          
        }
        else
        {
          ?>
          <div class="col-lg-12 col-md-12">
            <div class="title" Style="text-align:center;"><strong>No Result Found </strong>
              <p>No operator is added ...</p>
            </div>
          </div>
          <?php
        }
        
      ?>
      <div class="displayNone"> 
			    <input type="hidden"  id="txtSequenceId1" name="txtSequenceId1" value="<?php print_r($array_string); ?>"/>

          <input type="hidden"  id="txtSequenceId2" name="txtSequenceId2" value="<?php echo $count; ?>"/>

          <input type="hidden"  id="txtSequenceId3" name="txtSequenceId3" />

      </div>

        

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
    <script src="js/charts-home.js"></script>
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
      <script>
        function showme(unId,id1,id2){
          
          //$(unId).DataTable();
          $(unId).show();
          
          $(id1).hide();
          $(id2).show();
        }
        </script>
        <script>
          function hideme(unId,id1,id2){
            //alert(unId);
            $(unId).hide();
            
            $(id1).show();
            $(id2).hide();
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
      <script>
      function getState(val,count)
      {
          var state = val;
          
          $("#txtSequenceId3").val(state);
          
          var totcou = $("#txtSequenceId2").val();

         
         
      }
      </script>
      <script>
        $(document).ready(function(){
          $("#txtSequenceId1").val();
          $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
          });

        });
      </script>
      <script>
      function myFunc(state)
      {
        console.log(state);
        //alert(state);
      }
      </script>
  </body>
</html>
<?php 
	  }
?>