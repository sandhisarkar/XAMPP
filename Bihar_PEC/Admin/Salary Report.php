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
		$phpExcel ->getProperties()->setTitle("Monthly Operator's Salary Payment List");
		$phpExcel ->getProperties()->setCreator("Sandhi Sarkar");
		$phpExcel ->getProperties()->setDescription("Excel for Monthly Operator's Salary Payment");
		
		// Creating PHPExcel spreadsheet writer object
		// We will create xlsx file (Excel 2007 and above)
		$writer = PHPExcel_IOFactory::createWriter($phpExcel, "Excel2007");
		
		// When creating the writer object, the first sheet is also created
		
		// We will get the already created sheet
		$sheet = $phpExcel ->getActiveSheet();
		
		// Setting title of the sheet
		$sheet->setTitle('Monthly PF_ESI Payment Advice');
		
		// Creating spreadsheet header
		$sheet ->getCell('L1')->setValue('Monthly Operators Salary Payment Advice');
		$sheet->getStyle('L1')->getFont()->setBold(true)->setSize(12);
		
		$sheet ->getCell('A3')->setValue('State Name');
		$sheet ->getCell('B3')->setValue('District Name');
		$sheet ->getCell('C3')->setValue('Centre Name');
		$sheet ->getCell('D3')->setValue('Month-Year');
		$sheet ->getCell('E3')->setValue('Operator Name');
		$sheet ->getCell('F3')->setValue('Operator ID');
		$sheet ->getCell('G3')->setValue('Station ID');
		$sheet ->getCell('H3')->setValue('Number of Working Days');
		$sheet ->getCell('I3')->setValue('Basic');
		$sheet ->getCell('J3')->setValue('HRA');
		$sheet ->getCell('K3')->setValue('Conveyance');
		$sheet ->getCell('L3')->setValue('Allowance');
		$sheet ->getCell('M3')->setValue('Gross Salary');
		$sheet ->getCell('N3')->setValue('Employee Contribution to PF');
		$sheet ->getCell('O3')->setValue('Employee Contribution to ESI');
		$sheet ->getCell('P3')->setValue('Net Salary');
		$sheet ->getCell('Q3')->setValue('Actual Payable Amount');
		$sheet ->getCell('R3')->setValue('Adjustment');
		$sheet ->getCell('S3')->setValue('Hold Amount');
		$sheet ->getCell('T3')->setValue('Total Adjustment');
		$sheet ->getCell('U3')->setValue('Amount to be Deposited to Bank');
		$sheet ->getCell('V3')->setValue('Employer Contribution to PF');
		$sheet ->getCell('W3')->setValue('Employer Contribution to ESI');
		$sheet ->getCell('X3')->setValue('Reason for Hold');
		
		// Making headers text bold and larger
		$sheet->getStyle('A3:X3')->getFont()->setBold(true)->setSize(11);
		
		$count = 4;
		//$result1 = mysqli_query($con, "SELECT DISTINCT(MONTH_YEAR) FROM salary_month_details WHERE created_dttm >=  '".$stDt1."' AND created_dttm <= '".$ymd."' ORDER BY MONTH_YEAR ASC");
		
		$result1 = mysqli_query($con, "SELECT DISTINCT(MONTH_YEAR) FROM salary_month_details WHERE month_year= '".$monyr."' ORDER BY MONTH_YEAR ASC");
		 while($row = mysqli_fetch_row($result1)) {
			 
		 $month_yr = $row[0];
		 
		 //$result2 = mysqli_query($con, "SELECT state_name,dist_name,centre_name,operator_name,operator_id,station_id,working_days,basic,hra,conv,allow,gross,empee_pf,empee_esi,net,empr_pf,empr_esi,
		 	//paytoop,adv_adj,holamt,agg_adj,amt_to_bank,hold_reason
		 //FROM salary_month_details WHERE month_year =  '".$month_yr."' ");
		 
		 $result2 = mysqli_query($con, "SELECT state_name,dist_name,centre_name,operator_name,operator_id,station_id,working_days,basic,hra,conv,allow,gross,empee_pf,empee_esi,net,empr_pf,empr_esi,
		 	paytoop,adv_adj,holamt,agg_adj,amt_to_bank,hold_reason
		 FROM salary_month_details WHERE month_year= '".$monyr."' ");
		 while($row1 = mysqli_fetch_row($result2)){
		 
		 $state = $row1[0];
		 $dist = $row1[1];
		 $centre = $row1[2];
		 $opname = $row1[3];
		 $opid = $row1[4];
		 $stid = $row1[5];
		 $workday = $row1[6];
	     $basic = $row1[7];
	     $hra = $row1[8];
	     $conv = $row1[9];
		$allow = $row1[10];
		$gross = $row1[11];
		$empee_pf = $row1[12];
		$empee_esi = $row1[13];
		$net = $row1[14];
		$empr_pf = $row1[15];
		$empr_esi = $row1[16];
		 $paytoop = $row1[17];
		 $adj = $row1[18];
		 $hold_amt = $row1[19];
		 $totadj = $row1[20];
		 $amtobank = $row1[21];
		 $holdreason = $row1[22];
		 
		 
		// Insert product data
		$sheet ->getCell('A'.$count.'')->setValue($state);
		$sheet ->getCell('B'.$count.'')->setValue($dist);
		$sheet ->getCell('C'.$count.'')->setValue($centre);
		$sheet ->getCell('D'.$count.'')->setValue($month_yr);
		$sheet ->getCell('E'.$count.'')->setValue($opname);
		$sheet ->getCell('F'.$count.'')->setValue($opid);
		$sheet ->getCell('G'.$count.'')->setValue($stid);
		$sheet ->getCell('H'.$count.'')->setValue($workday);
		$sheet ->getCell('I'.$count.'')->setValue($basic);
		$sheet ->getCell('J'.$count.'')->setValue($hra);
		$sheet ->getCell('K'.$count.'')->setValue($conv);
		$sheet ->getCell('L'.$count.'')->setValue($allow);
		$sheet ->getCell('M'.$count.'')->setValue($gross);
		$sheet ->getCell('N'.$count.'')->setValue($empee_pf);
		$sheet ->getCell('O'.$count.'')->setValue($empee_esi);
		$sheet ->getCell('P'.$count.'')->setValue($net);
		$sheet ->getCell('Q'.$count.'')->setValue($paytoop);
		$sheet ->getCell('R'.$count.'')->setValue($adj);
		$sheet ->getCell('S'.$count.'')->setValue($hold_amt);
		$sheet ->getCell('T'.$count.'')->setValue($totadj);
		$sheet ->getCell('U'.$count.'')->setValue($amtobank);
		$sheet ->getCell('V'.$count.'')->setValue($empr_pf);
		$sheet ->getCell('W'.$count.'')->setValue($empr_esi);
		$sheet ->getCell('X'.$count.'')->setValue($holdreason);
		
		$count++;
		 }
		 
		 }
		    
		// Autosize the columns
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);
		$sheet->getColumnDimension('F')->setAutoSize(true);
		$sheet->getColumnDimension('G')->setAutoSize(true);
		$sheet->getColumnDimension('H')->setAutoSize(true);
		$sheet->getColumnDimension('I')->setAutoSize(true);
		$sheet->getColumnDimension('J')->setAutoSize(true);
		$sheet->getColumnDimension('K')->setAutoSize(true);
		$sheet->getColumnDimension('L')->setAutoSize(false);
		$sheet->getColumnDimension('M')->setAutoSize(true);
		$sheet->getColumnDimension('N')->setAutoSize(true);
		$sheet->getColumnDimension('O')->setAutoSize(true);
		$sheet->getColumnDimension('P')->setAutoSize(true);
		$sheet->getColumnDimension('Q')->setAutoSize(true);
		$sheet->getColumnDimension('R')->setAutoSize(true);
		$sheet->getColumnDimension('S')->setAutoSize(true);
		$sheet->getColumnDimension('T')->setAutoSize(true);
		$sheet->getColumnDimension('U')->setAutoSize(true);
		$sheet->getColumnDimension('V')->setAutoSize(true);
		$sheet->getColumnDimension('W')->setAutoSize(true);
		$sheet->getColumnDimension('X')->setAutoSize(true);
		
		// Save the spreadsheet
		$filename = "Monthly_Operators_Salary_Payment_".date('Ymd');
		
		
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
                    <a onclick= "openOverlay()" href="Attendence.php">Excel Upload</a>
                </li>
				<li>
                    <a onclick= "openOverlay()" href="Attendence Document.php">Document Upload</a>
                </li>
				<li>
                    <a onclick= "openOverlay()" href="Verify Attendence.php">Verify Document</a>
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
			  
			  <li class+"active">
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
		
        <h2 class="mb-4"><u>Monthly Operators Salary Payment Report</u> </h2>
		
        <p>
			<div class="col-sm-12">
				<section id="services" class="section" style="display:block;">
				<center>
				<div class="row">
					
					
					  <div class="col-sm-12  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top: 10%;">
					  
							<form  action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method ="post"  id = "export_excel" enctype="multipart/form-data">
						    <div>
								<!--i class="fa fa-calendar"></i>&nbsp;<label>Start Date : &nbsp;</label><input required ="true" type ="date" id="start_date" name ="start_date"></input><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<i class="fa fa-calendar"></i>&nbsp;<label>End Date : &nbsp;</label><input required ="true" type ="date" id="end_date" name ="end_date"></input-->
								
								<!--i class="fa fa-calendar"></i>&nbsp;<label>Start Date : &nbsp;</label><input required ="true" type ="date" id="start_date" name ="start_date"></input><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
								<i class="fa fa-calendar"></i>&nbsp;<label>End Date : &nbsp;</label><input required ="true" type ="date" id="end_date" name ="end_date"></input-->
								<i class="fa fa-calendar"></i><label style="margin-left: 1%;color: #495057;">Choose Month-Year : &nbsp; </label>
									<select required="true" id="month_year" name="month_year" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;">
										<option disabled selected value = "">Select Any...</option>
										<?php
											//mysqli_select_db( $con,"course_details");

											$sql = "SELECT DISTINCT(month_year) FROM salary_month_details";
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
						  <div class="box" >
							<h6 class="title"><i class="fa fa-search text-info"></i> No Operator's Salary Payment Record Found For :  <b> Month - Year : </b> <u>[<?php echo $_POST['month_year'];?>] </u>  <i class="fa fa-calendar text-info"></i></h6>
							
						  </div>
					  </div>
					 <?php
					 }
						?>
				
					<?php
					 if($msg == "ok")
					 {
						 
						 ?>
						 </br>
					  <div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" style="margin-top:5%;">
						  <div class="box" >
							<h6 class="title"><i class="fa fa-search text-info"></i> Operator's Salary Payment Advice Record Generated For :  <b> Month - Year : </b> <u>[<?php echo $_POST['month_year'];?>] </u>  <i class="fa fa-calendar text-info"></i></h6>
							
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
			
			//var start_month_year = $("#start_date").val();
			//alert(start_month_year);
			//var end_month_year = $("#end_date").val();
			//alert(end_month_year);
			var date = $("#month_year").val();
			
			
			if(date !== "" )
			{
				
					
					//document.getElementById("overlay").style.display = "block";
					//$("#search").show();
					
					return true;
				
			}
			if(date === null)
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
