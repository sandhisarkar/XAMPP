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


if (isset($_POST["excel_sub"])){
	
	$runno = $_POST["runno"];
	
	$sql="UPDATE audit_backup SET status= '1' WHERE run_no='".$runno."' ";
	
	if (!mysqli_query($con,$sql))
	{
	  
	  $success = "Error";
	  
	}
	else
	{
		
		$success = "Success";
	  
	}
	
}


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
		<link href="images/xyz.png" rel="apple-touch-icon">
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
		  <style>
			.main {
			  padding: 16px;
			  margin-top: 30px;
			  width: 100%;
			  height: 65vh;
			  overflow: auto;
			  cursor: grab;
			  cursor: -o-grab;
			  cursor: -moz-grab;
			  cursor: -webkit-grab;
			}

			.main img {
			  height: auto;
			  width: 100%;
			}
		  </style>

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
				
		  		<h1><a onclick= "openOverlay()" href="Home.php" class="logo" style = "font-size: 25px;">Admin Panel</a></h1>
				<p>Username : &nbsp; <?php echo $stname;?></p>
	        <ul class="list-unstyled components mb-5">
	          <li>
	            <a onclick= "openOverlay()" href="Home.php">Image Upload</a>
			  </li>
			  
			<li  class="active">
	            <a onclick= "openOverlay()" href="Lot Approval.php">Lot Approval</a>
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
		
        <h2 class="mb-4"><u>Lot Approval</u> </h2>
		
        <p>
			<div class="col-sm-12">
				<section id="services" class="section" style="display:block;">
				<center>
				<div class="row">
					
					
					  <div class="col-sm-12  wow bounceInUp" data-wow-duration="1.6s" style ="margin-top: 5%;">
					  
							<form action="Lot Approval.php" method="post" enctype="multipart/form-data">
							<div>
							<label style="margin-left: -7px;">Choose Run Number : &nbsp; </label>
									<select required="true" id="runno" name="runno" onchange="uploadme1()" style="font-size: 15px;height: 25px;padding-top: 0px;margin-top: 25px;width: 300px;">
										<option disabled selected value = "">Select Any...</option>
										<?php
											//mysqli_select_db( $con,"course_details");

											$sql = "SELECT DISTINCT run_no FROM batch_master where run_no <>  ' ' ";
											$result = mysqli_query($con, $sql);
											if (mysqli_num_rows($result) > 0) {
											// output data of each row
											while($row = mysqli_fetch_row($result)) {
												$sql1 = "SELECT Count(*) FROM batch_master where run_no = '".$row[0]."' ";
												$result1 = mysqli_query($con, $sql1);
												$row1 = mysqli_fetch_row($result1);
												$count1 = $row1[0];
												
												$sql2 = "SELECT Count(*) FROM audit_backup where run_no = '".$row[0]."' and status = '0'";
												$result2 = mysqli_query($con, $sql2);
												$row2 = mysqli_fetch_row($result2);
												$count2 = $row2[0];
												
												if($count1 == $count2)
												{
												?>
												<option><?php echo  $row[0]?></option>
												<?php
											}
											}
										} else {
											 echo  "";
										}
										?>
										
									</select>
							</div>
							
							<div style="padding-top: 3%;">
								<button type="submit" id = "excel_sub" name = "excel_sub" class="btn btn-primary"  onclick="uploadme()">Approve Lot Number<span></span> <i class="fa fa-check"></i></button>
							</div>
							</form>
							
							
					  </div>
					  <div id = "imageSh" class="main dragscroll col-md-6  wow bounceInUp" data-wow-duration="2.4s" style="margin-top:5%;display:none;">
						 <!--div  class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" >
							
							
						 </div-->
					 </div>
					 <?php
						if($success == "Success")
						{
						
							?>
							<div class="col-md-12  wow bounceInUp" data-wow-duration="2.4s" style="margin-top:5%;">
							  <div class="box">
								<h6>Lot Number is Ready for Audit . . .  <i class="fa fa-check text-success"></i></h6>
								<h6>Lot Number - <u><b><?php  echo $runno;?></b></u> </h6>
								
							  </div>
						  </div>
							<?php
						}
						if($error == "" || $success == "")
						{
							
							echo '<label class="text-danger"></label>';
							
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
			
			var runno = $("#runno").val();
			
			
			if(runno !== "")
			{
				
					
					document.getElementById("overlay").style.display = "block";
					
					return true;
				
			}
			if(runno === null)
			{
				document.getElementById("overlay").style.display = "none";
				
				return false;
			}
		}
		
		function uploadme1()
		{
			document.getElementById("excel_sub").style.background = "green";
			//document.getElementById("overlay").style.display = "block";
			
			//return true;
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
		$(document).ready(function() {
		$('#example').DataTable();
	} );
	</script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.rawgit.com/seikichi/tiff.js/master/tiff.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
	
	
		<script type="text/javascript">
		   var xhr = new XMLHttpRequest();
		   xhr.responseType = 'arraybuffer';
		   xhr.open('GET', "Documents/1202000001/1202120081/120212008[00001]/QC/120212008[00001]_005_A.TIF");


		   xhr.onload = function (e) {
		  var tiff = new Tiff({buffer: xhr.response});
		  var canvas = tiff.toCanvas();
		  canvas.style.height= "1000px";
		  canvas.style.width= "640px";
		  canvas.id = "image";
		  //document.body.append(canvas);
		  //document.getElementById("imageSh").appendChild(canvas);
		};
		xhr.send();
		 </script>
		
  </body>
</html>