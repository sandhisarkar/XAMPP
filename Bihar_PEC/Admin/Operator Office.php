<?php

session_start();
error_reporting(0);
//header( "refresh:120;url=Centre.php" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];



$op_sl = $_GET["Handle"];


if($op_sl == NULL)
{
	$msgNav = "";
}
else
{
	$msgNav = "Showing";
	$query_prof=mysqli_query($con,"select district_name,state_name,centre_name,operator_name,operator_id,station_id,father_name,dob,uidai_no,pan,aadhar_no,bank_name,branch_name,account_no,ifsc,doj,uan_status,uan_no,IP_status,IP_no,dol,activity_status,uidai_proof,pan_proof,aadhar_proof,pass_cheque_status,pass_cheque_proof,pf_esi_proof,consent_proof,photo_proof,appointment_proof,profile_status,basic,hra,conveyance,allowance,payable_amt FROM operator_profile WHERE sl_no = '".$op_sl."'");
    $n_prof=  mysqli_fetch_assoc($query_prof);
    $distname= $n_prof['district_name'];
	$state = $n_prof['state_name'];
	$centrename = $n_prof['centre_name'];
	$opname = $n_prof['operator_name'];
	$opid = $n_prof['operator_id'];
	$stid = $n_prof['station_id'];
	$fathername = $n_prof['father_name'];
	$dob = $n_prof['dob'];
	$uidai = $n_prof['uidai_no'];
	$pan = $n_prof['pan'];
	$aadhar = $n_prof['aadhar_no'];
	$bankname = $n_prof['bank_name'];
	$branchname = $n_prof['branch_name'];
	$acc = $n_prof['account_no'];
	$ifsc = $n_prof['ifsc'];
	
	$doj = $n_prof['doj'];
	
	if($doj != null)
	{
		$dojdate = substr($doj,0,2);
		$dojmonth = substr($doj,3,2);
		$dojyear = substr($doj,6,4);
		$doj = $dojyear ."-".$dojmonth."-".$dojdate;
		
	}
	else
	{
		$doj = null;
	}
	
	$uanstat = $n_prof['uan_status'];
	$uanno = $n_prof['uan_no'];
	$ipstat = $n_prof['IP_status'];
	$ipno = $n_prof['IP_no'];
	$dol = $n_prof['dol'];
	
	if($dol != null)
	{
		$doldate = substr($dol,0,2);
		$dolmonth = substr($dol,3,2);
		$dolyear = substr($dol,6,4);
		$dol = $dolyear ."-".$dolmonth."-".$doldate;
		
	}
	else
	{
		$dol = null;
	}
	
	$activity = $n_prof['activity_status'];
	
	if($dob != null)
	{
		$dobdate = substr($dob,0,2);
		$dobmonth = substr($dob,3,2);
		$dobyear = substr($dob,6,4);
		$dob = $dobyear ."-".$dobmonth."-".$dobdate;
	}
	else
	{
		$dob = null;
	}
	
	$uidaiproof = $n_prof['uidai_proof'];
	$panproof = $n_prof['pan_proof'];
	$aadharproof = $n_prof['aadhar_proof'];
	$passchequestat = $n_prof['pass_cheque_status'];
	$passchequeproof = $n_prof['pass_cheque_proof'];
	$pfesiproof = $n_prof['pf_esi_proof'];
	$consentproof = $n_prof['consent_proof'];
	$photoproof = $n_prof['photo_proof'];
	$appointmentproof = $n_prof['appointment_proof'];
	$profstat = $n_prof['profile_status'];
	
	
	$basic = $n_prof['basic'];
	$hra = $n_prof['hra'];
	$conv = $n_prof['conveyance'];
	$allow = $n_prof['allowance'];
	$payamt = $n_prof['payable_amt'];
	
	if($distname != null && $state != null && $centrename != null && $opname != null && $stid != null && $fathername != null && $dob != null && $uidai != null && $pan !=null && $aadhar != null && $bankname !=null && $branchname !=null && $acc != null && $ifsc != null && $doj !=null && $uanstat != null && $ipstat != null && $uidaiproof != null && $panproof != null || $aadharproof != null || $passchequeproof != null && $pfesiproof != null && $consentproof !=null && $photoproof != null && $appointmentproof !=null && $basic !=null && $hra != null && $conv != null && $allow != null)
	{
		$sqlx="UPDATE operator_profile SET profile_status = 'Complete' WHERE sl_no='".$op_sl."'";
		if (!mysqli_query($con,$sqlx))
		{
			$message = "Status not updated";
		}
		else
		{
			$message = "Status Updated";
			
		}
		
		//echo $message;
	}
	
}
if(isset($_POST["update_office"]))
{
	
	if($_POST['doj'] != null)
	{
		
		$dojdate = substr($_POST['doj'],8,2);
		$dojmonth = substr($_POST['doj'],5,2);
		$dojyear = substr($_POST['doj'],0,4);
		$doj =  $dojdate."/".$dojmonth."/".$dojyear;
		
	}
	else
	{
		$doj = "";
		
	}
	
	if($_POST['dol'] != null)
	{
		$doldate = substr($_POST['dol'],8,2);
		$dolmonth = substr($_POST['dol'],5,2);
		$dolyear = substr($_POST['dol'],0,4);
		$dol =  $doldate."/".$dolmonth."/".$dolyear;
		
	}
	else
	{
		$dol = "";
		
	}
	
	$sql="UPDATE operator_profile SET doj='".$doj."',uan_status = '".$_POST['status']."',uan_no='".$_POST['uan_no']."',ip_status = '".$_POST['ip_status']."',ip_no = '".$_POST['ip_no']."',activity_status='".$_POST['activity_status']."',dol = '".$dol."' WHERE sl_no='".$op_sl."' AND operator_id = '".$opid."'";
	
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
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/5.10.2/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link href="images/xyz.png" rel="icon">
		<link href="images/xyz.png" rel="apple-touch-icon">
		<link href='https://fonts.googleapis.com/css?family=PT+Sans+Caption:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
		
		
  </head>
  <body>
  
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

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5" >
		<?php if($msgNav == "Showing")
		{
			?>
				<h2 class="mb-4"><u>Edit Operator</u>   (<?php echo $opname;?>)</h2>
		<?php 
		} 
		    ?>
		<?php if($msgNav == "Success")
		{
			$opname = $opname;
		?>
				<h2 class="mb-4"><u>Edit Operator</u>   (<?php echo $opname;?>)</h2>
		<?php 
		} 
		?>				
        <p>
			<div class="col-sm-12" style = "margin-top:0%;">
				
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
					<center>
					<?php
						if($msgNav == "Showing")
						{
							
							echo '<div class="spinner-grow spinner-grow-sm"></div>';
							echo '<label class="text-info"> &nbsp;&nbsp;&nbsp;Showing Result for Operator ID :-  <u>'.$opid.'</u></label></br>';
							
							
						}
						if($msgNav == "Error")
						{
							header("refresh:1;url=Operator Office.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Error. . .Cannot Update Operator. . . Please try again</label></br>';
							
							
						}
						if($msgNav == "Success")
						{
							header("refresh:15;url=Operator Office.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Operator is Updated. . . Showing Result for Operator ID :-  <u>'.$opid.'</u></label></br>';
							$doj = $_POST['doj'];
							$uanstat = $_POST['status'];
							$uanno = $_POST['uan_no'];
							$ipstat = $_POST['ip_status'];
							$ipno = $_POST['ip_no'];
							$activity = $_POST['activity_status'];
							$dol = $_POST['dol'];
						}
					?>
				<ul class="pagination pagination-lg" style="display: inline flow-root list-item; padding-bottom: 1%;">
						<?php
							if($distname == null || $state == null || $centrename == null || $opname == null || $stid == null || $fathername == null || $dob == null)
							{
								?>
								<li><a style = "background-color: #f90606; border-color: #151313; color: #fff; z-index: 3;" onclick= "openOverlay()" href="Operator Profile.php?Handle=<?php echo  $op_sl ;?>" data-toggle="tooltip" title="Operator Profile" data-placement="left"><i class="fa fa-user-o" aria-hidden="true"></i></a></li>
								<?php
							}
							else
							{
								?>
								<li><a style = "background-color: #7df46b; border-color: #151313; color: #fff; z-index: 3;" href="Operator Profile.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator Profile" data-placement="left"><i class="fa fa-user-o" aria-hidden="true"></i></a></li>
								<?php
							}
						?>
						<?php
							if($uidai == null || $pan == null || $aadhar == null)
							{
								?>
								<li><a style = "background-color: #f90606; border-color: #151313; color: #fff; z-index: 3;" onclick= "openOverlay()" href="Operator ID.php?Handle=<?php echo  $op_sl ;?>" data-toggle="tooltip" title="Operator ID Information" data-placement="bottom"><i class="fa fa-id-card-o" aria-hidden="true"></i></a></li>
								<?php
							}
							else
							{
								?>
								<li><a style = "background-color: #7df46b; border-color: #151313; color: #fff; z-index: 3;" href="Operator ID.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator ID Information" data-placement="bottom"><i class="fa fa-id-card-o" aria-hidden="true"></i></a></li>
								<?php
							}
						?>	
						
						<?php
							if($bankname == null || $branchname == null || $acc == null || $ifsc == null)
							{
								?>
								<li><a style = "background-color: #f90606; border-color: #151313; color: #fff; z-index: 3;" href="Operator Bank.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator Bank Details" data-placement="bottom"><i class="fa fa-university" aria-hidden="true"></i></a></li>
								<?php
							}
							else
							{
								?>
								<li><a style = "background-color: #7df46b; border-color: #151313; color: #fff; z-index: 3;" href="Operator Bank.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator Bank Details" data-placement="bottom"><i class="fa fa-university" aria-hidden="true"></i></a></li>
								<?php
							}	
						?>
						
						<li class="active"><a onclick= "openOverlay()" href="Operator Office.php?Handle=<?php echo  $op_sl ;?>" data-toggle="tooltip" title="Operator Work Information" data-placement="bottom"><i class="fa fa-industry" aria-hidden="true"></i></a></li>						
						<?php
							if($uidaiproof == null || $panproof== null || $aadharproof == null || $passchequestat == null || $passchequeproof == null || $pfesiproof== null || $consentproof== null || $photoproof == null || $appointmentproof== null)
							{
								?>
								<li><a style = "background-color: #f90606; border-color: #151313; color: #fff; z-index: 3;" href="Operator Document.php?Handle=<?php echo  $op_sl ;?>"  onclick= "openOverlay()" data-toggle="tooltip" title="Operator Document Details" data-placement="bottom"><i class="fa fa-file" aria-hidden="true"></i></a></li>
								<?php
							}
							else
							{
								?>
								<li><a style = "background-color: #7df46b; border-color: #151313; color: #fff; z-index: 3;" href="Operator Document.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator Document Details" data-placement="bottom"><i class="fa fa-file" aria-hidden="true"></i></a></li>
								<?php
							}
						?>
						<?php
							if($basic == null || $hra == null || $conv == null || $allow == null || $payamt == null)
							{
								?>
								<li><a style = "background-color: #f90606; border-color: #151313; color: #fff; z-index: 3;" href="Operator Salary.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator Salary Details" data-placement="right"><i class="fa fa-rupee" aria-hidden="true"></i></a></li>
								<?php
							}
							else
							{
								?>
								<li><a style = "background-color: #7df46b; border-color: #151313; color: #fff; z-index: 3;" href="Operator Salary.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip"  title="Operator Salary Details" data-placement="right"><i class="fa fa-rupee" aria-hidden="true"></i></a></li>
								<?php
							}
						?>
					</ul>
					</center>
					
				</div>
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
					<center>
						<form  action = "Operator Office.php?Handle=<?php echo  $op_sl;?>" method ="post"  id = "export_excel" enctype="multipart/form-data">
						
						<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									<label style= "color: #495057;">Date Of Joining :  &nbsp; </label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $doj;?>" required= "true" type="date" id="doj" name="doj"  placeholder ="Enter Operator's D.O.J" autocomplete="off" style ="width:250px;" autofocus></input></br></br>
									
									<label style= "color: #495057;">EPF Status :  &nbsp;</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														
									<?php
										if($uanstat == "Yes")
										{
											?>
											<input style="margin-top: -3%;" required="true" checked="checked" onclick = "checkUAN('status_checked')"  type="radio" id="status_checked" name="status" value="Yes"><span> &nbsp; Yes &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style= "margin-top: -3%;" required="true"   onclick = "checkUAN('status_unChecked')" type="radio" id="status_unChecked" name="status" value="No"><span> &nbsp; No &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br></br>
										<?php
										}else{
										?>
											<input style="margin-top: -3%;" required="true"   onclick = "checkUAN('status_checked')" type="radio" id="status_checked" name="status" value="Yes"><span> &nbsp; Yes &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="margin-top: -3%;" required="true"  checked="checked" onclick = "checkUAN('status_unChecked')"  type="radio" id="status_unChecked" name="status" value="No"><span> &nbsp; No &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br></br>
											<?php
										}
									
									?>
									
									
									<label style= "color: #495057;">&nbsp;&nbsp;&nbsp;&nbsp;EPF Number :  &nbsp;</label> 
									
									<?php
										if($uanstat == "Yes")
										{
											
											?>					
											<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;"  value ="<?php echo $uanno;?>" pattern= "^\d{12}$" type="text" id="uan_no" name="uan_no" autocomplete="off" placeholder ="Enter UAN Number" required="true" style ="width:250px;" autofocus></input></br></br>
									<?php
											
										}
										?>
										<?php
										if($uanstat == "No")
										{
											?>					
											<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;"   readonly pattern= "^\d{12}$" type="text" id="uan_no" name="uan_no" autocomplete="off" placeholder ="Enter UAN Number" required="true" style ="width:250px;background-color:ghostwhite;" autofocus></input></br></br>
									<?php
										}
										?> 
										
										<label style= "color: #495057;"> &nbsp;ESI Status :  &nbsp;</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														
									<?php
										if($ipstat == "Yes")
										{
											?>
											<input style="margin-top: -3%;" required="true" checked="checked" onclick = "checkIP('status_ipchecked')"  type="radio" id="status_ipchecked" name="ip_status" value="Yes"><span> &nbsp; Yes &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="margin-top: -3%;" required="true"   onclick = "checkIP('status_ipunChecked')" type="radio" id="status_ipunChecked" name="ip_status" value="No"><span> &nbsp; No &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br></br>
										<?php
										}else{
										?>
											<input style="margin-top: -3%;" required="true"   onclick = "checkIP('status_ipchecked')" type="radio" id="status_ipchecked" name="ip_status" value="Yes"><span> &nbsp; Yes &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input style="margin-top: -3%;" required="true"  checked="checked" onclick = "checkIP('status_ipunChecked')"  type="radio" id="status_ipunChecked" name="ip_status" value="No"><span> &nbsp; No &nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</br></br>
											<?php
										}
									
									?>
									
									<label style= "color: #495057;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ESI Number :  &nbsp;</label> 
									
									<?php
										if($ipstat == "Yes")
										{
											
											?>					
											<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $ipno;?>" pattern= "^\d{10}$" type="text" id="ip_no" name="ip_no" autocomplete="off" placeholder ="Enter IP Number" required="true" style ="width:250px;" autofocus></input></br></br>
									<?php
											
										}
										?>
										<?php
										if($ipstat == "No")
										{
											?>					
											<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;"  readonly pattern= "^\d{10}$" type="text" id="ip_no" name="ip_no" autocomplete="off" placeholder ="Enter IP Number" required="true" style ="width:250px;background-color:ghostwhite;" autofocus></input></br></br>
									<?php
										}
										?> 
									
									<label style= "color: #495057;">&nbsp;Activity Status :  &nbsp;</label> 
														
									<select style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;height:35px;padding: .375rem .60rem;margin-top: -3%;" required="true" id="activity_status" name="activity_status" style="width: 250px;">
											<option selected value="" disabled>Select Any...</option>
											<option selected value= "<?php echo $activity; ?>"><?php echo $activity; ?></option>
										<?php
											mysqli_select_db( $con,"status_master");

											$sql = "SELECT status FROM status_master where status <> '".$activity."'";
											$result = mysqli_query($con, $sql);
											if (mysqli_num_rows($result) > 0) {
											// output data of each row
											while($row = mysqli_fetch_assoc($result)) {
												?>
												
												<option value = "<?php echo $row["status"]; ?>"><?php echo  $row["status"]?></option>
												<?php
											}
										} else {
											echo "";
										}
										?>
										
									</select></br></br>
									
									<label style="margin-left: -7px;color: #495057;">Date Of Leaving :  &nbsp; </label> 
														
									<?php
									if($activity == "Active")
									{
										?>		
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value =" " readonly  type="date" id="dol" name="dol"  placeholder ="Enter Operator's D.O.L" autocomplete="off" style ="width:250px;background-color:ghostwhite;" autofocus></input></br></br>
									<?php 
									}if($activity == "Inactive"){
										?>
										<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $dol;?>" required= "true" type="date" id="dol" name="dol"  placeholder ="Enter Operator's D.O.L" autocomplete="off" style ="width:250px;" autofocus></input></br></br>
										<?php
									}?>
									
									<input class="toggle btn btn-primary" onclick="uploadme()" type="submit" id="update_office" name = "update_office" value="Update Operator Office" style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
								</td>
							</tr>
							
						</table>
						
						
						</form>
					</center>
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
	  
		</div>
	<?php 
	  }
	?>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
	<script>
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();   
		});
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
	<script>
		function on() {
		  document.getElementById("overlay").style.display = "block";
		}

		function off() {
		  document.getElementById("overlay").style.display = "none";
		}
		
		function checkUAN(FieldId){
			
			
			if($('#status_unChecked').is(':checked')){
				
				$('#status_checked').prop('checked', false);
				$('#status_unChecked').prop('checked', true);
				$('#uan_no').prop('readonly', true);
				$("#uan_no").css("background-color", "ghostwhite");
				$('#uan_no').val('');
			}
			else if($('#status_checked').is(':checked')) {
				
				$('#status_checked').prop('checked', true);
				$('#status_unChecked').prop('checked', false);
				$('#uan_no').prop('readonly', false);
				$("#uan_no").css("background-color", "transparent");
			}else {
				// nothing don here now..........
			}
		}
		function checkIP(FieldIdIp){

			if($('#status_ipunChecked').is(':checked')){
				
				$('#status_ipchecked').prop('checked', false);
				$('#status_ipunChecked').prop('checked', true);
				$('#ip_no').prop('readonly', true);
				$("#ip_no").css("background-color", "ghostwhite");
				$('#ip_no').val('');
			}
			else if($('#status_ipchecked').is(':checked')) {
				
				$('#status_ipchecked').prop('checked', true);
				$('#status_ipunChecked').prop('checked', false);
				$('#ip_no').prop('readonly', false);
				$("#ip_no").css("background-color", "transparent");
			}else {
				// nothing don here now..........
			}
		}
		
		</script>
		
		
		<script type="text/javascript">

			$("#activity_status").change(function(){

				var selValue = $(this).val();

				//alert(selValue);
				
				if(selValue == "Active"){
					$("#dol").prop('readonly',true);
					$("#dol").css("background-color", "ghostwhite");
					$('#dol').val('');
				}
				if(selValue == "Inactive"){
					$("#dol").prop('readonly',false);
					$("#dol").css("background-color", "transparent");
					
				}
				
			});

		</script>
		<script language="javascript">
		function uploadme()
		{
			
			var doj = $("#doj").val();
			
			var status_checked = $("#status_checked").val();
			var status_unChecked = $("#status_unChecked").val();
			var uan_no = $("#uan_no").val();
			var status_ipchecked = $("#status_ipchecked").val();
			var status_ipunChecked = $("#status_ipunChecked").val();
			var ip_no = $("#ip_no").val();
			var activity_status = $("#activity_status").val();
			var dol = $("#dol").val();
			
			var patt = new RegExp("^[0-9]{12}$");
			var res = patt.test(uan_no);
			
			var patt1 = new RegExp("^[0-9]{10}$");
			var res1 = patt1.test(ip_no);
			
			
			
			if(doj !== "" && (status_checked !== ""  || status_unChecked !== "") &&  (status_ipchecked !== ""  || status_ipunChecked !== "") && activity_status !== "" )
			{
				
				if(($('#status_checked').is(':checked')  && uan_no !== ""  && res == true) || ($('#status_unChecked').is(':checked')  && uan_no == ""  && res == false))
				{
					
					if(($('#status_ipchecked').is(':checked') && ip_no !== "" && res1 == true) || ($('#status_ipunChecked').is(':checked') && ip_no === "" && res1 == false))
					{
						
						if((dol !== "" && activity_status == "Inactive" ) || (activity_status == "Active"))
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
					else
					{
						document.getElementById("overlay").style.display = "none";
						return false;
					}
				}
				
				
				
			}
			else
			{
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			
		}
		</script>
  </body>
</html>