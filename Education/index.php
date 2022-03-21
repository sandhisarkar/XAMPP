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
						<!--marquee behavior="alternate"-->
						<img src="images/output-onlinepngtools.png"  title="logo" alt="logo" style = "width:180px; height:120px;">
						<!--/marquee-->
					</div>
				</nav>
				
				<div class="container">
			
				<div class="tab-content">
					<div class="container-fluid">
                            <div class="row">
							   
                                <div class="col-sm-12" style = "margin-top:-10%;">
									<h1 style = "Color: white; margin-bottom: 20px;"> Home : </h1>
									<h1 style ="text-align: left;Color: white;font-size:25px;"> MODEL ACADEMIC SUPPORT CENTRE </h1>
									<h2 style ="text-align: left;Color: white;font-size:20px;"> <b>Smart Education │Economic Empowerment </b></h2>
									<h3 style ="text-align: left;Color: white;font-size:15px;"> A Joint Initiative of <b>Nevaeh Technology & The Next Ideation </b></h3>
								</div>
								<div class="col-sm-12" style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px;padding-top: 20px;padding-buttom: 20px;margin-top: 20px;">
										<marquee behavior="scroll" direction="left" scrollamount="8"><h1 style = "Color: white; text-align: center;font-size: 15px;margin-bottom: 0px;"> “A country’s problems – be it poverty, economic, socio- cultural, racism or  intolerance to differing views– cannot be overcome without making available quality education support  to students at primary, secondary and higher secondary level, particularly those who are denied opportunities to learn for reasons not in their hand. Quality education here means focus on acquisition of true knowledge and associated values and not the type – promoted in recent times on commercial basis – for learning how to use ‘short cuts’ supposedly required to crack high profile competitive examinations. To deliver value based quality education, we do not need to wait for the government to reform education system nor is there any need for huge upfront investment. It is indeed possible to connect subject matter experts [such as teachers, professors and trainers] from different locations to disadvantaged students in different areas of the country inexpensively and on real time basis by leveraging digital infrastructure that is already available widely and by eliminating all non-value adding investments and expenses. All we need is a vision and a desire to drive change at the grass root level without waiting for the government to act. Add to that a bit of innovation to “connect the dots” to make available academic support that will complement as well as strengthen existing education system. It is only through this way we will be able to achieve true democratization of knowledge and empower the underprivileged.”</h1></marquee>

										<marquee behavior="scroll" direction="up" scrollamount="1"><h1 style = "Color: white; text-align: center;font-size: 20px;"><b>Prof: Ranjan Das, Chairman – the Next Ideation and the Strategy Academy and Prof of Strategic Management at IIM Calcutta [Full time: 1994-2014; Visiting: 2014 onwards]<b></h1></marquee>
								</div>
								<div class="col-sm-12" style = "border-radius:5px;padding-top: 20px;padding-buttom: 20px;margin-top: 20px;">
										<h1 style = "Color: white;font-size: 15px;margin-bottom: 10px;">MASC incorporates the concept of providing an environment for every employee that encourages and fosters empowerment, professional and financial growth, entrepreneurial and technical freedom and operational objectivity. </h1>
										<h1 style = "Color: white;font-size: 15px;margin-bottom: 10px;">MASC moves ahead of others by providing a holistic learning experience to students using the modern technology to fully prepare them for a fast-changing world. The experienced faculty trains the students by using state-of-the-art technology, which further helps the students to prepare for tomorrow. The learning method offered by MASC allows students to interact with others and becoming economically empowered for the future.</h1>
										<h1 style = "Color: white;font-size: 15px;margin-bottom: 10px;">To stay ahead of the league, join MASC now. </h1>
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