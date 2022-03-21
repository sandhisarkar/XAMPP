<?php

session_start();
error_reporting(0);
//header( "refresh:120;url=Centre.php" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];



$at_sl = $_GET["Handle"];
$mon_yr = $_GET["MonYr"];

if($at_sl == NULL && $mon_yr == NULL)
{
	$msgNav = "";
}
else
{
	$query = mysqli_query($con,"select district_name, operator_id , operator_name,total_days_in_month,actual_working_days,hold_amount,hold_reason from monthly_attendence where sl_no = '".$at_sl."' AND month_year = '".$mon_yr."'");
	$row_q = mysqli_fetch_row($query);
	
	$dis = $row_q[0];
	$opid = $row_q[1];
	$opname = $row_q[2];
	$totalday = $row_q[3];
	$workday = $row_q[4];
	$holdamt = $row_q[5];
	$holdreason = $row_q[6];
	
	$msgNav = "Showing";
	
}


if(isset($_POST["update_attendance"]))
{

$sql="UPDATE monthly_attendence SET district_name='".$_POST['dis_name']."',operator_name = '".$_POST['op_name']."',actual_working_days='".$_POST['work_day']."',hold_amount = '".$_POST['hold_amount']."',hold_reason='".$_POST['hold_reason']."' WHERE sl_no='".$at_sl."' AND month_year= '".$mon_yr."'";

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
		<div id="content" class="p-4 p-md-5 pt-5" >
		<?php if($msgNav == "Showing")
		{
			?>
				<h2 class="mb-4"><u>Edit Attendance</u> (Month-Year : <u><?php  echo $mon_yr;?></u> <i class="fa fa-calendar text-info"></i>)</h2>
		<?php 
		} 
		    ?>
		<?php if($msgNav == "Success")
		{
			$cen_name = $_POST['centre_name'];
		?>
				<h2 class="mb-4"><u>Edit Attendance</u> (Month-Year : <u><?php  echo $mon_yr;?></u> <i class="fa fa-calendar text-success"></i>)</h2>
		<?php 
		} 
		?>				
        <p>
			<div class="col-sm-12" style = "margin-top:0%;">
				<section id="services" class="section" style="display:block;">
				<div class="row">
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					<center>
					<?php
						if($msgNav == "Showing")
						{
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box">
								<h6 class="title" style="margin:0%;text-align: center;font-weight: inherit;"><i class="fa fa-user text-warning"></i> Operator ID : ( <?php echo $opid ?>  ) </h6>
								
							  </div>
						  </div>
						  <?php
						}
						if($msgNav == "Error")
						{
							
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box">
								<h6 class="title" style="margin:0%;text-align: center;font-weight: inherit;"> Error. . .Cannot Update Attendance. . . Please try again</h6>
								
							  </div>
						  </div>
						  <?php
							
						}
						if($msgNav == "Success")
						{
							$dis = $_POST['dis_name'];
							$opname = $_POST['op_name'];
							$totalday = $_POST['tot_days'];
							$workday = $_POST['work_day'];
							$holdamt = $_POST['hold_amount'];
							$holdreason = $_POST['hold_reason'];
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s">
							  <div class="box">
								<h6 class="title" style="margin:0%;text-align: center;font-weight: inherit;"> Attendance is Updated</h6>
								<h6 class="title" style="margin:0%;text-align: center;font-weight: inherit;"><i class="fa fa-user text-success"></i> Operator ID : ( <?php echo $opid ?>  ) </h6>
								<h6 class="title" style="margin:0%;text-align: center;font-weight: inherit;"> Month-Year : <u><b><?php echo $mon_yr;?></b></u> <i class="fa fa-calendar text-success"></i></h6>
							  </div>
						  </div>
						  <?php
														
						}
					?></br>
					<form  action = "Attendance Edit.php?Handle=<?php echo  $at_sl;?>&MonYr=<?php echo $mon_yr;?>" method ="post"  id = "export_excel" enctype="multipart/form-data">
						<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									<label style= "color: #495057;"> &nbsp;District Name : &nbsp; </label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $dis;?>"  type="text" id="dis_name" name="dis_name" required="true" placeholder ="Enter District Name" autocomplete="off" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;margin-left:-7%">&nbsp; &nbsp; &nbsp;Operator Name : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $opname;?>"  type="text" id="op_name" name="op_name" required="true" placeholder ="Enter Operator Name"autocomplete="off" style ="width:250px;"></input></br></br>
									
									
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;display:none;" value ="<?php echo $totalday;?>"  type="text" id="tot_days" name="tot_days" autocomplete="off" placeholder ="Enter Total Days" required="true" style ="width:250px;"></input>
									
									<label style= "color: #495057;margin-left: -10%;">Actual Working Days : &nbsp; </label> 
														
									<input type = "number" style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" id="work_day" name="work_day" value="<?php echo $workday;?>" required="true" autocomplete="off" min= "0" max="<?php echo $totalday;?>" placeholder ="Enter Working Days" style="width: 250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp; &nbsp;Hold Amount : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $holdamt;?>"  type="number"  min= "0" max= "4000" id="hold_amount" name="hold_amount" autocomplete="off" placeholder ="Enter Hold Amount" required="true" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp; &nbsp;&nbsp;Hold Reason : &nbsp;</label> 
														
									<textarea style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;"  id="hold_reason" name="hold_reason" autocomplete="off" placeholder ="Enter Hold Reason"  style ="width:250px;"><?php echo $holdreason;?></textarea></br>
									
									
									
									<input class="toggle btn btn-primary" onclick="uploadme(<?php echo $at_sl; ?>)" type="submit" id="update_attendance" name = "update_attendance" value="Attendance Update" style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
								</td>
							</tr>
							
						</table>
					</form>
					</center>
					
				</div>
				
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
					
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
		function uploadme(stID)
		{
			
			var dist = $("#dis_name").val();
			var op_name = $("#op_name").val();
			var tot_days = $("#tot_days").val();
			var work_day = $("#work_day").val();
			var hold_amount = $("#hold_amount").val();
			
			
			if(dist === "" || op_name === "" || work_day === "" || hold_amount === "" || work_day <=0  || work_day >= tot_days || hold_amount < 0 || hold_amount > 4000)
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			
			if(dist !== null && op_name !== null && work_day !== null && hold_amount !== null && work_day <= tot_days)
			{
				document.getElementById("overlay").style.display = "block";
											
				return true;						
			}
			
			
		}
	</script>
  </body>
</html>