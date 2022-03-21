<?php

session_start();
error_reporting(0);
header("refresh:120;url=Operator Details.php" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];
$msgNav = "";
$get_event = "";


$q_cou=mysqli_query($con,"select COUNT(*) from operator_profile");
$n_cou=  mysqli_fetch_row($q_cou);
$cou = $n_cou[0];			
if($cou == 0)
{
	header("refresh:5;url=/Bihar_PEC/Admin/");
}	

$get_ID = $_GET["Handle"];

$get_event = $_GET["Event"];

if($get_ID == NULL || $get_event  != "Delete")
{
	$msgNav = "";
}
else
{
	//$msgNav = "Delete";
	$q1=mysqli_query($con,"select operator_id from operator_profile where sl_no='".$get_ID."'");
	$n1=  mysqli_fetch_assoc($q1);
	$opid= $n1['operator_id'];
	
	
	
	$sql1="Delete from operator_profile where sl_no = '".$get_ID."'";

		if (!mysqli_query($con,$sql1))
		{
		  $msgNav = "Not Delete";
		  header("refresh:3;url=Operator Details.php");
		}
		else
		{
			chdir("..");
		
			$uidaipath = "Admin/Documents/UIDAI/".$opid."/";
			if(!is_dir($uidaipath))
			{
				mkdir($uidaipath,"0777",true);
			}
			else
			{
				$uidaipath = "Admin/Documents/UIDAI/".$opid."/";
				
				$files = glob($uidaipath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/UIDAI/".$opid);
			
			$panpath = "Admin/Documents/PAN/".$opid."/";
			if(!is_dir($panpath))
			{
				mkdir($panpath,"0777",true);
			}
			else
			{
				$panpath = "Admin/Documents/PAN/".$opid."/";
				
				$files = glob($panpath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/PAN/".$opid);
			
			$aadharpath = "Admin/Documents/Aadhar/".$opid."/";
			if(!is_dir($aadharpath))
			{
				mkdir($aadharpath,"0777",true);
			}
			else
			{
				$aadharpath = "Admin/Documents/Aadhar/".$opid."/";
				
				$files = glob($aadharpath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/Aadhar/".$opid);
			
			$passchequepath = "Admin/Documents/Pass_Cheque/".$opid."/";
			if(!is_dir($passchequepath))
			{
				mkdir($passchequepath,"0777",true);
			}
			else
			{
				$passchequepath = "Admin/Documents/Pass_Cheque/".$opid."/";
				
				$files = glob($passchequepath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/Pass_Cheque/".$opid);
			
			$pfesipath = "Admin/Documents/PF_ESI/".$opid."/";
			if(!is_dir($pfesipath))
			{
				mkdir($pfesipath,"0777",true);
			}
			else
			{
				$pfesipath = "Admin/Documents/PF_ESI/".$opid."/";
				
				$files = glob($pfesipath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/PF_ESI/".$opid);
			
			$consentpath = "Admin/Documents/Consent/".$opid."/";
			if(!is_dir($consentpath))
			{
				mkdir($consentpath,"0777",true);
			}
			else
			{
				$consentpath = "Admin/Documents/Consent/".$opid."/";
				
				$files = glob($consentpath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/Consent/".$opid);
			
			$photopath = "Admin/Documents/Photo/".$opid."/";
			if(!is_dir($photopath))
			{
				mkdir($photopath,"0777",true);
			}
			else
			{
				$photopath = "Admin/Documents/Photo/".$opid."/";
				
				$files = glob($photopath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/Photo/".$opid);
			
			$appointmentpath = "Admin/Documents/Appointment/".$opid."/";
			if(!is_dir($appointmentpath))
			{
				mkdir($appointmentpath,"0777",true);
			}
			else
			{
				$appointmentpath = "Admin/Documents/Appointment/".$opid."/";
				
				$files = glob($appointmentpath.'/*');  
		   
				// Deleting all the files in the list 
				foreach($files as $file) { 
				   
					if(is_file($file))  
					
						// Delete the given file 
						unlink($file);  
				} 
			}
			rmdir("Admin/Documents/Appointment/".$opid);
			
			
			
			$query0=mysqli_query($con ,"select count(*) from operator_profile");
			$res0=mysqli_fetch_row($query0);
			$tot0 = $res0[0];
														
			if($tot0 > 0)
			{
				$sql2 = "SELECT sl_no from operator_profile order by sl_no";
				$result2 = mysqli_query($con, $sql2);
				if (mysqli_num_rows($result2) > 0) {
				$i =1;
				while($row1 = mysqli_fetch_row($result2)) {
					$temp_sl = $row1[0];
					//echo $temp_sl;
					$sqlx="UPDATE operator_profile SET sl_no = '".$i."' WHERE sl_no='".$temp_sl."'";
					if (!mysqli_query($con,$sqlx))
					{
						
					}
					else
					{
						  $i =$i+1;
					}
					
					}
					$msgNav = "Delete";
					header("refresh:10;url=Operator Details.php");
			   }
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
  </head>
  <body>
		<script>
		function openModalForRecord(unId) {
			//alert("test---->"+unId);
			$("#txtSequenceId").val(unId);
			//alert($("#txtSequenceId").val());
			 $("#MyFirstModalId").modal('show');
			 
		}
		</script>
		<script>
		function openModalForRecordEdit(unId) {
			//alert("test---->"+unId);
			$("#txtSequenceId").val(unId);
			//alert($("#txtSequenceId").val());
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
			  
	          <li class="active">
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
		
		<div id="content" class="p-4 p-md-5 pt-5" >
		
        <h2 class="mb-4"><u>Operator Details</u></h2>
		<span class="glyphicon glyphicon-search"></span>
        <p>
			<div class="col-sm-12" style = "margin-top:5%;">
				
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto; overflow-x:auto;">
				
					<center>
					
					
					<?php
															
															if($msgNav == "Delete"  && $get_event == "Delete")
															{
																header("refresh:3;url=Operator Details.php" );
																echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
																echo '<label class="text-success">Operator Deleted Successfully</label>';
																header("refresh:3;url=Operator Details.php" );
																
															}
															if($msgNav == "Not Delete" && $get_event == "Delete")
															{
																
																header("refresh:5;url=Operator Details.php" );
																echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
																echo '<label class="text-danger">Error . . . Not Deleted</label>';
																header("refresh:5;url=Operator Details.php" );
															}
															

															$sql = "select sl_no,district_name,state_name,centre_name,Operator_name,Operator_id,station_id,basic,hra,conveyance,allowance,payable_amt,Activity_status,Profile_status from operator_profile ORDER BY sl_no";
															$result = mysqli_query($con, $sql);
															$cenID = "";
															if (mysqli_num_rows($result) > 0) {
																// output data of each row
																
																?>
																
																
																  <div class="input-group mb-3">
																	<input id="myInput" type="text" class="form-control" placeholder="Search.." autofocus>
																	<div class="input-group-append">
																	  <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
																	</div>
																  </div>
																
																<table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: x-small;">
																<thead class="thead-dark">
																	<tr>
																		<th style = 'padding:auto;'>Sl. No.</th>
																		<th style = 'padding:auto;'>District</th>
																		<th style = 'padding:auto;'>State</th>
																		<th style = 'padding:auto;'>Centre Name</th>
																		<th style = 'padding:auto;'>Operator Name</th>
																		<th style = 'padding:auto;'>Operator ID</th>
																		<th style = 'padding:auto;'>Station ID</th>
																		<th style = 'padding:auto;'>Basic</th>
																		<th style = 'padding:auto;'>HRA</th>
																		<th style = 'padding:auto;'>Conveyance</th>
																		<th style = 'padding:auto;'>Allowance</th>
																		<th style = 'padding:auto;'>Payable Amount</th>
																		<th style = 'padding:auto;'>Activity Status</th>
																		<th style = 'padding:auto;'>Profile Status</th>
																		<th style ='padding:auto;'>Action</th>
																	</tr>
																	</thead>
																<?php
																while($row = mysqli_fetch_assoc($result)) {
																	?>
																	<tbody id="myTable">
																	<tr>
																		<td style = "padding: auto;"><?php echo  $row["sl_no"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["district_name"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["state_name"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["centre_name"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["Operator_name"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["Operator_id"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["station_id"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["basic"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["hra"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["conveyance"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["allowance"]?></td>
																		<td style = "padding: auto;"><?php echo  $row["payable_amt"]?></td>
																		<?php 
																		if($row["Activity_status"]== "Active")
																		{
																			?>
																			<td style = "padding: auto; "><label class="spinner-grow spinner-grow-sm text-success"></label></td>
																			<?php
																		}
																		else
																		{
																			?>
																			<td style = "padding: auto; "><label class="spinner-grow spinner-grow-sm text-danger"></label></td>
																			<?php
																		}
																		?>
																		<?php 
																		if($row["Profile_status"]== "Complete")
																		{
																			?>
																			<td style = "padding: auto; "><label class="spinner-grow spinner-grow-sm text-success"></label></td>
																			<?php
																		}
																		else
																		{
																			?>
																			<td style = "padding: auto; "><label class="spinner-grow spinner-grow-sm text-danger"></label></td>
																			<?php
																		}
																		?>
																		
																		<td style = "padding: auto;"><Span><button type="button" style = "background-color: transparent; border-color: transparent;" onclick="openModalForRecordEdit(<?php echo  $row["sl_no"]?>);"><i class="fa fa-edit" style="font-size:25px; color:#007bff""></i></button></span></td>
																		<!--button type="button" style = "background-color: transparent; border-color: transparent;" onclick="openModalForRecord(<?php echo  $row["sl_no"]?>);"><i class="fa fa-trash-o" style="font-size:25px; color:#007bff"></i></button></td-->
																		
																	    
																	</tr>
																	</tbody>
																	<?php
																	// onClick="deleteme(<?php echo  $row["sl_no"];   ---- delete ok cancel popup
																	//Centre Details.php?Handle=<?php echo  $row["sl_no"]
																	//<a href="Operator Details.php?Handle=<?php echo  $row["sl_no"]?
																}
																?>
																
																</table><?php
															} else {
																header( "refresh:10;url=/Bihar_PEC/Admin/" );
																?>
																	<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
																			<p>No Result Found !</p>
																			<p></p>
																			<p> Please Wait.. Rederecting within a second... </p>
																	</div>
																 <?php
																 header( "refresh:10;url=/Bihar_PEC/Admin/" );
															}
															
														?>
				
				</center>											
				
				</div>
								
			</div>
		</p>
        <p></p>
      </div>
	  <div class="displayNone"> 
		<input type="hidden" id="txtSequenceId"/>
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
			  <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "deleteme()">Confirm</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		
		<div id="overlay">	  
			<div class="load-icon center" style= "text-align:center;">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		
		<!--div id="overlay" onclick="off()">
		  <div id="loader"></div>
		</div-->
		
		
		<!-- Modal -->
		<div id="MySecondModalId" class="modal fade bd-example-modal-sm" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <h4 class="modal-title float-left">Edit Operator ! </h4>
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
		
		
		</div>
	<?php 
	  }
	?>
	<script language ="javascript">
	function deleteme()
	{
		
		var CurrentId = $("#txtSequenceId").val();
		//alert("CurrentId--->>"+CurrentId);
		$("#MyFirstModalId").modal('hide');
		document.getElementById("overlay").style.display = "block";
		
		var event = "Delete";
			window.location.href = 'Operator Details.php?Handle=' +CurrentId+'&Event='+event+'';
			//document.getElementById("loader").style.display = "none";
			txt = "Deleted Successfully";
			
			
			return true;
		//	document.getElementById("demo").innerHTML = txt;
		
	}
	</script>
	<script>
		function on() {
		  document.getElementById("overlay").style.display = "block";
		}

		function off() {
		  document.getElementById("overlay").style.display = "none";
		}
		</script>
	<script language ="javascript">
	function editme()
	{
		
		var CurrentId = $("#txtSequenceId").val();
		//alert("CurrentId--->>"+CurrentId);
		$("#MySecondModalId").modal('hide');
		
		document.getElementById("overlay").style.display = "block";
			window.location.href = 'Operator Profile.php?Handle=' +CurrentId+'';
			txt = "Edit Open";
			
			
			return true;
		//	document.getElementById("demo").innerHTML = txt;
		
	}
	</script>
	
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
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
  </body>
</html>