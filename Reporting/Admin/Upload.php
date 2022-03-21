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

if(isset($_POST["sub_excel"]))
{
	
	if(!empty($_FILES["excel_file"]))
	{
    if($_FILES["excel_file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $_FILES["excel_file"]["type"] == "application/vnd.ms-excel")
		{
      include("Classes/PHPExcel/IOFactoty.php");
			require_once 'Classes/PHPExcel.php';
			$output .="
				<table class='table table-hover table-bordered table-striped' border ='1' width='100%' style = 'text-align: center; overflow-x:auto;font-size: x-small;'>
					<thead class='thead-dark'>
          <tr>
            <th style = 'padding:auto;'>Department</th>
						<th style = 'padding:auto;'>State</th>
            <th style = 'padding:auto;'>District</th>
            <th style = 'padding:auto;'>Operator ID</th>
						<th style = 'padding:auto;'>PEC Location</th>
						<th style = 'padding:auto;'>Operator Name</th>
						<th style = 'padding:auto;'>Station ID</th>
						<th style = 'padding:auto;'>Activity Status</th>
					</tr>
					</thead>
			";
			
			
			$object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);
			$object ->setActiveSheetIndex(0);
			
			//count define
			$count = 0;
      
      foreach($object -> getWorksheetIterator() as $worksheet)
			{
        $highestRow = $worksheet->getHighestRow();
        //echo $highestRow;
				for($row =2; $row<= $highestRow; $row++)
				{
          $dept  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1,$row)->getValue());
          $state  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2,$row)->getValue());
          $district  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3,$row)->getValue());
          $id  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4,$row)->getValue());
					$cenname = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5,$row)->getValue());
					$name  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6,$row)->getValue());
					$stationid = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(7,$row)->getValue());
          $activity = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(8,$row)->getValue());

          $emp_status = null;

          $query_cou = mysqli_query($con, "SELECT Count(*) FROM tbl_operator where operator_id ='".$id."'");
					$result_cou=mysqli_fetch_row($query_cou);
          $op_cou = $result_cou[0];
          
          if($op_cou == 0)
		      {
            $query_sl = mysqli_query($con ,"SELECT Count(sl_no) from tbl_operator");
			      $res_sl=mysqli_fetch_row($query_sl);
            $tot = $res_sl[0];
            
            $slno = 0;
            if($tot == null)
            {
              //increament count
              $slno =1;
            }
            else
            {
              //increament count
              $slno =$tot+1;
            }	
            
            if($dept != null && $id != null && $name != null && $district != null && $state != null && $cenname != null)
			      {
                if($stationid == null || $stationid == "NA")
                {
                  $stationid = "00000";
                }
                else
                {
                  $stationid = $stationid;
                }
                if($activity == "Not working")
                {
                  
                  //$activity = "Inactive";
                  $emp_status = "0";
                }
                else if($activity == "Existing")
                {
                  $emp_status = "1";
                }
                else
                {
                  $emp_status = "2";
                }
                $sql_check = "SELECT * FROM tbl_operator where operator_id = TRIM('".$id."') ";
                $res_chk = mysqli_query($con,$sql_check);
                $noofRows = mysqli_num_rows($res_chk);

                if($noofRows > 0)
                {

                }
                else
                {
                  $insert_sql="INSERT INTO tbl_operator (`sl_no`,`dept`,`state`,`district`,`operator_id`,`pec_location`,`username`,`password`,`station_id`,`emp_status`) VALUES ('".$slno."','".$dept."','".$state."','".$district."','".$id."','".$cenname."','".$name."','password','".$stationid."','".$emp_status."')";
                  if (!mysqli_query($con,$insert_sql))
                  {	  
                    //header('location:Error.php');
                    //echo $insert_sql;
                  }
                  else
                  {
                    $output .= "
                        <tbody>
                        <tr>
                          <td>$dept</td>
                          <td>$state</td>
                          <td>$district</td>
                          <td>$id</td>
                          <td>$cenname</td>
                          <td>$name</td>
                          <td>$stationid</td>
                          <td>$activity</td>
                        </tr>
                        </tbody>
                      ";

                    //increament count
                    $count +=1;
                  }
                }
            }
          }
          else
          {   

            if($activity == "Not working")
            {
              
              //$activity = "Inactive";
              $emp_status = "0";
            }
            else if($activity == "Existing")
            {
              $emp_status = "1";
            }
            else
            {
              $emp_status = "2";
            }

            $sql_edit = "UPDATE tbl_operator set username='".$name."',pec_location='".$cenname."',station_id = '".$stationid."',emp_status = '".$emp_status."' WHERE operator_id = '".$id."'  ";

            if (!mysqli_query($con,$sql_edit))
            {
              
            }
            else
            {
                
            }
          }				
        }
      }
      if($count > 0)
      {
        $output .= '</table>';
        
        $success = "Uploaded";
        //header( "refresh:30;url=Operator.php" );
      }
      if($count == 0)
      {
        $success = "No Update";
        //header( "refresh:3;url=Operator.php" );
      }
    }
    else
    {
      $error = "Invalid File";
				
      //header( "refresh:3;url=Operator.php" );
    }
  }
  else
  {
    
    $error = "Select";
    //header( "refresh:3;url=Operator.php" );
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
          <div class="sidenav-header-logo"><a href="./" class="brand-small text-center" onclick="openOverlay()"> <strong><i class="icon-bars"> </i></strong></a></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <h5 class="sidenav-heading">Main</h5>
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="./" onclick="openOverlay()"> <i class="icon-home"></i>Home</a></li>
            <li class="active"><a href="Upload.php" onclick="openOverlay()"> <i class="icon-form"></i>Upload</a></li>
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
            <li class="breadcrumb-item active">Upload</li>
          </ul>
        </div>
      </div>
      <section class="forms">
        <div class="container-fluid">
          <!-- Page Header-->
          <header> 
            <h1 class="h3 display">Upload Excel . . .</h1>
            <p>(To Add Some Operators)</p>
          </header>
          <div class="row">
            <div class="col-lg-4">
            </div>

            <div class="col-lg-4">
              <div class="card">
                <div class="card-header d-flex align-items-center">
                  <h4>Excel Submission</h4>
                </div>
                <div class="card-body">
                  <p>Excel submit to add operators</p>
                  <form style="border-style: none;" action = "" method ="post"  id = "export_excel" enctype="multipart/form-data">
                    <div class="form-group">
                      <label>Choose an Excel </label>
                      <input type="file"  required ="true"
                      accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" 
                      placeholder="Excel Upload" id="excel_file" name = "excel_file" class="form-control">
                    </div>
                    
                    <div class="form-group">       
                      <input type="submit" value="Upload Excel" style="float: right;" class="btn btn-primary" id="sub_excel" name = "sub_excel" onclick = "uploadme()">
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
						if($error == "Invalid File")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Invalid File . . . Please Select Correct File</label>';
							
						}
						if($error == "Select")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Please Select Correct File</label>';
							
						}
						if($success == "Uploaded")
						{
							//header( "refresh:30;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted </label>';
							echo $output;
							
						}
						if($success == "No Update")
						{
							//header( "refresh:3;url=Operator.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted </label>';
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
          var excel = $("#excel_file").val();
          
          
          if(excel === "")
          {
            
            document.getElementById("overlay").style.display = "none";
            return false;
          }
          if(excel !== null)
          {
            
            document.getElementById("overlay").style.display = "block";
            window.location.href = '/';

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
  </body>
</html>
<?php 
	  }
	?>