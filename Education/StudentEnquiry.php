<?php

    session_start();
    error_reporting(0);

$con=mysqli_connect("localhost","root","root","demo");

$msgNav = "";



if(isset($_POST["centre_sea"]))
{
	$centre_name = $_POST['centre_name'];
	$centre_location = $_POST['centre_location'];
	
	
	/*$q1=mysqli_query($con,"select cen_address,cen_state,cen_pin,per_name,per_phone,per_email_address from centre_details where cen_name ='".$centre_name."' and cen_location = '".$centre_location."'");
	$n1=  mysqli_fetch_assoc($q1);
	
	$centre_address = $n1['cen_address'];
	$centre_state = $n1['cen_state'];
	$centre_pin = $n1['cen_pin'];
	$person_name = $n1['per_name'];
	$person_phone = $n1['per_phone'];
	$person_email = $n1['per_email_address'];*/
}
   

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
							   
                               <div class="col-sm-12" style = "margin-top: -5%; margin-left: -5%;">
									<h1 style = "Color: white; margin-bottom: 40px;"> Search for Centres : </h1>
									
										<div class="col-sm-7" style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; margin-left: 225px;">
											<form action="StudentEnquiry.php" method="post">
											<table>
												
												
												
												<tr>
													<td>
														<font style="color:White; margin-left:70px; font-family: Verdana;  margin-top:15px; font-size:17px;">Centre Location : &nbsp;&nbsp;&nbsp;</font> 
														<!--input type="dropdown" id="centre_state" name="centre_state"  required="true" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;"-->		
															<select required="true" id="centre_location" onChange = getName(this.value); name="centre_location" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																<option disabled selected value = "">Select Location</option>
																<?php
																	mysqli_select_db( $con,"course_details");

																	$sql = "SELECT DISTINCT cen_location FROM centre_details";
																	$result = mysqli_query($con, $sql);
																	if (mysqli_num_rows($result) > 0) {
																	// output data of each row
																	while($row = mysqli_fetch_assoc($result)) {
																		?>
																		<option><?php echo  $row["cen_location"]?></option>
																		<?php
																	}
																} else {
																	 echo  "";
																}
																?>
																
															</select>
													</td>
												</tr>
												
												
												
												<tr>
													<td>
														<font style="color:White; margin-left:92px; font-family: Verdana;  margin-top:15px; font-size:17px;">Centre Name : &nbsp;&nbsp;&nbsp;</font> 
														<select required="true" id="centre_name" name="centre_name" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
																
															<option value ="" disabled selected>Select Centre</option>
																
														</select>
													</td>
												</tr>
												
												
												
												<tr>
													<td>
														<input class="toggle btn btn-primary" type="submit" id="centre_sea" name = "centre_sea" value="Search" style="color:White; margin-left:260px; font-family: Verdana;  margin-top:15px; font-size:17px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
													</td>
												</tr>
												
											</table>
											</form>
											</div>
									
									<div class="col-sm-12">
											
											<table style="width:100%; font-size: larger; margin-top: 0%;">
												<p style = "color:white;padding-top: 5%;font-size: large;">Centre Details</p>
												<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;font-size: large;">
													
													<th style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;">Centre Name</th>
													<th style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;">Centre Location</th> 
													<th style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;">Address</th>
													
													<th style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;">Contact</th>
													<th style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white;">Centre Email</th>
													
												</tr>
												<?php
															mysqli_select_db( $con,"centre_details");

															$sql = "SELECT cen_name,cen_location,cen_address,per_phone,per_email_address FROM centre_details where cen_location = '".$centre_location."' and cen_name= '".$centre_name."'";
															$result = mysqli_query($con, $sql);
															$cenID = "";
															if (mysqli_num_rows($result) > 0) {
																// output data of each row
																while($row = mysqli_fetch_assoc($result)) {
																	?>
																	<tr style = "text-align: center; box-shadow: 0px 0px 14px #999999;border-radius:5px; color: white; font-size: 20px;">
																	<td style = "padding: 5px;"><?php echo  $row["cen_name"]?></td>
																	<td style = "padding: 5px;"><?php echo  $row["cen_location"]?></td>
																	<td style = "padding: 5px;"><?php echo  $row["cen_address"]?></td>
																	<td style = "padding: 5px;"><?php echo  $row["per_phone"]?></td>
																	<td style = "padding: 5px;"><?php echo  $row["per_email_address"]?></td>
																	<td style = "padding: 5px;"><a href="Contact.php?cen_name=<?php echo  $row["cen_name"]?>&cen_location=<?php echo  $row["cen_location"]?>">Contact Us<i class="fas fa-address-book" style="font-size:25px"></i></a></td>
																	
																	</tr>
																	
																	<?php
																}
															} else {
																?>
																<tr style = "text-align: center;border-radius:5px; color: white; font-size: 20px;"> 
																
																 <td></td>
																 <td></td>
																 <td style = "padding-top: 5%;"><?php echo "Search Result Not Found"; ?></td>
																 <td></td>
																 <td></td>
																 
																 </tr><?php
															}
														?>
												
											</table>
										
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
		 <script src="https://code.jquery.com/jquery-2.1.1.min.js"   type="text/javascript"></script>
       
		 <script>
			function getName(val)
			{
				$.ajax({
					type: "POST",
					url: "Enquiry.php",
					data: 'cen_location='+val,

					success: function(data)
					{
						$("#centre_name").html(data);
					}
				});
			}
			
			
		</script>
		
		
					
    </body>
</html>
<?php
session_start();

$con=mysqli_connect("localhost","root","root","demo");
if(!isset($con))
{
    die("Database Not Found");
}

if(!empty($_REQUEST["cen_location"])) {

    $query ="SELECT cen_name FROM centre_details WHERE cen_location = '" . $_POST["cen_location"]  ."'";
    
	
    $result = mysqli_query($con, $query);
	?>
    <option disabled selected value="">Select Centre</option>

<?php
    while($row2=mysqli_fetch_assoc($result)){
		?>
        //var_dump($row2);
       
            <option><?php echo     $row2['cen_name']; ?>  </option>
<?php
         }
     }
    
	
?>





