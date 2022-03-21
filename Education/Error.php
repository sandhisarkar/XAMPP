<?php

    session_start();
    error_reporting(0);

$con=mysqli_connect("localhost","root","root","demo");

$msgNav = "";

$cen_location = $_GET["cen_location"];
$cen_name = $_GET["cen_name"];


?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link type="text/css" rel="stylesheet" href="css/login.css"></link>
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
							<ul class="nav navbar-nav ml-auto">
								
									<div class='speech-bubble' style = "position: relative;margin: .5em auto; padding: 1em;  width: 10em; height: 4em;  border-radius: .25em; background: transparent;  font: 2em/4 Century Gothic, Verdana, sans-serif;  text-align: center;">
										<h1><?php  echo $msgNav ?></h1>
									</div>
								
									
							</ul>
						</div>
						<img src="images/output-onlinepngtools.png"  title="logo" alt="logo" style = "width:180px; height:120px;">
					</div>
					
				</nav>
				
				<div class="container" style = "margin-top: -3%;">
			
				<div class="tab-content">
					<div class="container-fluid">
                            <div class="row">
							   
                                <div class="col-sm-12" style = "margin-top: 5%; margin-left: 0%;">
									
									<h1 style = "Color: white; margin-bottom: 40px;">  </h1>
									<div class="col-sm-12" style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px;padding-top: 50px;padding-buttom: 50px;">
										<h1 style = "Color: white; text-align: center;font-size: xx-large;margin-bottom: 50px;">  Submission Error,&nbsp;<span> Please Try Again !</span>  </h1>
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





