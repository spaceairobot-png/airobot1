<?php
session_start();




	extract($_POST);
	if(isset($login))
	{
		$err="";
		
		include 'connection.php';
        
		$pass2 = hash('sha512', $pass);
		
        $mySqlStr = "select Id  , Username , Role , Password , 	ResetToken ,TokenExpDate ,Counsellor,  IsActive from tbllogin where Username='$username' and IsActive = 1";
		
        $que=mysqli_query($conn,$mySqlStr);
        $row=mysqli_num_rows($que);
		
		if($row)
			{	
				while ($row1=mysqli_fetch_row($que))
    			{
				$_SESSION['UserId']=$row1[0];
				$_SESSION['Username']=$row1[1];
				$_SESSION['Role']=$row1[2];
				$_SESSION['Password']=$row1[3];
				$_SESSION['ResetToken']=$row1[4];
				$_SESSION['TokenExpDate']=$row1[5];
				$_SESSION['Counsellor']=$row1[6];
				}
				
				if ($_SESSION['Password'] == $pass2) 
				{
					header('location:admin');
					
				}else if  ($_SESSION['ResetToken'] == $pass  && $_SESSION['TokenExpDate'] > date("Y/m/d")) {
					header('location:admin');
				}
				
				
				if  (($_SESSION['ResetToken'] != $pass ) || $_SESSION['TokenExpDate'] < date("Y/m/d") )
				{
					$err="<font color='red'>Invalid Username or Password !</font>";	
				}
				else if ($_SESSION['Password'] != $pass2)  {
					$err="<font color='red'>Wrong Username or Password !</font>";	
				}
			
				
				
			}
		else
			{
				$err="<font color='red'>Wrong Username or Password !</font>";
			}
	}
	
	
	
	?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
	<style>
	.login{
	height:100px;
	top:130px;
 position:relative;
animation:mymove 3s ease-out forwards;
animation-iteration-count:1;

/* Safari and Chrome */
-webkit-animation:mymove 1s;
}

@keyframes mymove
{ from {top:0px; opacity: 0;}
to {top:130px; opacity: 1}
}

@-webkit-keyframes mymove /* Safari and Chrome */
{
from {top:0px; opacity: 0;}
to {top:130px; opacity: 1;}
}

body {
    background: url('css/img/bg.jpg') no-repeat top center fixed;
    background-size: 400px auto;
    background-color: #f5f5f5;
}

body::before {
    content: "";
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background-color: grey; /* semi-transparent overlay */
    z-index: -1;
}	

.login {
    animation: fadeIn 1s ease-out;
    margin-top: 60px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.login-panel {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.25);
    padding: 30px;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.login-panel .form-control {
    background: rgba(255,255,255,0.8);
    border: none;
    border-radius: 10px;
    font-size: 16px;
    color: #333;
}

.login-panel .btn-success {
    border-radius: 10px;
    font-weight: bold;
    font-size: 16px;
}

a {
    color: #ddd;
    text-decoration: underline;
}

a:hover {
    color: #fff;
    text-decoration: none;
}

</style>
	
	<!-- jQuery -->
    <script src="css/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="css/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="css/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="css/sb-admin-2.js"></script>
	
	<script src="js/jquery-1.12.4.js"></script>
	
	<script>history.pushState({}, "", "")</script>
<script>
//for nav menu use - keep open or close status

localStorage.removeItem("close");
localStorage.removeItem("open");

window.onload = myOnloadFunc;

function myOnloadFunc() {
   document.getElementById('name').value = ''
   document.getElementById('pass').value = ''
}

$(document).ready(function () {
$('.js-text-to-password-onedit').focus(function(){
    el = $(this);
      if(el.prop('type') == 'text'){
        el.prop('type', 'password');
      }
	});
});
</script>
</head>




<body >
<div>
<?php
// $servername = "127.0.0.1";
// $username = "root";
// $password = "123456";

// // Create connection
// $conn = new mysqli($servername, $username, $password);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 
// echo "Connected successfully";
?>
</div>

<h1 class="page-title text-center" style="font-weight:bold; color:#2C3E50; margin-bottom:20px; letter-spacing:2px;">
    AI Robot Space Solution 🚀
</h1>

    <div class="container" >
        <div class="row" style="margin-top:20px">
            <div class="col-md-4 col-md-offset-4">
			<div class="login">
                <div class="login-panel panel panel-default" style="margin-top:0%">
                    <div  text-center">
    <h3 class="panel-title" style="font-weight:bold; font-size:22px;">Welcome back</h3>
    <p style="margin-top:5px; color:#black;">Sign in to continue</p>
</div>
                    <div class="panel-body">
                        <form method="post"  autocomplete="off">
                            <fieldset>
                                					
                                <div class="form-group">
                                    <input class="form-control" id="name" name="username" type="text" value="" autofocus required placeholder="username" autocomplete="off" \>
                                </div>
								
                                <div class="form-group">
                
									<input type="text"  id="pass" name="pass" placeholder="Password" class="form-control js-text-to-password-onedit" required>

                                </div>
                                
                                
								<div class="form-group">
                                    <input name="login" type="submit" value="Login" class="btn btn-lg btn-success btn-block">
                                </div>
								
								<div class="form-group">
                                    <label>
                                        <?php echo @$err;?>
                                    </label>
                                </div>
								
                                
                            </fieldset>
                        </form>
						 <p class="font-weight-light mb-2"><a href="reset_pswd_email.php">+ Forget Password</a></p>
						
						 <small class="font-weight-light mb-0 ">Copyright &copy; 2025 ( Version 1.0.1) </small>
                    </div>
                </div>
            </div>
        </div>
		</div>
    </div>

</body>

</html>
