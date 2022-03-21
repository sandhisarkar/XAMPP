<?php

session_start();
error_reporting(0);
//header( "refresh:120;url=PF_ESI Report.php" );
//require('fpdf/fpdf.php');
$con=mysqli_connect("localhost","root","root","bihar_pec");
$q=mysqli_query($con,"select admin_user from admin_user where admin_user='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['admin_user'];
$id=$_SESSION['user'];
$error = "";
$success = "";


$get_ID = $_GET["Handle"];
echo $get_ID;
if($get_ID == "Generated")
{
	header( "refresh:3;url=PF_ESI Report.php" );
}
else
{
	
}

if(isset($_POST["excel_sub"]))
{
	$stDt1 = $_POST['start_date'];
	$endDt1 = $_POST['end_date'];
	
	$year1 = substr($stDt1,0,4);
	$month1 = substr($stDt1,5,2);
	
	$year2 = substr($endDt1,0,4);
	$month2 = substr($endDt1,5,2);
	
	$distname = $_POST['dist_name'];
	
	if($month2 == "01")
	{
		$date = 31;
	}
	if($month2 == "02" && $year2%4 == 0)
	{
		$date = 29;
	}
	if($month2 == "02" && $year2%4 != 0)
	{
		$date = 28;
	}
	if($month2 == "03")
	{
		$date = 31;
	}
	if($month2 == "04")
	{
		$date = 30;
	}
	if($month2 == "05")
	{
		$date = 31;
	}
	if($month2 == "06")
	{
		$date = 30;
	}
	if($month2 == "07")
	{
		$date = 31;
	}
	if($month2 == "08")
	{
		$date = 31;
	}
	if($month2 == "09")
	{
		$date = 30;
	}
	if($month2 == "10")
	{
		$date = 31;
	}
	if($month2 == "11")
	{
		$date = 30;
	}
	if($month2 == "12")
	{
		$date = 31;
	}
	
	$ymd = $year2."-".$month2."-".$date;
	
	$monyr= $_POST["month_year"];
	
	
	
		//$sql = "SELECT DISTINCT(MONTH_YEAR) FROM salary_month_details WHERE created_dttm >=  '".$stDt1."' AND created_dttm <= '".$ymd."' ORDER BY MONTH_YEAR ASC";
		 
		 $sql = "SELECT DISTINCT(MONTH_YEAR) FROM salary_month_details WHERE month_year= '".$monyr."' ORDER BY MONTH_YEAR ASC";
		 
		 $result = mysqli_query($con, $sql);
		//echo $sql;
		if (mysqli_num_rows($result) > 0) {			
			
		$msg = "ok";
		
		//Including PHPExcel library and creation of its object
		require_once 'Classes/PHPExcel.php';
		$phpExcel = new PHPExcel;

		// Setting font to Arial Black
		//$phpExcel->getDefaultStyle()->getFont()->setName('Arial Black');
		
		// Setting font size to 14
		//$phpExcel->getDefaultStyle()->getFont()->setSize(14);
		
		//Setting description, creator and title
		$phpExcel ->getProperties()->setTitle("Monthly Customer Billing Advice");
		$phpExcel ->getProperties()->setCreator("Sandhi Sarkar");
		$phpExcel ->getProperties()->setDescription("Excel for Customer Billing Advice");
		
		// Creating PHPExcel spreadsheet writer object
		// We will create xlsx file (Excel 2007 and above)
		$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
		
		// When creating the writer object, the first sheet is also created
		
		// We will get the already created sheet
		$sheet = $phpExcel ->getActiveSheet();
		
		// Setting title of the sheet
		$sheet->setTitle('Monthly Customer Billing Advice');
		
		// Creating spreadsheet header
		$sheet ->getCell('E1')->setValue('Monthly Customer Billing Advice');
		$sheet->getStyle('E1')->getFont()->setBold(true)->setSize(12);
		
		$sheet ->getCell('A3')->setValue('Serial No.');
		$sheet ->getCell('B3')->setValue('Month-Year');
		$sheet ->getCell('C3')->setValue('District Name');
		$sheet ->getCell('D3')->setValue('Centre Name');
		$sheet ->getCell('E3')->setValue('Station ID');
		$sheet ->getCell('F3')->setValue('Number of Working Days');
		$sheet ->getCell('G3')->setValue('Rate Per Centre Per Month');
		$sheet ->getCell('H3')->setValue('Billing Amount');
		$sheet ->getCell('I3')->setValue('Billing Status');
		
		
		// Making headers text bold and larger
		
		$sheet->getStyle('A3:I3')->getFont()->setBold(true)->setSize(11);
		
		$count = 4;
		$sl_no = 1;
		$result1 = mysqli_query($con, "SELECT DISTINCT(MONTH_YEAR) FROM salary_month_details WHERE month_year= '".$monyr."' ORDER BY MONTH_YEAR ASC");
		 while($row = mysqli_fetch_row($result1)) {
			 
		 $month_yr = $row[0];
		 
		 $result2 = mysqli_query($con, "SELECT centre_name,station_id,working_days,billing_rate,bill_amount_per_month_per_operator,customer_bill_status FROM salary_month_details WHERE month_year =  '".$month_yr."' AND dist_name = '".$distname."'");
		 while($row1 = mysqli_fetch_row($result2)){
		 
		 
		 $centrename = $row1[0];
		 $stationid = $row1[1];
		 $workday = $row1[2];
	     $billrate = $row1[3];
	     $billamtperop = $row1[4];
		 $status = $row1[5];
		 
		 if($status == 'Created')
		{
			$status = "Pending for Approval";
		}
		else if($status == 'Pending')
		{
			$status = "Approved but Bill Generation Pending";
		}
		else
		{
			$status = "Bill Generated";
		}
		 
		// Insert product data
		$sheet ->getCell('A'.$count.'')->setValue($sl_no);
		$sheet ->getCell('B'.$count.'')->setValue($month_yr);
		$sheet ->getCell('C'.$count.'')->setValue($distname);
		$sheet ->getCell('D'.$count.'')->setValue($centrename);
		$sheet ->getCell('E'.$count.'')->setValue($stationid);
		$sheet ->getCell('F'.$count.'')->setValue($workday);
		$sheet ->getCell('G'.$count.'')->setValue($billrate);
		$sheet ->getCell('H'.$count.'')->setValue($billamtperop);
		$sheet ->getCell('I'.$count.'')->setValue($status);
		
		$count++;
		$sl_no++;
		 }
		 
		 }
		    
		// Autosize the columns
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(false);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		
		
		// Save the spreadsheet
		$filename = "Monthly_Customer_Billing_".date('Ymd');
		
		//alert($filename);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');	
			
		
		}
		else
		{
			$msg= "not ok";
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
		<script src='https://kit.fontawesome.com/a076d05399.js'></script>
		
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
		
        <h2 class="mb-4"><u>Generate Monthly Neaveh Billing Advice (Bill to Customer)</u> </h2>
		
        <p>
			<div class="col-sm-12">
				<section id="services" class="section" style="display:block;">
				<center>
				<div class="row">
					
					
					  <div class="col-sm-12  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top:10%">
					  
							<form  action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method ="post"  id = "export_excel" enctype="multipart/form-data">
						    <div>
								<!--i class="fa fa-calendar"></i>&nbsp;<label>Start Date : &nbsp;</label><input required ="true" type ="date" id="start_date" name ="start_date"></input><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<i class="fa fa-calendar"></i>&nbsp;<label>End Date : &nbsp;</label><input required ="true" type ="date" id="end_date" name ="end_date"></input-->
								<label style="margin-left: -30px;color: #495057;"><i class="fa fa-calendar"></i>&nbsp; Choose Month-Year : &nbsp; </label>
									<select required="true" id="month_year" name="month_year" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 115px;">
										<option disabled selected value = "">Select Any...</option>
										<?php
											//mysqli_select_db( $con,"course_details");

											$sql = "SELECT DISTINCT(month_year) FROM salary_month_details where customer_bill_status  = 'Pending' OR customer_bill_status  = 'Created' order by month_year ASC";
											$result = mysqli_query($con, $sql);
											if (mysqli_num_rows($result) > 0) {
											// output data of each row
											while($row = mysqli_fetch_row($result)) {
												?>
												<option><?php echo  $row[0]?></option>
												<?php
											}
										} else {
											 echo  "";
										}
										?>
										
									</select></br>
							</div>
							<div style="padding-top: 1%;">
								<i class="fa fa-map"></i>&nbsp;<label>Choose Location : &nbsp; </label>
									<!--class="btn btn-primary dropdown-toggle" -->
									<select   required="true" id="dist_name" name="dist_name" autofocus>
											<option selected value="" disabled>Select Any...</option>
											<?php
											

											$sql = "SELECT Distinct(dist_name) FROM salary_month_details where customer_bill_status  = 'Pending' OR customer_bill_status  = 'Created' order by dist_name ASC";
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
									</select>
								
							</div>
							<div style="padding-top: 1%;">
								<button type="submit" id = "excel_sub" name = "excel_sub" class="btn btn-primary"  onclick = "uploadme()">Export to Excel<span></span> <i class="fa fa-file-excel-o"></i></button>
							</div>
							</form>
					  
					  </div>
					 
					 
					 
							
					<?php
					 if($msg == "not ok")
					 {
						 
						 ?>
						 </br>
					  
					  <div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" style="margin-top:5%;">
						  <div class="box">
							<h4 class="title"><i class="fa fa-search text-info"></i> No Customer Billing Advice Found. . . </h4>
							<h6 class = "title"><i class="fa fa-map text-warning"></i> District - <u><?php echo $distname;?></u> </h6>
							<h6 class = "title"> Month-Year :  <u>[<?php echo $_POST["month_year"];?>]</u> <i class="fa fa-calendar text-info"></i></h6>
						  </div>
					  </div>
					 <?php
					 }
						?>
				

							
				</div>
				</center>
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
		
		<div class="displayNone"> 
			<input type="hidden"  id="txtSequenceId" name="txtSequenceId"/>
		</div>
		<!-- Modal -->
		
		
		<div id="MyFirstModalId" class="modal fade bd-example-modal-lg" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header">
			  <h4 class="modal-title float-left">Month - Year : <span id="mon" name="mon"></span></h4>
				<button type="button" class="close" data-dismiss="modal">X</button>
				
			  </div>
			  <div class="modal-body">
				<!--p>Hey ! Do you want to delete ?</p-->
				<!--p--><table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: x-small;">
					<thead class="thead-dark">
						<tr>
							<th style = 'padding:auto;'>State</th>
							<th style = 'padding:auto;'>District</th>
							<th style = 'padding:auto;'>Centre Name</th>
							<th style = 'padding:auto;'>Operator Name</th>
							<th style = 'padding:auto;'>Operator ID</th>
							<th style = 'padding:auto;'>Billing Amount</th>	
						</tr>
					</thead>
					
					<?php
					
					//$abc = '<script>document.write(document.getElementById("#txtSequenceId"));</script>';
					echo $_SESSION["txtSequenceId"][$count];
					$query = "SELECT bill_amount_per_month_per_operator FROM salary_month_details WHERE month_year =  '".$_SESSION["txtSequenceId"]."' ";
					 $result1 = mysqli_query($con, $query);
					 echo $query;
					while($row = mysqli_fetch_row($result1)) {
						?>
						<tbody>
						<tr>
							<td style = "padding: auto;"><?php echo  $row[0]?></td>
						</tr>
						</tbody>
						<?php
						
					}
					?>
				</table><!--/p-->
			  </div>
			  <div class="modal-footer">
			  <!--button type="submit" id = "excel_sub" class="btn btn-primary" data-dismiss="modal" onclick = "uploadme()">Confirm</button-->
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
			</div>
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
		function uploadme()
		{
			
			var distname = $("#dist_name").val();
			var date = $("#month_year").val();
			
			
			
			
			if(date !== "" && distname !== "")
			{
				
					
					//document.getElementById("overlay").style.display = "block";
					//$("#search").show();
					
					return true;
				
			}
			if(date === null || distname === null)
			{
				document.getElementById("overlay").style.display = "none";
				//$("#search").hide();
				return false;
			}
			
		}
	</script>
	
	<script language ="javascript">
		function openOverlay()
		{
			
			document.getElementById("overlay").style.display = "block";
			
				return true;
			
			
		}
	</script>
	<script>
	function showme(unId,id1,id2){
		
		//$(unId).DataTable();
		$(unId).show();
		
		$(id1).hide();
		$(id2).show();
	}
	</script>
	<script>
		function hideme(unId,id1,id2){
			//alert(unId);
			$(unId).hide();
			
			$(id1).show();
			$(id2).hide();
		}
		</script>
		<script>
		function operatorCheck()
		{
			
			var value = $('#operator').val();
			if(value === "ALL")
			{
				
				$("#operator_id").prop('readonly',true);
				$("#operator_id").css("background-color", "ghostwhite");
				$('#operator_id').val('');
			}
			if(value === "Individual")
			{
				
				$("#operator_id").prop('readonly',false);
				$("#operator_id").css("background-color", "transparent");
				
			}
			
		}
		</script>
	<script>
		$(document).ready(function() {
		$('#example').DataTable();
	} );
	</script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
    
  </body>
</html>
