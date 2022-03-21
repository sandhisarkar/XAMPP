<?php

session_start();
error_reporting(0);
//header( "refresh:120;url=Centre.php" );

$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];


if(isset($_POST["ven_sub"]))
{
	mysqli_select_db($con,"vendor_details");
					
	$query = mysqli_query($con, "SELECT Count(*) FROM vendor_details");
	$result=mysqli_fetch_row($query);
	$ven_cou = $result[0];
	
	if($ven_cou == 0)
	{
		$sl_no = 1;
		$insert_sql="INSERT INTO vendor_details (sl_no,vendor_name,vendor_code,vendor_address,Contact_person,Contact_details,person_mail,GSTN,Outsourcing_rate,status) VALUES ('".$sl_no."','".$_POST["ven_name"]."','".$_POST["ven_code"]."','".$_POST["ven_address"]."','".$_POST["person_name"]."','".$_POST["person_contact"]."','".$_POST["person_email"]."','".$_POST["gstn"]."','".$_POST["billing_rate"]."','Active')";

		if (!mysqli_query($con,$insert_sql))
		{	  
			
			$msgnav = "Error";
			header("refresh:3;url=Vendor Details.php" );	
		}
		else
		{
			
			$msgnav = "Success";
			$vencode = $_POST["ven_code"];
			header("refresh:15;url=Vendor Details.php" );	
		}		
	}
	else
	{
		$sl_no = $ven_cou +1;
		
			$query2 = mysqli_query($con, "SELECT Count(*) FROM vendor_details where vendor_name = '".$_POST["ven_name"]."' OR vendor_code = '".$_POST["ven_code"]."' OR vendor_address= '".$_POST["ven_address"]."' OR Contact_details= '".$_POST["person_contact"]."' OR person_mail = '".$_POST["person_email"]."' OR GSTN = '".$_POST["gstn"]."'");
			$result2=mysqli_fetch_row($query2);
			$cou = $result2[0];
			
			
			if($cou ==0)
			{
				$insert_sql="INSERT INTO vendor_details (sl_no,vendor_name,vendor_code,vendor_address,Contact_person,Contact_details,person_mail,GSTN,Outsourcing_rate,status) VALUES ('".$sl_no."','".$_POST["ven_name"]."','".$_POST["ven_code"]."','".$_POST["ven_address"]."','".$_POST["person_name"]."','".$_POST["person_contact"]."','".$_POST["person_email"]."','".$_POST["gstn"]."','".$_POST["billing_rate"]."','Active')";

				if (!mysqli_query($con,$insert_sql))
				{	  
					
					$msgnav = "Error";
					header("refresh:3;url=Vendor Details.php" );	
				}
				else
				{
					
					$msgnav = "Success";
					$vencode = $_POST["ven_code"];
					header("refresh:15;url=Vendor Details.php" );	
				}
			}
			else
			{
				
				$msgnav = "Exists";
				header("refresh:5;url=Vendor Details.php" );	
				
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
			  
	          <li class="active">
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
		
				<h2 class="mb-4"><u>Vendor Registration</u></h2>
	
        <p>
			<div class="col-sm-12" style = "margin-top:0%;">
				
				<div class="col-sm-6" style = "text-align: center; margin-left: auto;margin-right: auto;">
					<center>
					<?php
						if($msgnav == "Exists")
						{
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-warning">Vendor alreay exists... Try agian !</label></br>';
							
							
						}
						if($msgnav == "Error")
						{
							header("refresh:5;url=Vendor.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-danger">Error. . . vendor Cannot be Inserted. . . Please try again</label></br>';
							
							
						}
						if($msgnav == "Success")
						{
							header("refresh:15;url=Vendor Details.php" );	
							echo '<div class="spinner-grow spinner-grow-sm"> </div><span> &nbsp;&nbsp;&nbsp;</span>';
							echo '<label class="text-success">Vendor is Inserted Successfully with Vendor Code - <u>'.$vencode.'</u></label></br>';
							
						}
					?>
					<form  action = "Vendor.php" method ="post"  id = "export_excel" enctype="multipart/form-data">
						<table>
							
							
							<tr>
								<td style = "text-align: center;margin-left: auto;margin-right: auto;">
								
									<label style= "color: #495057;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vendor Name : &nbsp; </label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" type="text"  id="ven_name" name="ven_name" required="true" placeholder ="Enter Vendor Name" autocomplete="off" style ="width:250px;" autofocus></input></br></br>
									
									<label style= "color: #495057;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vendor Code : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" type="text" pattern = "^[A-Z0-9]+$" id="ven_code" name="ven_code" required="true" placeholder ="Enter Vendor Code"autocomplete="off" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp;&nbsp;Vendor Address : &nbsp; </label> 
														
									<textarea style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" id="ven_address" name="ven_address"  required="true" autocomplete="off" placeholder ="Enter Vendor Location"style="width: 250px;"></textarea></br></br>
									
									<label style= "color: #495057;">&nbsp;&nbsp;&nbsp;Contact Person : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" type="text"  id="person_name" name="person_name" autocomplete="off" placeholder ="Enter Person Name" required="true" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp;&nbsp;&nbsp;&nbsp; Person Phone : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" type="tel" pattern="^[0-9]{10}$" id="person_contact" name="person_contact" autocomplete="off" placeholder ="Enter Person Phone" required="true" style ="width:250px;" ></input></br></br>
									<!--small>[Format: 0123456789(10 Digit Number)]</small-->
									
									<label style= "color: #495057;">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Person Email : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" type="email"  id="person_email" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="person_email" autocomplete="off" placeholder ="Enter Person Email ID" required="true" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; GSTN : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" type="text" pattern="^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$" id="gstn" name="gstn" autocomplete="off" placeholder ="Enter Person GST Number" required="true" style ="width:250px;"></input></br></br>
									
									<label style= "color: #495057;">Outsourcing Rate : &nbsp;</label> 
														
									<input style ="border-radius:5px;width:250px;border: 1px solid #ced4da;color: #495057;background-color: #fff;color: #6c757d;opacity: 1;padding: .375rem .60rem;margin-top: -3%;" type="number" min = "1" pattern = "^[0-9]$" id="billing_rate" name="billing_rate" autocomplete="off" placeholder ="Enter Price in Rupees" required="true" style ="width:250px;"></input></br></br>
									
									<button class="toggle btn btn-primary" onclick ="uploadme()" type="submit" id="ven_sub" name = "ven_sub" value="Save Vendor" style="font-family: Verdana;  margin-top:15px; background-color: #1163aa; border: transparent; margin-bottom: 15px;">Save Vendor</button>
									
								</td>
							</tr>
							
						</table>
					</form></center>
					
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
		function validateInputFieldValue() {
			var phoneNo = $("#person_contact").val();
			//alert("dekhi to phone no ta -->>"+phoneNo);
		}
		
	</script>
	<script>
		function uploadme()
		{
			
			var vendor_name = $("#ven_name").val();
			var vendor_code = $("#ven_code").val();
			var vendor_address = $("#ven_address").val();
			var person_name = $("#person_name").val();
			var person_contact = $("#person_contact").val();
			var person_email = $("#person_email").val();
			var gstn = $("#gstn").val();
			var billing_rate = $("#billing_rate").val();
			
			var patt = new RegExp("^[A-Z0-9]+$");
			var res = patt.test(vendor_code);
			
			var patt1 = new RegExp("^[0-9]{10}$");
			var res1 = patt1.test(person_contact);
			
			var patt2 = new RegExp("^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$");
			var res2 = patt2.test(person_email);
			
			var patt3 = new RegExp("^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$");
			var res3 = patt3.test(gstn);
			
			var patt4 = new RegExp("^[0-9]+$");
			var res4 = patt4.test(billing_rate);
			
			
			
			if(vendor_name === "" || vendor_code === "" || vendor_address === "" || person_name === "" || person_contact === "" || person_email === "" || gstn === "" || billing_rate === "" || res == false || res1 == false || res2 == false || res3 == false || res4 == false || billing_rate <=0)
			{
				
				document.getElementById("overlay").style.display = "none";
				return false;
			}
			if(vendor_name !== "" && vendor_code !== "" && vendor_address !== "" && person_name !== "" && person_contact !== "" && person_email !== "" && gstn !== "" && billing_rate !== "" && res == true && res1 == true && res2 == true && res3 == true && res4 == true && billing_rate >= 1)
			{
				
				document.getElementById("overlay").style.display = "block";
											
				return true;		
			}
			
		}
	</script>
  </body>
</html>