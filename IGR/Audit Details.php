<?php

session_start();
error_reporting(0);
//header( "refresh:120;url=PF_ESI Report.php" );
//require('fpdf/fpdf.php');
$con=mysqli_connect("localhost","root","root","dsr_murshidabad");
$q=mysqli_query($con,"select user_name from ac_user where user_id='".$_SESSION['user']."'");
$n=  mysqli_fetch_assoc($q);
$stname= $n['user_name'];
$id=$_SESSION['user'];
$error = "";
$success = "";

$Lot_No= $_GET['Lot_No'];
$DO= $_GET['DO'];
$RO= $_GET['RO'];
$Book= $_GET['Book'];
$Year= $_GET['Year'];
$Deed= $_GET['Deed'];
$Policy= $_GET['Policy'];
$Vol = $_GET['Vol'];
$UAT = $_GET['UAT'];

$batch = $DO.$RO.$Book.$Year.$Vol;
$sql = "select proj_key,batch_key,box_number,page_name,status,page_name,doc_type,policy_number,qc_size from image_master where serial_no= '1' and policy_number ='".$Policy."' and status<>29 order by serial_no";
$result = mysqli_query($con, $sql);
$n1 = mysqli_fetch_row($result);
$img_name = $n1[3];

$sql1 = "select sum(qc_size) from image_master where policy_number ='".$Policy."'  and status<>29 ";
$result1 = mysqli_query($con, $sql1);
$n2 = mysqli_fetch_row($result1);
$tot_size = number_format($n2[0]);

$sql2 = "select qc_size from image_master where page_index_name ='".$img_name."' and status<>29 ";
$result2 = mysqli_query($con, $sql2);
$n3 = mysqli_fetch_row($result2);
$img_size = number_format($n3[0]);

$sql3 = "select distinct proj_key,batch_key,box_number from image_master where policy_number ='".$Policy."' and status<>29 order by serial_no";
$result3 = mysqli_query($con, $sql3);
$n4 = mysqli_fetch_row($result3);
$proj_key = $n4[0];
$batch_key = $n4[1];
$box_number = $n4[2];

$sql4 = "select count(page_index_name) from image_master where policy_number = '".$Policy."'";
$result4 = mysqli_query($con, $sql4);
$n4 = mysqli_fetch_row($result4);
$img_cou = $n4[0];

date_default_timezone_set('Asia/Kolkata'); 
$datetime = date("Y-m-d H:i:s"); // time in India

if($img_cou > 0)
{
	$sql5 = "select Count(policy_number) from lic_qa_log where proj_key=".$proj_key." and batch_key=".$batch_key." and box_number=".$box_number." and policy_number='".$Policy."'";
	$result5 = mysqli_query($con, $sql5);
	$n5 = mysqli_fetch_row($result5);
	$lic_qa_policy_cou = $n5[0];
	
	if($lic_qa_policy_cou == 0)
	{
		$insert_sql="INSERT INTO lic_qa_log (proj_key,box_number,policy_number,batch_key,created_by,created_dttm) VALUES (".$proj_key.",".$box_number.",'".$Policy."',".$batch_key.",'".$id."','".$datetime."')";

			if (!mysqli_query($con,$insert_sql))
			{	  

			}
			else
			{
				
				$sql_qa_solved = "update lic_qa_log set SOLVED= '5' where proj_key= ".$proj_key." and box_number= ".$box_number." and policy_number='".$Policy."' and batch_key= '".$batch_key."' and solved <> '7'";
				
				if (!mysqli_query($con,$sql_qa_solved))
				{
				  
				}
				else
				{
					$sql_qa_status = "update lic_qa_log set qa_status= '1' where proj_key= ".$proj_key." and box_number= ".$box_number." and policy_number='".$Policy."' and batch_key= '".$batch_key."' ";
				
					if (!mysqli_query($con,$sql_qa_status))
					{
					  
					}
					else
					{
						
					}
				}
			}
	}
}

$sql6 = "select comments,missing_img_exp,poor_scan_exp,rearrange_exp,decision_misd_exp,linked_policy_exp,qa_status from lic_qa_log where proj_key=".$proj_key." and batch_key=".$batch_key." and box_number=".$box_number." and policy_number='".$Policy."'";
$result6 = mysqli_query($con, $sql6);
$n6 = mysqli_fetch_row($result6);

$comments = $n6[0];
$missing_img_exp = $n6[1];
$poor_scan_exp = $n6[2];
$rearrange_exp = $n6[3];
$decision_misd_exp = $n6[4];
$linked_policy_exp = $n6[5];
$qa_status = $n6[6];


$result = mysqli_query($con,"SELECT * FROM ac_user WHERE user_id='".$_SESSION['user']."'");
                    
                    while($row = mysqli_fetch_array($result))
                      {

?>
<!doctype html>
<html lang="en">
  <head>
  	<title>IGR B'ZER</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<link href="BZer.ico" rel="icon">
		
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
		  <style>
			.main {
			  padding: 0px;
			  margin-top: 25px;
			  width: 100%;
			  height: 75vh;
			  overflow: auto;
			  cursor: grab;
			  cursor: -o-grab;
			  cursor: -moz-grab;
			  cursor: -webkit-grab;
			}
			.modal a.close-modal {
				top: 0px;
				right: 0px;
			}
		  </style>
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
				
		  		<h1><a onclick= "openOverlay()" href="IGR Audit.php" class="logo" style = "font-size: 25px;">Audit Panel</a></h1>
				<p>Username : &nbsp; <?php echo $stname;?></p>
	        <ul class="list-unstyled components mb-5">
	          <li  class="active">
	            <a onclick= "openOverlay()" href="IGR Audit.php">IGR Audit</a>
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
		
        <h2 class="mb-4"><u>IGR Quality Control</u> </h2>
		<h5>Images</h5>
        <p>
			<div class="col-sm-12">
				<section id="services" class="section" style="display:block;">
				
				<div class="row">
					
					
					  <div class="col-sm-3  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top: 3%;">
					  
							
							<div>
							<label style="margin-left: -7px;"><u><b>Image List : </b></u></label></br>
									<select required="true" id="image_name" onChange = "getName(this.value);"  name="image_name" size="25" style="font-size: 15px;padding-top: 0px;margin-top: 25px;width: 250px;">
										
										<?php
											
											$sql = "select proj_key,batch_key,box_number,page_name,status,page_name,doc_type,policy_number,qc_size from image_master where policy_number ='".$Policy."' and status<>29 order by serial_no";
											
											$result = mysqli_query($con, $sql);
											
											if (mysqli_num_rows($result) > 0) {
											
											
											while($row = mysqli_fetch_row($result)) {
												
												
												?>
												
												<option><?php echo  $row[3]; ?></option>
												<?php
												}
												
											
											
										} else {
											 echo  "";
										}
										?>
										
									</select>
									
							</div>
							<div style="margin-left:-20%;">
								<h6 class="text-info" style="text-align:center;">Total Size : <?php echo $tot_size;?> KB</h6>
								<h6  id= "img_size"  name= "img_size" style="text-align:center;">Image Size : <?php echo $img_size;?> KB</h6>
								<button style="margin-left:20%;" id="prevPage" type="button" onclick="previous()"> <</button>
								<button type="button" id ="nextPage" onclick="next()"> ></button>
								<button style="margin-left:25%;" type="button" onclick="zoomin()"> +</button>
								<button type="button" onclick="zoomout()"> -</button>
							</div>
							
					  </div>
					  <div style="margin-top:3%;" data-wow-duration="2.4s" class="col-md-9  wow bounceInUp">
						  <label><u><b> Image : </u></b></label></br>
							  <div id = "imageSh" class="main dragscroll col-md-12  wow bounceInUp" data-wow-duration="2.4s" >
								 
								 
								 <!--div  class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" >
									
									
								 </div-->
							 </div>
					 </div>
					 <div class="col-sm-3  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top: 3%;">
						
							<h6><u><b>Exception</b></u></h6>
							<div class="col-md-6  wow bounceInUp" style="max-width: 100%;">
								<?php
									if($missing_img_exp == 1)
									{
										?>
										<input type="checkbox" checked id= "missing_img"  onclick = "missing_img()"></input> Missing Img</br><?php
									}
									else
									{
										?>
										<input type="checkbox" id= "missing_img"  onclick = "missing_img()"></input> Missing Img</br><?php
									}
								?>
								<?php
									if($poor_scan_exp == 1)
									{
										?>
										<input type="checkbox" id= "poor_scan" checked onclick = "poor_scan()"></input> Poor Scan</br><?php
									}
									else
									{
										?>
										<input type="checkbox" id= "poor_scan"  onclick = "poor_scan()"></input> Poor Scan</br><?php
									}
								?>
								<?php
									if($rearrange_exp == 1)
									{
										?>
										<input type="checkbox" checked id= "rearrange"  onclick = "rearrange()"></input> Rearrange</br><?php
									}
									else
									{
										?>
										<input type="checkbox" id= "rearrange"  onclick = "rearrange()"></input> Rearrange</br><?php
									}
								?>
								<?php
									if($decision_misd_exp == 1)
									{
										?>
										<input type="checkbox" checked id= "spel"  onclick = "spel()"></input> Speling Mistake</br><?php
									}
									else
									{
										?>
										<input type="checkbox" id= "spel"  onclick = "spel()"></input> Speling Mistake</br><?php
									}
								?>
								<?php
									if($linked_policy_exp == 1)
									{
										?>
										<input type="checkbox" checked id= "wrong_prop"  onclick = "wrong_prop()"></input> Wrong Property<?php
									}
									else
									{
										?>
										<input type="checkbox" id= "wrong_prop"  onclick = "wrong_prop()"></input> Wrong Property<?php
									}
								?>
								<input type="checkbox" id= "crop_clean" style="display:none;" onclick = "crop_clean()"></input> 
								<input type="checkbox" id= "extra_page"  style="display:none;" onclick = "extra_page()"></input> 
								<input type="checkbox" id= "move" style="display:none;" onclick = "move()"></input> 
								<input type="checkbox" id= "other" style="display:none;" onclick = "other()"></input> 
								<input type="checkbox" id= "indexing" style="display:none;" onclick = "indexing()"></input> 
							</div>
							<h6 style ="margin-top: 5%;"><u><b>Remarks</b></u></h6>
							<div class="col-sm-6  wow bounceInUp" style="max-width: 100%;">
							<?php
							if($qa_status == "2")
							{
								?>
								<textarea  id = "exception_log" style="font-size: 13px;padding-top: 0px;margin-top: 0px;width:250px;height: 150px;"><?php echo $comments; ?></textarea><?php
							}
							else
							{
								?>
								<textarea  id = "exception_log" style="font-size: 13px;padding-top: 0px;margin-top: 0px;width:250px;height: 150px;"></textarea><?php
							}
							?>
								
								
							</div>
							<div  style ="margin-top: 3%;">
								<button type="button" style="margin-left: 5%;" id = "accepted" onclick="accepted()"> Accepted</button>
								<button type="button" style="margin-left: 8%;" id = "exception" onclick="exception()"> Mark Exception</button>
							</diV>
						
					 </div>
					 <div class="col-sm-9  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top: 3%;">
					
						<?php
							
							$sql1 = "select Concat('Name: ',a.initial_name,' ',a.First_name,' ',a.Last_name,' ',char(10),a.rel_code,'/o: ',a.Relation,'\r','\n',char(10),'Address: ',a.address,'\r','District: ',a.Address_district_name,' Pin: ',a.pin,'\r','PS: ',a.Address_ps_name,' City: ',a.city,'\t','\t','\t','     ') as 'Name and Address',Concat('\r','Transaction : ',trim(f.tran_maj_name),' (',trim(g.tran_name),' )','\r','Deed Registered at: ',c.ro_name,'\r','Status : ',trim(D.EC_NAME),'\r') as 'Status and Transaction',a.other_party_code,a.more from index_of_name a,district b, ro_master c,party_CODE d ,party f,tranlist_code g,deed_details h where a.District_Code = b.district_code and a.ro_code = c.ro_code  and a.party_code = d.ec_code and h.tran_maj_code = f.tran_maj_code and g.tran_maj_code = h.tran_maj_code and g.tran_min_code = h.tran_min_code and  h.District_Code = a.District_Code and h.ro_code = a.ro_code and h.book = a.book and h.deed_year = a.deed_year and h.deed_no = a.deed_no and a.district_code = '".$DO."' and c.district_code = '".$DO."' and h.district_code = '".$DO."'and h.ro_code = '".$RO."' and h.deed_year = '".$Year."' and h.deed_no = '".$Deed."' and a.Ro_code = '".$RO."' and c.Ro_code = '".$RO."' and a.book = '".$Book."' and a.deed_year = '".$Year."' and a.deed_no = '".$Deed."' order by a.item_no";
							
							$result1 = mysqli_query($con, $sql1);
							
							if (mysqli_num_rows($result1) > 0) {
							
								?>
								
								<table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size:small;">
										<thead class="thead-dark">
											<tr>
												<th style = 'padding:auto;'>Name and Address</th>
												<th style = 'padding:auto;'>Status and Transaction</th>
											</tr>
										</thead>
									<?php
									
									while($row = mysqli_fetch_row($result1)) {
										$sql2 = "select ec_name from party_code where ec_code = '".$row[2]."'";
										$result2 = mysqli_query($con, $sql2);
										$n3 = mysqli_fetch_row($result2);
										
										$party_code = $n3[0];
										?>
										
										<tbody id="myTable" style="text-align: left;">
										<tr>
										<?php
											if($row[2] !="")
											{
												?>
												<td><?php echo  nl2br($row[0])."( ".$n3." )";?></td>
												<?php
											}
											else
											{
												?>
												<td><?php echo  nl2br($row[0]);?></td>
												<?php
											}
											if($row[2] =="Y")
											{
												?>
												<td><?php echo  nl2br($row[1])." And More Persons.";?></td>
												<?php
											}
											else
											{
												?>
												<td><?php echo  nl2br($row[1]);?></td>
												<?php
											}
										
										?>
										
											</tr>
										</tbody>
										
										<?php		
									}
									?>
									</table>
									<?php
							}
							
							$sql3 = "select distinct Concat('District: ',trim(b.district_name),',','\r','PS: ') as 'Property Location',concat('Property No : ',a.item_no,'\n','Property Type: ',pt.description) as 'Property Type',Concat('Premises No: ',a.Premises,'\n','\r','Plot: ',a.Plot_code_type,'-',a.Plot_No) as 'Plot and Khatian No',a.Land_Area_acre,a.Land_Area_bigha,a.Land_Area_katha,a.Land_Area_chatak,a.Land_Area_sqfeet,a.Land_Area_decimal,a.Structure_area_in_sqFeet,a.ps_code,a.property_district_code,a.Khatian_type,a.khatian_No,ps_code,moucode,road_code,road,ref_ps,ref_mouza,bata_no,bata_khatian_no from index_of_property a,district b,ro_master c,deed_details h,property_type pt where  a.Property_district_code = b.district_code and h.District_Code = a.district_code and h.ro_code = a.ro_code and h.book = a.book and h.deed_year = a.deed_year and h.deed_no = a.deed_no and pt.apartment_type_code = a.property_type and c.ro_code = a.ro_code  and a.district_code = '".$DO."'  and c.ro_code ='".$RO."' and a.ro_code ='".$RO."' and a.book = '".$Book."' and a.deed_year = '".$Year."' and a.deed_no = '".$Deed."'";
							
							$result3 = mysqli_query($con, $sql3);
							
							if (mysqli_num_rows($result3) > 0) {
								?>
								<table class="table table-hover table-bordered table-striped" border ='1' width='100%' style = "text-align: center; overflow-x:auto;font-size:small;">
										<thead class="thead-dark">
											<tr>
												<th style = 'padding:auto;'>Property Location</th>
												<th style = 'padding:auto;'>Property Type</th>
												<th style = 'padding:auto;'>Plot and Khatian No</th>
												<th style = 'padding:auto;'>Area with Property</th>
											</tr>
										</thead>
										<?php
									while($row1 = mysqli_fetch_row($result3)) {
										$sql4 = "select trim(ps_name) from ps where ps_code = '".$row1[10]."' and district_code = '".$row1[11]."'";
										
										$result4 = mysqli_query($con, $sql4);
										$n4 = mysqli_fetch_row($result4);
										$ps_name = $n4[0];
										
										
										$sql5 = "select eng_mouname from moucode where moucode = '".$row1[15]."' and district_code = '".$row1[11]."' and ps_code = '".$row1[10]."'";
										
										$result5 = mysqli_query($con, $sql5);
										$n5 = mysqli_fetch_row($result5);
										$moucode = $n5[0];
										
										$Area = "";
										$PlotKhatian = "";
										$PropLoc = "";
										?>
										<tbody id="myTable" style="text-align: left;">
										<tr>
										<?php
										$PropLoc = $PropLoc.$row1[0].$ps_name."\r"."Road: ".$row1[17];
										if($row1[15] != "")
										{
											$PropLoc = $PropLoc."\r"."Mouza: ".$moucode;
											
										}
										if($row1[19] != "")
										{
											$PropLoc = $PropLoc." ReF Mouza: ".$row1[19];
											
										}
										
										
										if($row1[20] != "")
										{
											$PlotKhatian = $PlotKhatian.$row1[2]."/".$row1[20];
											
										}
										if($row1[13] != "")
										{
											$PlotKhatian = $PlotKhatian."\r"."Khatian No: ".$row1[12]."-".$row1[13];
											
										}
										if($row1[21] != "")
										{
											$PlotKhatian = $PlotKhatian.$row1[2]."/".$row1[21];
											
										}
										
										if($row1[3] != "0")
										{
											$Area = $Area.$row1[3]." Acre ";
										}
										if ($row1[4] != "0")
										{
											$Area = $Area.$row1[4]." Bigha ";
										}
										
										if ($row1[5] != "0")
										{
											$Area = $Area.$row1[5]." Katha ";
										}
										if ($row1[6] != "0")
										{
											$Area = $Area.$row1[6]." Chatak ";
										}
										if ($row1[7] != "0")
										{
											$Area = $Area.$row1[7]." ". "SqFeet  ";
										}
										if ($row1[8] != "0")
										{
											$Area = $Area.$row1[8]." Decimal ";
										}
										
										if ($row1[9] != "0")
										{
											$Area = $Area."Structure Area ".$row1[9]." SqFeet or ".number_format((int)($row1[9] / 10.7639),2) + " SqMeter";
										}
										?>
											<td><?php echo  nl2br($PropLoc);?></td>
											<td><?php echo  nl2br($row1[1]);?></td>
											<td><?php echo  nl2br($PlotKhatian);?></td>
											<td><?php echo  nl2br($Area);?></td>
											</tr>
										</tbody>
										<?php
									}
									?>
									</table>
									<?php
							}
						?>
					 </div>
					 <?php
						
						if($error == "" || $success == "")
						{
							
							echo '<label class="text-danger"></label>';
							
						}
					 ?>
					 
					
					 
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
		
		<div class="displayNone"> 
			<input type="hidden"  id="txtSequenceId1" name="txtSequenceId1" value="<?php echo $Lot_No;?>"/>
			<input type="hidden"  id="txtSequenceId2" name="txtSequenceId2" value="<?php echo $batch;?>"/>
			<input type="hidden"  id="txtSequenceId3" name="txtSequenceId3" value="<?php echo $Policy;?>"/>
			<input type="hidden"  id="txtSequenceId4" name="txtSequenceId4" value="<?php echo $img_name;?>"/>
			<input type="hidden"  id="txtSequenceId5" name="txtSequenceId5" value="<?php echo $proj_key;?>"/>
			<input type="hidden"  id="txtSequenceId6" name="txtSequenceId6" value="<?php echo $batch_key;?>"/>
			<input type="hidden"  id="txtSequenceId7" name="txtSequenceId7" value="<?php echo $box_number;?>"/>
			<input type="hidden"  id="txtSequenceId8" name="txtSequenceId8" value="<?php echo $UAT;?>"/>
			<input type="hidden"  id="txtSequenceId9" name="txtSequenceId9" value="<?php echo $comments;?>"/>
			<input type="hidden"  id="check1" name="check1" />
			<input type="hidden"  id="check2" name="check2" />
			<input type="hidden"  id="check3" name="check3" />
			<input type="hidden"  id="check4" name="check4" />
			<input type="hidden"  id="check5" name="check5" />
			<input type="hidden"  id="check6" name="check6" />
			<input type="hidden"  id="check7" name="check7" />
			<input type="hidden"  id="check8" name="check8" />
			<input type="hidden"  id="check9" name="check9" />
			<input type="hidden"  id="check10" name="check10" />
			<input type="hidden"  id="solved" name="solved" />
			<input type="hidden"  id="qa_status" name="qa_status" />
		</div>
		
		<!-- Modal -->
		<div id="MySecondModalId" class="modal" style="box-shadow: 0 0 0px;padding: 0px;border-color: transparent;background: transparent;border-color: rgba(0,0,0,0);">
			<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <img src="BZer.ico" style="height:36px;width:36px;"></img>
			  <h4 class="modal-title float-left"><span>&nbsp;&nbsp;&nbsp;</span>IGR Audit!</h4>
			  <button type="button" class="close" data-dismiss="modal"><a href="#" rel="modal:close" style="color: #372d2d;">X</a></button>
			  </div>
			  <div class="modal-body">
				<p>Provide atleast one exception type</p>
			  </div>
			  <div class="modal-footer" style="margin:0px;">
			  <button type="button" class="btn btn-primary" data-dismiss="modal"><a href="#" rel="modal:close" style="color: white;">Ok</a></button>
			  
			  </div>
			 
			</div>
		</div>
		  
		</div>
		
		<div id="MyFirstModalId" class="modal" style="box-shadow: 0 0 0px;padding: 0px;border-color: transparent;background: transparent;border-color: rgba(0,0,0,0);">
			<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  <img src="BZer.ico" style="height:36px;width:36px;"></img>
			  <h4 class="modal-title float-left"><span>&nbsp;&nbsp;&nbsp;</span>IGR Audit!</h4>
			  <button type="button" class="close" data-dismiss="modal"><a href="#" rel="modal:close" style="color: #372d2d;">X</a></button>
			  </div>
			  <div class="modal-body">
				<p>This batch is already marked as ready for UAT.....</p>
			  </div>
			  <div class="modal-footer" style="margin:0px;">
			  <button type="button" class="btn btn-primary" data-dismiss="modal"><a href="#" rel="modal:close" style="color: white;">Ok</a></button>
			  
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
	
	     selectTags = document.getElementsByTagName("select");
		
		for(var i = 0; i < selectTags.length; i++) {
		  selectTags[i].selectedIndex =0;
		}
			
    </script>
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
	
	<script>
			function getName(val)
			{
				
				$.ajax({
					type: "POST",
					url: "getIMGsize.php",
					data: 'img='+val,
					
					success: function(data)
					{
						//alert(1.1);
						$("#img_size").html(data);
						document.getElementById("overlay").style.display = "none";
					}
				});
				
				var divs = document.getElementsByTagName("canvas");
			 //alert(divs.length);
					if (divs.length ) {
						divs[0].parentNode.removeChild(divs[0]);
					}
				   var lot = $('#txtSequenceId1').val();
				   var batch = $('#txtSequenceId2').val();	
				   var policy = $('#txtSequenceId3').val();	
				  
				   var xhr = new XMLHttpRequest();
				   xhr.responseType = 'arraybuffer';
				   xhr.open('GET', 'Documents/'+lot+'/'+batch+'/'+policy+'/QC/'+val+'');


				   xhr.onload = function (e) {
				  var tiff = new Tiff({buffer: xhr.response});
				  var canvas = tiff.toCanvas();
				  canvas.style.height= "1000px";
				  canvas.style.width= "100%";
				  canvas.id = "image";
				  //document.body.append(canvas);
				  document.getElementById("imageSh").appendChild(canvas);
				};
				xhr.send();
				
				
			}
			
			
		</script>
	<script language ="javascript">
		function openOverlay()
		{
			
			document.getElementById("overlay").style.display = "block";
			
				return true;
			
			
		}
		function zoomin() {
			
			
		  var myImg = document.getElementById("image");
		  var currWidth = myImg.clientWidth;
		  //alert(currWidth);
		  if (currWidth == 1181) return false;
		  else {
			myImg.style.width = (currWidth + 100) + "px";
		  }
		}

		function zoomout() {
		  var myImg = document.getElementById("image");
		  var currWidth = myImg.clientWidth;
		  
		  if (currWidth == 481) return false;
		  else {
			myImg.style.width = (currWidth - 100) + "px";
		  }
		}
		
		function missing_img()
		{
			var img = $('#image_name').val();
			var origDoctype = "";
			if ($('#missing_img').is(":checked")) { 
						origDoctype = $('#exception_log').text()+img.substr(17,5)+"-"+" Missing image \n";
						$('#exception_log').text(origDoctype);
					  }
		    else
		    {
				
				var strToReplace;
                strToReplace = img.substr(17,5)+"-"+" Missing image \n";
				var text_log = $('#exception_log').text();
				$('#exception_log').text(text_log.replace(strToReplace, ""));
			}
		}
		
		function poor_scan()
		{
			var img = $('#image_name').val();
			var origDoctype = "";
			if ($('#poor_scan').is(":checked")) { 
						origDoctype = $('#exception_log').text()+img.substr(17,5)+"-"+" Poor scan quality \n";
						$('#exception_log').text(origDoctype);
					  }
		    else
		    {
				var strToReplace;
                strToReplace = img.substr(17,5)+"-"+" Poor scan quality \n";
				var text_log = $('#exception_log').text();
				$('#exception_log').text(text_log.replace(strToReplace, ""));
			}
		}
		
		function rearrange()
		{
			var img = $('#image_name').val();
			var origDoctype = "";
			if ($('#rearrange').is(":checked")) { 
						origDoctype = $('#exception_log').text()+img.substr(17,5)+"-"+" Rearrange error \n";
						$('#exception_log').text(origDoctype);
					  }
		    else
		    {
				var strToReplace;
                strToReplace = img.substr(17,5)+"-"+" Rearrange error \n";
				var text_log = $('#exception_log').text();
				$('#exception_log').text(text_log.replace(strToReplace, ""));
			}
		}
		
		function spel()
		{
			var img = $('#image_name').val();
			var origDoctype = "";
			if ($('#spel').is(":checked")) { 
						origDoctype = $('#exception_log').text()+img.substr(17,5)+"-"+" Spelling Mistake \n";
						$('#exception_log').text(origDoctype);
					  }
		    else
		    {
				var strToReplace;
                strToReplace = img.substr(17,5)+"-"+" Spelling Mistake \n";
				var text_log = $('#exception_log').text();
				$('#exception_log').text(text_log.replace(strToReplace, ""));
			}
		}
		
		function wrong_prop()
		{
			var img = $('#image_name').val();
			var origDoctype = "";
			if ($('#wrong_prop').is(":checked")) { 
						origDoctype = $('#exception_log').text()+img.substr(17,5)+"-"+" Wrong Property \n";
						$('#exception_log').text(origDoctype);
					  }
		    else
		    {
				var strToReplace;
                strToReplace = img.substr(17,5)+"-"+" Wrong Property \n";
				var text_log = $('#exception_log').text();
				$('#exception_log').text(text_log.replace(strToReplace, ""));
			}
			
		
		}
	</script>
	<script type="text/javascript">
		function exception()
		{
			var policy= $('#txtSequenceId3').val();
			var proj_key= $('#txtSequenceId5').val();
			var batch_key= $('#txtSequenceId6').val();
			var box_number= $('#txtSequenceId7').val();
			var UAT= $('#txtSequenceId8').val();
			var expBol=false;
			var crop_clean = $('#check1').val();
			var spel = $('#check2').val();
			var extra_page = $('#check3').val();
			var wrong_prop = $('#check4').val();
			var missing_img = $('#check5').val();
			var move = $('#check6').val();
			var other = $('#check7').val();
			var poor_scan = $('#check8').val();
			var rearrange = $('#check9').val();
			var indexing = $('#check10').val();
			var solved = $('#solved').val();
			
			
			if(UAT == "false")
			{
				
				if ($('#crop_clean').is(":checked") == true)
				{
					crop_clean = 1;
					expBol = true;
				}
				else
				{
					crop_clean = 0;
				}
				if ($('#spel').is(":checked") == true)
				{
					spel = 1;
					expBol = true;
				}
				else
				{
					spel = 0;
				}
				if ($('#extra_page').is(":checked") == true)
				{
					extra_page = 1;
					expBol = true;
				}
				else
				{
					extra_page = 0;
				}
				if ($('#wrong_prop').is(":checked") == true)
				{
					wrong_prop = 1;
					expBol = true;
				}
				else
				{
					wrong_prop = 0;
				}
				if ($('#missing_img').is(":checked") == true)
				{
					missing_img = 1;
					expBol = true;
				}
				else
				{
					missing_img = 0;
				}
				if ($('#move').is(":checked") == true)
				{
					move = 1;
					expBol = true;
				}
				else
				{
					move = 0;
				}
				if ($('#other').is(":checked") == true)
				{
					other = 1;
					expBol = true;
				}
				else
				{
					other = 0;
				}
				if ($('#poor_scan').is(":checked") == true)
				{
					poor_scan = 1;
					expBol = true;
				}
				else
				{
					poor_scan = 0;
				}
				if ($('#rearrange').is(":checked") == true)
				{
					rearrange = 1;
					expBol = true;
				}
				else
				{
					rearrange = 0;
				}
				if ($('#indexing').is(":checked") == true)
				{
					indexing = 1;
					expBol = true;
				}
				else
				{
					indexing = 0;
				}
				var comments = $('#exception_log').text();
				
				if(expBol == true)
				{
					solved= 4;
					$.ajax({
						type: "POST",
						url: "UpdateQaPolicyException.php",
						data: 'crop_clean='+crop_clean+'&spel='+spel+'&extra_page='+extra_page+'&wrong_prop='+wrong_prop+'&missing_img='+missing_img+'&move='+move+'&other='+other+'&poor_scan='+poor_scan+'&rearrange='+rearrange+'&indexing='+indexing+'&comments='+comments+'&solved='+solved+'&policy='+policy+'&proj_key='+proj_key+'&batch_key='+batch_key+'&box_number='+box_number,
						
						success: function(data)
						{
							
							document.getElementById("overlay").style.display = "block";
							
								$.ajax({
								type: "POST",
								url: "QaExceptionStatus.php",
								data: 'solved='+solved+'&qa_status=2&policy='+policy+'&proj_key='+proj_key+'&batch_key='+batch_key+'&box_number='+box_number,
								
								success: function(data)
								{
									
									document.getElementById("overlay").style.display = "block";
									
										$.ajax({
										type: "POST",
										url: "UpdateStatus.php",
										data: 'status=30&policy='+policy+'&proj_key='+proj_key+'&batch_key='+batch_key+'&box_number='+box_number+'&policy_export_status=22',
										
										success: function(data)
										{
											
											document.getElementById("overlay").style.display = "block";
											
												$.ajax({
												type: "POST",
												url: "UpdateAllImageStatus.php",
												data: 'PAGE_EXCEPTION=32&policy='+policy+'&proj_key='+proj_key+'&batch_key='+batch_key+'&box_number='+box_number+'&PAGE_DELETED=29&PAGE_ON_HOLD=38&PAGE_RESCANNED_NOT_INDEXED=39&PAGE_EXPORTED=28',
												
												success: function(data)
												{
													
													document.getElementById("overlay").style.display = "none";
													
													window.location.href = 'IGR Audit.php';
												}
											});
										}
									});
								}
							});
						}
					});
					
				}
				else
				{
					$("#MySecondModalId").modal('show');
					 $("#MySecondModalId").modal({
					  escapeClose: false,
					  clickClose: false,
					  showClose: false
					  
					});
					
				}
			}
			else
			{
				$("#MySecondModalId").modal('show');
				$("#MyFirstModalId").modal({
					  escapeClose: false,
					  clickClose: false,
					  showClose: false
					  
					});
			}
		}
		
		
		function accepted()
		{
			var policy= $('#txtSequenceId3').val();
			var proj_key= $('#txtSequenceId5').val();
			var batch_key= $('#txtSequenceId6').val();
			var box_number= $('#txtSequenceId7').val();
			var UAT= $('#txtSequenceId8').val();
			var expBol=false;
			var crop_clean = $('#check1').val();
			var spel = $('#check2').val();
			var extra_page = $('#check3').val();
			var wrong_prop = $('#check4').val();
			var missing_img = $('#check5').val();
			var move = $('#check6').val();
			var other = $('#check7').val();
			var poor_scan = $('#check8').val();
			var rearrange = $('#check9').val();
			var indexing = $('#check10').val();
			var solved = $('#solved').val();
			
			if(UAT == "false")
			{
				$.ajax({
					type: "POST",
					url: "UpdateStatus.php",
					data: 'status=31&policy='+policy+'&proj_key='+proj_key+'&batch_key='+batch_key+'&box_number='+box_number+'&policy_export_status=22',
										
					success: function(data)
					{
						document.getElementById("overlay").style.display = "block";
						
						$.ajax({
						type: "POST",
						url: "UpdateAllImageStatus.php",
						data: 'PAGE_EXCEPTION=33&policy='+policy+'&proj_key='+proj_key+'&batch_key='+batch_key+'&box_number='+box_number+'&PAGE_DELETED=29&PAGE_ON_HOLD=38&PAGE_RESCANNED_NOT_INDEXED=39&PAGE_EXPORTED=28',
											
						success: function(data)
						{
							document.getElementById("overlay").style.display = "block";
							
							$.ajax({
							type: "POST",
							url: "QaExceptionStatus.php",
							data: 'solved=3&qa_status=0&policy='+policy+'&proj_key='+proj_key+'&batch_key='+batch_key+'&box_number='+box_number,					
							
							success: function(data)
							{
								document.getElementById("overlay").style.display = "none";
								
								window.location.href = 'IGR Audit.php';
							}
							});
						}
						});
						
					}
					});
			}
			else
			{
				$("#MyFirstModalId").modal({
					  escapeClose: false,
					  clickClose: false,
					  showClose: false
					  
					});
			}
		}
		
	</script>
	<script>
	$("#nextPage").click(function() {
		$('#image_name option:selected').removeAttr('selected');
	
	  $('#image_name option:selected').next().prop('selected', 'selected');
	  var val =$('#image_name').val();
	  $.ajax({
					type: "POST",
					url: "getIMGsize.php",
					data: 'img='+val,
					
					success: function(data)
					{
						//alert(1.1);
						$("#img_size").html(data);
						document.getElementById("overlay").style.display = "none";
					}
				});
				
				var divs = document.getElementsByTagName("canvas");
			 //alert(divs.length);
					if (divs.length ) {
						divs[0].parentNode.removeChild(divs[0]);
					}
				   var lot = $('#txtSequenceId1').val();
				   var batch = $('#txtSequenceId2').val();	
				   var policy = $('#txtSequenceId3').val();	
				  
				   var xhr = new XMLHttpRequest();
				   xhr.responseType = 'arraybuffer';
				   xhr.open('GET', 'Documents/'+lot+'/'+batch+'/'+policy+'/QC/'+val+'');


				   xhr.onload = function (e) {
				  var tiff = new Tiff({buffer: xhr.response});
				  var canvas = tiff.toCanvas();
				  canvas.style.height= "1000px";
				  canvas.style.width= "100%";
				  canvas.id = "image";
				  //document.body.append(canvas);
				  document.getElementById("imageSh").appendChild(canvas);
				};
				xhr.send();
				
				
	})

	$("#prevPage").click(function() {
		$('#image_name option:selected').removeAttr('selected');
		
	  $('#image_name option:selected').prev().prop('selected', 'selected');
	  var val = $('#image_name').val();
	  $.ajax({
					type: "POST",
					url: "getIMGsize.php",
					data: 'img='+val,
					
					success: function(data)
					{
						//alert(1.1);
						$("#img_size").html(data);
						document.getElementById("overlay").style.display = "none";
					}
				});
				
				var divs = document.getElementsByTagName("canvas");
			 //alert(divs.length);
					if (divs.length ) {
						divs[0].parentNode.removeChild(divs[0]);
					}
				   var lot = $('#txtSequenceId1').val();
				   var batch = $('#txtSequenceId2').val();	
				   var policy = $('#txtSequenceId3').val();	
				  
				   var xhr = new XMLHttpRequest();
				   xhr.responseType = 'arraybuffer';
				   xhr.open('GET', 'Documents/'+lot+'/'+batch+'/'+policy+'/QC/'+val+'');


				   xhr.onload = function (e) {
				  var tiff = new Tiff({buffer: xhr.response});
				  var canvas = tiff.toCanvas();
				  canvas.style.height= "1000px";
				  canvas.style.width= "100%";
				  canvas.id = "image";
				  //document.body.append(canvas);
				  document.getElementById("imageSh").appendChild(canvas);
				};
				xhr.send();
				
				
	});
	</script>
	
  
		
		<script type="text/javascript">
			var divs = document.getElementsByTagName("canvas");
			 //alert(divs.length);
			if (divs.length ) {
				divs[0].parentNode.removeChild(divs[0]);
			}
		   var lot = $('#txtSequenceId1').val();
		   var batch = $('#txtSequenceId2').val();	
		   var policy = $('#txtSequenceId3').val();	
		   var img = $('#txtSequenceId4').val();	
		   var xhr = new XMLHttpRequest();
		   xhr.responseType = 'arraybuffer';
		   xhr.open('GET', 'Documents/'+lot+'/'+batch+'/'+policy+'/QC/'+img+'');


		   xhr.onload = function (e) {
		  var tiff = new Tiff({buffer: xhr.response});
		  var canvas = tiff.toCanvas();
		  canvas.style.height= "1000px";
		  canvas.style.width= "100%";
		  canvas.id = "image";
		  //document.body.append(canvas);
		  document.getElementById("imageSh").appendChild(canvas);
		};
		xhr.send();
		 </script>
		
  </body>
</html>