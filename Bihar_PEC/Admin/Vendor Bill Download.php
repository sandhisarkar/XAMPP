<?php

session_start();
error_reporting(0);
//header( "url=/Bihar_PEC/" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];
$error = "";
$success = "";

//echo $_POST["monthyear"];

if(isset($_POST["sub_excel"]))
{
	$monyear = $_POST["month_year"];
	$year = substr($monyear,0,4);
	$month = substr($monyear,5,2);
	
	$month_year = $month."-".$year;
	
	
	if($month == "01")
	{
		$date = 31;
	}
	if($month == "02" && $year%4 == 0)
	{
		$date = 29;
	}
	if($month == "02" && $year%4 != 0)
	{
		$date = 28;
	}
	if($month == "03")
	{
		$date = 31;
	}
	if($month == "04")
	{
		$date = 30;
	}
	if($month == "05")
	{
		$date = 31;
	}
	if($month == "06")
	{
		$date = 30;
	}
	if($month == "07")
	{
		$date = 31;
	}
	if($month == "08")
	{
		$date = 31;
	}
	if($month == "09")
	{
		$date = 30;
	}
	if($month == "10")
	{
		$date = 31;
	}
	if($month == "11")
	{
		$date = 30;
	}
	if($month == "12")
	{
		$date = 31;
	}
	
	$monyear = $year."-".$month."-".$date;
	
	$totaldays=cal_days_in_month(CAL_GREGORIAN,$month,$year);
	
	$month_yr = $_POST["month_year"];
	
	//$query = "select DISTINCT pf_doc, esi_doc from salary_month_details where month_year = '".$month_yr."' AND pf_esi_challan_status = 'Completed'";
	$q1=mysqli_query($con,"select DISTINCT vendor_doc from salary_month_details where month_year = '".$month_yr."' AND vendor_bill_status = 'Completed'");
	$n1=  mysqli_fetch_row($q1);
	//echo $query;
	$cus_bill_doc= $n1[0];
	
	//echo strlen($pf_doc);
	$cus_bill_doc = substr($cus_bill_doc,6,strlen($cus_bill_doc)-6);
	
	
	if($cus_bill_doc != null) 
	{
		$msgNav = "Success";
		
	}
	else
	{
		$msgNav = "Error";
	}
	
}



$result = mysqli_query($con,"SELECT * FROM admin_user WHERE admin_user='".$_SESSION['user']."'");
                    
                    while($row = mysqli_fetch_array($result))
                      {

?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Bihar PEC Admin Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link href="images/xyz.png" rel="icon">
		<link href="images/xyz.png" rel="apple-touch-icon">
		
		
			<!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  </head>
  <body>
  <script>
		function openModalForRecord() {
			//alert("test---->"+unId);
			//$("#txtSequenceId").val(unId);
			//alert($("#excel_file").val());
			 $("#MyFirstModalId").modal('show');
			 
		}
		</script>
		<?php  

			include 'usersession.php';

		?>
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only"></span>
	        </button>
        </div>
				<div class="p-4 pt-5">
				
		  		<h1><a onclick= "openOverlay()" href="/Bihar_PEC/Admin/" class="logo" style = "font-size: 25px;">Admin Panel</a></h1>
				<p>Username : &nbsp; <?php echo $stname;?></p>
	        <ul class="list-unstyled components mb-5">
	          <li>
	            <a onclick= "openOverlay()" href="/Bihar_PEC/Admin/">Home</a>
			  </li>
	          
	          <li>
              <a href="#CenSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Centre Details</a>
              <ul class="collapse list-unstyled" id="CenSubmenu">
                <li>
                    <a onclick= "openOverlay()" href="Centre.php">Excel Upload</a>
                </li>
                <li>
                    <a onclick= "openOverlay()" href="Centre Details.php">Centre Details</a>
                </li>
              </ul>
	          </li>
			  
	          <li>
              <a href="#VenSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Vendor Details</a>
			  <ul class="collapse list-unstyled" id="VenSubmenu">
                <li>
                    <a onclick= "openOverlay()" href="Vendor.php">Add New Vendor</a>
                </li>
                <li>
                    <a onclick= "openOverlay()" href="Vendor Details.php">Vendor Details</a>
                </li>
              </ul>
	          </li>
			  
	          <li>
              <a href="#OpSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Operator Details</a>
			  <ul class="collapse list-unstyled" id="OpSubmenu">
                <li>
                    <a onclick= "openOverlay()" href="Operator.php">Excel Upload</a>
                </li>
                <li>
                    <a onclick= "openOverlay()" href="Operator Details.php">Operator Details</a>
                </li>
              </ul>
	          </li>
			  
			<li>
              <a href="#MonAttSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Monthly Attendance</a>
			  <ul class="collapse list-unstyled" id="MonAttSubmenu">
                <li>
                    <a onclick= "openOverlay()" href="Attendence.php">Upload Attendance</a>
                </li>
				<li>
                    <a onclick= "openOverlay()" href="Attendence Document.php">Document Upload</a>
                </li>
				<li>
                    <a onclick= "openOverlay()" href="Verify Attendence.php">Verify Attendance</a>
                </li>
				<li>
                    <a onclick= "openOverlay()" href="Attendance Approval.php">Attendance Approval</a>
                </li>
				<li>
                    <a onclick= "openOverlay()" href="Salary Generate.php">Generate Salary</a>
                </li>
              </ul>
	          </li>
			  
			  
			<li>
			  <a href="#OpPaySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Operators Payment</a>
				  <ul class="collapse list-unstyled" id="OpPaySubmenu">
					
					<li>
						<a href="#OpPfEsiSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">PF/ESI Payment Advice</a>
							<ul class="collapse list-unstyled" id="OpPfEsiSubmenu">
								<li><a onclick= "openOverlay()" href="PF_ESI Report.php">Generate PF/ESI Payment Advice</a></li>
								<li><a onclick= "openOverlay()" href="PF_ESI Upload.php">Upload PF/ESI Payment Document</a></li>
								<li><a onclick= "openOverlay()" href="PF_ESI Download.php">Download PF/ESI Payment Document</a></li>
							</ul>
					</li>
					
					<li>
						<a href="#OpBankSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Bank Payment Advice</a>
							<ul class="collapse list-unstyled" id="OpBankSubmenu">
								<li><a onclick= "openOverlay()" href="Bank Approval.php">Approve Operator Salary Payment </a></li>
								<li><a onclick= "openOverlay()" href="Bank Advice Report.php">Generate Bank Payment Advice</a></li>	
								<li><a onclick= "openOverlay()" href="Bank Upload.php">Upload Bank Payment Document</a></li>
								<li><a onclick= "openOverlay()" href="Bank Download.php">Download Bank Payment Document</a></li>
							</ul>
					</li>
				  </ul>
			  </li>
			  
			  <li>
				<a href="#CusBillSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Neaveh Billing</a>
				<ul class="collapse list-unstyled" id="CusBillSubmenu">
					
					<li>
						<a href="#CusBillAdSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Neaveh Billing Advice</a>
						<ul class="collapse list-unstyled" id="CusBillAdSubmenu">
							<li><a onclick= "openOverlay()" href="Customer Bill Approval.php">Approve Invoice Generation</a></li>
							<li><a onclick= "openOverlay()" href="Customer Billing Report.php">Generate Nevaeh Billing Advice</a></li>
							<li><a onclick= "openOverlay()" href="Customer Bill Upload.php">Upload Customer Invoice</a></li>
							<li><a onclick= "openOverlay()" href="Customer Bill Download.php">Download Customer Invoice</a></li>
						</ul>
					</li>
				</ul>
			  </li>
			  
			  
			  
			  <li class="active">
				<a href="#VenBillSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Vendor Billing</a>
				<ul class="collapse list-unstyled" id="VenBillSubmenu">
					
					<li>
						<a href="#VenBillAdSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Vendor Billing Advice</a>
						<ul class="collapse list-unstyled" id="VenBillAdSubmenu">
							<li><a onclick= "openOverlay()" href="Vendor Billing Report.php">Generate Vendor Billing Advice</a></li>
							<li><a onclick= "openOverlay()" href="Vendor Bill Upload.php">Upload Vendor Invoice</a></li>
							<li><a onclick= "openOverlay()" href="Vendor Bill Approval.php">Approve Vendor Invoice</a></li>
							<li><a onclick= "openOverlay()" href="Vendor Bill Download.php">Download Vendor Invoice</a></li>
						</ul>
					</li>
				</ul>
			  </li>
			  
			  <li>
			  <a href="#BillDash" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Summary Status</a>
				  <ul class="collapse list-unstyled" id="BillDash">
					<li><a onclick= "openOverlay()" href="Operator Billing.php">Operators Payment Summary</a></li>
					<li><a onclick= "openOverlay()" href="Centre Billing.php">Customer Billing Summary</a></li>
					<li><a onclick= "openOverlay()" href="Vendor Billing.php">Vendor Billing Summary</a></li>
				  </ul>
			  </li>
			  
			  <li>
			  <a href="#ReportSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Reports</a>
				  <ul class="collapse list-unstyled" id="ReportSubmenu">
					<li><a onclick= "openOverlay()" href="PF_ESI.php">PF/ESI Payment Report</a></li>
					<li><a onclick= "openOverlay()" href="Salary.php">Operator Salary Payment Report</a></li>
					<li><a onclick= "openOverlay()" href="Bank Advice.php">Payment Disbursement Report</a></li>
					<li><a onclick= "openOverlay()" href="Customer Report.php">Customer Billing Report</a></li>
					<li><a onclick= "openOverlay()" href="Vendor Report.php">Vendor Billing Report</a></li>		
				  </ul>
			  </li>
			 
			  
			  <li>
	              <a onclick= "openOverlay()" href="logout.php">Logout</a>
	          </li>
	        </ul>

	        

	        <div class="footer">
	        	<p>
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> <br>All rights reserved <br><i class="fa fa-heart" style="color:red;"></i> Developed by <br><a onclick= "openOverlay()" href="mailto:sandhisarkar2@gmail.com?Subject =Contact from Website" target="_blank" style= "color: beige;">Sandhi Sarkar</a>
				</p>
				
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5" >
		
        <h2 class="mb-4"><u>Vendor Billing Invoice Download</u> (Monthly)</h2>
		
        <p>
			<div class="col-sm-12" style = "margin-top:5%;">
				
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					
					
					<center>
						
						
						<form  action = "Vendor Bill Download.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
							<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									
									
									<label style="margin-left: -5%;color: #495057;">Choose Month-Year : &nbsp; </label>
									<select required="true" id="month_year" name="month_year" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 300px;">
										<option disabled selected value = "">Select Any...</option>
										<?php
											//mysqli_select_db( $con,"course_details");

											$sql = "SELECT DISTINCT(month_year) FROM salary_month_details where vendor_bill_status  = 'Completed'";
											$result = mysqli_query($con, $sql);
											if (mysqli_num_rows($result) > 0) {
											// output data of each row
											while($row = mysqli_fetch_row($result)) {
												?>
												<option><?php echo  $row[0]?></option>
												<?php
											}
										} else {
											 echo  "";
										}
										?>
										
									</select></br></br>
									
									<button class="toggle btn btn-primary" onclick = "uploadme()" type="submit" id="sub_excel" name = "sub_excel"
									style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">Search <i class="fa fa-search"></i></button>
									
								</td>
							</tr>
							
							
							</table>
							
						</form>
						</center>
						
				</div>
				
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
				<section id="services" class="section" style="display:block;">
				<div class="row" style="margin-top: 5%;">
					<?php
						
						if($error == "" || $success == "")
						{
							
							echo '<label class="text-danger"></label>';
							
						}
						if($error == "Invalid File")
						{
							//header( "refresh:3;url=Attendence.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-danger">Invalid File . . . Please Select Correct File</label>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box">
								<h6><i class="fa fa-file text-warning"></i> Invalid File . . . Please Select Correct File</h6>
								
							  </div>
						  </div>
							<?php
						}
						
						if($error == "Select")
						{
							header( "refresh:3;url=Attendence.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-danger">Please Select Correct File</label>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box">
								<h6><i class="fa fa-file text-error"></i> Please Select Correct File</h6>
								
							  </div>
						  </div>
							<?php
						}
						if($msgNav == "Success")
						{
							header( "refresh:30;url=Attendence.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted</label>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box" >
								<h6><i class="fa fa-search text-info"></i> Showing Vendor Bill Invoice . . .  </i></h6>
								<h5>Month-Year : <u><b><?php  echo $month_yr;?></b></u> <i class="fa fa-calendar text-info"></i></h5>
								
							  </div>
						  </div>
						  <div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box" >
								<h6><i class="fa fa-file text-warning"></i> Download Vendor Bill Invoice . . .  </i></h6>
								<button class="btn btn-primary" style="background: green;"> <a href="<?php echo $cus_bill_doc;?>" style ="color: white;" download="Vendor_Bill_Advice_<?php echo $month_yr;?>.pdf">Download <i class="fa fa-download" style ="color: white;"></i></a></button>
							  </div>
						  </div>
						  
						  <?php
							//echo $output;
							
						}
						if($msg == "Exists"  )
						{
							//&& $success == "No Update"
							header( "refresh:5;url=Attendence.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-warning">Attendance already been submitted for Month-Year : '.$month.'-'.$year.'</label>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box" >
								<h6> Attendance already been submitted for Month-Year : <u><?php echo $month; ?> - <?php echo $year; ?></u> <i class="fa fa-calendar text-success"></i></h6>
								
							  </div>
						  </div>
							
							<?php
						}
						if($success == "No Update" && $msg != "Exists" && $msg != "Not in Operator")
						{
							header( "refresh:3;url=Attendence.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted</label>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box">
								<h6><i class="fa fa-file text-success"></i> File Uploaded Successfully . . .  <?php echo $count; ?> Rows Inserted</h6>
								
							  </div>
						  </div>
						  <?php
							header( "refresh:3;url=Attendence.php" );
						}
						if($msg == "Not in Operator")
						{
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-warning">Operator ID : '.$opid.' Not Found... Please Add this Operator ID</label></br>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box">
								<h6 class="title" style="margin:0%;text-align: center;"><i class="fa fa-user text-warning"></i> Operator ID : <u>(<?php echo $opid ?> )</u> Not Found . . . Please Add this Operator ID</h6>
								
							  </div>
						  </div>
						  <?php
						}
						
					?>
				</div>
				</section>
				</div>
				
			</div>
		</p>
        <p></p>
      </div>
	  <div id="overlay">	  
			<div class="load-icon center" style= "text-align:center;">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		
		<!-- Modal -->
		<div id="MyFirstModalId" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <h4 class="modal-title float-left">Delete Operator !</h4>
				<button type="button" class="close" data-dismiss="modal">X</button>
				
			  </div>
			  <div class="modal-body">
				<p>Hey ! Do you want to delete ?</p>
			  </div>
			  <div class="modal-footer">
			  <button type="submit" id = "excel_sub" class="btn btn-primary" data-dismiss="modal" onclick = "uploadme()">Confirm</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		
		<div class="displayNone"> 
		<input type="hidden"  id="txtSequenceId"/>
	  </div>
		
		</div>
	<?php 
	  }
	?>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
	<script>
		function on() {
		  document.getElementById("overlay").style.display = "block";
		}

		function off() {
		  document.getElementById("overlay").style.display = "none";
		}
		</script>
		<script language ="javascript">
		function uploadme()
		{
			
			var date = $("#month_year").val();		
			
			
			
			
			
			if(date !=="")
			{
				
				document.getElementById("overlay").style.display = "block";
				return true;
				
			}
			
			else
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			
			
		}
	</script>
	<script language ="javascript">
		function openOverlay()
		{
			
			document.getElementById("overlay").style.display = "block";
			//window.location.href = 'Operator.php';

				return true;
			//}
			//	document.getElementById("demo").innerHTML = txt;
			
		}
	</script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
       
		 
  </body>
</html>


