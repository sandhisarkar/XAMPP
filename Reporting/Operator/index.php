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

$q=mysqli_query($con,"select username from tbl_operator where operator_id ='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$username= $n['username'];
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

$query5=mysqli_query($con ,"select * from tbl_attendance where operator_id = '".$_SESSION['user']."'");
$res5=mysqli_fetch_row($query5);
$totapp = mysqli_num_rows($query5);

$datetime = date("Y-m-d");
$lastday;
if(substr($datetime,5,2) == 1)
{
  $lastday = 31;
}
if(substr($datetime,5,2) == 2 && substr($datetime,8,2) % 2 == 0)
{
  $lastday = 29;
}
else
{
  $lastday = 29;
}
if(substr($datetime,5,2) == 3)
{
  $lastday = 31;
}
if(substr($datetime,5,2) == 4)
{
  $lastday = 30;
}
if(substr($datetime,5,2) == 5)
{
  $lastday = 31;
}
if(substr($datetime,5,2) == 6)
{
  $lastday = 30;
}
if(substr($datetime,5,2) == 7)
{
  $lastday = 31;
}
if(substr($datetime,5,2) == 8)
{
  $lastday = 31;
}
if(substr($datetime,5,2) == 9)
{
  $lastday = 30;
}
if(substr($datetime,5,2) == 10)
{
  $lastday = 31;
}
if(substr($datetime,5,2) == 11)
{
  $lastday = 30;
}
if(substr($datetime,5,2) == 3)
{
  $lastday = 31;
}

$startDate = substr($datetime,0,4)."-".substr($datetime,5,2)."-"."01";
$lastDate  = substr($datetime,0,4)."-".substr($datetime,5,2)."-".$lastday;

$query6=mysqli_query($con ,"SELECT * from tbl_attendance where operator_id = '".$_SESSION['user']."' AND created_dttm between '".$startDate."' and '".$lastDate."' ");
$res6=mysqli_fetch_row($query6);
$totThisapp = mysqli_num_rows($query6);

$query7=mysqli_query($con ,"SELECT SUM(csv_upco), SUM(csv_newen) from tbl_attendance where operator_id = '".$_SESSION['user']."' AND created_dttm between '".$startDate."' and '".$lastDate."' ");
$res7=mysqli_fetch_row($query7);
$sumupdate = $res7[0];
$sumnew = $res7[1];

$query8=mysqli_query($con ,"SELECT SUM(csv_upco), SUM(csv_newen), SUM(original_enrollment) from tbl_attendance where operator_id = '".$_SESSION['user']."'  ");
$res8=mysqli_fetch_row($query8);
$cumuupdate = $res8[0];
$cumunew = $res8[1];
$cumuorg = $res8[2];

$cumudiff = $cumuorg - ($cumuupdate+$cumunew);

$query9=mysqli_query($con ,"SELECT * from tbl_outrangetime where operator_id = '".$_SESSION['user']."'  ");
$res9=mysqli_fetch_row($query9);
$outtimetotal = mysqli_num_rows($query9);

$query10=mysqli_query($con ,"SELECT count(*) from tbl_attendance where operator_id = '".$_SESSION['user']."' and en_diff <> 0 ");
$res10=mysqli_fetch_row($query10);
$mismatchtot = $res10[0];

$stdt = strtotime($startDate);
$enddt = strtotime($datetime);
$stepVal = '+1 day';
$dis_wise_count = 0;
while($stdt <= $enddt)
{
    
    
    $disdt = date('Y-m-d',$stdt);
    $sql_op_count = "SELECT COUNT(operator_id) from tbl_operator where operator_id = '".$_SESSION['user']."' and operator_id NOT IN (select operator_id from tbl_attendance where created_dttm ='".$disdt."') ";
    //$sql_op_count = "SELECT COUNT(a.`operator_id`) FROM `tbl_attendance` a, `tbl_operator` b WHERE a.`operator_id` = b.`operator_id` AND b.`state` = '".$state."' AND b.`district` = '".$district_name."' AND a.`created_DTTM` BETWEEN '".$datestartapplication."' AND '".$dateendapplication."'";
    $result_op = mysqli_query($con, $sql_op_count);
    while($row_op = mysqli_fetch_row($result_op)) 
    {
        $dis_wise_count = $dis_wise_count + $row_op[0];
    }


    $stdt = strtotime($stepVal,$stdt);
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
          <div class="sidenav-header-logo"><a href="./" class="brand-small text-center" onclick="openOverlay()"> <strong><i class="icon-bars"> </i></strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li class="active"><a href="./" onclick="openOverlay()"> <i class="icon-home"></i>Home</a></li>
            <!--li><a href="Upload.php" onclick="openOverlay()"> <i class="icon-form"></i>Upload</a></li-->
            <li><a href="Application.php" onclick="openOverlay()"> <i class="fa fa-rocket"></i>Reporting</a></li>
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
      <!-- Counts Section -->
      <section class="dashboard-counts section-padding">
        <div class="container-fluid">
          <div class="row">
            
            
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-3 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="fa fa-rocket"></i></div>
                <div class="name"><strong class="text-uppercase">Enrollment Till Date</strong><span></span>
                  <div class="count-number" style="font-size:inherit;">New Enrollment -
                        <?php
                          echo $cumunew;
                        ?>
                  </div>
                  <div class="count-number" style="font-size:inherit;">Update / Correction -
                        <?php
                          echo $cumuupdate;
                        ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-3 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="fa fa-envelope-open-o" style="color:blue;"></i></div>
                <div class="name"><strong class="text-uppercase">Average Till Date</strong><span></span>
                  <div class="count-number" style="font-size:inherit;">New Enrollment -
                        <?php
                          echo number_format($cumunew / $totapp,2,'.','');
                        ?>
                  </div>
                  <div class="count-number" style="font-size:inherit;">Update / Correction -
                        <?php
                          echo number_format($cumuupdate / $totapp,2,'.','');
                        ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-3 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="fa fa-calendar"></i></div>
                <div class="name"><strong class="text-uppercase">Current Month</strong><span></span>
                  <div class="count-number" style="font-size:inherit;">Day Reported - 
                      <?php 
                        if($totThisapp == 1 || $totThisapp == 0)
                        {
                          echo $totThisapp." Day";
                        }
                        else
                        {
                          echo $totThisapp." Days";
                        }
                      ?> 
                  </div>
                  <div class="count-number" style="font-size:inherit;">New Enrollment -
                        <?php
                          if($sumnew==0)
                          {
                            echo 0;
                          }
                          else
                          {
                            echo $sumnew;
                          }
                        ?>
                  </div>
                  <div class="count-number" style="font-size:inherit;margin-bottom: 10%;">Update / Correction -
                        <?php
                        if($sumupdate==0)
                        {
                          echo 0;
                        }
                        else
                        {
                          echo $sumupdate;
                        }
                        ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-3 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="fa fa-calendar" style="color:red;"></i></div>
                <div class="name"><strong class="text-uppercase">Out of Time Till Date</strong><span></span>
                  <div class="count-number" style="font-size:inherit;">Total Cases - 
                    <?php echo $outtimetotal ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Count item widget-->
            <div class="col-xl-4 col-md-3 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="fa fa-exclamation-triangle" style="color:orange;"></i></div>
                <div class="name"><strong class="text-uppercase">Current Month Pending Report </strong><span></span>
                  <div class="count-number" style="font-size:inherit;">Total - 
                    <?php echo $dis_wise_count ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-md-3 col-6">
              <div class="wrapper count-title d-flex">
                <div class="icon"><i class="fa fa-database" style="color:red;"></i></div>
                <div class="name"><strong class="text-uppercase">Report Mismatch Till Date</strong><span></span>
                  <div class="count-number" style="font-size:inherit;">Total Cases - 
                    <?php echo abs($mismatchtot) ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Header Section-->
      <section class="dashboard-header section-padding">
        <div class="container-fluid">
          <div class="row d-flex align-items-md-stretch">
            <!-- To Do List-->
            
            <!-- Pie Chart-->
            
            <!-- Line Chart -->
            <div class="col-lg-12" style="text-align: center;">
                <h2>List of Reportings . . .</h2>
                <p>ID : <?php echo $_SESSION['user'];?><p>
            </div>
          </div>
        </div>
      </section>
      <!-- Statistics Section-->
      
      <!-- Updates Section -->
      <section class="mt-30px mb-30px">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <!-- Recent Updates Widget          -->
              <div id="new-updates" class="card updates recent-updated">
                <div id="updates-header" class="card-header d-flex justify-content-between align-items-center">
                  <h2 class="h5 display"><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box" aria-expanded="true" aria-controls="updates-box">Reporting Details</a></h2><a data-toggle="collapse" data-parent="#new-updates" href="#updates-box" aria-expanded="true" aria-controls="updates-box"><i class="fa fa-angle-down"></i></a>
                </div>
                <div id="updates-box" role="tabpanel" class="collapse show">
                  
                    <!-- Item-->
                    <?php

                    $sql = "SELECT updatecorrection, csv_upco, enrollment,csv_newen,original_enrollment,en_diff, date_format(created_dttm,'%d-%M-%Y'),remarks from tbl_attendance where operator_id = '".$_SESSION['user']."' AND created_dttm between '".$startDate."' and '".$lastDate."' ORDER BY created_dttm";
                    $result = mysqli_query($con, $sql);
                    $cenID = "";
                    if (mysqli_num_rows($result) > 0) {
                      ?>
                      <div class="input-group mb-3">
                          <input id="myInput" type="text" class="form-control" placeholder="Search.." autofocus>
                          <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-search" style="font-size: x-large;" aria-hidden="true"></i></span>
                          </div>
                      </div>
                      <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                      <thead class="thead-dark">
                        <tr>
                          <th style = 'padding:auto;'>Update / Correlation</th>
                          <th style = 'padding:auto;'>Update / Correlation (CSV)</th>
                          <th style = 'padding:auto;'>New Enrollment</th>
                          <th style = 'padding:auto;'>New Enrollment (CSV)</th>
                          <th style = 'padding:auto;'>Actual Enrollment</th>
                          <th style = 'padding:auto;'>Enrollment Difference</th>
                          <th style = 'padding:auto;'>Reporting Date</th>
                          <th style = 'padding:auto;'>Remarks</th>
                          
                        </tr>
                      </thead>
                        <?php
                      while($row = mysqli_fetch_row($result)) {
                          ?>
                          <tbody id="myTable">
																	<tr>
																		<td style = "padding: auto;"><?php echo  $row[0]?></td>
                                    <td style = "padding: auto;"><?php echo  $row[1]?></td>
                                    <td style = "padding: auto;"><?php echo  $row[2]?></td>
                                    <td style = "padding: auto;"><?php echo  $row[3]?></td>
                                    <td style = "padding: auto;"><?php echo  $row[4]?></td>
                                    <td style = "padding: auto;"><?php echo  abs($row[5])?></td>
                                    <td style = "padding: auto;"><?php echo  $row[6]?></td>
                                    <?php
                                        if($row[7] == "")
                                        {
                                          ?>
                                          <td style = "padding: auto;"><?php echo  "---"; ?></td>
                                          <?php
                                        }
                                        else
                                        {
                                          ?>
                                          <td style = "padding: auto;"><?php echo  $row[7]?></td>
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
                                <p>There's no Reporting available...</p>
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
              </div>
              <!-- Recent Updates Widget End-->
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
        function on() {
          document.getElementById("overlay").style.display = "block";
        }

        function off() {
          document.getElementById("overlay").style.display = "none";
        }
      </script>
      <script>
        $(document).ready(function(){
          $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
          });
        });
      </script>
  </body>
</html>
<?php 
	  }
?>