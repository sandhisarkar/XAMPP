<?php
session_start();

$con=mysqli_connect("localhost","root","root","demo");
if(!isset($con))
{
    die("Database Not Found");
}

$msg = "";
$head = "Admin Login";
if(isset($_REQUEST["u_sub"]))
{
    
 $usr=$_POST['u_user'];
 $pwd=$_POST['u_ps'];
 if($usr!=''&&$pwd!='')
 {
   $query=mysqli_query($con ,"select * from admin_user_data where s_user='".$usr."' and s_pwd='".$pwd."'");
   $res=mysqli_fetch_row($query);
   $query1=mysqli_query($con ,"select * from admin_user_data where s_user='".$usr."'");
   $res1=mysqli_fetch_row($query1);

   if($res)
   {
    $_SESSION['user']=$usr;
    header('location:home.php');
   }
   else
   {
    
    echo '<script>';
    $msg = 'Invalid username or password';
    echo '</script>';
   }
   
   if($res1)
   {
    $_SESSION['user']=$usr;
    header('location:home.php');
   }
   else
   {
    
    echo '<script>';
    $msg = 'Invalid username or password';
    echo '</script>';
   }
  }
 else
 {
    echo '<script>';
    $msg = 'Enter both username and password';
    echo '</script>';
 
 }
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="css/login.css"></link>
        <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
         <link rel="stylesheet" href="bootstrap/bootstrap-theme.min.css">
       <script src="bootstrap/jquery.min.js"></script>
        <script src="bootstrap/bootstrap.min.js"></script>

       
        <title><?php echo $head; ?></title>
        
		<!-- Favicons -->
		<link href="imgages/xyz.png" rel="icon">
		<link href="imgages/xyz.png" rel="apple-touch-icon">
        
        
    </head>
    <body  style="background-image:url('./images/06.jpg'); background-size: cover;" >
        <form id="index" action="index.php" method="post">
            
            <div class="container-fluid">    
                <div class="row">
                  <div class="col-sm-12">
                        <img src="" width="100%" style="box-shadow: 1px 5px 14px #999999; "></img>
                  </div>
                 </div>    
             
        
            
            
                <div  id="divtop">
                    
                        <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
                            <div id="dmain"  > 
                               <br>
							   <center><h1  width="120px" height="100px" style= "color:aliceblue;"><?php echo $head; ?></h1></center>
                               <br>
								<h4 style="color:red; margin-left: 75px;"> 
									<?php echo $msg; ?>
								</h4>

                                    <input type="text" id="u_user" name="u_user" class="form-control" style="width:320px; margin-left: 60px; " placeholder="Enter Your Username"><br>
                                    <input type="password" id="u_ps" name="u_ps" class="form-control" style="width:320px; margin-left: 60px;" placeholder="Enter Your Password"><br> <br>
                                    <input type="submit" id="u_sub" name="u_sub" value="Login" class="toggle btn btn-primary" style="width:120px; margin-left: 160px"><br> <br>
                                    <a href="/Education" style="margin-left: 150px; color: blanchedalmond;"><b>Back to Main Page</b></a>
                             </div>
                     </div>
                    </div>
               </div>
            </div>  
            </div>
        </form>  
       </body>
</html>
