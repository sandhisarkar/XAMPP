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
						<img src="images/1.jpg"  title="logo" alt="logo" style = "width:125px; height:90px;">
					</div>
				</nav>
				
				<div class="container">
			
				<div class="tab-content">
					<div class="container-fluid">
                            <div class="row">
							   
                               <div class="col-sm-12" style = "margin-top:0%;">
									<h1 style = "Color: white; margin-bottom: 50px;"> Features List : </h1>
									
									<ul style= "color:white; font-size:17px;">
										<li style = "padding-bottom: 5px;">The Teachers provide cloud based real-time classroom academic support.</li>
										<li style = "padding-bottom: 5px;">Faculty comprises of a group of renowned and quality teachers who are best in the industry.</li>
										<li style = "padding-bottom: 5px;">Students are provided Technology enabled Smart Learning and Transformation Solution [SLTS].</li>
										<li style = "padding-bottom: 5px;">100% LIVE teaching over video and audio platform is offered to students.</li>
										<li style = "padding-bottom: 5px;">Students get the availability of recordings of LIVE sessions as and when needed.</li>
										<li style = "padding-bottom: 5px;">Students are encouraged to take active participation in class discussion using the reverse Video and Audio system.</li>
										<li style = "padding-bottom: 5px;">Students are provided convenient timing outside normal school hours.</li>
										<li style = "padding-bottom: 5px;">Mandated Practice Problem Solving Sessions [PPSS] prior to each class conducted by teachers.</li>
										<li style = "padding-bottom: 5px;">Evaluation of students learning ability is conducted by organizing Mock Tests following the pattern of Higher Secondary Examination, and sharing the results.</li>
										<li style = "padding-bottom: 5px;">MASC shares the student attendance record and various submissions, progress report with the parents on regular interval.</li>
										<li style = "padding-bottom: 5px;">Students are provided a detailed scheduling of sessions with date and time, for the entire 2 year period of the course.</li>
										<li style = "padding-bottom: 5px;">Affordable price package.</li>
										<li style = "padding-bottom: 5px;">Free basic career training in essential 3 areas to help the students develop their employability immediately after passing Class XII HS Examination.</li>
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