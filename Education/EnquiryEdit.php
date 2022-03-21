<?php

    session_start();
    error_reporting(0);

$con=mysqli_connect("localhost","root","root","demo");
$q=mysqli_query($con,"select s_name from admin_user_data where s_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['s_name'];
$id=$_SESSION['user'];
$msgNav = "";

$get_enq_ID = $_GET["enq_id"];



$q_fetch=mysqli_query($con,"select * from enquiry_details where enq_id='".$_GET["enq_id"]."'");
$n_fetch=  mysqli_fetch_assoc($q_fetch);

$getstugenID = $n_fetch['id'];
$centre_id = $n_fetch['centre_id'];
$centre_name = $n_fetch['centre_name'];
$centre_address = $n_fetch['centre_address'];
$centre_state = $n_fetch['centre_state'];
$centre_pin = $n_fetch['centre_pin'];
$centre_location = $n_fetch['centre_location'];
$student_name = $n_fetch['student_name'];
$student_phone = $n_fetch['student_phone'];
$student_email = $n_fetch['student_email'];
$student_course = $n_fetch['student_course'];
$admission_class = $n_fetch ['admission_class'];
$source_name = $n_fetch['source'];
$remarks = $n_fetch['remarks'];
$status = $n_fetch['status'];



if(isset($_POST["centre_sub"]))
{
    
 
 mysqli_select_db( $con,"enquiry_details");


    $student_name1 = strtoupper ($_POST['student_name']);
	$student_phone1 = $_POST['student_phone'];
	$student_email1 = $_POST['student_email'];
	$student_course1 = $_POST['course_name'];
	$admission_class1 = $_POST ['class_for'];
	$source_name1 = $_POST['source'];
	$remarks1 = $_POST['remarks'];
	$status1 = $_POST['status'];
	$modified_date = date("Y-m-d");

 
 
 $sql="UPDATE enquiry_details SET id='".$getstugenID."',centre_id = '".$centre_id."',centre_name = '".$centre_name."',centre_address = '".$centre_address."',centre_state = '".$centre_state."',centre_pin ='".$centre_pin."',centre_location = '".$centre_location."',student_name = '".$student_name1."',student_phone = '".$student_phone1."',student_email='".$student_email1."',student_course = '".$student_course1."',admission_class='".$admission_class1."',source='".$source_name1."',remarks = '".$remarks1."',modified_dttm = '".$modified_date."' WHERE enq_id='".$get_enq_ID."'";

	if (!mysqli_query($con,$sql))
	{
	  //die('Error: ' . mysqli_error());
	  $msgNav = "Error in updating the Subject";
	  header('location:home.php');
    }
	else
	{
	  //echo "1 record added";
	  $msgNav = "Subject is updated successfully";
	  header('location:ThankYou.php');
	}
}



?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link type="text/css" rel="stylesheet" href="css/login.css"></link>
        <title>NTPL Panel</title>
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
         <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
       <script src="bootstrap/jquery.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>
        <link type="text/css" rel="stylesheet" href="css/admform.css"></link>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	   
	   <!-- Bootstrap CSS CDN -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<!-- Our Custom CSS -->
		<link type="text/css" rel="stylesheet" href="css/style5.css"></link>

		<!-- Font Awesome JS -->
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
		   
			
    </head>
    <body style="background-image:url(./images/03.jpg) ">
        
        <?php  

			include 'usersession.php';

		?>
			
          
		 <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Student Panel</h3>
			
            </div>

            <ul class="list-unstyled components">
                <p style = "font-size:15px;">Welcome </p>
                <li class="active">
                    <a href="home.php" aria-expanded="false">Home</a>
                    
                </li>
				
				
				
                <li>
                   <a href="StudentEnquiry.php">Add Enquiry</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>

            
        </nav>

        <!-- Page Content Holder -->
        <div id="content">

				<nav class="navbar navbar-expand-lg  ">
					<div class="container-fluid">

						<button type="button" id="sidebarCollapse" class="navbar-btn">
							<span></span>
							<span></span>
							<span></span>
						</button>
						<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<i class="fas fa-align-justify"></i>
						</button>

						
						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="nav navbar-nav ml-auto">
								
									<div class='speech-bubble' style = "position: relative;margin: .5em auto; padding: 1em;  width: 10em; height: 4em;  border-radius: .25em; background: transparent;  font: 2em/4 Century Gothic, Verdana, sans-serif;  text-align: center;">
										<h1><?php  echo $msgNav ?></h1>
									</div>
								
									
							</ul>
						</div>
					</div>
					
				</nav>
				
				<div class="container" style = "margin-top: -3%;">
			
				<div class="tab-content">
					<div class="container-fluid">
                            <div class="row">
							   
                               <div class="col-sm-12" style = "margin-top: -5%; margin-left: -5%;">
									<h1 style = "Color: white; margin-bottom: 40px;"> Update Your Enquiry : </h1>
									
										<div class="col-sm-6" style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; margin-left: 225px;">
											<form action="EnquiryEdit.php?enq_id=<?php echo  $_GET["enq_id"]?>" method="post">
												
											<table>
												<tr>
													<td>
														<font style="color:White; margin-left: 50px; font-family: Verdana;  margin-top:15px; font-size:17px;">Student Name : &nbsp;&nbsp;&nbsp;</font> 
														<input value="<?php echo $student_name?>" required="true" type="text" id="student_name" name="student_name"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 5px;width: 250px;text-transform: uppercase;">
														
													</td>
												</tr>
												
												<tr>
													<td>
														<font style="color:White; margin-left:36px; font-family: Verdana;  margin-top:15px; font-size:17px;">Student Contact : &nbsp;&nbsp;&nbsp;</font> 
														<input value="<?php echo $student_phone?>" type="text" id="student_phone" name="student_phone"  pattern="[0-9]{10}" maxlength="10" required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 21px;width: 250px;text-transform: uppercase;"><span style = "color:white;padding-left: 275px;">[Format: 9999999999]</span>
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:55px; font-family: Verdana;  margin-top:15px; font-size:17px;">Student Email : &nbsp;&nbsp;&nbsp;</font> 
														<input value="<?php echo $student_email?>" type="email" id="student_email" name="student_email"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:117px; font-family: Verdana;  margin-top:15px; font-size:17px;">Course : &nbsp;&nbsp;&nbsp;</font> 
														<!--input type="dropdown" id="centre_state" name="centre_state"  required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;"-->		
															<select required="true" id="course_name" name="course_name" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																	<option  value="" disabled>Select any course</option>
																	<option selected><?php echo $student_course ?></option>
																<?php
																	mysqli_select_db( $con,"course_details");

																	$sql = "SELECT course_name FROM course_details where course_name <> '".$student_course."'";
																	$result = mysqli_query($con, $sql);
																	if (mysqli_num_rows($result) > 0) {
																	// output data of each row
																	while($row = mysqli_fetch_assoc($result)) {
																		?>
																		
																		<option><?php echo  $row["course_name"]?></option>
																		<?php
																	}
																} else {
																	echo "";
																}
																?>
																
															</select>
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:10px; font-family: Verdana;  margin-top:15px; font-size:17px;">Admission for Class : &nbsp;&nbsp;&nbsp;</font> 
														<select required="true" id="class_for" name="class_for" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																<option  value="" disabled>Select Any </option>
																<option selected><?php echo $admission_class ?></option>
																<?php
																	mysqli_select_db( $con,"class_master");

																	$sql = "SELECT class_name FROM class_master where class_name <> '".$admission_class."'";
																	$result = mysqli_query($con, $sql);
																	if (mysqli_num_rows($result) > 0) {
																	// output data of each row
																	while($row = mysqli_fetch_assoc($result)) {
																		?>
																		
																		<option><?php echo  $row["class_name"]?></option>
																		<?php
																	}
																} else {
																	echo "";
																}
																?>
															</select>
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:55px; font-family: Verdana;  margin-top:15px; font-size:17px;">Source of Info  : &nbsp;&nbsp;&nbsp;</font> 
														<!--input type="dropdown" id="centre_state" name="centre_state"  required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;"-->		
															<select required="true" id="source" name="source" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																<option  value="" disabled>Select Any </option>
																<option selected><?php echo $source_name ?></option>
																<?php
																	mysqli_select_db( $con,"source_master");

																	$sql = "SELECT source_name FROM `source_master` WHERE source_name <> '".$source_name."'";
																	$result = mysqli_query($con, $sql);
																	if (mysqli_num_rows($result) > 0) {
																	// output data of each row
																	while($row = mysqli_fetch_assoc($result)) {
																		?>
																		
																		<option><?php echo  $row["source_name"]?></option>
																		<?php
																	}
																} else {
																	echo "";
																}
																?>
															</select>
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:111px; font-family: Verdana;  margin-top:15px; font-size:17px;">Enquiry : &nbsp;&nbsp;&nbsp;</font> 
														
														<input value="<?php echo $remarks?>" required="true" type="text" id="remarks" name="remarks"  style="font-size: 15px;height: 70px;padding-top: 0px;margin-top: 25px;width: 250px;">
													</td>
												</tr>
												
												<tr>
													<td>
														<font style="color:White; margin-left:120px; font-family: Verdana;  margin-top:15px; font-size:17px;">Status  : &nbsp;&nbsp;&nbsp;</font> 
														<!--input type="dropdown" id="centre_state" name="centre_state"  required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;"-->		
															<select required="true" id="status" name="status" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																<option  value="" disabled>Select Any </option>
																<option selected><?php echo $status ?></option>
																<?php
																	mysqli_select_db( $con,"status_master");

																	$sql = "SELECT status_name FROM `status_master` WHERE status_name <> '".$status."'";
																	$result = mysqli_query($con, $sql);
																	if (mysqli_num_rows($result) > 0) {
																	// output data of each row
																	while($row = mysqli_fetch_assoc($result)) {
																		?>
																		
																		<option><?php echo  $row["status_name"]?></option>
																		<?php
																	}
																} else {
																	echo "";
																}
																?>
															</select>
													</td>
												</tr>
												
												<tr>
														<td>
															<input class="toggle btn btn-primary" type="submit" id="centre_sub" name = "centre_sub" value="Update" style="color:White; margin-left:250px; font-family: Verdana;  margin-top:15px; font-size:17px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
														</td>
										    	</tr>
												
											</table>
											
											
											</form>
											</div>
											</div>					
								</div>
							   
							</div>
					</div>
				</div>
				
			</div>
		</div>

					
				</div>
		 <!-- jQuery CDN - Slim version (=without AJAX) -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<!-- Popper.JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<!-- Bootstrap JS -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<script type="text/javascript">
		$(document).ready(function () {
		$('#sidebarCollapse').on('click', function () {
		$('#sidebar').toggleClass('active');
		$(this).toggleClass('active');
		});
		});
		</script>																														  
					
    </body>
</html>