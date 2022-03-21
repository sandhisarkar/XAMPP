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

if(($hour >= 9 && $min <= 59) && ($hour < 21 && $min <= 59))
{
    $enablestat = true;
    $ggg = "ok";
}
else
{
    $enablestat = false;
    $ggg = "not";
}

if(isset($_POST["sub_app_zero"]))
{
    $operator_id = $_POST["operator"];
	  $updatecorrect=$_POST['updatecorrect'];
    $enrollment=$_POST['enrollment'];
    $dateapplication=$_POST["datetimepicker2"];
    $remarks = $_POST["remarks"];

    $remark = implode(',',$remarks);

    $created_dttm = $year."-".$month."-".$day;
    $result=mysqli_query($con ,"select * from tbl_attendance where operator_id = '".$operator_id."' and created_dttm = '".$dateapplication."'");
    if(mysqli_num_rows($result) > 0)
    {
        $error = "Exists";
    }
    else
    {
      $endiff = 0;
      $query_day_count = mysqli_query($con ,"SELECT COUNT(slno) FROM `tbl_attendance` WHERE created_dttm = '".$dateapplication."'");
      $result_day_count = mysqli_fetch_row($query_day_count);
      $day_count = $result_day_count[0];
      
      $slno = 0;
      if($day_count == null)
      {
      $slno =1;
      }
      else
      {
      $slno =$day_count+1; 
      }
      
      $dt1 = strtotime($dateapplication);

      $dt2 = date('D', $dt1);

      if($dt2 == "Sun")
      {
        $result=mysqli_query($con ,"select * from tbl_outrangetime where operator_id = '".$operator_id."' and created_date = '".$dateapplication."'");
            
        $formatedDTTM = "00".":"."00".":"."00"." Hrs";
        $item_no = 1;
        $insertOutRange_sql="INSERT INTO tbl_outrangetime (item_no,operator_id,created_date,log_dttm) VALUES ('".$item_no."','".$operator_id."','".$dateapplication."','".$formatedDTTM."')";

        if (!mysqli_query($con,$insertOutRange_sql))
        {	  
            //$error = "Query";
        }
        else
        {
            //$success = "Success";
        }
      }
      $ope_query = "SELECT dept,state,district,pec_location,station_id FROM tbl_operator where operator_id = '".$operator_id."'";
      $ope_result = mysqli_query($con,$ope_query);
      $result_op_details =mysqli_fetch_row($ope_result);

      $db_dept = $result_op_details[0];
      $db_state = $result_op_details[1];
      $db_district = $result_op_details[2];
      $db_pec_location = $result_op_details[3];
      $db_stid = $result_op_details[4];

      $csv_stid = $db_stid;

      $insert_sql="INSERT INTO tbl_attendance (slno,operator_id,updatecorrection,enrollment,original_enrollment,csv_upco,csv_newen,en_diff,dept,state,district,pec_location,stid_db,stid_csv,created_dttm,remarks) VALUES ('".$slno."','".$operator_id."','".$updatecorrect."','".$enrollment."','0','0','0','".$endiff."','".$db_dept."','".$db_state."','".$db_district."','".$db_pec_location."','".$db_stid."','".$csv_stid."','".$dateapplication."','".$remark."')";

      if (!mysqli_query($con,$insert_sql))
      {	  
        $error = "Query";
      }
      else
      {
        $success = "Success";
      }
    }
}

if(isset($_POST["sub_app"]))
{
    $operator_id = $_POST["operator"];
	  $updatecorrect=$_POST['updatecorrect'];
    $enrollment=$_POST['enrollment'];
    $dateapplication=$_POST["datetimepicker2"];
    $remarks = $_POST["remarks"];

    //if(($hour >= 9 && $min <= 59) && ($hour < 20 && $min <= 59))
    //{
        //$enablestat = true;
        //$ggg = "ok";
        
        //todays date comparison
        //if($year == substr($dateapplication, 0,4) && $month == substr($dateapplication,5,2) && $day == substr($dateapplication,8,2))
        //{

          if(!empty($_FILES["excel_file"]))
          {
            $allowed = array('csv','xls');
            $csv_file_name = $_FILES["excel_file"]["name"];
            $ext = pathinfo($csv_file_name, PATHINFO_EXTENSION);
            if(in_array($ext, $allowed))
		        {
              $created_dttm = $year."-".$month."-".$day;
              $result=mysqli_query($con ,"select * from tbl_attendance where operator_id = '".$operator_id."' and created_dttm = '".$dateapplication."'");
              if(mysqli_num_rows($result) > 0)
              {
                  $error = "Exists";
              }
              else
              {

                $handle = fopen($_FILES['excel_file']['tmp_name'],"r");

                $count = 0;
                $item_no = 0;
                $upco = 0;
                $newen = 0;

                $csv_stid = "";
                while($data = fgetcsv($handle))
                {
                    $id = mysqli_real_escape_string($con,$data[0]);
                    $magicNo = mysqli_real_escape_string($con,$data[1]);
                    $type = mysqli_real_escape_string($con,$data[3]);
                    $opid = mysqli_real_escape_string($con,$data[8]);

                    $datestring = substr($magicNo,14,8);
                    $formattedDate = substr($datestring,0,4)."-".substr($datestring,4,2)."-".substr($datestring,6,2);

                    $timeString = substr($magicNo,22,6);
                    $hourString = substr($timeString,0,2);
                    $minString = substr($timeString,2,2);
                    $secString = substr($timeString,4,2);

                    $csv_stid = substr($magicNo,4,5);

                    if($formattedDate == $dateapplication && strtoupper($operator_id) == strtoupper($opid))
                    {
                      //$count++;
                      if($type == "U")
                      {
                        $upco++;
                      }
                      if($type == "E")
                      {
                        $newen++;
                      }

                      $result=mysqli_query($con ,"select * from tbl_outrangetime where operator_id = '".$operator_id."' and created_date = '".$dateapplication."'");
                      
                      $dt1 = strtotime($dateapplication);

                      $dt2 = date('D', $dt1);

                      if($dt2 != "Sun")
                      {
                        if($hourString >= 9 && $hourString <19)
                        {

                        }
                        else
                        {

                          if(mysqli_num_rows($result) > 0)
                          {
                              $item_no++;
                          }
                          else
                          {
                            $item_no = 1;
                          }

                          $formatedDTTM = $hourString.":".$minString.":".$secString." Hrs";

                          $insertOutRange_sql="INSERT INTO tbl_outrangetime (item_no,operator_id,created_date,log_dttm) VALUES ('".$item_no."','".$operator_id."','".$dateapplication."','".$formatedDTTM."')";

                          if (!mysqli_query($con,$insertOutRange_sql))
                          {	  
                              //$error = "Query";
                          }
                          else
                          {
                              //$success = "Success";
                          }
                        }


                       }
                       else
                       {
                          if(mysqli_num_rows($result) > 0)
                          {
                              $item_no++;
                          }
                          else
                          {
                            $item_no = 1;
                          }

                          $formatedDTTM = $hourString.":".$minString.":".$secString." Hrs";

                          $insertOutRange_sql="INSERT INTO tbl_outrangetime (item_no,operator_id,created_date,log_dttm) VALUES ('".$item_no."','".$operator_id."','".$dateapplication."','".$formatedDTTM."')";

                          if (!mysqli_query($con,$insertOutRange_sql))
                          {	  
                              //$error = "Query";
                          }
                          else
                          {
                              //$success = "Success";
                          }
                       }

                    }
                   
                }

                $count = $upco + $newen;


                $endiff = $updatecorrect+$enrollment-$count;

                fclose($handle);

                if($count > 0)
                {
					
                  $query_day_count = mysqli_query($con ,"SELECT COUNT(slno) FROM `tbl_attendance` WHERE created_dttm = '".$dateapplication."'");
                  $result_day_count = mysqli_fetch_row($query_day_count);
                  $day_count = $result_day_count[0];
                  
                  $slno = 0;
                  if($day_count == null)
                  {
                  $slno =1;
                  }
                  else
                  {
                  $slno =$day_count+1; 
                  }
                  
                  $ope_query = "SELECT dept,state,district,pec_location,station_id FROM tbl_operator where operator_id = '".$operator_id."'";
                  $ope_result = mysqli_query($con,$ope_query);
                  $result_op_details =mysqli_fetch_row($ope_result);

                  $db_dept = $result_op_details[0];
                  $db_state = $result_op_details[1];
                  $db_district = $result_op_details[2];
                  $db_pec_location = $result_op_details[3];
                  $db_stid = $result_op_details[4];



                  $insert_sql="INSERT INTO tbl_attendance (slno,operator_id,updatecorrection,enrollment,original_enrollment,csv_upco,csv_newen,en_diff,dept,state,district,pec_location,stid_db,stid_csv,created_dttm,remarks) VALUES ('".$slno."','".$operator_id."','".$updatecorrect."','".$enrollment."','".$count."','".$upco."','".$newen."','".$endiff."','".$db_dept."','".$db_state."','".$db_district."','".$db_pec_location."','".$db_stid."','".$csv_stid."','".$dateapplication."','".$remarks."')";

                  if (!mysqli_query($con,$insert_sql))
                  {	  
                      $error = "Query";
                  }
                  else
                  {
                      $success = "Success";
                  }
                }
                else
                {
                  $error = "Not For Date";
                }
                
              }
            }
            else
            {
                $error = "Invalid File";
            }
          }
        //}
        /*else
        {
            $error = "Current Date";
        }*/

    //}
    /*else
    {
        $enablestat = false;
        $ggg = "not";
        $error = "Timeout";
    }*/

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge,firefox">
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
            <li class="active"><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Daily Reporting </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li class="active"><a href="Application.php" onclick="openOverlay()"> <i class="fa fa-rocket"></i>Reporting</a></li>
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
      <!-- Breadcrumb-->
      <div class="breadcrumb-holder">
        <div class="container-fluid">
          <ul class="breadcrumb">
            <li class="breadcrumb-item" onclick="openOverlay()"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Reporting</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Reporting Panel . . .</h1>
            <p>(To Add Daily Reporting for Specific Operator)</p>
          </header>
          <div class="row">
            <div class="col-lg-4">
            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Reporting </h4>
                </div>
                <div class="card-body">
                  <p>(Apply for Daily Reporting)</p>
                  <div class="form-group row">
                    
                      <div class="i-checks">
                          <input id="radioCustom1" type="radio" value="with" name="a" onclick="checkrdio1()" class="form-control-custom radio-custom">
                          <label for="radioCustom1" style="color:#212529;">Enrollment With Figure</label>
                        </div>
                        <div class="i-checks">
                          <input id="radioCustom2" type="radio" value="without" name="a" onclick="checkrdio2()" class="form-control-custom radio-custom">
                          <label for="radioCustom2" style="color:#212529;">Zero Enrollment Figure</label>
                        </div>
                       
                  </div>
                  <form style="border-style: none; display: none;" action = "" method ="post"  id = "ReportingCSV" enctype="multipart/form-data">
                    <?php
                        if($enablestat == true || $enablestat == false) 
                        {
                            ?>
                            <div class="form-group">
                            <label>Choose Operator Id </label>
                                <select enable ="<?php $enablestat; ?>" required ="true" placeholder="Choose Operator" id="operator" name="operator" autofocus class="form-control">
                                    <option selected value="">Choose Operator</option>
                                    <?php
                                                    

                                    $sql = "SELECT Distinct(operator_id) FROM tbl_operator where emp_status <> 0 order by operator_id ASC";
                                    $result = mysqli_query($con, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                    // output data of each row
                                    
                                    while($row = mysqli_fetch_row($result)) {
                                        ?>
                                        
                                        <option style = "color:black;" value = "<?php echo $row[0]; ?>"><?php echo  $row[0]?></option>
                                        <?php
                                    }
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                            <label>Update / Correction </label>
                            <input type="number" required ="true" min="0" max=""
                            placeholder="Enter any update or correction" id="updatecorrect" name = "updatecorrect" class="form-control">
                            </div> 
                            <div class="form-group">
                            <label>New Enrollment </label>
                            <input type="number" required ="true" min="0" max=""
                            placeholder="Enter new enrollment" id="enrollment" name = "enrollment" class="form-control">
                            </div>  
                            <div class="form-group">
                            <label>Reporting Date </label>
                                <input type="date" required ="true" 
                                placeholder="Choose Proper Date" id="datetimepicker2" name = "datetimepicker2" class="form-control">
                            </div>  
                            <div class="form-group">
                              <label>Choose Reporting CSV </label>
                              <input type="file"  required ="true"
                              accept=".csv"
                              placeholder="Excel Upload" id="excel_file" name = "excel_file" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Remarks </label>
                              <textarea class="form-control"
                              placeholder="Any remarks" id="remarks"  name = "remarks" ></textarea>
                            </div>  
                            <div class="form-group">       
                              <input type="submit" value="Submit Reporting" style="float: right;"  class="btn btn-primary" id="sub_app" name = "sub_app" onclick = "uploadme()">
                            </div>
                            <?php
                        }
                        
                    ?>
                    
                  </form>
                  <form style="border-style: none; display: none;" action = "" method ="post"  id = "Reporting" enctype="multipart/form-data">
                    <?php
                        if($enablestat == true || $enablestat == false)
                        {
                            ?>
                              <div class="form-group">
                              <label>Choose Operator Id </label>
                                  <select enable ="<?php $enablestat; ?>" required ="true" placeholder="Choose Operator" id="operator" name="operator" autofocus class="form-control">
                                      <option selected value="">Choose Operator</option>
                                      <?php
                                                      

                                      $sql = "SELECT Distinct(operator_id) FROM tbl_operator where emp_status <> 0 order by operator_id ASC";
                                      $result = mysqli_query($con, $sql);
                                      if (mysqli_num_rows($result) > 0) {
                                      // output data of each row
                                      
                                      while($row = mysqli_fetch_row($result)) {
                                          ?>
                                          
                                          <option style = "color:black;" value = "<?php echo $row[0]; ?>"><?php echo  $row[0]?></option>
                                          <?php
                                      }
                                      } else {
                                          echo "";
                                      }
                                      ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                <label>Update / Correction </label>
                                <input type="number" required ="true" min="0" max="0"
                                placeholder="Enter any update or correction" id="updatecorrect" name = "updatecorrect" class="form-control">
                              </div> 
                              <div class="form-group">
                                <label>New Enrollment </label>
                                <input type="number" required ="true" min="0" max="0"
                                placeholder="Enter new enrollment" id="enrollment" name = "enrollment" class="form-control">
                              </div>  
                              <div class="form-group">
                              <label>Reporting Date </label>
                                  <input type="date" required ="true" 
                                  placeholder="Choose Proper Date" id="datetimepicker2" name = "datetimepicker2" class="form-control">
                              </div>
                              <div class="form-group">
                                <label>Remarks </label>
                                <select multiple="" class="form-control" id="remarks"  name = "remarks[]" required ="true">
                                  <option style = "color:black;">Absent / On leave</option>
                                  <option style = "color:black;">Electricity problem</option>
                                  <option style = "color:black;">Device problem</option>
                                  <option style = "color:black;">ID Inactive</option>
                                  <option style = "color:black;">System registration pending</option>
                                  <option style = "color:black;">Location space problem</option>
                                  <option style = "color:black;">Location not allotated / shifted</option>
                                  <option style = "color:black;">Public issue / over crowd</option>
                                  <option style = "color:black;">Administrative Issue</option>
                                  <option style = "color:black;">Sunday / Holiday</option>
                                  <option style = "color:black;">Other</option>
                                <select>
                              </div>  
                              <div class="form-group">       
                                <input type="submit" value="Submit Reporting" style="float: right;"  class="btn btn-primary" id="sub_app_zero" name = "sub_app_zero" onclick = "uploadme()">
                              </div>
                            
                            <?php
                        }
                        
                    ?>
                    
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
						if($error == "Timeout")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Reporting time has been expired for today.</label>';
							
						}
						if($error == "Current Date")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Please Select Current Date</label>';
							
            }
            if($error == "Invalid File")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Invalid File - '.$csv_file_name.'</label>';
							
            }
            if($error == "Query")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Reporting not submitted for operator - '.$operator_id.' </label>';
							
            }
            if($error == "Not For Date")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Reporting is not submitted for operator - '.$operator_id.'.</br>Check uploadable CSV File again along with current date and operator_id in CSV</label>';
							
            }
						if($error == "Exists")
						{
							//header( "refresh:30;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Reporting of operator - '.$operator_id.' is already been registered for Date - ( '.$dateapplication.' )</label>';
							//echo $output;
							
						}
						if($success == "Success")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Reporting of operator - '.$operator_id.' is successfully registered for Date - ( '.$dateapplication.' )</label>';
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
    <script language="javascript">
        var rdio1 = $("#radioCustom1").val();
        var rdio2 = $("#radioCustom2").val();
        function checkrdio1()
        {
          document.getElementById("ReportingCSV").style.display = "block";
          document.getElementById("Reporting").style.display = "none";
        }
        function checkrdio2()
        {
          document.getElementById("ReportingCSV").style.display = "none";
          document.getElementById("Reporting").style.display = "block";
        }
    </script>
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
          var operator = $("#operator").val();
          var updatecorrect = $("#updatecorrect").val();
          var enrollment = $("#enrollment").val();
          var datetimepicker2 = $("#datetimepicker2").val();
          var csv = $("#excel_file").val();

          if(csv=== "" || operator === "" || updatecorrect === "" || enrollment === "" || datetimepicker2 === "")
          {
            
            document.getElementById("overlay").style.display = "none";
            return false;
          }
          if(csv!== null && operator !== null && updatecorrect !== null && enrollment !== null && datetimepicker2 !== null)
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