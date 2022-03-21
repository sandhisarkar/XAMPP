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
	
	if(!empty($_FILES["excel_file"]))
	{
		if($_FILES["excel_file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $_FILES["excel_file"]["type"] == "application/vnd.ms-excel")
		{
			include("Classes/PHPExcel/IOFactoty.php");
			require_once 'Classes/PHPExcel.php';
			$output .="
				<table class='table table-hover table-bordered table-striped' border ='1' width='100%' style = 'text-align: center; overflow-x:auto;font-size: x-small;'>
					<thead class='thead-dark'>
					<tr>
						<th style = 'padding:auto;'>District Name</th>
						<th style = 'padding:auto;'>Operator ID</th>
						<th style = 'padding:auto;'>Operator Name</th>
						<th style = 'padding:auto;'>Month-Year</th>
						<th style = 'padding:auto;'>Total Days in Month</th>
						<th style = 'padding:auto;'>Working Days in Month</th>
						<th style = 'padding:auto;'>Hold Amount</th>
						<th style = 'padding:auto;'>Hold Reason</th>
					</tr>
					</thead>
			";
			
			$object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);
			$object ->setActiveSheetIndex(0);
			
			$query1 = mysqli_query($con, "SELECT Count(*) FROM monthly_attendence where  month_year = '".$month_year."' ");
			$result1=mysqli_fetch_row($query1);
			$cen_cou1= $result1[0];
			
			if($cen_cou1 == 0)
			{
				$msg = "Not Exists";
			}
			else
			{
				$msg = "Exists";
			}
			
			if($msg == "Not Exists")
			{
				//count define
				$count = 0;
				
				foreach($object -> getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					
					for($row =2; $row<= $highestRow; $row++)
					{
						//$district  = $worksheet->getActiveSheet()->getCell(B2)->getValue();
						$dist  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1,$row)->getValue());
						$opid  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2,$row)->getValue());
						$opname  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3,$row)->getValue());
						$workdays = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4,$row)->getValue());
						$holdamount = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5,$row)->getValue());
						$holdreason = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6,$row)->getValue());
						
						if($holdamount == null)
						{
							$holdamount = 0;
						}
						else
						{
							$holdamount = $holdamount;
						}
						// search from centre details 
						mysqli_select_db($con,"monthly_attendence");
						
						
						
							$query = mysqli_query($con, "SELECT Count(*) FROM monthly_attendence where operator_id = '".$opid."' AND month_year = '".$month_year."' ");
							$result=mysqli_fetch_row($query);
							$cen_cou = $result[0];
							
							if($cen_cou == 0)
							{
								$query1 = mysqli_query($con, "SELECT Count(*) FROM operator_profile where operator_id = '".$opid."' ");
								$result1 =mysqli_fetch_row($query1);
								$cen_cou1 = $result1[0];
								
								if($cen_cou1 == 0)
								{
									
									
									
									
									$sql="Delete from monthly_attendence where month_year = '".$month_year."'";

									if (!mysqli_query($con,$sql))
									{
								
										$msg = "Not in Operator";
									  
									}
									else
									{
										$msg = "Not in Operator";
									}
									
									break;
								}
								else
								{
											//checking max sl_no
										mysqli_select_db($con,"monthly_attendence");
										
										$query_sl = mysqli_query($con ,"select Count(*) from monthly_attendence where month_year = '".$month_year."'");
										$res=mysqli_fetch_row($query_sl);
										$tot = $res[0];
										
										
										
										if($tot == 0)
										{
											//increament count
											$slno =1;
										}
										else
										{
											//increament count
											$slno =$tot+1;
										}	
											
										// insert rows
										if($opid != null && $opname != null && $workdays != null && $dist != null)
										{
											$insert_sql="INSERT INTO monthly_attendence (sl_no,district_name,operator_id,operator_name,month_year,total_days_in_month,actual_working_days,hold_amount,hold_reason,status,created_dttm) VALUES ('".$slno."','".$dist."','".$opid."','".$opname."','".$month_year."','".$totaldays."','".$workdays."','".$holdamount."','".$holdreason."','Created','".$monyear."')";
											
											if (!mysqli_query($con,$insert_sql))
											{	  
												//header('location:Error.php');
											}
											else
											{
												//if row count greater than zero and inserted
												$output .= "
													<tbody>
													<tr>
														<td>$dist</td>
														<td>$opid</td>
														<td>$opname</td>
														<td>$month_year</td>
														<td>$totaldays</td>
														<td>$workdays</td>
														<td>$holdamount</td>
														<td>$holdreason</td>
													</tr>
													</tbody>
												";
												
												//increament count
												$count +=1;
											}
										}
								}
								
								
							}
							else
							{
								//$msg = "Exists";
								//echo $msg;
								//header( "refresh:5;url=Attendence.php" );
								//break;
							}
						
					}
					
				}
				if($count > 0)
				{
					$output .= '</table>';
					$success = "Uploaded";
					//header("refresh:10;url=Centre.php");
				}
				if($count == 0)
				{
					$success = "No Update";
					//header("refresh:5;url=Attendence.php");
				}
			}
			
			
			
		}
		else
		{
			$error = "Invalid File";
			//header( "refresh:3;url=Attendence.php" );
		}
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
			  
			  <li class="active">
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
			  
			  
			  
			  <li>
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
		
        <h2 class="mb-4"><u>Excel Upload</u> (Monthly Attendance Sheet)</h2>
		
        <p>
			<div class="col-sm-12" style = "margin-top:10%;">
				
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					
					
					<center>
						
						
						<form  action = "Attendence.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
							<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Choose Excel File : &nbsp; </label> 
														
									<input  required ="true" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="toggle btn btn-primary"
									type="File" id="excel_file" name = "excel_file" /></br></br>
									
									<label>Choose Month-Year : &nbsp; </label>
									<input required= "true" type="date" id="month_year" name="month_year"  autocomplete="off" style ="width:300px;" autofocus></input></br>
									<button class="toggle btn btn-primary" onclick = "uploadme()" type="submit" id="sub_excel" name = "sub_excel"
									style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">Upload</button>
									
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
							header( "refresh:3;url=Attendence.php" );
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
						if($success == "Uploaded" && $msg != "Not in Operator")
						{
							header( "refresh:30;url=Attendence.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted</label>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box" >
								<h6><i class="fa fa-file text-success"></i> File Uploaded Successfully . . .  <?php echo $count; ?> Rows Inserted</h6>
								
							  </div>
						  </div>
						  <?php
							echo $output;
							
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
			var excel = $("#excel_file").val();
			var date = $("#month_year").val();
			
			if(excel === "" || date ==="")
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			if(excel !== null && date !== "")
			{
				
				document.getElementById("overlay").style.display = "block";
				window.location.href = 'Attendence.php';

				return true;
			}
			//}
			//	document.getElementById("demo").innerHTML = txt;
			
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
  </body>
</html>
