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
if(isset($_POST["update_document"]))
{
	
	if($_FILES["uidai_proof"]["type"] ==  "application/pdf" && $_FILES["photo_proof"]["type"] == "image/jpeg" && 
	$_FILES["pan_proof"]["type"] ==  "application/pdf" && $_FILES["aadhar_proof"]["type"] ==  "application/pdf" && 
	$_FILES["pass_cheque_proof"]["type"] ==  "application/pdf" && $_FILES["pf_esi_proof"]["type"] ==  "application/pdf" &&
	$_FILES["consent_proof"]["type"] ==  "application/pdf" && $_FILES["appointment_proof"]["type"] ==  "application/pdf")
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
		
		$uidaipath=$uidaipath.$_FILES['uidai_proof']['name'];
		$panpath=$panpath.$_FILES['pan_proof']['name'];
		$aadharpath=$aadharpath.$_FILES['aadhar_proof']['name'];
		$passchequepath = $passchequepath.$_FILES['pass_cheque_proof']['name'];
		$pfesipath = $pfesipath.$_FILES['pf_esi_proof']['name'];
		$consentpath = $consentpath.$_FILES['consent_proof']['name'];
		$photopath = $photopath.$_FILES['photo_proof']['name'];
		$appointmentpath = $appointmentpath.$_FILES['appointment_proof']['name'];
		
		if(move_uploaded_file($_FILES['uidai_proof']['tmp_name'],$uidaipath) 
			&& move_uploaded_file($_FILES['pan_proof']['tmp_name'],$panpath)
			&& move_uploaded_file($_FILES['aadhar_proof']['tmp_name'],$aadharpath)
			&& move_uploaded_file($_FILES['pass_cheque_proof']['tmp_name'],$passchequepath)
			&& move_uploaded_file($_FILES['pf_esi_proof']['tmp_name'],$pfesipath)
			&& move_uploaded_file($_FILES['consent_proof']['tmp_name'],$consentpath)
			&& move_uploaded_file($_FILES['photo_proof']['tmp_name'],$photopath)
			&& move_uploaded_file($_FILES['appointment_proof']['tmp_name'],$appointmentpath))
			{
				$uidaiproof = $_FILES['uidai_proof']['name'];
				$panproof = $_FILES['pan_proof']['name'];
				$aadharproof = $_FILES['aadhar_proof']['name'];
				$passchequeproof = $_FILES['pass_cheque_proof']['name'];
				$pfesiproof = $_FILES['pf_esi_proof']['name'];
				$consentproof = $_FILES['consent_proof']['name'];
				$photoproof = $_FILES['photo_proof']['name'];
				$appointmentproof = $_FILES['appointment_proof']['name'];
			}
			
			
		$sql="UPDATE operator_profile SET uidai_proof='".$uidaiproof."',pan_proof = '".$panproof."',aadhar_proof='".$aadharproof."',pass_cheque_status = '".$_POST['status']."',pass_cheque_proof = '".$passchequeproof."',pf_esi_proof='".$pfesiproof."',consent_proof = '".$consentproof."',photo_proof='".$photoproof."',appointment_proof='".$appointmentproof."' WHERE sl_no='".$op_sl."' AND operator_id = '".$opid."'";
	
		if (!mysqli_query($con,$sql))
		{
		  
		  $msgNav = "Error";
		  
		}
		else
		{
			
			$msgNav = "Success";
		  
		}
			
		
	}
	else
	{
		$msgNav = "Invalid File";
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
		<?php if($msgNav == "Invalid File")
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
							header("refresh:1;url=Operator Document.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Error. . .Cannot Update Operator. . . Please try again</label></br>';
							
							
						}
						if($msgNav == "Success")
						{
							header("refresh:15;url=Operator Document.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Operator is Updated. . . Showing Result for Operator ID :-  <u>'.$opid.'</u></label></br>';
							$uidaiproof = $_FILES['uidai_proof']['name'];
							$panproof = $_FILES['pan_proof']['name'];
							$aadharproof = $_FILES['aadhar_proof']['name'];
							$passchequestat = $_POST['status'];
							$passchequeproof = $_FILES['pass_cheque_proof']['name'];
							$pfesiproof = $_FILES['pf_esi_proof']['name'];
							$consentproof = $_FILES['consent_proof']['name'];
							$photoproof = $_FILES['photo_proof']['name'];
							$appointmentproof = $_FILES['appointment_proof']['name'];
							
						}
						if($msgNav == "Invalid File")
						{
							header("refresh:15;url=Operator Document.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-info"> &nbsp;&nbsp;&nbsp;Showing Result for Operator ID :-  <u>'.$opid.'</u></label></br>';
							echo '<label class="text-warning">Warning !!! Cannot upload documents... Please select proper document !</label></br>';
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
						<?php
							if($doj == null || $uanstat == null || $ipstat==null)
							{
								?>
								<li><a style = "background-color: #f90606; border-color: #151313; color: #fff; z-index: 3;" href="Operator Office.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator Work Information" data-placement="bottom"><i class="fa fa-industry" aria-hidden="true"></i></a></li>
								<?php
							}
							else
							{
								?>
								<li><a style = "background-color: #7df46b; border-color: #151313; color: #fff; z-index: 3;" href="Operator Office.php?Handle=<?php echo  $op_sl ;?>" onclick= "openOverlay()" data-toggle="tooltip" title="Operator Work Information" data-placement="bottom"><i class="fa fa-industry" aria-hidden="true"></i></a></li>
								<?php
							}	
						?>
						<li class="active"><a onclick= "openOverlay()" href="Operator Document.php?Handle=<?php echo  $op_sl ;?>" data-toggle="tooltip" title="Operator Document Details" data-placement="bottom"><i class="fa fa-file" aria-hidden="true"></i></a></li>						
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
						<form  action = "Operator Document.php?Handle=<?php echo  $op_sl;?>" method ="post"  id = "export_excel" enctype="multipart/form-data">
						<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									<label style="margin-left:-8%;color: #495057;"">Certification Proof :  &nbsp; </label> 
														
									<input required ="true" accept = ".pdf,application/pdf" class="toggle btn btn-primary" type="File" id="uidai_proof" name = "uidai_proof" value= "<?php echo $uidaiproof;?>" autofocus style="margin-bottom: 7px;"><!--span class="text-success">&nbsp;<?php echo $uidaiproof;?></span--></input></br>
									
									<label style="color: #495057;">&nbsp;&nbsp;&nbsp;&nbsp;PAN Proof :  &nbsp; </label> 
														
									<input required ="true" accept = ".pdf,application/pdf" class="toggle btn btn-primary" type="File" id="pan_proof" name = "pan_proof" value= "<?php echo $panproof;?>" autofocus style="margin-bottom: 7px;"><!--span class="text-success">&nbsp;<?php echo $panproof;?></span--></input></br>
									
									<label style="color: #495057;">Aadhar Proof :  &nbsp; </label> 
														
									<input required ="true" accept = ".pdf,application/pdf" class="toggle btn btn-primary" type="File" id="aadhar_proof" name = "aadhar_proof" value = "<?php echo $aadharproof;?>" autofocus style="margin-bottom: 7px;"><!--span class="text-success">&nbsp;<?php echo $aadharproof;?></span--></input></br>
									
									<label style="margin-left: -67px;color: #495057;">Passbook/Cheque :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label> 
									
									<?php
									if($passchequestat == "Pass")
									{
										?>
										<input required="true" checked  type="radio" id="status_checked" name="status" value="Pass"><span> &nbsp; Passbook &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></input>
									    <input required="true"   type="radio" id="status_unChecked" name="status" value="Cheque" style="margin-bottom: 7px;"><span> &nbsp; Cheque &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></input></br>
										<?php
									}
									else if($passchequestat == "Cheque")
									{
										
										?>
										<input required="true"   type="radio" id="status_checked" name="status" value="Pass"><span> &nbsp; Passbook &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></input>
										<input required="true"  checked type="radio" id="status_unChecked" name="status" value="Cheque" style="margin-bottom: 7px;"><span> &nbsp; Cheque &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></input></br>
											<?php
									}else
									{
										?>
										<input required="true"  type="radio" id="status_checked" name="status" value="Pass" autofocus><span> &nbsp; Passbook &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></input>
										<input required="true"  type="radio" id="status_unChecked" name="status" value="Cheque" style="margin-bottom: 7px;"><span> &nbsp; Cheque &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></input></br>
										<?php
									}
									?>
									
									<label style="margin-left: -73px;color: #495057;">Passbook/Cheque Proof :  &nbsp; </label> 
									<input required ="true" accept = ".pdf,application/pdf" class="toggle btn btn-primary" type="File" id="pass_cheque_proof" name = "pass_cheque_proof" value = "<?php echo $passchequeproof;?>" style="margin-bottom: 7px;"><!--span class="text-success">&nbsp;<?php echo $passchequeproof;?></span--></input></br>
									
									<label style="color: #495057;">&nbsp;EPF/ESI Proof :  &nbsp; </label> 
									<input required ="true" accept = ".pdf,application/pdf" class="toggle btn btn-primary" type="File" id="pf_esi_proof" name = "pf_esi_proof" value = "<?php echo $pfesiproof;?>" style="margin-bottom: 7px;"><!--span class="text-success">&nbsp;<?php echo $pfesiproof;?></span--></input></br>
									
									<label style ="margin-left: -3px;color: #495057;">Consent Proof :  &nbsp; </label> 
									<input required ="true" accept = ".pdf,application/pdf" class="toggle btn btn-primary" type="File" id="consent_proof" name = "consent_proof" value = "<?php echo $consentproof;?>" style="margin-bottom: 7px;"><!--span class="text-success">&nbsp;<?php echo $consentproof;?></span--></input></br>
									
									<label style ="margin-left: 14px;color: #495057;">Photo Proof :  &nbsp; </label> 
									<input required ="true" accept = "image/*" class="toggle btn btn-primary" type="File" id="photo_proof" name = "photo_proof" value = "<?php echo $photoproof;?>" style="margin-bottom: 7px;"><!--span class="text-success">&nbsp;<?php echo $photoproof;?></span--></br>
									
									<label style ="margin-left: -37px;color: #495057;">Appointment Proof :  &nbsp; </label> 
									<input required ="true" accept = ".pdf,application/pdf" class="toggle btn btn-primary" type="File" id="appointment_proof" name = "appointment_proof" value = "<?php echo $appointmentproof;?>"><!--span class="text-success">&nbsp;<?php echo $appointmentproof;?></span--></input></br>
									
									<input class="toggle btn btn-primary"  onclick = "uploadme()" type="submit" id="update_document" name = "update_document" value="Update Operator Documents" style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
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
			
			
			var uidai = $("#uidai_proof").val();
			
			var pan = $("#pan_proof").val();
			var aadhar = $('#aadhar_proof').val();
			var passchequestat = $('#status_checked').val();
			var passchequestat1 = $('#status_unChecked').val();
			var passchequeproof = $('#pass_cheque_proof').val();
			var pfesiproof = $('#pf_esi_proof').val();
			var consentproof = $('#consent_proof').val();
			var photoproof = $('#photo_proof').val();
			var appointmentproof = $('#appointment_proof').val();
			
			
			//var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
			var allowedImageExtensions = /(\.jpg|\.jpeg)$/i;
			var allowedPdfExtensions = /(\.pdf)$/i;
			
			
			if(allowedPdfExtensions.exec(appointmentproof) ==".pdf,.pdf" && allowedImageExtensions.exec(photoproof) ==".jpg,.jpg" && allowedPdfExtensions.exec(consentproof) ==".pdf,.pdf"
			&& allowedPdfExtensions.exec(pfesiproof) ==".pdf,.pdf" && allowedPdfExtensions.exec(passchequeproof) ==".pdf,.pdf" && allowedPdfExtensions.exec(aadhar) ==".pdf,.pdf"
			&& allowedPdfExtensions.exec(pan) ==".pdf,.pdf" && allowedPdfExtensions.exec(uidai) ==".pdf,.pdf" && (($('#status_checked').is(':checked')) || ($('#status_unChecked').is(':checked')) ))
			{
				
				document.getElementById("overlay").style.display = "block";
															
				return true;
			}
			else
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			/*if(allowedImageExtensions.exec(photoproof)= "" && !allowedPdfExtensions.exec(uidai)  && !allowedPdfExtensions.exec(pan) && !allowedPdfExtensions.exec(aadhar)
			      && !allowedPdfExtensions.exec(passchequeproof) && !allowedPdfExtensions.exec(pfesiproof) && !allowedPdfExtensions.exec(consentproof) && !allowedPdfExtensions.exec(appointmentproof))
			{
				alert("OKKLKKKKKKK");
				
			}
			else
			{
				alert("ok");
			}*/
			
		}
		</script>
  </body>
</html>