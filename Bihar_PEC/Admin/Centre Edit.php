<?php

session_start();
error_reporting(0);
//header( "refresh:120;url=Centre.php" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];



$cen_sl = $_GET["Handle"];

if($cen_sl == NULL)
{
	$msgNav = "";
}
else
{
	$query = mysqli_query($con,"select Dist_name, State_name , centre_name,centre_address, vendor_code, billing_rate_per_month,status from centre_details where sl_no = '".$cen_sl."'");
	$row_q = mysqli_fetch_assoc($query);
	
	$dis = $row_q["Dist_name"];
	$state = $row_q["State_name"];
	$cen_name = $row_q["centre_name"];
	$cen_add = $row_q["centre_address"];
	$ven_code = $row_q["vendor_code"];
	$billrate = $row_q["billing_rate_per_month"];
	$status = $row_q["status"];
	
	$msgNav = "Showing";
	
}

if(isset($_POST["update_centre"]))
{

$sql="UPDATE centre_details SET Dist_name='".$_POST['dis_name']."',State_name = '".$_POST['state_name']."',centre_name='".$_POST['centre_name']."',centre_address = '".$_POST['centre_address']."',vendor_code='".$_POST['vendor_code']."',billing_rate_per_month='".$_POST['billing_rate']."',status = '".$_POST['status']."' WHERE sl_no='".$cen_sl."'";

	if (!mysqli_query($con,$sql))
	{
	  
	  $msgNav = "Error";
	  header("refresh:3;url=Centre Details.php" );	
    }
	else
	{
		
	  $msgNav = "Success";
	  header("refresh:15;url=Centre Details.php" );
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
		<link rel="stylesheet" href="css/stylenew.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link href="images/xyz.png" rel="icon">
		<link href="images/xyz.png" rel="apple-touch-icon">
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
		<?php if($msgNav == "Showing")
		{
			?>
				<h2 class="mb-4"><u>Edit Centre</u> (<?php  echo $cen_name;?>)</h2>
		<?php 
		} 
		    ?>
		<?php if($msgNav == "Success")
		{
			$cen_name = $_POST['centre_name'];
		?>
				<h2 class="mb-4"><u>Edit Centre</u> (<?php  echo $cen_name;?>)</h2>
		<?php 
		} 
		?>				
        <p>
			<div class="col-sm-12" style = "margin-top:0%;">
				
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					<center>
					<?php
						if($msgNav == "Showing")
						{
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-info">Showing Result for Centre :-  <u>'.$cen_name.'</u></label></br>';
							
							
						}
						if($msgNav == "Error")
						{
							header("refresh:1;url=Centre Details.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Error. . .Cannot Update Centre. . . Please try again</label></br>';
							
							
						}
						if($msgNav == "Success")
						{
							header("refresh:15;url=Centre Details.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Centre is Updated</label></br>';
							$dis = $_POST['dis_name'];
							$state = $_POST['state_name'];
							$cen_name = $_POST['centre_name'];
							$cen_add = $_POST['centre_address'];
							$ven_code = $_POST['vendor_code'];
							$billrate = $_POST['billing_rate'];
							$status = $_POST['status'];
						}
					?></br>
					<form  action = "Centre Edit.php?Handle=<?php echo  $cen_sl;?>" method ="post"  id = "export_excel" enctype="multipart/form-data">
						<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
									<label style= "color: #495057;"> &nbsp;District Name : &nbsp; </label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $dis;?>"  type="text" id="dis_name" name="dis_name" required="true" placeholder ="Enter District Name" autocomplete="off" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp; &nbsp; &nbsp;State Name : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $state;?>"  type="text" id="state_name" name="state_name" required="true" placeholder ="Enter State Name"autocomplete="off" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp; &nbsp;Centre Name : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $cen_name;?>"  type="text" id="centre_name" name="centre_name" autocomplete="off" placeholder ="Enter Centre Name" required="true" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">Centre Address : &nbsp; </label> 
														
									<textarea style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" id="centre_address" name="centre_address"  required="true" autocomplete="off" placeholder ="Enter Centre Location"style="width: 250px;"><?php echo $cen_add;?> </textarea></br></br>
									
									<label style= "color: #495057;">&nbsp; &nbsp;Vendor Code : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $ven_code;?>" pattern = "^[A-Z0-9]+$" type="text" id="vendor_code" name="vendor_code" autocomplete="off" placeholder ="Enter Unique Vendor Code" required="true" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Billing Rate : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" value ="<?php echo $billrate;?>" type="number" pattern = "^[0-9]+$" min = "1" id="billing_rate" name="billing_rate" autocomplete="off" placeholder ="Enter Price in Rupees" required="true" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp;&nbsp;Activity Status :  &nbsp;</label> 
														
									<select style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;height:35px;padding: .375rem .60rem;margin-top: -3%;" required="true" id="status" name="status" style="width: 250px;">
											<option selected value="" disabled>Select Any...</option>
											<option selected value= "<?php echo $status; ?>"><?php echo $status; ?></option>
										<?php
											mysqli_select_db( $con,"status_master");

											$sql = "SELECT status FROM status_master where status <> '".$status."'";
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
										
									</select></br>
									
									<input class="toggle btn btn-primary" onclick="uploadme(<?php echo $cen_sl; ?>)" type="submit" id="update_centre" name = "update_centre" value="Centre Update" style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">
								</td>
							</tr>
							
						</table>
					</form>
					</center>
					
				</div>
				
				<div class="col-sm-12" style = "text-align: center; margin-left: auto;margin-right: auto;">
					
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
		function uploadme(cenID)
		{
			
			var dist = $("#dis_name").val();
			var state = $("#state_name").val();
			var cen_name = $("#centre_name").val();
			var cen_add = $("#centre_address").val();
			var ven_code = $("#vendor_code").val();
			var billrate = $("#billing_rate").val();
			var status = $("#status").val();
			
			var patt = new RegExp("^[A-Z0-9]+$");
			var res = patt.test(ven_code);
			var patt1 = new RegExp("^[0-9]+$");
			var res1 = patt1.test(billrate);
			
			
			if(dist === "" || state === "" || cen_name === "" || cen_add === "" || ven_code === "" || res == false || billrate === "" || billrate == false || billrate <=0 || status === "")
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			
			if(dist !== null && state !== null && cen_name !== null && cen_add !== null && ven_code !== null && res == true && billrate !== null && res1 == true && status !== null && billrate>=1)
			{
				document.getElementById("overlay").style.display = "block";
											
				return true;						
			}
			
			
		}
	</script>
  </body>
</html>