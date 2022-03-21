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
    $state = $_POST["state"];

    $operator_id = $_POST["operator"];
	
    $dateapplication=$_POST["datetimepicker2"];
    

    //if(($hour >= 9 && $min <= 59) && ($hour < 20 && $min <= 59))
    //{
        //$enablestat = true;
        //$ggg = "ok";
        
        //todays date comparison
        //if($year == substr($dateapplication, 0,4) && $month == substr($dateapplication,5,2) && $day == substr($dateapplication,8,2))
        //{
            $created_dttm = $year."-".$month."-".$day;
            $result=mysqli_query($con ,"select * from tbl_attendance where operator_id = '".$operator_id."' and created_dttm = '".$dateapplication."'");
            if(mysqli_num_rows($result) > 0)
            {
                $success = "Exists";
                $sql_res = "SELECT b.state,b.district,a.operator_id,b.username,b.pec_location,b.station_id,a.updatecorrection,a.enrollment,a.remarks,date_format(a.created_dttm,'%d-%M-%Y')  from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.operator_id = '".$operator_id."' and a.created_dttm = '".$dateapplication."' ";
                $result_res = mysqli_query($con, $sql_res);
                while($row_res = mysqli_fetch_row($result_res)) {
                $st = $row_res[0];
                $dt = $row_res[1];
                $opid = $row_res[2];
                $opname = $row_res[3];
                $ploc = $row_res[4];
                $stid = $row_res[5];
                $upcor = $row_res[6];
                $enr = $row_res[7];
                $rmk = $row_res[8];
                $repdate = $row_res[9];
                }
            }
            else
            {
                $error = "Not Exists";
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

if(isset($_POST["sub_app_edit"]))
{
    //print_r($operator_id);
    /*$updatecorrect = $_POST["updatecorrect"];
    $enrollment = $_POST["enrollment"];
    $remarks = $_POST["remarks"];

    if($updatecorrect != null && $enrollment != null && $remarks != null)
    {
        $sql_edit = "UPDATE tbl_attendance set updatecorrection= '".$updatecorrect."',enrollment= '".$enrollment."',remarks= '".$remarks."' WHERE operator_id = '".$operator_id."' and created_dttm = '".$dateapplication."' ";
         echo $sql_edit;           
        if (!mysqli_query($con,$sql_edit))
        {
            $error = "Query";
        }
        else
        {
            $success = "Change";
        }
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
            <li class="active"><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Daily Reporting </a>
              <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                <li><a href="Application.php" onclick="openOverlay()"> <i class="fa fa-rocket"></i>Reporting</a></li>
                <li class="active"><a href="Edit.php" onclick="openOverlay()"><i class="fa fa-edit"></i>Edit Reporting</a></li>
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
            <li class="breadcrumb-item active">Edit Reporting</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Reporting Panel for Edit. . .</h1>
            <p>(Search for Specific Operator's reporting details with specific date)</p>
          </header>
          <div class="row">
            <div class="col-lg-4">
            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Reporting For Edit</h4>
                </div>
                <div class="card-body">
                  <p>(Search for Daily Reporting for Specific Operator)</p>
                  
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
                                                    

                                    $sql = "SELECT Distinct(state) FROM tbl_attendance where state !='' order by state ASC";
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
                            <label>Choose Operator Id </label>
                                <select enable ="<?php $enablestat; ?>" required ="true" placeholder="Choose Operator" id="operator" name="operator" autofocus class="form-control">
                                    <option disabled selected value = "">Select Any...</option>
                                </select>
                            </div>
                             
                             
                            <div class="form-group">
                            <label>Reporting Date </label>
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
                                <div>
                                    <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
                                    <thead class="thead-dark">
                                            <tr>
                                                <!--th style = 'padding:auto;'>Sl. No.</th-->
                                                <th style = 'padding:auto;'>State</th>
                                                <th style = 'padding:auto;'>District</th>
                                                <th style = 'padding:auto;'>Operator ID</th>
                                                <th style = 'padding:auto;'>Operator Name</th>
                                                <th style = 'padding:auto;'>PEC Location</th>
                                                <th style = 'padding:auto;'>Station ID</th>
                                                <th style = 'padding:auto;'>Update / Correction</th>
                                                <th style = 'padding:auto;'>New Enrollment</th>
                                                <th style = 'padding:auto;'>Actual Enrollment</th>
                                                <th style = 'padding:auto;'>Enrollment Difference</th>
                                                <th style = 'padding:auto;'>Remarks</th>
                                                <th style = 'padding:auto;'>Reporting Date</th>
                                                <th style = 'padding:auto;'>Action</th>
                                            </tr>
                                    </thead>
                                    <?php
                                    $sql = "SELECT b.state,b.district,a.operator_id,b.username,b.pec_location,b.station_id,a.updatecorrection,a.enrollment,a.original_enrollment,a.en_diff,a.remarks,date_format(a.created_dttm,'%d-%M-%Y')  from tbl_attendance a, tbl_operator b where a.operator_id = b.operator_id and a.operator_id = '".$operator_id."' and a.created_dttm = '".$dateapplication."' ";
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
                                            <?php
                                            if($row[9] == 0)
                                            {
                                              ?>
                                              <td style = "padding: auto;"><?php echo  $row[9]?></td>
                                              <?php
                                            }
                                            else
                                            {
                                              ?>
                                              <td style = "padding: auto;color:red;"><?php echo  abs($row[9])?></td>
                                              <?php
                                            }
                                            ?>
                                            <td style = "padding: auto;"><?php echo  $row[10]?></td>
                                            <td style = "padding: auto;"><?php echo  $row[11]?></td>
                                            <td style = "padding: auto;"><button type="button" style = "background-color: transparent; border-color: transparent;"  data-toggle="modal" data-target="#myModal"><i class="fa fa-edit" style="font-size:25px; color:#007bff"></i></button></td>
                                        </tr>
                                     </tbody>
                                     <?php
                                    }
                                    ?>
                                    </table>
                                </div>
                                <div class="card-body text-center">
                                    
                                    <!-- Modal-->
                                    <div id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                                        <div role="document" class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 id="exampleModalLabel" class="modal-title">Edit Reporting</h5>
                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                            <p style="color:black;">( Operator ID - <b style="color:orange;"><?php echo $opid; ?></b>)</p>
                                            <p style="color:black;">( Name - <b style="color:orange;"><?php echo $opname; ?></b>)</p>
                                            <form  style="border-style: none;"  id = "EditReporting" enctype="multipart/form-data">

                                                <div class="form-group">
                                                <label>Update / Correction </label>
                                                <input type="number" required ="true" min="0" max="" value="<?php echo $upcor; ?>"
                                                placeholder="Enter any update or correction" id="updatecorrect" name = "updatecorrect" class="form-control">
                                                </div> 

                                                <div class="form-group">
                                                <label>New Enrollment </label>
                                                <input type="number" required ="true" min="0" max="" value="<?php echo $enr; ?>"
                                                placeholder="Enter new enrollment" id="enrollment" name = "enrollment" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                <label>Remarks </label>
                                                <textarea class="form-control" value="<?php echo $rmk; ?>"
                                                placeholder="Any remarks" id="remarks"  name = "remarks" ><?php echo $rmk; ?></textarea>
                                                </div> 

                                                
                                                <div class="form-group">     
                                                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                                <button type="button" id="sub_app_edit" name = "sub_app_edit" onclick = "uploadEditme('<?php echo $dateapplication ?>')" value="Save Changes"  style="float: right;" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                            </div>
                                            <!--div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                            </div-->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="displayNone"> 
                                    <input type="hidden"  id="txtSequenceId1" name="txtSequenceId1" value="<?php echo $operator_id; ?>"/>
                                    <input type="hidden"  id="txtSequenceId1" name="txtSequenceId2" value="<?php echo $dateapplication; ?>"/>
                                </div>
                            <?php
							
						}
						if($error == "Not Exists")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">No Reporting result found for operator - '.$operator_id.' and Date - '.$dateapplication.' </label>';
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
		function uploadEditme(repdate)
		{
          //var operator = $("#operator").val();
          var updatecorrect = $("#updatecorrect").val();
          var enrollment = $("#enrollment").val();
          var remarks = $("#remarks").val();
          //var datetimepicker2 = $("#datetimepicker2").val();
          var operatorid = $("#txtSequenceId1").val().trim();
          //var repdate = $("#txtSequenceId2").text();
          //alert(operatorid);
          var reportdate = repdate;

          if(operatorid === "" || reportdate === "" ||updatecorrect === "" || enrollment === "")
          {
            
            document.getElementById("overlay").style.display = "none";
            return false;
          }
          if(operatorid !== null && reportdate !== "" && updatecorrect !== null && enrollment !== null)
          {
            
            document.getElementById("overlay").style.display = "block";
            $.ajax({
					type: "POST",
					url: "editReporting.php",
					data: 'opId='+operatorid+'&reDate='+reportdate+'&updateCorrect='+updatecorrect+'&enrollment='+enrollment+'&remarks='+remarks,
					
					success: function(data)
					{
                        $("#result").html(data);
                        document.getElementById("overlay").style.display = "block";
                        //document.getElementById("overlay").style.display = "none";
                        window.location.href = '';
                        return true;
					}
			});
          }
          
        }
      </script>
      
      <script language ="javascript">
        function uploadme() {
            var state =  $("#state").val();
            var operator =  $("#operator").val();
            var repdate =  $("#datetimepicker2").val();

            if(state === "" || operator === "" || repdate === "")
            {
                
                document.getElementById("overlay").style.display = "none";
                return false;
            }
            if(state !== null && operator !== "" && repdate !== "")
            {
                document.getElementById("overlay").style.display = "block";
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
    <script>
			function getName(val)
			{
				document.getElementById("overlay").style.display = "block";
				//alert(val);
				$.ajax({
					type: "POST",
					url: "getOperator.php",
					data: 'state='+val,
					
					success: function(data)
					{
						$("#operator").html(data);
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