<?php

session_start();
error_reporting(0);
header( "refresh:120;url=Salary Generate.php" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];
$error = "";
$success = "";


if(isset($_POST["sub_excel"]))
{
	$query = mysqli_query($con, "SELECT Count(*) FROM salary_month_details where month_year = '".$_POST['month_year']."' ");
	$result=mysqli_fetch_row($query);
	$cen_cou = $result[0];
	
	if($cen_cou == 0)
	{
		$query_q = mysqli_query($con,"select b.district_name,b.state_name,b.centre_name,b.operator_name,b.operator_id,a.month_year,a.total_days_in_month,a.actual_working_days,c.billing_rate_per_month,
		d.vendor_name,d.vendor_address,d.vendor_code,d.outsourcing_rate,b.basic,b.hra,b.conveyance,b.allowance,b.payable_amt,a.hold_amount,a.hold_reason,c.status,d.status,b.activity_status,a.created_dttm,b.station_id,b.bank_name,b.branch_name,b.account_no,b.ifsc		
		from monthly_attendence a,operator_profile b, centre_details c,vendor_details d where a.operator_id = b.operator_id and b.centre_name = c.centre_name and b.district_name = c.dist_name 
		and b.state_name = c.state_name and d.vendor_code = c.vendor_code AND a.month_year = '".$_POST['month_year']."' order by b.sl_no");
		$row_q = mysqli_num_rows($query_q);
		
		
		if (mysqli_num_rows($query_q) > 0) {
			$count = 0;
			$output .="
				<table class='table table-hover table-bordered table-striped' border ='1' width='100%' style = 'text-align: center; overflow-x:auto;font-size: x-small;'>
					<thead class='thead-dark'>
					<tr>
						<th style = 'padding:auto;'>Operator Name</th>
						<th style = 'padding:auto;'>Operator ID</th>
						<th style = 'padding:auto;'>Month-Year</th>
						<th style = 'padding:auto;'>Total Days in Month</th>
						<th style = 'padding:auto;'>Working Days</th>
						<th style = 'padding:auto;'>Basic</th>
						<th style = 'padding:auto;'>HRA</th>
						<th style = 'padding:auto;'>Conveyance</th>
						<th style = 'padding:auto;'>Allowance</th>
						<th style = 'padding:auto;'>Payable Amount</th>
					</tr>
					</thead>
			";
				while($row1 = mysqli_fetch_row($query_q)) {
					
				$dist = $row1[0];	
				$state = $row1[1];
				$cen = $row1[2];
				$opname = $row1[3];
				$opid = $row1[4];
				$monyear = $row1[5];
				$totday = $row1[6];
				$workday = $row1[7];	
				$cenrate = $row1[8];	
				$venname = $row1[9];
				$venadd = $row1[10];
				$vencode = $row1[11];
				$venrate = $row1[12];
				$basic = $row1[13];
				$hra = $row1[14];
				$conv = $row1[15];
				$allow = $row1[16];
				$payamt = $row1[17];
				$holdamt = $row1[18];
				$holreason = $row1[19];
				$censtat = $row1[20];
				$venstat = $row1[21];
				$opstat = $row1[22];
				$created_dttm = $row1[23];
				$station_id = $row1[24];
				$bank = $row1[25];
				$branch = $row1[26];
				$acc = $row1[27];
				$ifsc = $row1[28];
				
				$query_sl = mysqli_query($con ,"select Count(sl_no) from salary_month_details where month_year = '".$_POST['month_year']."'");
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
				
				
				$cenbillamtpermonperop = ($cenrate/$totday)*$workday;
				
				$gross = $basic+$hra+$conv+$allow;
				
				$paytoop = ($payamt/$totday)*$workday;
				
				$empeepf = ($basic *12)/100;
				$empeeEsi = ($gross *0.75)/100;
				
				$net = $gross - $empeepf -$empeeEsi;
				$advadj = $net - $paytoop;
				$amttobank = $paytoop -$holdamt;
				$aggadj = $advadj + $holdamt;	
				
				$emperpf = ($basic *13)/100;
				$emperEsi = ($gross *3.25)/100;
				
				$venbillamt = ($venrate/$totday)*$workday;
				$venbillamtpermonperop = $venbillamt - $amttobank - $empeepf - $empeeEsi;
				
				
				$insert_sql="INSERT INTO salary_month_details (sl_no,month_year,total_days,dist_name,state_name,centre_name,Operator_name,operator_id,working_days,billing_rate,bill_amount_per_month_per_operator,ven_name,
				ven_add,ven_code,ven_bill_rate,ven_bill_amount,ven_bill_per_month_per_op,basic,hra,conv,allow,payamt,paytoop,holamt,hold_reason,gross,net,empee_pf,empee_esi,empr_pf,empr_esi,adv_adj,agg_adj,amt_to_bank,cen_status,ven_status,operator_status,created_dttm,station_id,bank_name,branch_name,acc_no,ifsc,pf_esi_challan_status,bank_advice_status,customer_bill_status,vendor_bill_status)
				VALUES ('".$slno."','".$monyear."','".$totday."','".$dist."','".$state."','".$cen."','".$opname."','".$opid."','".$workday."','".str_replace(",","",number_format($cenrate,2))."','".str_replace(",","",number_format($cenbillamtpermonperop,2))."','".$venname."','".$venadd."','".$vencode."','".str_replace(",","",number_format($venrate,2))."',
				'".str_replace(",","",number_format($venbillamt,2))."','".str_replace(",","",number_format($venbillamtpermonperop,2))."','".str_replace(",","",number_format($basic,2))."','".str_replace(",","",number_format($hra,2))."','".str_replace(",","",number_format($conv,2))."','".str_replace(",","",number_format($allow,2))."','".str_replace(",","",number_format($payamt,2))."','".str_replace(",","",number_format($paytoop,2))."',
				'".str_replace(",","",number_format($holdamt,2))."','".$holreason."','".str_replace(",","",number_format($gross,2))."','".str_replace(",","",number_format($net,2))."','".str_replace(",","",number_format($empeepf,2))."','".str_replace(",","",number_format($emperEsi,2))."','".str_replace(",","",number_format($emperpf,2))."','".str_replace(",","",number_format($emperEsi,2))."',
				'".str_replace(",","",number_format($advadj,2))."','".str_replace(",","",number_format($aggadj,2))."','".str_replace(",","",number_format($amttobank,2))."','".$censtat."','".$venstat."','".$opstat."','".$created_dttm."','".$station_id."','".$bank."','".$branch."','".$acc."','".$ifsc."','Pending','Created','Created','Created')";

				if (!mysqli_query($con,$insert_sql))
				{	  
					header('location:Error.php');
				}
				else
				{
					
					//increament count
					$count = $slno;
					$output .= "
						<tbody>
						<tr>
							<td>$opname</td>
							<td>$opid</td>
							<td>$monyear</td>
							<td>$totday</td>
							<td>$workday</td>
							<td>$basic</td>
							<td>$hra</td>
							<td>$conv</td>
							<td>$allow</td>
							<td>$payamt</td>
						</tr>
						</tbody>
					";
					
				}
				
				
				}
				if($count > 0)
				{
					$output .= '</table>';
					$success = "Uploaded";
					header("refresh:30;url=Salary Generate.php");
				}					
				else
				{
					$success = "No Update";
					header("refresh:5;url=Salary Generate.php");
				}					
				}
	}
	else
	{
		$msg = "Exists";
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
		
        <h2 class="mb-4"><u>Generate Monthly Salary</u> </h2>
		
        <p>
			<div class="col-sm-12" style = "margin-top:10%;">
				
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					
					
					<center>
						
						
						<form  action = "Salary Generate.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
							<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									
									
									<label>Choose Month-Year : &nbsp; </label>
									<!--class="btn btn-primary dropdown-toggle" -->
									<select   required="true" id="month_year" name="month_year" style="width: 250px;">
											<option selected value="" disabled>Select Any...</option>
											
										<?php
											

											$sql = "SELECT Distinct(month_year) FROM monthly_attendence where status = 'Approved' AND month_year NOT IN (select month_year from salary_month_details) order by month_year ASC";
											$result = mysqli_query($con, $sql);
											if (mysqli_num_rows($result) > 0) {
											// output data of each row
											
											while($row = mysqli_fetch_row($result)) {
												?>
												
												<option value = "<?php echo $row[0]; ?>"><?php echo  $row[0]?></option>
												<?php
											}
										} else {
											echo "";
										}
										?>
										
									</select></br></br>
									
									<button class="toggle btn btn-primary" onclick = "uploadme()" type="submit" id="sub_excel" name = "sub_excel"
									style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">Generate Salary</button>
									
								</td>
							</tr>
							
							
							</table>
							
						</form>
						</center>
						
				</div>
				
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
					<?php
						
						if($error == "" || $success == "")
						{
							
							echo '<label class="text-danger"></label>';
							
						}
						if($error == "Invalid File")
						{
							header( "refresh:3;url=Attendence.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Invalid File . . . Please Select Correct File</label>';
							
						}
						if($error == "Select")
						{
							header( "refresh:3;url=Salary Generate.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Please Select Correct File</label>';
							
						}
						if($success == "Uploaded")
						{
							header( "refresh:30;url=Salary Generate.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Total Salary Generated : '.$count.' </label>';
							echo $output;
							
						}
						if($success == "No Update")
						{
							header( "refresh:3;url=Salary Generate.php" );
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Total Salary Generated : '.$count.' </label>';
							header( "refresh:3;url=Salary Generate.php" );
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
			var month_year = $("#month_year").val();
			
			
			if(month_year === "" || month_year ==="")
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			if(month_year !== null && month_year !== "")
			{
				
				document.getElementById("overlay").style.display = "block";
				window.location.href = 'Salary Generate.php';

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
  </body>
</html>
