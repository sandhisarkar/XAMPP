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

date_default_timezone_set('Asia/Kolkata'); 

$datetime = date("Y-m-d H:i:s");
$year = substr($datetime,0,4);
$month = substr($datetime,5,2);
$day = substr($datetime,8,2);
$hour = substr($datetime,11,2);
$min = substr($datetime,14,2);

$enablestat ;

if(($hour >= 9 && $min <= 59) && ($hour < 20 && $min <= 59))
{
    $enablestat = true;
    $ggg = "ok";
}
else
{
    $enablestat = false;
    $ggg = "not";
}



if(isset($_POST["sub_app_search"]))
{
   
    //$operator_id = $_POST["operator"];
    $state = $_POST["state"];
    $district = $_POST["district"];
    $location=$_POST["location"];
	
	  $datestartapplication=$_POST["datetimepicker1"];
    $dateendapplication = $_POST["datetimepicker2"];
    
    $_SESSION['state']=$state;
    $_SESSION['district']=$district;
    $_SESSION['location']=$location;
    $_SESSION['start_date']=$datestartapplication;
    $_SESSION['end_date']=$dateendapplication;
  
    if($district == "All")
    {
      $created_dttm = $year."-".$month."-".$day;
      $result=mysqli_query($con ,"SELECT distinct(a.operator_id) from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.pec_location = '".$location."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' ");
      
      $noofrow = mysqli_num_rows($result);

      if($noofrow > 0)
      {
          $success = "Exists";
      }            
      else
      {
          $error = "Not Exists";
      }
    }
    else
    {
      $created_dttm = $year."-".$month."-".$day;
      $result=mysqli_query($con ,"SELECT distinct(a.operator_id) from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.district = '".$district."' and a.pec_location = '".$location."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' ");
      
      $noofrow = mysqli_num_rows($result);

      if($noofrow > 0)
      {
          $success = "Exists";
      }            
      else
      {
          $error = "Not Exists";
      }
    }
 
}



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
          <div class="sidenav-header-logo"><a href="./" class="brand-small text-center" > <strong><i class="icon-bars"> </i></strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="./" onclick="openOverlay()"> <i class="icon-home"></i>Home</a></li>
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
            <li class="active"><a href="#exampledropdownDropdown1" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-file-excel-o"></i>Report </a>
              <ul id="exampledropdownDropdown1" class="collapse list-unstyled ">
                <li><a href="Range.php" onclick="openOverlay()"> <i class="fa fa-calendar"></i>Date</a></li>
                <li><a href="District.php" onclick="openOverlay()"><i class="fa fa-globe"></i>District</a></li>
                <li><a href="Supervisor.php" onclick="openOverlay()"><i class="fa fa-user-o"></i>Supervisor</a></li>
                <li class="active"><a href="Location.php" onclick="openOverlay()"><i class="fa fa-area-chart"></i>PEC Location</a></li>
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
            <li class="breadcrumb-item active">PEC Location</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">PEC Location wise report. . .</h1>
            <p>(Search result for specific PEC Location)</p>
          </header>
          <div class="row">
            <div class="col-lg-4">
            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Search Details</h4>
                </div>
                <div class="card-body">
                  <p>(Details report for specific PEC Location)</p>
                  
                  <form style="border-style: none;" action = "" method ="post"  id = "Reporting" enctype="multipart/form-data">
                    <?php
                        if($enablestat == true || $enablestat == false) 
                        {
                            ?>
                            <div class="form-group">
                            <label>Choose State </label>
                                    <select enable ="<?php $enablestat; ?>" required ="true" placeholder="Choose Proper State" onChange = "getName(this.value);" id="state" name="state" autofocus class="form-control">
                                    <option selected value="">Choose State</option>
                                    <?php
                                                    

                                    $sql = "SELECT Distinct(state) FROM tbl_attendance where state != '' order by state ASC";
                                    $result = mysqli_query($con, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    
                                    while($row = mysqli_fetch_row($result)) {
                                        ?>
                                        
                                        <option style="color:black;" value = "<?php echo $row[0]; ?>"><?php echo  $row[0]?></option>
                                        <?php
                                    }
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                            <label>Choose District </label>
                                <select enable ="<?php $enablestat; ?>" required ="true" placeholder="Choose District" onChange = "getNameDis(this.value);" id="district" name="district" autofocus class="form-control">
                                    <option disabled selected value = "">Select Any...</option>
                                </select>
                            </div>
                            <div class="form-group">
                            <label>Choose PEC Location </label>
                                <select enable ="<?php $enablestat; ?>" required ="true" placeholder="Choose District" id="location" name="location" autofocus class="form-control">
                                    <option disabled selected value = "">Select Any...</option>
                                </select>
                            </div>
                            <div class="form-group">
                            <label>Reporting Start Date </label>
                                <input type="date" required ="true" 
                                placeholder="Choose Proper Date" id="datetimepicker1" name = "datetimepicker1" class="form-control">
                            </div>
                             
                            <div class="form-group">
                            <label>Reporting End Date </label>
                                <input type="date" required ="true" 
                                placeholder="Choose Proper Date" id="datetimepicker2" name = "datetimepicker2" class="form-control">
                            </div>  
                            
                            <div class="form-group">       
                            <input type="submit" value="Search" style="float: right;"  class="btn btn-primary" id="sub_app_search" name = "sub_app_search" onclick = "uploadme()">
                            </div>
                            <?php
                        }
                        
                    ?>
                    
                  </form>
                </div>
                <div id="result">
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
						if($error == "Timeout")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Reporting time has been expired for today.</label>';
							
						}
						if($error == "Current Date")
						{
							//header( "refresh:3;url=Operator.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-danger">Please Select Current Date</label>';
							
                        }
                        if($success == "Change")
                        {
                            echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Reporting for Operator ID - '.$operator_id.' is Updated for Date - '.$dateapplication.'</label>';
                        }
						if($success == "Exists")
						{
							//header( "refresh:30;url=Operator.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-danger">Reporting of operator - '.$operator_id.' is already been registered for today</label>';
                            //echo $output;
                            ?>
								<form style="border-style: none;" action = "genLocation.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
									<div style="text-align: center;padding-bottom:10px;">
										<button id="gen_rep" name ="gen_rep" type="submit" class="btn btn-primary"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp; Generate Report</button>
									</div>
								</form>
                                <div class="input-group mb-3">
                                    <input id="myInput" type="text" class="form-control" placeholder="Search.." autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                                <div id = "range_reporting_table">
                                    
                                    <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: xx-small;">
                                    <thead class="thead-dark">
                                            <tr>
                                                <!--th style = 'padding:auto;'>Sl. No.</th-->
                                                <th style = 'padding:auto;'>State</th>
                                                <th style = 'padding:auto;'>District</th>
                                                <th style = 'padding:auto;'>Department</th>
                                                <th style = 'padding:auto;'>Operator ID</th>
                                                <th style = 'padding:auto;'>Operator Name</th>
                                                <th style = 'padding:auto;'>PEC Location</th>
                                                <th style = 'padding:auto;'>Station ID (DB)</th>
                                                <th style = 'padding:auto;'>Station ID (CSV)</th>
                                                <th style = 'padding:auto;'>Update / Correction</th>
                                                <th style = 'padding:auto;'>Update / Correction(CSV)</th>
                                                <th style = 'padding:auto;'>Update / Correction(Difference)</th>
                                                <th style = 'padding:auto;'>New Enrollment</th>
                                                <th style = 'padding:auto;'>New Enrollment(CSV)</th>
                                                <th style = 'padding:auto;'>New Enrollment(Difference)</th>
                                                
                                                <!--th style = 'padding:auto;'>Remarks</th-->
                                                <th style = 'padding:auto;'>Reporting Date</th>
                                            </tr>
                                    </thead>
                                    <?php
                                    if($district == "All")
                                    {
                                      $sql = "SELECT a.state,a.district,a.dept,a.operator_id,b.username,a.pec_location,a.stid_db,a.stid_csv,a.updatecorrection,a.csv_upco,a.enrollment,a.csv_newen,a.original_enrollment,a.en_diff,a.remarks,date_format(a.created_dttm,'%d-%M-%Y')  from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.pec_location = '".$location."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' order by a.created_dttm";
                                      $result = mysqli_query($con, $sql);
                                      while($row = mysqli_fetch_row($result)) {
                                      ?>
                                       <tbody id="myTable">
                                          <tr>
                                              <td style = "padding: auto;"><?php echo  $row[0]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[1]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[2]?></td>		
                                              <td style = "padding: auto;"><?php echo  $row[3]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[4]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[5]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[6]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[7]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[8]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[9]?></td>
                                              <?php
                                              if($row[8]-$row[9] == 0)
                                              {
                                                ?>
                                                <td style = "padding: auto;"><?php echo  $row[8]-$row[9]?></td>
                                                <?php
                                              }
                                              else
                                              {
                                                ?>
                                                <td style = "padding: auto;color:red;"><?php echo  abs($row[8]-$row[9])?></td>
                                                <?php
                                              }
                                              ?>
                                              <td style = "padding: auto;"><?php echo  $row[10]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[11]?></td>
                                              <?php
                                              if($row[10]-$row[11] == 0)
                                              {
                                                ?>
                                                <td style = "padding: auto;"><?php echo  $row[10]-$row[11]?></td>
                                                <?php
                                              }
                                              else
                                              {
                                                ?>
                                                <td style = "padding: auto;color:red;"><?php echo  abs($row[10]-$row[11])?></td>
                                                <?php
                                              }
                                              ?>
                                              <!--td style = "padding: auto;">here row[12] echo for remarks</td-->
                                              <td style = "padding: auto;"><?php echo  $row[15]?></td>
                                          </tr>
                                       </tbody>
                                       <?php
                                      }
                                    }
                                    else
                                    {
                                      $sql = "SELECT a.state,a.district,a.dept,a.operator_id,b.username,a.pec_location,a.stid_db,a.stid_csv,a.updatecorrection,a.csv_upco,a.enrollment,a.csv_newen,a.original_enrollment,a.en_diff,a.remarks,date_format(a.created_dttm,'%d-%M-%Y') from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.state = '".$state."' and a.district = '".$district."' and a.pec_location = '".$location."' and a.created_dttm BETWEEN '".$datestartapplication."' and '".$dateendapplication."' order by a.created_dttm";
                                      $result = mysqli_query($con, $sql);
                                      while($row = mysqli_fetch_row($result)) {
                                      ?>
                                      <tbody id="myTable">
                                          <tr>
                                              <td style = "padding: auto;"><?php echo  $row[0]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[1]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[2]?></td>		
                                              <td style = "padding: auto;"><?php echo  $row[3]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[4]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[5]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[6]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[7]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[8]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[9]?></td>
                                              <?php
                                              if($row[8]-$row[9] == 0)
                                              {
                                                ?>
                                                <td style = "padding: auto;"><?php echo  $row[8]-$row[9]?></td>
                                                <?php
                                              }
                                              else
                                              {
                                                ?>
                                                <td style = "padding: auto;color:red;"><?php echo  abs($row[8]-$row[9])?></td>
                                                <?php
                                              }
                                              ?>
                                              <td style = "padding: auto;"><?php echo  $row[10]?></td>
                                              <td style = "padding: auto;"><?php echo  $row[11]?></td>
                                              <?php
                                              if($row[10]-$row[11] == 0)
                                              {
                                                ?>
                                                <td style = "padding: auto;"><?php echo  $row[10]-$row[11]?></td>
                                                <?php
                                              }
                                              else
                                              {
                                                ?>
                                                <td style = "padding: auto;color:red;"><?php echo  abs($row[10]-$row[11])?></td>
                                                <?php
                                              }
                                              ?>
                                              <!--td style = "padding: auto;">here row[12] echo for remarks</td-->
                                              <td style = "padding: auto;"><?php echo  $row[15]?></td>
                                          </tr>
                                      </tbody>
                                      <?php
                                      }
                                    }
                                    
                                    ?>
                                    </table>
                                </div>
                                
                            <?php
							
						}
						if($error == "Not Exists")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">No Reporting result found for PEC Location - '.$location.'</label>';
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
        function uploadme() {
            var state =  $("#state").val();
            var location =  $("#location").val();
			var repstdate =  $("#datetimepicker1").val();
            var rependdate =  $("#datetimepicker2").val();
            
            if(state === "" || location === "" || repstdate === "" || rependdate === "")
            {
                
                document.getElementById("overlay").style.display = "none";
                return false;
            }
            if(state !== null && location !== null && repstdate !== null && rependdate !== null)
            {
                document.getElementById("overlay").style.display = "block";
                return true;
            }
        }
      </script>
      <script>
        function uploadEditmeNormal(st,loc)
		{
          var state = st;
          var location = loc;
          
          if(state === "" || location === "" )
          {
            
            document.getElementById("overlay").style.display = "none";
            return false;
          }
          if(state !== null && location !== "" )
          {
            
            document.getElementById("overlay").style.display = "none";
            var excel_data = $('#range_reporting_table').html();
            var page = "genLocation.php?data="+excel_data;
            window.location = page;
            return true;
            
          }
          
        }
      </script>
    <script language ="javascript">
		function uploadEditme(st,stdt,endt)
		{
          var state = st;
          var startdt = stdt;
          var enddt = endt;

          if(state === "" || startdt === "" || enddt === "")
          {
            
            document.getElementById("overlay").style.display = "none";
            return false;
          }
          if(state !== null && startdt !== "" && enddt !== "")
          {
            
            document.getElementById("overlay").style.display = "block";
            $.ajax({
					type: "POST",
					url: "genRange.php",
					data: 'state='+state+'&startdt='+startdt+'&enddt='+enddt,
					
					success: function(data)
					{
                        $("#result").html(data);
                        document.getElementById("overlay").style.display = "none";
                        //document.getElementById("overlay").style.display = "none";
                        //window.location.href = '';
                        return true;
					}
			});
          }
          
        }
      </script>
      <script>
            $(document).ready(function(){
                $('#gen_rep').click(function(){
                    var excel_data = $('#range_reporting_table').html();
                    var page = "genLocation.php?data="+excel_data;
                    window.location = page;
                });
            });
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
    <script>
			function getName(val)
			{
				document.getElementById("overlay").style.display = "block";
				//alert(val);
				$.ajax({
					type: "POST",
					url: "getAllDistrict.php",
					data: 'state='+val,
					
					success: function(data)
					{
						$("#district").html(data);
						document.getElementById("overlay").style.display = "none";
					}
				});
			}
	</script>
  <script>
			function getNameDis(val)
			{
        var val1 = $("#state").val();
        //alert(val1);
				document.getElementById("overlay").style.display = "block";
				//alert(val);
				$.ajax({
					type: "POST",
					url: "getLocation.php",
					data: 'district='+val+'&state='+val1,
					
					success: function(data)
					{
						$("#location").html(data);
						document.getElementById("overlay").style.display = "none";
					}
				});
			}
			
			
	</script>
  </body>
</html>
<?php 
	  }
	?>