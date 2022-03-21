<?php

session_start();
error_reporting(0);
//header( "refresh:120;url=Centre.php" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];
$error = "";
$success = "";



if(isset($_POST["sub_excel"])) {
	
	if(!empty($_FILES["excel_file"]))
	{
		$file_array = explode(".",$_FILES["excel_file"]["name"]);
		
		if($_FILES["excel_file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || $_FILES["excel_file"]["type"] == "application/vnd.ms-excel")
		{
			include("Classes/PHPExcel/IOFactoty.php");
			require_once 'Classes/PHPExcel.php';
			$output .="
				<table class='table table-hover table-bordered table-striped' border ='1' width='100%' style = 'text-align: center; overflow-x:auto;font-size: x-small;'>
					<thead class='thead-dark'>
					<tr>
						<th style = 'padding:auto;'>District</th>
						<th style = 'padding:auto;'>State</th>
						<th style = 'padding:auto;'>Centre Name</th>
						<th style = 'padding:auto;'>Centre Address</th>
						<th style = 'padding:auto;'>Vendor Code</th>
						<th style = 'padding:auto;'>Billing Rate</th>
					</tr>
					</thead>
			";
			
			$object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);
			$object ->setActiveSheetIndex(0);
			
			//count define
			$count = 0;
			
			foreach($object -> getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				
				
				for($row =2; $row<= $highestRow; $row++)
				{
					//$district  = $worksheet->getActiveSheet()->getCell(B2)->getValue();
					$district  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1,$row)->getValue());
					$state  = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2,$row)->getValue());
					$cenname = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3,$row)->getValue());
					$cenadd = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4,$row)->getValue());
					$vendorcode = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5,$row)->getValue());
					$billrate = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6,$row)->getValue());
					
					// search from centre details 
					mysqli_select_db($con,"centre_details");
					//$sql = "SELECT Count(*) FROM centre_details where centre_name = '".$cenname."' AND dist_name = '".$district."'";
					$query = mysqli_query($con, "SELECT Count(*) FROM centre_details where centre_name = '".$cenname."' AND dist_name = '".$district."' AND state_name = '".$state."'");
					$result=mysqli_fetch_row($query);
					$cen_cou = $result[0];
					
					if($cen_cou == 0)
					{
						//checking max sl_no
						mysqli_select_db($con,"centre_details");
						$query_sl = mysqli_query($con ,"select Count(sl_no) from centre_details");
						$res=mysqli_fetch_row($query_sl);
						$tot = $res[0];
						
						$slno = 0;
						if($tot == null)
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
						if($district != null && $state != null && $cenname != null)
						{
							$insert_sql="INSERT INTO centre_details (sl_no,Dist_name,State_name,centre_name,centre_address,vendor_code,billing_rate_per_month,status) VALUES ('".$slno."','".$district."','".$state."','".$cenname."','".$cenadd."','".$vendorcode."','".$billrate."','Active')";

							if (!mysqli_query($con,$insert_sql))
							{	  
								header('location:Error.php');
							}
							else
							{
								//if row count greater than zero and inserted
								$output .= "
									<tbody>
									<tr>
										<td>$district</td>
										<td>$state</td>
										<td>$cenname</td>
										<td>$cenadd</td>
										<td>$vendorcode</td>
										<td>$billrate</td>
									</tr>
									</tbody>
								";
								
								//increament count
								$count +=1;
							}
						}
					}
					
				}
				
			}
			
			if($count > 0)
			{
				$output .= '</table>';
				$success = "Uploaded";
				header("refresh:10;url=Centre.php");
			}
			if($count == 0)
			{
				$success = "No Update";
				header("refresh:5;url=Centre.php");
			}
		}
		else
		{
			$error = "Invalid File";
			header( "refresh:3;url=Centre.php" );
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
	          
	          <li class="active">
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
		
        <h2 class="mb-4"><u>Excel Upload</u> (Centre)</h2>
		
        <p>
			<div class="col-sm-12" style = "margin-top:5%;">
				
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					
					
					<center><form  action = "Centre.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
						<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									<label>Choose Excel File: &nbsp; </label> 
														
									<input  required ="true" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="toggle btn btn-primary" type="File" id="excel_file" name = "excel_file">
									
									<button class="toggle btn btn-primary" onclick = "uploadme()" type="submit" id="sub_excel" name = "sub_excel"
									style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">Upload</button>
								</td>
							</tr>
							
							
						</table>
					</form></center>
					
				</div>
				
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
					<?php
						
						if($error == "" || $success == "")
						{
							
							echo '<label class="text-danger"></label>';
						}
						if($error == "Invalid File")
						{
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Invalid File . . . Please Select Correct File</label>';
							//header( "refresh:30;url=Centre.php" );
						}
						if($success == "Uploaded")
						{
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted</label>';
							echo $output;
							
						}
						if($success == "No Update" && $error != "Invalid File")
						{
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">File Uploaded Successfully . . .  '.$count.' Rows Inserted</label>';
							//header( "refresh:30;url=Centre.php" );
						}
					?>
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
		function on() {
		  document.getElementById("overlay").style.display = "block";
		}

		function off() {
		  document.getElementById("overlay").style.display = "none";
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
	<script language ="javascript">
		function uploadme()
		{
			var excel = $("#excel_file").val();
			
			
			if(excel === "")
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			if(excel !== null)
			{
				
				document.getElementById("overlay").style.display = "block";
				window.location.href = 'Operator.php';

				return true;
			}
			
		}
	</script>
  </body>
</html>

