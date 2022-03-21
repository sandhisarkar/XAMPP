<?php

    session_start();
    error_reporting(0);

$con=mysqli_connect("localhost","root","root","demo");



   

?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NTPL Education Portal</title>
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
		 
		<!-- Favicons -->
		<link href="images/xyz.png" rel="icon">
		<link href="images/xyz.png" rel="apple-touch-icon">
			
    </head>
    <body style="background-image:url(./images/03.jpg) ">
        
        
			
          
		 <div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Education Panel</h3>
			
            </div>

            <ul class="list-unstyled components">
                <p style = "font-size:15px;"></p>
                <li class="active">
                    <a href="home.php" aria-expanded="false">Home</a>
                    
                </li>
				
				<li>
                    <a href="About.php">About Us</a>
                </li>
				
				
				
				<li>
                    <a href="CourseOffered.php">Course Details</a>
                </li>
				
				
				<li>
                    <a href="ContactUs.php">Contact Us</a>
                </li>
				
				<li>
                    <a href="Centre">Login</a>
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
							
						</div>
						<img src="images/output-onlinepngtools.png"  title="logo" alt="logo" style = "width:180px; height:120px;">
					</div>
				</nav>
				
				<div class="container">
			
				<div class="tab-content">
					<div class="container-fluid">
                            <div class="row">
							   
                               <div class="col-sm-12" style = "margin-top:-10%;">
									<h1 style = "Color: white; margin-bottom: 30px;"> Course Offered : </h1>
									
									<h3 style ="text-align: justify;Color: white;font-size:17px; padding-bottom: 10px;"> The Course offered by MASC will cover the entire syllabus of Pure Science stream for students of class XI and XII. The Course will provide quality education in a comprehensive manner and the prescribed text book of WB HS Council will be followed.</h3>
									<h3 style ="text-align: justify;Color: white;font-size:17px;"><u>7 Science Subjects : </u></h3>
									<table style="width:100%; font-size: larger; margin-top: 1%;margin-bottom: 1%;">
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<th style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;">Sl No.<th>
											<th style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;">Subject<th>
										</tr>
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<td style = "text-align: center; border-radius:5px; color: white;">1<td>
											<td style = "text-align: center; border-radius:5px; color: white;">Math [3]<td>
										</tr>
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<td style = "text-align: center; border-radius:5px; color: white;">2<td>
											<td style = "text-align: center; border-radius:5px; color: white;">Chemistry [2] <td>
										</tr>
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<td style = "text-align: center; border-radius:5px; color: white;">3<td>
											<td style = "text-align: center; border-radius:5px; color: white;">Biology [2] <td>
										</tr>
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<td style = "text-align: center; border-radius:5px; color: white;">4<td>
											<td style = "text-align: center; border-radius:5px; color: white;">Computer science & application [3] <td>
										</tr>
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<td style = "text-align: center; border-radius:5px; color: white;">5<td>
											<td style = "text-align: center; border-radius:5px; color: white;">Physics [1]<td>
										</tr>
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<td style = "text-align: center; border-radius:5px; color: white;">6<td>
											<td style = "text-align: center; border-radius:5px; color: white;">Bengali [3]<td>
										</tr>
										<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999; color: white;font-size: large;">
											<td style = "text-align: center; border-radius:5px; color: white;">7<td>
											<td style = "text-align: center; border-radius:5px; color: white;">English [3]<td>
										</tr>
									</table>
									
									<h3 style = "Color: white; "> <b>NOTE : </b></h3>
									<ul style = "Color: white; font-size: 12px;">
										<li>Numbers in the bracket indicates that the concerned subject is also included in other Science Streams [there are 3 Science streams viz. Pure Science, Bio Science and Eco Science].</li>
										<li>Three Skill building subjects are: [1] Personal Selling, [2] Computer Programming and [3] Starting a New Entrepreneurial Venture.</li>
									</ul>
								</div>
								<div class="col-sm-12" style = "margin-top:0%;">
									<h1 style = "Color: white; margin-bottom: 10px;"> <u>Programme Details : </u></h1>
									<ul style = "Color: white;font-size:14px">
										<li>MASC will teach all Science subjects covered in the Higher Secondary Board and the prescribed text book s of WB HS Council will be followed.</li>
										<li>The classes will be conducted beyond school hours and will have one class of 2 hours per day dealing with one HS subject each day and 1 hour of pre-class Practice Problem Solving Sessions.</li>
										<li>On completion of formal session student will be given free training for next 6 weeks in 3 areas to help them start working, if required, immediately after passing Class XII HS Exam.</li>
										<h3 style = "color:white;font-size: 15px;padding-top: 10px;">These 3 areas will be: [a] Personal Selling, [b] Basic Computer Programming and [c] Starting One’s Own Business.</h3>
									</ul>
							    </div>
								<div class="col-sm-12" style = "margin-top:1%;">
									<h1 style = "Color: white; margin-bottom: 10px;"> <u>Evaluation : </u></h1>
									<ul style = "Color: white;font-size:14px">
										<li>Ensuring regular exercises by setting quality PPSS questions, checking out answers ,  sharing the right answers to the students for each module as per HS standards and identify the mistakes and guiding them in the correct path.</li>
										<li>Conducting mock tests following the exact pattern of HS Examination, and sharing the results with the students as well with the parents for better understanding of the progress and learning capability of the student.</li>			
									</ul>
								</div>
								<div class="col-sm-12" style = "margin-top:1%;">
									<h1 style = "Color: white; margin-bottom: 10px;"> <u>Eligibility : </u></h1>
									<ul style = "Color: white;font-size:14px">
										<li>Aspirant must be a regular student of a school opting for Science stream. </li>
									</ul>
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