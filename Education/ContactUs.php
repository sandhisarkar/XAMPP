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
							   
                               <div class="col-sm-12" style = "margin-top:0%;">
									<h1 style = "Color: white; margin-bottom: 50px;"> Contact Us : </h1>
									
									<h1 style = "Color: #f57e42; margin-bottom: 10px;"><b>Nevaeh Technology Pvt. Ltd.</b></h1>
									<h3 style = "Color: white; margin-bottom: 10px;">DH-6/31, 02-362, New Town Action Area 1D, Rajarhat, Opposite to Unitech Building Gate 2,  Kolkata – 700156</h3>
									<h3 style = "Color: white; margin-bottom: 10px;">Phone : <a href="tel:+91 33 4014 5841">+91 33 4014 5841</a><br><span style ="padding-left: 68px;"><a href="tel:+91 33 4014 5821">+91 33 4014 5821</a></span><br><span style ="padding-left: 68px;"><a href="tel:+91 9836790920">+91 9836790920</a></span></h3>
									<h3 style = "Color: white; margin-bottom: 10px;"> Email : <a href="mailto:info.masc@nevaehtech.com"><u>info.masc@nevaehtech.com<u></a></h3>
									<h3 style = "Color: white; margin-bottom: 30px;"> Website : <a href="https://www.nevaehtech.com"><u>www.nevaehtech.com<u></a></h3>
									
									
								</div>
								<div class="col-sm-12" style = "margin-top:0%;">
									<marquee behavior="scroll" direction="left" scrollamount="10"><h1 style = "Color: white;">For More Enquiry,<a href="StudentEnquiry.php" style = "Color: white; margin-bottom: 10px; text-align: centre;">&nbsp;<u>Contact Here</u></a></h1></marquee>
									
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