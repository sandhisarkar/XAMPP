<?php

    session_start();
    error_reporting(0);

$con=mysqli_connect("localhost","root","root","demo");
$q=mysqli_query($con,"select cen_id from centre_details where cen_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['cen_id'];
$id=$_SESSION['user'];
$msgNav = "";

$sta=mysqli_query($con,"select cen_id,user_name,cen_name from centre_details where cen_id='".$_SESSION['user']."'");
$stat=  mysqli_fetch_assoc($sta);
$stcen_id = $stat['cen_id'];
$cen_name = $stat["cen_name"];
$cen_per = $stat["user_name"];


	$get_stu_ID = $_GET["student_id"];
	

	$q1=mysqli_query($con,"select past_board,eng_marks,ls_marks,ps_marks,math_marks,past_edu_agg from admission_details where student_id='".$get_stu_ID."'");
	$n1=  mysqli_fetch_assoc($q1);
	 
	$past_board = $n1['past_board']; 
	$eng_marks = $n1['eng_marks']; 
	$ls_marks = $n1['ls_marks']; 
	$ps_marks = $n1['ps_marks'];
	$math_marks = $n1['math_marks']; 	
	$past_edu_agg = $n1['past_edu_agg'];
	
	$modified_date = date("Y-m-d");
	
	$student_phone = $_POST['student_phone'];
	$student_email = $_POST['student_email'];
	$gur_phone = $_POST['gur_phone'];
	
	$status = "Contact Info";
	
	 mysqli_select_db( $con,"admission_details");
	
	 $sql="UPDATE admission_details SET student_phone='".$student_phone."',student_email = '".$student_email."',gur_phone='".$gur_phone."',status= '".$status."',modified_dttm='".$modified_date."' WHERE student_id='".$get_stu_ID."'";

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
	 

$result = mysqli_query($con,"SELECT * FROM centre_details WHERE cen_id='".$_SESSION['user']."'");
                    
                    while($row = mysqli_fetch_array($result))
                      {
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link type="text/css" rel="stylesheet" href="css/login.css"></link>
        <title>NTPL Education Panel</title>
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
                <h3>Centre Panel</h3>
				<p style = "font-size:13px; color:white;">(Welcome to : <?php echo $cen_name ?>)</p>
            </div>

            <ul class="list-unstyled components">
                <p style = "font-size:15px;">Welcome User : <?php echo $cen_per ?></p>
                <li class="active">
                    <a href="home.php" aria-expanded="false">Home</a>
                    
                </li>
				
				
				<li>
                    <a href="#enquirySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Enquiry</a>
                    <ul class="collapse list-unstyled" id="enquirySubmenu" style= "font-size:15px;">
                        <li>
                            <a href="Contact.php">Add Enquiry</a>
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
                            <a href="Step1.php">Add Admission</a>
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
										<form action="Step5Edit.php?student_id=<?php echo  $get_stu_ID?>" method="post">
										
										<div class="col-sm-6" style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; margin-left: 50px;">
												<table>
												
												<tr>
													<td><p style = "color:white;"><u>Past Educational Information</u></p></td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:25px; font-family: Verdana;  margin-top:15px; font-size:17px;">Board in Class 10 : &nbsp;&nbsp;&nbsp;</font> 
														<input value = "<?php echo $past_board?>" required = "true" type="text" id="past_board" name="past_board"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 15px;width: 250px;">
														
													</td>
												</tr>
												<tr>
													<td>
													<p style="color:white;margin-top: 20px;">(Marks:)</p>
													</td>
												</tr>
												<tr>
													<td>
														<font style="color:White; margin-left:100px; font-family: Verdana;  margin-top:15px; font-size:17px;">Marks in English : &nbsp;</font> 
														<input value ="<?php echo $eng_marks?>" required = "true" maxlength="3" min="0" max="100" type="number" id="eng_marks" name="eng_marks"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 15px;width: 100px;">
														
														
													</td>
												</tr>
												<tr>
													<td>
														
														<font style="color:White; margin-left:61px; font-family: Verdana;  margin-top:15px; font-size:17px;">Marks in Life Science : &nbsp;</font> 
														<input value ="<?php echo $ls_marks?>" required = "true" maxlength="3" min="0" max="100" type="number" id="ls_marks" name="ls_marks"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 15px;width: 100px;">
														
													</td>
												</tr>
												
												<tr>
													<td>
														<font style="color:White; margin-left:24px; font-family: Verdana;  margin-top:15px; font-size:17px;">Marks in Physical Science : &nbsp;</font> 
														<input value ="<?php echo $ps_marks?>" required = "true" maxlength="3" min="0" max="100" type="number" id="ps_marks" name="ps_marks"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 15px;width: 100px;">
														
													</td>
												</tr>
												
												<tr>
													<td>
														
														<font style="color:White; margin-left:56px; font-family: Verdana;  margin-top:15px; font-size:17px;">Marks in Mathematics : &nbsp;</font> 
														<input value ="<?php echo $math_marks?>" required = "true" maxlength="3" min="0" max="100" type="number" id="math_marks" name="math_marks"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 15px;width: 100px;">
														
													</td>
												</tr>
												
												<tr>
													<td>
														<font style="color:White; margin-left: 155px; font-family: Verdana;  margin-top:15px; font-size:17px;">Aggregate : &nbsp;</font> 
														<input value ="<?php echo $past_edu_agg?>" required = "true" type="number" min="0" max="100" step="any" id="agg" name="agg"  style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 15px;width: 100px;"><span style = "color:white;padding-left: 10px;">Percentage(%)</span>
														
													</td>
												</tr>
												
												<tr>
													<td style ="padding-bottom: 7px;">
														<p></p>
													</td>
												</tr>
												
												<tr>
														<td>
															<input class="toggle btn btn-primary" type="submit" id="centre_sub" name = "centre_sub" value="Save & Continue" style="color:White; margin-left:180px; font-family: Verdana;  margin-top:15px; font-size:17px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
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





