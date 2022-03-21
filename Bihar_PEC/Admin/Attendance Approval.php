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

$q1=mysqli_query($con,"select Distinct(month_year) from monthly_attendence");
$n1=  mysqli_fetch_row($q1);




if(isset($_POST["sub_excel"]))
{
	$monyear = $_POST["month_year"];
	
	$sql1 = "SELECT COUNT(*) FROM monthly_attendence where month_year = '".$monyear."' ";
	$result1 = mysqli_query($con, $sql1);
	
	$cou_check = mysqli_fetch_row($result1);
	$cou = $cou_check[0];
	
	if($cou > 0)
	{
		$msg = "Greater";
		//echo $monyear;
	}
	else
	{
		$msg = "Zero";
	}
	
}


if(isset($_POST["approve"]))
{
	$monthyr = $_POST["name"];
	
	$sql="UPDATE monthly_attendence SET status='Approved' WHERE month_year='".$monthyr."'";

	if (!mysqli_query($con,$sql))
	{
	  
	  $msgNav = "Error";
	 
    }
	else
	{
		
	  $msgNav = "Success";
	  
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
		<script>
			function openModalForRecordEdit(unId,monYr) {
				
				$("#txtSequenceId").val(unId);
				$("#txtSequenceId1").val(monYr);
				
				 $("#MySecondModalId").modal('show');
				 
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
			  
			  
			<li class="active">
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
		
        <h2 class="mb-4"><u>Attendance Approval</u> </h2>
		
        <p>
			<div class="col-sm-12" style = "margin-top:5%;">
				
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					
					
					<center>
					<form  action = "Attendance Approval.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
							<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									
									
									<label style="margin-left: -5%;color: #495057;">Choose Month-Year : &nbsp; </label>
									<select required="true" id="month_year"  name="month_year" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 300px;">
										<option disabled selected value = "">Select Any...</option>
										<?php
											//mysqli_select_db( $con,"course_details");

											$sql = "SELECT DISTINCT(month_year) FROM monthly_attendence ";
											$result = mysqli_query($con, $sql);
											if (mysqli_num_rows($result) > 0) {
											// output data of each row
											while($row = mysqli_fetch_row($result)) {
												$sql1 = "SELECT COUNT(*) FROM monthly_attendence where month_year = '".$row[0]."' AND status = 'Created' ";
												$result1 = mysqli_query($con, $sql1);
												
												$cou_check = mysqli_fetch_row($result1);
												$cou = $cou_check[0];
												
												if($cou == 0)
												{
													$sql2 = "SELECT COUNT(*) FROM monthly_attendence where month_year = '".$row[0]."' AND status = 'Pending' ";
													$result2 = mysqli_query($con, $sql2);
													
													$cou_check1 = mysqli_fetch_row($result2);
													$cou1 = $cou_check1[0];
													
													if($cou1 == 0)
													{
														echo "";
													}
													else
													{
														?>
														<option><?php echo  $row[0]?></option>
														<?php
													}
												}
												else
												{
													echo  "";
												}
												
												
											}
										} else {
											 echo  "";
										}
										?>
										
									</select></br>
									
									<button class="toggle btn btn-primary" onclick = "uploadme()" type="submit" id="sub_excel" name = "sub_excel"
									style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">Search<span></span> <i class="fa fa-search"></i></button>
									
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
						if($msgNav == "Success")
						{
							header( "refresh:30;url=Attendence.php" );
							//echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							//echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted</label>';
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box" >
								<h6>Attendance Approved Successfully . . .  </h6>
								<h5>Month-Year - <u><b><?php  echo $monthyr;?></b></u> <i class="fa fa-calendar text-success"></i></h5>
								
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
						if($msg == "Greater")
						{
							mysqli_select_db( $con,"monthly_attendence");

							$sql = "SELECT sl_no,district_name,operator_id,operator_name,actual_working_days,hold_amount,hold_reason,month_year FROM monthly_attendence where month_year = '".$monyear."' ORDER BY sl_no";
							$result = mysqli_query($con, $sql);
							
							if (mysqli_num_rows($result) > 0) {
							// output data of each row
							$cou = mysqli_num_rows($result);
							
							?>
							
							<div class="input-group mb-3">
								<input id="myInput" type="text" class="form-control" placeholder="Search.." autofocus>
								<div class="input-group-append">
								  <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
								</div>
							  </div>
							  
							  
							  
										<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" id = "app" style = "display:none;margin-bottom: -20px;">
											<div class="box" style ="padding:0%; box-shadow: 0 0 white;">
											
												<form  action = "Attendance Approval.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
												<div>
													<input type="text" id = "name" name="name" value="<?php echo $monyear;?>" style = "display:none;"></input>
													<button type="submit" id = "approve" name = "approve" class="btn btn-primary"  onclick = "uploadme1()" style="background: green;">Approve Attendance<span></span><i class="fa fa-check"></i></button>
												</div>
												</form>
											
											</div>
										
										</div>
								  
							  
							  
							<table class="table table-hover table-bordered table-striped" id ="table" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: small;">
								<thead class="thead-dark">
								<tr>
									<th style = 'padding:auto;'><input type="checkbox" id= "check" onclick = "check(<?php echo $cou;?>)"></input></th>
									<th style = 'padding:auto;'>Sl. No.</th>
									<th style = 'padding:auto;'>Month-Year</th>
									<th style = 'padding:auto;'>District</th>
									<th style = 'padding:auto;'>Operator ID</th>
									<th style = 'padding:auto;'>Operator Name</th>
									<th style = 'padding:auto;'>Actual Working Days</th>
									<th style = 'padding:auto;'>Hold Amount</th>
									<th style = 'padding:auto;'>Hold Reason</th>
									<th style = 'padding:auto;'>Action</th>
								</tr>
								</thead>
							<?php
							while($row = mysqli_fetch_row($result)) {
								?>
								<tbody id="myTable">
								<tr>
									<td><input type="checkbox" id= "check<?php echo $row[0];?>"></td>
									<td style = "padding: auto;"><?php echo  $row[0]?></td>
									<td style = "padding: auto;"><?php echo  $row[7]?></td>
									<td style = "padding: auto;"><?php echo  $row[1]?> </td>
									<td style = "padding: auto;"><?php echo  $row[2]?></td>
									<td style = "padding: auto;"><?php echo  $row[3]?></td>
									<td style = "padding: auto;"><?php echo  $row[4]?></td>
									<td style = "padding: auto;"><?php echo  $row[5]?></td>
									<td style = "padding: auto;"><?php echo  $row[6]?></td>
									
									
									<td style = "padding: auto;"><button type="button" style = "background-color: transparent; border-color: transparent;" onclick="openModalForRecordEdit(<?php echo  $row[0]?>,'<?php echo $row[7]?>');"><i class="fa fa-edit" style="font-size:25px; color:#007bff""></i></button></td>
									
									<!--button type="button" style = "background-color: transparent; border-color: transparent;" onclick="openModalForRecord(<?php echo  $row["sl_no"]?>);"><i class="fa fa-trash-o" style="font-size:25px; color:#007bff"></i></button-->
								</tr>
								</tbody>
								<?php
								// onClick="deleteme(<?php echo  $row["sl_no"];   ---- delete ok cancel popup
								//Centre Details.php?Handle=<?php echo  $row["sl_no"]
							}
							?>
							
							</table><?php
						} 
						}
						if($msg == "Zero")
						{
							
							?>
								<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
										<p>No Result Found !</p>
										<p></p>
										<p> Please Wait.. Rederecting within a second... </p>
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
		
	
		
		<div id="MySecondModalId" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <h4 class="modal-title float-left">Edit Operator Attendance ! </h4>
				<button type="button" class="close" data-dismiss="modal">X</button>
				
			  </div>
			  <div class="modal-body">
				<p>Hey ! Do you want to Edit ?</p>
			  </div>
			  <div class="modal-footer">
			  <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "editme()">Confirm</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		
		<div class="displayNone"> 
		<input type="hidden"  id="txtSequenceId"/>
		<input type="hidden"  id="txtSequenceId1"/>
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
			
			
			if(date !== null)
			{
				
				document.getElementById("overlay").style.display = "block";
				return true;
				
			}
			if(date === null )
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			
			
		}
		function uploadme1()
		{
			document.getElementById("overlay").style.display = "block";
				return true;
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
	<!--script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /-->
  
  <!-- Template Main JS File -->
  <!--script src="assets/js/main.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script-->
       
		 <script>
			function getName(val)
			{
				document.getElementById("overlay").style.display = "block";
				//alert(val);
				$.ajax({
					type: "POST",
					url: "getDistrict.php",
					data: 'monthyear='+val,
					
					success: function(data)
					{
						$("#district_name").html(data);
						document.getElementById("overlay").style.display = "none";
					}
				});
			}
			
			
		</script>
		<script>
			$(document).ready(function(){
			  $("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			  });
			});
			</script>
			
			<script>
			function check(val)
			{
				
				if ($("input[type=checkbox]").is( 
                      ":checked")) { 
					 $("#app").show();
					  for(var i= 1; i <=val; i ++)
					  {
						  
						  $("#check"+i).prop("checked", true);
						  $("#check"+i).prop("disabled", true);
					  }
                       
                    } else {
							
						   for(var i= 1; i <=val; i ++)
						   {
								  
							    $("#check"+i).prop("checked", false);
								
							}
                    }
				if ($("input[type=checkbox]").is(":not(:checked)")) { 
					 
					 $("#app").hide();
					  for(var i= 1; i <=val; i ++)
					  {
						  
						  $("#check"+i).prop("checked", false);
						  $("#check"+i).prop("disabled", false);
						  
					  }
                       
                    }

						
			}
			</script>
			<script language ="javascript">
			function editme()
			{
				
				var CurrentId = $("#txtSequenceId").val();
				var MonthYr = $("#txtSequenceId1").val();
				
				
				$("#MySecondModalId").modal('hide');
				
				document.getElementById("overlay").style.display = "block";
				window.location.href = 'Attendance Edit.php?Handle=' +CurrentId+'&MonYr='+MonthYr+'';
					
					
				return true;	
				
				
			}
			</script>
			
  </body>
</html>


