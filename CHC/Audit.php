<?php

session_start();
error_reporting(0);

include "include/db.php";
$q=mysqli_query($con,"select user_name from ac_user where user_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['user_name'];
$id=$_SESSION['user'];
$error = "";
$success = "";



if (isset($_POST["excel_sub"])){
	
	$runno= $_POST["runno"];
	$percent = $_POST["percent"];
	
	if($runno != null && $percent != null)
	{
		//$sql = "select distinct a.District_Code,a.RO_Code,a.Book,a.Deed_year,a.Deed_no,b.district_name,c.ro_name,a.Serial_No,a.Serial_Year,d.tran_maj_name as 'Trans Major',e.tran_name as 'Trans Minor',a.Volume_No,a.Page_From,a.Page_To,a.Date_of_Completion,a.Date_of_Delivery,a.Deed_Remarks,a.Created_DTTM,a.Scan_doc_type from deed_details a,district b, ro_master c,party d,tranlist_code e,policy_master f where a.District_Code = b.district_code and a.ro_code = c.ro_code and a.tran_maj_code = d.tran_maj_code and a.tran_min_code = e.tran_min_code and a.tran_maj_code = e.tran_maj_code and f.do_code = a.district_code and f.br_code = a.ro_code and f.year = a. book and f.deed_year = a.deed_year and f.deed_no = a.deed_no and f.run_no = '".$runno."' group by a.district_code,a.deed_no order by a.deed_no";
		$sql = "select distinct a.proj_code,a.bundle_key,a.bundle_code,b.case_file_no,b.case_status,b.case_nature,b.case_type,b.case_year,b.district,a.creation_date,a.handover_date,b.dept_remark,b.created_dttm,b.modified_dttm from bundle_master a, metadata_entry b where a.bundle_code = '".$runno."' and a.proj_code = b.proj_code and a.bundle_key = b.bundle_key order by b.item_no";
        
        $result = mysqli_query($con, $sql);
		if (mysqli_num_rows($result) > 0) {
			$total_cou = mysqli_num_rows($result);
			
		}
		if($percent <= 100)
		{
			
			$limit = ($total_cou * TRIM($percent))/100;
			
			//$sql1 = "select distinct a.District_Code,a.RO_Code,a.Book,a.Deed_year,a.Deed_no,b.district_name,c.ro_name,a.Serial_No,a.Serial_Year,d.tran_maj_name as 'Trans Major',e.tran_name as 'Trans Minor',a.Volume_No,a.Page_From,a.Page_To,a.Date_of_Completion,a.Date_of_Delivery,a.Deed_Remarks,a.Created_DTTM,a.Scan_doc_type,a.hold,a.hold_reason from deed_details a,district b, ro_master c,party d,tranlist_code e,policy_master f where a.District_Code = b.district_code and a.ro_code = c.ro_code and a.tran_maj_code = d.tran_maj_code and a.tran_min_code = e.tran_min_code and a.tran_maj_code = e.tran_maj_code and f.do_code = a.district_code and f.br_code = a.ro_code and f.year = a. book and f.deed_year = a.deed_year and f.deed_no = a.deed_no and f.run_no = '".$runno."' group by a.district_code,a.deed_no order by RAND() limit ".number_format($limit)."";
			$sql1 = "select distinct a.proj_code,a.bundle_key,a.bundle_code,b.case_file_no,b.case_status,b.case_nature,b.case_type,b.case_year,b.district,a.creation_date,a.handover_date,b.dept_remark,b.created_dttm,b.modified_dttm from bundle_master a, metadata_entry b where a.bundle_code = '".$runno."' and a.proj_code = b.proj_code and a.bundle_key = b.bundle_key order by b.item_no,RAND() limit ".number_format($limit)."";
            
            $result1 = mysqli_query($con, $sql1);
			
			$showing_cou = mysqli_num_rows($result1);
			
			
			$sql_stat=mysqli_query($con,"select distinct status,proj_code,bundle_key from bundle_master where bundle_code = '".$runno."' ");
			$n_stat=  mysqli_fetch_row($sql_stat);
			$status= $n_stat[0];	
            $proj_code = $n_stat[1];
            $bundle_key = $n_stat[2];
			
		}
		if($total_cou > 0 && $showing_cou > 0)
		{
			$success = "Success";
			
		}
		else
		{
			$success = "Zero";
			
		}
		//$sql9 = "select distinct a.District_Code,a.RO_Code,a.Book,a.Deed_year,a.Deed_no,b.district_name,c.ro_name,a.Serial_No,a.Serial_Year,d.tran_maj_name as 'Trans Major',e.tran_name as 'Trans Minor',a.Volume_No,a.Page_From,a.Page_To,a.Date_of_Completion,a.Date_of_Delivery,a.Deed_Remarks,a.Created_DTTM,a.Scan_doc_type,a.hold,a.hold_reason,f.policy_number from deed_details a,district b, ro_master c,party d,tranlist_code e,policy_master f where a.District_Code = b.district_code and a.ro_code = c.ro_code and a.tran_maj_code = d.tran_maj_code and a.tran_min_code = e.tran_min_code and a.tran_maj_code = e.tran_maj_code and f.do_code = a.district_code and f.br_code = a.ro_code and f.year = a. book and f.deed_year = a.deed_year and f.deed_no = a.deed_no and f.run_no = '".$runno."' group by a.district_code,a.deed_no";
		$sql9 = "select distinct a.proj_code,a.bundle_key,a.bundle_code,b.case_file_no,b.case_status,b.case_nature,b.case_type,b.case_year,b.district,a.creation_date,a.handover_date,b.dept_remark,b.created_dttm,b.modified_dttm from bundle_master a, metadata_entry b where a.bundle_code = '".$runno."' and a.proj_code = b.proj_code and a.bundle_key = b.bundle_key order by b.item_no";	
        
        $result9 = mysqli_query($con, $sql9);
		
		if (mysqli_num_rows($result9) > 0) {
		
		while($row1 = mysqli_fetch_row($result9)) {
		
			//$policy_number = $row1[0].$row1[1].$row1[2].$row1[3]."[".$row1[4]."]";
			$policy_number = $row1[3];
			$sql_polstat_q=mysqli_query($con,"select status from case_file_master where case_file_no ='".$policy_number."'");
			$n_polstat_q=  mysqli_fetch_row($sql_polstat_q);
			$pol_status_q= $n_polstat_q[0];	
			
			if($pol_status_q == "30")
			{
               
				break;
			}
			
		}
			
		}
		
	}
	
}


$result = mysqli_query($con,"SELECT * FROM ac_user WHERE user_id='".$_SESSION['user']."'");
                    
                    while($row = mysqli_fetch_array($result))
                      {

?>
<!doctype html>
<html lang="en">
  <head>
  	<title>CHC Audit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
    <link href="images/Nevaeh.ico" rel="icon">
    <link href="images/Nevaeh.ico" rel="apple-touch-icon">


    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src="https://cdn.rawgit.com/seikichi/tiff.js/master/tiff.min.js"></script>
    
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
        
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.rawgit.com/seikichi/tiff.js/master/tiff.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
		
  </head>
  <body>
  
		<script>
		function openModalForRecordEdit(unId1,unId2,unId3,unId4,unId5,unId6,unId7,unId8) {
		    $("#txtSequenceId1").val(unId1);
			$("#txtSequenceId2").val(unId2);
			$("#txtSequenceId3").val(unId3);
			$("#txtSequenceId4").val(unId4);
			$("#txtSequenceId5").val(unId5);
			$("#txtSequenceId6").val(unId6);
            $("#txtSequenceId7").val(unId7);
            $("#txtSequenceId11").val(unId8);
			$('#case_status').text(unId5);
            $('#policy_no').text(unId4);
            $('#case_nature').text(unId6);
            $('#case_type').text(unId7);
            $('#case_year').text(unId8);
			$("#MySecondModalId").modal('show');
			$("#MySecondModalId").modal({
					  escapeClose: false,
					  clickClose: false,
					  showClose: false
					  
					});
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
				
		  		<h1><a onclick= "openOverlay()" href="Audit.php" class="logo" style = "font-size: 25px;">Audit Panel</a></h1>
				<p>Username : &nbsp; <?php echo $stname;?></p>
	        <ul class="list-unstyled components mb-5">
	          <li  class="active">
	            <a onclick= "openOverlay()" href="Audit">CHC Audit</a>
			  </li>
			  
			
			  <li>
	              <a onclick= "openOverlay()" href="logout.php">Logout</a>
	          </li>
	        </ul>

	        

	        <div class="footer">
	        	<p>
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> <br>All rights reserved <br><i class="fa fa-code" style="color:black;"></i> Developed by <br><a onclick= "openOverlay()" href="mailto:sandhisarkar2@gmail.com?Subject =Contact from CHC" target="_blank" style= "color: beige;">Nevaeh Technology Pvt. Ltd.</a>
				</p>
				
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5" >
		
        <h2 class="mb-4"><u>CHC Quality Control</u> </h2>
		<h5>Selection</h5>
        <p>
			<div class="col-sm-12">
				<section id="services" class="section" style="display:block;">
				<center>
				<div class="row">
					
					
					  <div class="col-sm-7  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top: 3%;">
					  
							<form action="Audit.php" method="post" enctype="multipart/form-data">
							<div>
							<label style="margin-left: -7px;">Submitted Bundle : &nbsp; </label>
									<select required="true" id="runno" name="runno" onchange="chengeValue()" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 250px;">
										<option disabled selected value = "">Select Any...</option>
										<?php
											//mysqli_select_db( $con,"course_details");

											$sql = "SELECT DISTINCT bundle_code FROM bundle_master where status = '6'";
                                            $result = mysqli_query($con, $sql);
                                            

                                            $total_bundle_count = mysqli_num_rows($result);

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
										
									</select><span>&nbsp;&nbsp;&nbsp;</span>
									<input required="true" type="number" id="percent" name="percent" min="1" max="100" value="100" style="height: 25px;width: 100px;"></input> %
									<span>&nbsp;&nbsp;&nbsp;</span> <button type="submit" id = "excel_sub" name = "excel_sub" class="btn btn-primary"  onclick="uploadme()" style="padding: 3px;">Search<span></span> <i class="fa fa-search"></i></button>
							</div>
							
							
							</form>
							
							
					  </div>
					  <div class="col-sm-5  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top: 5%;">
						<div>
							<form action="Audit.php" method="post" enctype="multipart/form-data">
								
								<?php 
									if($status == "7")
									{
										?>
										
										<input type="checkbox" id= "check" checked = "true" disabled readonly ="false" onclick = "check()"></input>
										<?php
									}
									else if($status == "6")
									{
										?>
										
										<input type="checkbox" id= "check" readonly ="true" onclick = "check()"></input>
										<?php
									}
									else
									{
										?>
										<input type="checkbox" id= "check" onclick = "check()"></input>
										<?php
									}
								?>
								
								
								<span>&nbsp;&nbsp;&nbsp;</span>Ready For UAT
								<input type="hidden"  id="txtSequenceId" value = "<?php echo $runno;?>" name="txtSequenceId"/>
								<span>&nbsp;&nbsp;&nbsp;</span> <button type="submit" id = "check_sub" name = "check_sub" class="btn btn-primary"  onclick="uploadme1()" style="padding: 3px;display:none;">Approve<span></span> <i class="fa fa-check"></i></button>
							</form>
						</div>
					  </div>
					  <div id = "imageSh" class="main dragscroll col-md-6  wow bounceInUp" data-wow-duration="2.4s" style="margin-top:5%;display:none;">
						 <!--div  class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" >
							
							
						 </div-->
					 </div>
					 <?php
						if($success == "Success")
						{
							
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" style="margin-top:1%;">
							  <div class="box">
								
								<h6>Bundle Number - <u><b><?php  echo $runno;?></b></u> </h6>
								<h6>Showing <b><?php echo $showing_cou;?></b> out of <b><?php echo $total_cou;?></b> Records</h6>
							  </div>
						  </div>
						  
							<?php
							//$sql1 = "select distinct a.District_Code,a.RO_Code,a.Book,a.Deed_year,a.Deed_no,b.district_name,c.ro_name,a.Serial_No,a.Serial_Year,d.tran_maj_name as 'Trans Major',e.tran_name as 'Trans Minor',a.Volume_No,a.Page_From,a.Page_To,a.Date_of_Completion,a.Date_of_Delivery,a.Deed_Remarks,a.Created_DTTM,a.Scan_doc_type,a.hold,a.hold_reason,f.policy_number from deed_details a,district b, ro_master c,party d,tranlist_code e,policy_master f where a.District_Code = b.district_code and a.ro_code = c.ro_code and a.tran_maj_code = d.tran_maj_code and a.tran_min_code = e.tran_min_code and a.tran_maj_code = e.tran_maj_code and f.do_code = a.district_code and f.br_code = a.ro_code and f.year = a. book and f.deed_year = a.deed_year and f.deed_no = a.deed_no and f.run_no = '".$runno."' group by a.district_code,a.deed_no order by RAND() limit ".number_format($limit)."";
                            $sql1 = "select distinct a.proj_code,a.bundle_key,a.bundle_code,b.case_file_no,b.case_status,b.case_nature,b.case_type,b.case_year,b.district,a.creation_date,a.handover_date,b.dept_remark,b.created_dttm,b.modified_dttm from bundle_master a, metadata_entry b where a.bundle_code = '".$runno."' and a.proj_code = b.proj_code and a.bundle_key = b.bundle_key order by b.item_no,RAND() limit ".number_format($limit)."";
							$result1 = mysqli_query($con, $sql1);
							
							if (mysqli_num_rows($result1) > 0) {
								
								?>
									<div class="input-group mb-3">
										<input id="myInput" type="text" class="form-control" placeholder="Search.." autofocus>
										<div class="input-group-append">
										  <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
										</div>
									  </div>
									  <h3>Case File Details</h3>
									  
									  <table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size: x-small;">
										<thead class="thead-dark">
											<tr>
												<th style = 'padding:auto;'>Bundle Code</th>
												<th style = 'padding:auto;'>Case File Number</th>
												<th style = 'padding:auto;'>Case Status</th>
												<th style = 'padding:auto;'>Case Nature</th>
												<th style = 'padding:auto;'>Case Type</th>
												<th style = 'padding:auto;'>Case Year</th>
												<th style = 'padding:auto;'>District Name</th>
												<th style = 'padding:auto;'>Date of Completion</th>
												<th style = 'padding:auto;'>Date of Delivery</th>
												<th style = 'padding:auto;'>Department Remarks</th>
												<th style = 'padding:auto;'>Created DTTM</th>
												<th style = 'padding:auto;'>Modified DTTM</th>
												<!--th style = 'padding:auto;'>Hold</th>
												<th style ='padding:auto;'>Hold Reason</th-->
												<th style ='padding:auto;'>Action</th>
										    </tr>
									    </thead>
									<?php
									while($row = mysqli_fetch_row($result1)) {
										?>
										<tbody id="myTable">
										<?php
										//$policy_no = $row[0].$row[1].$row[2].$row[3]."[".$row[4]."]";
                                        $policy_no = $row[3];
                                        
                                        $sql_polstat=mysqli_query($con,"select status from case_file_master where case_file_no ='".$policy_no."'");
                                        
										$n_polstat=  mysqli_fetch_row($sql_polstat);
										$pol_status= $n_polstat[0];	
										
										if($pol_status == "30")
										{
                                            
										?>
										<tr style= "background-color:#e65e5e;">
											<td style = "padding: auto;"><?php echo  $row[2]?></td>
											<td style = "padding: auto;"><?php echo  $row[3]?></td>
											<td style = "padding: auto;"><?php echo  $row[4]?></td>
											<td style = "padding: auto;"><?php echo  $row[5]?></td>
											<td style = "padding: auto;"><?php echo  $row[6]?></td>
											<td style = "padding: auto;"><?php echo  $row[7]?></td>
											<td style = "padding: auto;"><?php echo  $row[8]?></td>
											<td style = "padding: auto;"><?php echo  $row[9]?></td>
											<td style = "padding: auto;"><?php echo  $row[10]?></td>
											<td style = "padding: auto;"><?php echo  $row[11]?></td>
											<td style = "padding: auto;"><?php echo  $row[12]?></td>
											<td style = "padding: auto;"><?php echo  $row[13]?></td>
											
											
											
											<td style = "padding: auto;"><Span><button type="button" style = "background-color: transparent; border-color: transparent;" onclick="openModalForRecordEdit('<?php echo $row[0]; ?>','<?php echo $row[1]; ?>','<?php echo $row[2]; ?>','<?php echo $row[3]; ?>','<?php echo $row[4]; ?>','<?php echo $row[5];?>','<?php echo $row[6];?>','<?php echo $row[7];?>');"><i class="fa fa-edit" style="font-size:25px; color:#007bff;"></i></button></span></td>
											
										</tr>
										</tbody>
										<?php
										}
										else if($pol_status == "31")
										{
										?>
										<tr style= "background-color:#629962;">
                                        <td style = "padding: auto;"><?php echo  $row[2]?></td>
											<td style = "padding: auto;"><?php echo  $row[3]?></td>
											<td style = "padding: auto;"><?php echo  $row[4]?></td>
											<td style = "padding: auto;"><?php echo  $row[5]?></td>
											<td style = "padding: auto;"><?php echo  $row[6]?></td>
											<td style = "padding: auto;"><?php echo  $row[7]?></td>
											<td style = "padding: auto;"><?php echo  $row[8]?></td>
											<td style = "padding: auto;"><?php echo  $row[9]?></td>
											<td style = "padding: auto;"><?php echo  $row[10]?></td>
											<td style = "padding: auto;"><?php echo  $row[11]?></td>
											<td style = "padding: auto;"><?php echo  $row[12]?></td>
											<td style = "padding: auto;"><?php echo  $row[13]?></td>
										
											
											<td style = "padding: auto;"><Span><button type="button" style = "background-color: transparent; border-color: transparent;" onclick="openModalForRecordEdit('<?php echo $row[0]; ?>','<?php echo $row[1]; ?>','<?php echo $row[2]; ?>','<?php echo $row[3]; ?>','<?php echo $row[4]; ?>','<?php echo $row[5];?>','<?php echo $row[6];?>','<?php echo $row[7];?>');"><i class="fa fa-edit" style="font-size:25px; color:#007bff;"></i></button></span></td>
											
										</tr>
										</tbody>
										<?php
										}
										else
										{
										?>
										<tr>
                                        <td style = "padding: auto;"><?php echo  $row[2]?></td>
											<td style = "padding: auto;"><?php echo  $row[3]?></td>
											<td style = "padding: auto;"><?php echo  $row[4]?></td>
											<td style = "padding: auto;"><?php echo  $row[5]?></td>
											<td style = "padding: auto;"><?php echo  $row[6]?></td>
											<td style = "padding: auto;"><?php echo  $row[7]?></td>
											<td style = "padding: auto;"><?php echo  $row[8]?></td>
											<td style = "padding: auto;"><?php echo  $row[9]?></td>
											<td style = "padding: auto;"><?php echo  $row[10]?></td>
											<td style = "padding: auto;"><?php echo  $row[11]?></td>
											<td style = "padding: auto;"><?php echo  $row[12]?></td>
											<td style = "padding: auto;"><?php echo  $row[13]?></td>
											
											
											<td style = "padding: auto;"><Span><button type="button" style = "background-color: transparent; border-color: transparent;" onclick="openModalForRecordEdit('<?php echo $row[0]; ?>','<?php echo $row[1]; ?>','<?php echo $row[2]; ?>','<?php echo $row[3]; ?>','<?php echo $row[4]; ?>','<?php echo $row[5];?>','<?php echo $row[6];?>','<?php echo $row[7];?>');"><i class="fa fa-edit" style="font-size:25px; color:#007bff;"></i></button></span></td>
											
										</tr>
										</tbody>
										<?php
										
										}
									}
									?>
									</table>
									<?php
							}
						}
						if($success == "Zero")
						{
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" style="margin-top:5%;">
							  <div class="box">
								
								<h6>Bundle Number - <u><b><?php  echo $runno;?></b></u> </h6>
								<h6>No Record Found. . .</h6>
							  </div>
						  </div>
						  <?php
						}
						if($error == "" || $success == "")
						{
							
							echo '<label class="text-danger"></label>';
							
                        }
                        if($total_bundle_count ==0)
                        {
                            ?>
                            <div class="col-md-12  wow bounceInUp" data-wow-duration="5.0s" style="margin-top:5%;">
							  <div class="box">
								
                                <h1><u><b>Bundle Sumission Details</b><u></h1></br>
								<h6>There's no Bundle Submitted for Audit...</h6>
								
							  </div>
						  </div>
                          <?php
                        }
                        if($total_bundle_count >0 && $success == "")
                        {
                            ?>
                            <div class="col-md-12  wow bounceInUp" data-wow-duration="5.0s" style="margin-top:5%;">
							  <div class="box">
								
                                <h1><u><b>Bundle Sumission Details</b><u></h1></br>
								<h6>Please, Select proper Bundle from Submitted Bundle list for Audit...</h6>
								
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
			<input type="hidden"  id="txtSequenceId1" name="txtSequenceId1"/>
			<input type="hidden"  id="txtSequenceId2" name="txtSequenceId2"/>
			<input type="hidden"  id="txtSequenceId3" name="txtSequenceId3"/>
			<input type="hidden"  id="txtSequenceId4" name="txtSequenceId4"/>
			<input type="hidden"  id="txtSequenceId5" name="txtSequenceId5"/>
			<input type="hidden"  id="txtSequenceId6" name="txtSequenceId6"/>
			<input type="hidden"  id="txtSequenceId7" name="txtSequenceId7"/>
            <input type="hidden"  id="txtSequenceId11" name="txtSequenceId11"/>
			<input type="hidden"  id="txtSequenceId8" name="txtSequenceId8" value="<?php echo $total_cou; ?>"/>
			<input type="hidden"  id="txtSequenceId9" name="txtSequenceId9" value="<?php echo $pol_status_q; ?>,<?php echo $policy_number; ?>"/>
			<input type="hidden"  id="txtSequenceId10" name="txtSequenceId10" value="<?php echo $percent; ?>"/>
		</div>
		
		<!-- Modal -->
		<div id="MySecondModalId" class="modal" style="box-shadow: 0 0 0px;padding: 0px;border-color: transparent;background: transparent;">
		 <div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <img src="images/Nevaeh.ico" style="height:36px;width:36px;"></img>
			  <h4 class="modal-title float-left"><span>&nbsp;&nbsp;&nbsp;</span>CHC Audit !</h4>
				<button type="button" class="close" data-dismiss="modal"><a href="#" rel="modal:close" style="color: #372d2d;">X</a></button>
				
			  </div>
			  <div class="modal-body">
				<h5>Hey ! Do you want to open this File ?</h5>
				<ul>
					<li><h6>Case File Number - <u style="font-style: bold;"><b><span id="policy_no"></span></b></u></h6></li>
                        <ul>
                            <li><h6>Case Status - <u style="font-style: italic;"><b><span id="case_status"></span></b></u></h6></li>
                            <li><h6>Case Nature - <u style="font-style: italic;"><b><span id="case_nature"></span></b></u></h6></li>
                            <li><h6>Case Type - <u style="font-style: italic;"><b><span id="case_type"></span></b></u></h6></li>
                            <li><h6>Case Year - <u style="font-style: italic;"><b><span id="case_year"></span></b></u></h6></li>
                        </ul>
				</ul>
				
			  </div>
			  <div class="modal-footer">
			  <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "editme()">Confirm</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><a href="#" rel="modal:close" style="color: white;">Close</a></button>
			  </div>
			</div>
			</div>
		</div>
		
		<div id="MyFirstModalId" class="modal" style="box-shadow: 0 0 0px;padding: 0px;border-color: transparent;background: transparent;">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <img src="images/Nevaeh.ico" style="height:36px;width:36px;"></img>
			  <h4 class="modal-title float-left"><span>&nbsp;&nbsp;&nbsp;</span>CHC !</h4>
				<button type="button" class="close" onclick = "no('<?php echo $runno; ?>');" data-dismiss="modal"><a href="#" rel="modal:close" style="color: #372d2d;">X</a></button>
				
			  </div>
			  <div class="modal-body">
				<p>Do You Want to Mark this Bundle as Ready for UAT...?</p>
				
			  </div>
			  <div class="modal-footer">
			  <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "yes('<?php echo $runno; ?>','<?php echo $proj_code;?>','<?php echo $bundle_key?>');">Yes</button>
			  <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick = "no('<?php echo $runno; ?>');"><a href="#" rel="modal:close" style="color: white;">No</a></button>
			  </div>
			</div>

		  </div>
		</div>
		
		<div id="MyThirdModalId" class="modal" style="box-shadow: 0 0 0px;padding: 0px;border-color: transparent;background: transparent;">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <img src="images/Nevaeh.ico" style="height:36px;width:36px;"></img>
			  <h4 class="modal-title float-left"><span>&nbsp;&nbsp;&nbsp;</span>CHC !</h4>
				<button type="button" class="close" onclick = "no('<?php echo $runno; ?>');" data-dismiss="modal"><a href="#" rel="modal:close" style="color: #372d2d;">X</a></button>
				
			  </div>
			  <div class="modal-body">
				<p>There is Exception in Case File Number :  <u style="font-style: italic;"><b><span id="policy_no_check"><span></b></u></p>
				
			  </div>
			  <div class="modal-footer">
			  <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "no('<?php echo $runno; ?>');"><a href="#" rel="modal:close" style="color: white;">OK</a></button>
			  
			  </div>
			</div>

		  </div>
		</div>
		
		<div id="MyForthModalId" class="modal" style="box-shadow: 0 0 0px;padding: 0px;border-color: transparent;background: transparent;">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <img src="images/Nevaeh.ico" style="height:36px;width:36px;"></img>
			  <h4 class="modal-title float-left"><span>&nbsp;&nbsp;&nbsp;</span>CHC !</h4>
				<button type="button" class="close" onclick = "no('<?php echo $runno; ?>');" data-dismiss="modal"><a href="#" rel="modal:close" style="color: #372d2d;">X</a></button>
				
			  </div>
			  <div class="modal-body">
				<p>Error ... </p>
				
			  </div>
			  <div class="modal-footer">
			  <button type="button" class="btn btn-primary" data-dismiss="modal" onclick = "no('<?php echo $runno; ?>');"><a href="#" rel="modal:close" style="color: white;">OK</a></button>
			  
			  </div>
			</div>

		  </div>
		</div>
		
		<div id="MyFifthModalId" class="modal" style="box-shadow: 0 0 0px;padding: 0px;border-color: transparent;background: transparent;">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <img src="images/Nevaeh.ico" style="height:36px;width:36px;"></img>
			  <h4 class="modal-title float-left"><span>&nbsp;&nbsp;&nbsp;</span>CHC !</h4>
				<button type="button" class="close" onclick = "checkout();" data-dismiss="modal"><!--a href="Audit.php" rel="modal:close" style="color: #372d2d;"-->X<!--/a--></button>
				
			  </div>
			  <div class="modal-body">
				<p>Volumes Successfully Marked For UAT...</p>
				
			  </div>
			  <div class="modal-footer">
			  <button type="button" class="btn btn-primary" onclick = "checkout();" data-dismiss="modal"><!--a href="Audit.php" rel="modal:close" style="color: white;"-->OK<!--/a--></button>
			  
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>	
<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

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
			
			var runno = $("#runno").val();
			
			var percent = $("#percent").val();
			$("#txtSequenceId").val(runno);
			
			if(runno !== null && percent !== "" && percent >=0 && percent <=100)
			{
				
					
					document.getElementById("overlay").style.display = "block";
					
					return true;
				
			}
			if(runno === null || percent === null || percent < 0 || percent >100)
			{
				document.getElementById("overlay").style.display = "none";
				
				return false;
			}
		}
		function chengeValue()
		{
			var runno = $("#runno").val();
			
			
			$("#txtSequenceId").val(runno);
		}
		
		function uploadme1()
		{
			//document.getElementById("excel_sub").style.background = "green";
			document.getElementById("overlay").style.display = "block";
			
			return true;
		}
	</script>
	
	<script language ="javascript">
		function openOverlay()
		{
			
			document.getElementById("overlay").style.display = "block";
			
				return true;
			
			
		}
	</script>
	<script language ="javascript">
	function editme()
	{
		var lot_no =$("#txtSequenceId").val();
		var proj_code = $("#txtSequenceId1").val();
		var bundle_key = $("#txtSequenceId2").val();
		var book = $("#txtSequenceId5").val();
        var year = $("#txtSequenceId11").val();
		var deed_no = $("#txtSequenceId6").val();
		var policy_no = $("#txtSequenceId4").val();
		var vol = $("#txtSequenceId7").val();
		var check_UAT;
		if ($('#check').is(":checked") == true)
		{
			check_UAT = true;
		}
		else
		{
			check_UAT = false;
		}
		  
		document.getElementById("overlay").style.display = "block";
		window.location.href = 'Audit Details.php?Lot_No='+lot_no+'&Proj=' +proj_code+'&Bundle='+bundle_key+'&Status='+book+'&Year='+year+'&Nature='+deed_no+'&File='+policy_no+'&Type='+vol+'&UAT='+check_UAT+'';
		
		return true;
		
		
	}
	
	
	function no(lot_no)
	{
		$("#check").prop("checked", false);
	}
    
   
	function yes(lot_no,proj_code,bundle_key)
	{
		var total_cou = $('#txtSequenceId8').val();
        var percent = $('#txtSequenceId10').val();
        
        
        $('#txtSequenceId1').val(proj_code);
        $('#txtSequenceId2').val(bundle_key);
        
        
        
		var status_check_with_pol = $('#txtSequenceId9').val();

		var status = status_check_with_pol.substr(0,2);
        var policy = status_check_with_pol.substr(3,status_check_with_pol.length);
        

		
		if(status == 30)
		{
			$('#policy_no_check').text(policy);
			$("#MyThirdModalId").modal('show');
			$("#MyThirdModalId").modal({
					  escapeClose: false,
					  clickClose: false,
					  showClose: false
					  
					});
		}
		else
		{
			$('#MyFirstModalId').hide();
			document.getElementById("overlay").style.display = "block";
			$.ajax({
				type: "POST",
				url: "ReadyForUAT.php",
				data: 'runno='+lot_no+'&percent='+percent+'&Proj='+proj_code+'&Bundle='+bundle_key,
				
				success: function(data)
				{
					document.getElementById("overlay").style.display = "none";
					$("#check").prop("disabled", true);
					$("#MyFifthModalId").modal('show');
					 $("#MyFifthModalId").modal({
					  escapeClose: false,
					  clickClose: false,
					  showClose: false
					  
					});
                    
				}
			});
		}
		
	}
	
	</script>
	<script>
	function checkout()
	{
        $('#MyFifthModalId').hide();
        document.getElementById("overlay").style.display = "block";
		window.location.href = 'Audit.php';
	}
	</script>
	<script language ="javascript">
		$("#check").click(function() 
		{
			
			var lot_no =$("#txtSequenceId").val();
			
            var total_cou = $('#txtSequenceId8').val();
            
            
			
			if ($('#check').is(":checked") == true)
			{
				if(total_cou > 0)
				{
					$("#MyFirstModalId").modal('show');
					$("#MyFirstModalId").modal({
							  escapeClose: false,
							  clickClose: false,
							  showClose: false
							  
							});
				}
				 
			}
			else
			{
				 $("#check").prop("checked", false);
			}
			//document.getElementById("check").checked = false;
		});
	</script>
	
		<script type="text/javascript">
				function selectFolder(e) {
				var theFiles = e.target.files;
				var relativePath = theFiles[0].webkitRelativePath;
				var folder = relativePath.split("/");
			//alert(folder[0]);
					//document.getElementById("file").value=folder[0];
					document.getElementById("takingfolder").value=folder[0];
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