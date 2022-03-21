<?php

    session_start();
    error_reporting(0);

$con=mysqli_connect("localhost","root","root","demo");
$q=mysqli_query($con,"select s_name from admin_user_data where s_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['s_name'];
$id=$_SESSION['user'];
$msgNav = "";

	$cen_location = $_GET["cen_location"];
	
	$cen_name = $_GET["cen_name"];
	$stu_id = $_GET["stu_id"];
	

	 chdir("..");
	 
	$status = "Document Upload";
	
	$created_date = date("Y-m-d");
	
	$picpath="Admin/documents/photo/".$stu_id."/";
	if(!is_dir($picpath))
	{
		mkdir($picpath,"0777",true);
	}
	else
	{
		$picpath="Admin/documents/photo/".$stu_id."/";
		
		$files = glob($picpath.'/*');  
   
		// Deleting all the files in the list 
		foreach($files as $file) { 
		   
			if(is_file($file))  
			
				// Delete the given file 
				unlink($file);  
		} 
	}
	$markpath ="Admin/documents/marksheet/".$stu_id."/";
	if(!is_dir($markpath))
	{
		mkdir($markpath,"0777",true);
	}
	else
	{
		$markpath ="Admin/documents/marksheet/".$stu_id."/";
		
		$files = glob($markpath.'/*');  
   
		// Deleting all the files in the list 
		foreach($files as $file) { 
		   
			if(is_file($file))  
			
				// Delete the given file 
				unlink($file);  
		} 
	}
	$docpath="Admin/documents/admission_proof/".$stu_id."/";
	
	if(!is_dir($docpath))
	{
		mkdir($docpath,"0777",true);
	}
	else
	{
		$docpath="Admin/documents/admission_proof/".$stu_id."/";
		
		$files = glob($docpath.'/*');  
   
		// Deleting all the files in the list 
		foreach($files as $file) { 
		   
			if(is_file($file))  
			
				// Delete the given file 
				unlink($file);  
		} 
	}
	$proofpath="Admin/documents/id_proof/".$stu_id."/";
	if(!is_dir($proofpath))
	{
		mkdir($proofpath,"0777",true);
	}
	else
	{
		$proofpath="Admin/documents/id_proof/".$stu_id."/";
		
		$files = glob($proofpath.'/*');  
   
		// Deleting all the files in the list 
		foreach($files as $file) { 
		   
			if(is_file($file))  
			
				// Delete the given file 
				unlink($file);  
		} 
	}
	
	
	
	$picpath=$picpath.$_FILES['photo_upload']['name'];
	$markpath=$markpath.$_FILES['marksheet_upload']['name'];
	$docpath=$docpath.$_FILES['admission_document_upload']['name'];     	    
	$proofpath=$proofpath.$_FILES['id_proof_upload']['name']; 
	
	if(move_uploaded_file($_FILES['photo_upload']['tmp_name'],$picpath)
	  && move_uploaded_file($_FILES['marksheet_upload']['tmp_name'],$markpath)
	  && move_uploaded_file($_FILES['admission_document_upload']['tmp_name'],$docpath)
	  && move_uploaded_file($_FILES['id_proof_upload']['tmp_name'],$proofpath)
	  )
	{
		$img=$_FILES['photo_upload']['name'];
		$img1=$_FILES['marksheet_upload']['name'];
		$img2=$_FILES['admission_document_upload']['name'];
		$img3=$_FILES['id_proof_upload']['name'];
		
	}
	
	
	 mysqli_select_db( $con,"admission_details");
	
	 $sql="UPDATE admission_details SET photo_upload='".$picpath."',marksheet_upload = '".$markpath."',admission_document_upload='".$docpath."',id_proof_upload='".$proofpath."',status='".$status."',created_dttm='".$created_date."' WHERE student_id='".$stu_id."'";

	if (!mysqli_query($con,$sql))
	{
	  //die('Error: ' . mysqli_error());
	  //$msgNav = "Error in updating the Subject";
    }
	else
	{
	  //echo "1 record added";
	  //$msgNav = "Subject is updated successfully";
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

						<button type="button" id="sidebarCollapse" class="navbar-btn" style ="margin-left: -30px;">
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
				
				<div class="container" style = "margin-top: -3%;">
			
				<div class="tab-content">
					<div class="container-fluid">
                            <div class="row">
							   
                               <div class="col-sm-12" style = "margin-top: 0%; margin-left: -5%;">
									<h1 style = "Color: white; margin-bottom: 40px;"> Admission : </h1>
										<form action="Step9.php?stu_id=<?php echo  $stu_id?>" method="post" enctype="multipart/form-data">
											
											<div class="col-sm-8" style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; margin-left: 50px;">
												<table>
												<tr>
													<td><p style = "color:white;margin-top: 5px;"><u>Course & Class Selection</u></p></td>
												</tr>
												
												<tr>
													<td>
														<font style="color:White; margin-left:150px; font-family: Verdana;  margin-top:15px; font-size:17px;">Course : &nbsp;&nbsp;&nbsp;</font> 
														<!--input type="dropdown" id="centre_state" name="centre_state"  required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;"-->		
															<select required="true" id="course_name" name="course_name" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 0px;width: 250px;">
																	<option selected value="" disabled>Select any course</option>
																<?php
																	mysqli_select_db( $con,"course_details");

																	$sql = "SELECT course_name FROM course_details";
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
														<font style="color:White; margin-left:44px; font-family: Verdana;  margin-top:15px; font-size:17px;">Admission for Class : &nbsp;&nbsp;&nbsp;</font> 
														<select required="true" id="class_for" name="class_for" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																<option selected value="" disabled>Select Any </option>
																<?php
																	mysqli_select_db( $con,"class_master");

																	$sql = "SELECT class_name FROM class_master";
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
														<font style="color:White; margin-left: 50px; font-family: Verdana;  margin-top:15px; font-size:17px;">Start Date : &nbsp;</font> 
														<input required="true" type="date" id="ad_start_date" name="ad_start_date"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 40px;width: 150px;text-transform: uppercase;">
														<font style="color:White; margin-left: 45px; font-family: Verdana;  margin-top:15px; font-size:17px;">End Date : &nbsp;</font> 
														<input required="true" type="date" id="ad_end_date" name="ad_end_date"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 40px;width: 150px;text-transform: uppercase;">
													</td>
												</tr>
												
												<tr>
													<td>
														<font style="color:White; margin-left:66px; font-family: Verdana;  margin-top:15px; font-size:17px;">Discount Percent : &nbsp;&nbsp;&nbsp;</font> 
														<input required = "true" min="0" max="25" type="number" id="dis" name="dis"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 15px;width: 250px;margin-bottom: 14px;">
														
													</td>
												</tr>
												<tr>
														<td>
															<input class="toggle btn btn-primary" type="submit" id="centre_sub" name = "centre_sub" value="Save & Continue" style="color:White; margin-left:260px; font-family: Verdana;  margin-top:15px; font-size:17px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
														</td>
										    	</tr>
												
												</table>
												</div>
											
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





