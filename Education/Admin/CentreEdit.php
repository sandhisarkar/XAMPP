<?php

    session_start();
    error_reporting(0);

$con=mysqli_connect("localhost","root","root","demo");
$q=mysqli_query($con,"select s_name from admin_user_data where s_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['s_name'];
$id=$_SESSION['user'];
$msgNav = "";

$get_cen_ID = $_GET["cen_id"];



$q_fetch=mysqli_query($con,"select id,cen_name,cen_address,cen_state,cen_pin,cen_location,per_name,per_phone,per_email_address,user_name,user_password from centre_details where cen_id='".$_GET["cen_id"]."'");
$n_fetch=  mysqli_fetch_assoc($q_fetch);

$getID = $n_fetch['id'];
$centre_name = $n_fetch['cen_name'];
$centre_address = $n_fetch['cen_address'];
$centre_state = $n_fetch['cen_state'];
$centre_pin = $n_fetch['cen_pin'];
$centre_location = $n_fetch['cen_location'];
$person_name = $n_fetch['per_name'];
$person_phone = $n_fetch['per_phone'];
$person_email = $n_fetch['per_email_address'];
$user_name = $n_fetch['user_name'];
$user_password = $n_fetch['user_password'];

if(isset($_POST["centre_sub"]))
{
    
 
 mysqli_select_db( $con,"centre_details");

 
 $centre_name_temp1 =$_POST['centre_name'];
 $centre_name1= strtoupper ($centre_name_temp1);
 
 $centre_id_temp1 = substr($centre_name1,0,4);
 $centre_id_temp2 = str_pad($getID,4,"0",STR_PAD_LEFT);
 $centre_id1 = $centre_id_temp1."_".$centre_id_temp2;
 
 $centre_address1 = strtoupper ($_POST['centre_address']);
 $centre_state1 = $_POST['centre_state'];
 $centre_pin1 = $_POST['centre_pin'];
 $centre_location_temp1 = $_POST['centre_location'];
 $centre_location1 = strtoupper ($centre_location_temp1);
 
 $person_name1 = strtoupper ($_POST['person_name']);
 $phone1 =$_POST['phone'];
 $email_address1 =$_POST['email_address'];
 $user_name1 =$_POST['user_name'];
 $user_password1=$_POST['user_password'];
 
 $sql="UPDATE centre_details SET cen_id='".$centre_id1."',cen_name = '".$centre_name1."',cen_address='".$centre_address1."',cen_state = '".$centre_state1."',cen_pin='".$centre_pin1."',cen_location='".$centre_location1."',per_name = '".$person_name1."',per_phone='".$phone1."',per_email_address='".$email_address1."',user_name='".$user_name1."',user_password='".$user_password1."' WHERE cen_id='".$get_cen_ID."'";

	if (!mysqli_query($con,$sql))
	{
	  //die('Error: ' . mysqli_error());
	  $msgNav = "Error in updating the centre";
	   header('location:Error.php');
    }
	else
	{
	  //echo "1 record added";
	  $msgNav = "Centre is updated successfully";
	  header('location:ThankYou.php');
	}
}


$result = mysqli_query($con,"SELECT * FROM admin_user_data WHERE s_user='".$_SESSION['user']."'");
                    
                    while($row = mysqli_fetch_array($result))
                      {
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link type="text/css" rel="stylesheet" href="css/login.css"></link>
        <title>Admin Panel</title>
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
                <h3>Admin Panel</h3>
			
            </div>

            <ul class="list-unstyled components">
                <p style = "font-size:15px;">Welcome : <?php echo $id ?></p>
                <li class="active">
                    <a href="home.php" aria-expanded="false">Home</a>
                    
                </li>
				
				<li>
					<a href="#centreSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Centres</a>
                    <ul class="collapse list-unstyled" id="centreSubmenu" style= "font-size:15px;">
                        <li>
                            <a href="Centre.php">Add Centre</a>
                        </li>
                        <li>
                            <a href="CentreInfo.php">Centre Details</a>
                        </li>
                    </ul>
				</li>
                <li>
                    <a href="#courseSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Courses</a>
                    <ul class="collapse list-unstyled" id="courseSubmenu" style= "font-size:15px;">
                        <li>
                            <a href="Course.php">Add Course</a>
                        </li>
                        <li>
                            <a href="CourseInfo.php">Course Details</a>
                        </li>
                    </ul>
                </li>
				<li>
                    <a href="#subjectSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Subjects</a>
                    <ul class="collapse list-unstyled" id="subjectSubmenu" style= "font-size:15px;">
                        <li>
                            <a href="Subject.php">Add Subject</a>
                        </li>
                        <li>
                            <a href="SubjectInfo.php">Subject Details</a>
                        </li>
                    </ul>
                </li>
				<li>
                    <a href="#enquirySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Enquiry</a>
                    <ul class="collapse list-unstyled" id="enquirySubmenu" style= "font-size:15px;">
                        <li>
                            <a href="StudentEnquiry.php">Add Enquiry</a>
                        </li>
                        <li>
                            <a href="EnquiryInfo.php">Enquiry Details</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#admissionSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Admission</a>
                    <ul class="collapse list-unstyled" id="admissionSubmenu" style= "font-size:15px;">
                        <li>
                            <a href="Admission.php">Add Admission</a>
                        </li>
                        <li>
                            <a href="AdmissionInfo.php">Admission Details</a>
                        </li>
                    </ul>
                </li>
				<li>
                    <a href="#feesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Fees Collection</a>
                    <ul class="collapse list-unstyled" id="feesSubmenu" style= "font-size:15px;">
                        <li>
                            <a href="Feescollection.php">Add Fees Collection</a>
                        </li>
                        <li>
                            <a href="FeescollectionInfo.php">Fees Collection Details</a>
                        </li>
                    </ul>
                </li>
				<li>
                    <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reports</a>
                    <ul class="collapse list-unstyled" id="reportSubmenu" style= "font-size:15px;">
                        <li>
                            <a href="StudentReport.php">Student Details Report</a>
                        </li>
						<li>
                            <a href="AdmissionReport.php">Admission Report</a>
                        </li>
                        <a href="#feereportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Fees Collections Reports</a>
						<ul class="collapse list-unstyled" id="feereportSubmenu" style= "font-size:15px;">
							<li>
								<a href="CentreFeeReport.php">Centre Wise</a>
							</li>
							<li>
								<a href="StudentFeeReport.php">Student Report</a>
							</li>
						</ul>
						<li>
                            <a href="EnquiryReport.php">Enquiry Report</a>
                        </li>
						<a href="#deureportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Fees Deus Reports</a>
						<ul class="collapse list-unstyled" id="deureportSubmenu" style= "font-size:15px;">
							<li>
								<a href="CentreDeuReport.php">Centre Wise</a>
							</li>
							<li>
								<a href="StudentDeuReport.php">Student Report</a>
							</li>
						</ul>
                    </ul>
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
					<?php 
					  }
					?>
				</nav>
				
				<div class="container" style = "margin-top: -50px;">
			
				<div class="tab-content">
					<div class="container-fluid">
                            <div class="row">
							   
                               <div class="col-sm-12" style = "margin-top: -10%; margin-left: 10%;">
									<h1 style = "Color: white; margin-bottom: 40px;"> Edit Centre : </h1>
									
									<div class="col-sm-6">
										<form action="CentreEdit.php?cen_id=<?php echo  $get_cen_ID?>" method="post" style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px;">
											<table>
												<tr>
													<td>
														<font style="color:White; margin-left:50px; font-family: Verdana;  margin-top:15px; font-size:17px;">Centre Name : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $centre_name;?>" type="text" id="centre_name" name="centre_name" required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;text-transform: uppercase;"></input>
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:33px; font-family: Verdana;  margin-top:15px; font-size:17px;">Centre Address : &nbsp;&nbsp;&nbsp;</font> 
														
														<textarea id="centre_address" name="centre_address"  required="true" style="font-size: 15px;height: 50px;padding-top: 0px;margin-top: 25px;width: 250px;"><?php echo $centre_address;?> </textarea>
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:55px; font-family: Verdana;  margin-top:15px; font-size:17px;">Centre State : &nbsp;&nbsp;&nbsp;</font> 
														<!--input type="dropdown" id="centre_state" name="centre_state"  required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;"-->		
															<select required="true" id="centre_state" name="centre_state" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																	<option><?php echo $centre_state;?></option>
																<?php
																	mysqli_select_db( $con,"state_master");

																	$sql = "SELECT state_name FROM state_master";
																	$result = mysqli_query($con, $sql);
																	if (mysqli_num_rows($result) > 0) {
																	// output data of each row
																	while($row = mysqli_fetch_assoc($result)) {
																		?>
																		
																		<option><?php echo  $row["state_name"]?></option>
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
														<font style="color:White; margin-left:35px; font-family: Verdana;  margin-top:15px; font-size:17px;">Centre Pincode : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $centre_pin;?>" type="text" id="centre_pin" name="centre_pin" pattern="[0-9]{6}" maxlength="6" required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;text-transform: uppercase;"><span style = "color:white;padding-left: 250px;">[Format: 999999]</span>
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:30px; font-family: Verdana;  margin-top:15px; font-size:17px;">Centre Location : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $centre_location;?>" type="text" id="centre_location" name="centre_location" required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;text-transform: uppercase;">
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:50px; font-family: Verdana;  margin-top:15px; font-size:17px;">Person Name : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $person_name;?>" type="text" id="person_name" name="person_name"  required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;text-transform: uppercase;">
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:34px; font-family: Verdana;  margin-top:15px; font-size:17px;">Person Contact : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $person_phone;?>" type="text" id="phone" name="phone"  pattern="[0-9]{10}" maxlength="10" required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;"><span style = "color:white;padding-left: 250px;">[Format: 9999999999]</span>
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:52px; font-family: Verdana;  margin-top:15px; font-size:17px;">Person Email : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $person_email;?>" type="email" id="email_address" name="email_address"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:13px; font-family: Verdana;  margin-top:15px; font-size:17px;">Person Username : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $user_name;?>" type="text" id="user_name" name="user_name" maxlength="8" required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
														
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:20px; font-family: Verdana;  margin-top:15px; font-size:17px;">Person Password : &nbsp;&nbsp;&nbsp;</font> 
														<input value ="<?php echo $user_password;?>" type="password" id="user_password" name="user_password" required="true" maxlength="8" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
														
													</td>
												</tr>
												<tr>
													<td>
														<input class="toggle btn btn-primary" type="submit" id="centre_sub" name = "centre_sub" value="Update" style="color:White; margin-left:220px; font-family: Verdana;  margin-top:35px; font-size:17px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
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