<?php 
ob_start();
session_start();

require_once('../connection.php');

$Username = $_SESSION['Username'];
$UserRole = $_SESSION['Role'];
$CSRole   = $_SESSION['Counsellor'];

if($Username == "") 
{
	header('Location:../index.php');
	ob_end_flush(); // Important to flush buffer immediately!
	exit();
}

//solve resubmit issue
header_remove(); // Remove previous headers
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0"); 

//session_cache_limiter("private_no_expire");
?>
    <!DOCTYPE html>
    <html lang="en"><head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Admin Dashboard</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/bootstrap-toggle.min.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>
            window.jQuery || document.write('<script src="../js/vendor/jquery.min.js"><\/script>')
        </script>
        <script src="../js/bootstrap.min.js"></script>
        

        <script src="../js/bootstrap-toggle.min.js"></script>

        <link href="../css/dashboard.css" rel="stylesheet">

        <link href="../css/menu.css" rel="stylesheet">
        
        <link href="../css/table0.css" rel="stylesheet">


        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>



	var status1 = localStorage.getItem("close");
 
  if (status1 == 1)
  {
    document.write("<style>#main { width:100%; margin-Left:auto;}  #mySidenav{ visibility:hidden;} #closebtn{ visibility:hidden;} #openbtn{ visibility:visible;} </style>");
  }
	else 
	{
    document.write("<style>#main { width:86.3%; } #mySidenav{ visibility:visible; width:12.66666667%; } #closebtn{ visibility:visible;} #openbtn{ visibility:hidden;} </style>");
	}
</script>
<script>
		
        function openNav() {
            document.getElementById("mySidenav").style.width = "12.66666667%";
            document.getElementById("main").style.marginLeft = "12.66666667%";
            document.getElementById("closebtn").style.visibility = "visible";
            document.getElementById("openbtn").style.visibility = "hidden";
            document.getElementById("mySidenav").style.visibility = "visible";
            document.getElementById("main").style.width = "86.3%";
            
            localStorage.setItem('open', '1');
            localStorage.setItem('close', '0');
        }

        function closeNav() {
            
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.getElementById("closebtn").style.visibility = "hidden";
            document.getElementById("openbtn").style.visibility = "visible";
            document.getElementById("mySidenav").style.visibility = "hidden";
            document.getElementById("main").style.width = "100%";
            
            localStorage.setItem('open', '0');
            localStorage.setItem('close', '1');
        }
    </script>

	<?php 
	if (@$_GET['page'] != 'print_invoice') {
		include 'func/calender.php'; 
	}
	?>
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" style="background:#f5f5f5;border-bottom:1px solid #eee;">
            <div class="container-fluid" style="background-color:aliceblue">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        
                    </button>
                 
				<a class="navbar-brand" href="index.php?page=listing_dashboard"> Welcome <?php echo $Username ?> !
				</a>
				
                </div>
               
				<div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
					<div id="hidemenu">
					
							<?php if($UserRole == 'Adm'){ ?>
							<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">User List
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_loginuser">New Login</a></li>
                                        <li><a runat="server" href="index.php?page=listing_loginuser">User list</a></li>
                                    </ul>
                                </li>				
						<?php } ?>
			
							<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add New Student
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_student">Create</a></li>
                                        <li><a runat="server" href="index.php?page=add_student_import">Import</a></li>
                                    </ul>
                                </li>
					
							<li class=" dropdown ">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Student Database
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=listing_student">Search</a></li>
										
                                      
										<hr style="margin-top:2%; margin-bottom:2%;">	
                                    </ul>
                                </li>
								
                            <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Enrolment List 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=listing_enrolment">Enrolment List</a></li>
                                    </ul>
                                </li>	
								
							<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Payment List
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_payment">Add Payment</a></li>
										<li><a runat="server" href="index.php?page=listing_payment">Payment list</a></li>
                                        <li><a runat="server" href="index.php?page=listing_checkpayment">Check list</a></li>
                                    </ul>
                                </li>	
								
                                <?php if($UserRole == 'Adm'){ ?>
                                <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Product List
                                        <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a runat="server" href="index.php?page=add_product">Add Product</a></li>
                                            <li><a runat="server" href="index.php?page=listing_product">Product list</a></li>
                                        </ul>
                                </li>				
                                <?php } ?>

                                <?php if($UserRole == 'Adm'){ ?>
                                <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Expense List
                                        <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a runat="server" href="index.php?page=add_expense">Add Expense</a></li>
                                            <li><a runat="server" href="index.php?page=listing_expense">Expense list</a></li>
                                        </ul>
                                </li>				
                                <?php } ?>
								
								<hr>
								 
								 <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Counsellor 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_parameter&pname=Counsellor">Add Counsellor</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=Counsellor">Counsellor List</a></li>
                                    </ul>
                                </li>
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Engagement 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_parameter&pname=Engagement">Add Engagement</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=Engagement">Engagement List</a></li>
                                    </ul>
                                </li>
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Event/Batch
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_parameter&pname=Event">Add Event</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=Batch">Event List</a></li>
                                    </ul>
                                </li>
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> State 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_parameter&pname=State">Add State</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=State">State List</a></li>
                                    </ul>
                                </li>
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Country 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_parameter&pname=Country">Add Country</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=Country">Country List</a></li>
                                    </ul>
                                </li>
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> School 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_parameter&pname=School">Add School</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=School">School List</a></li>
                                    </ul>
                                </li>
								
								<!-- <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Institution 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a runat="server" href="index.php?page=add_institution_link">Add Institution</a></li>
										<li><a runat="server" href="index.php?page=listing_institution_link">Institution List</a></li>
                                    </ul>
                                </li> -->
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Course 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                       <li><a runat="server" href="index.php?page=add_parameter&pname=Course">Add Course</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=Course">Course List</a></li>
                                    </ul>
                                </li>
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Qualification 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                       <li><a runat="server" href="index.php?page=add_parameter&pname=Qualification">Add Qualification</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=Qualification">Qualification List</a></li>
                                    </ul>
                                </li>
								
								<li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-wrench"> </span> Program Level 
									<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                       <li><a runat="server" href="index.php?page=add_parameter&pname=Level">Add Program Level</a></li>
										<li><a runat="server" href="index.php?page=listing_parameter&pname=Level">Program Level List</a></li>
                                    </ul>
                                </li>
								
						</div>
								
						<li><a style="text-align:center" href="index.php?page=update_password" >Profile <span class="glyphicon glyphicon-user"> </span></a></li>
                        <li><a href="logout.php" style="text-align:center">Logout <span class="glyphicon glyphicon-log-out"> </span></a></li>
                    </ul>
                    
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div id="mySidenav" class="col-sm-3 col-md-2 sidebar ">

                    <ul class="nav nav-sidebar">
                        <!--<li ><a href="index.php">Dashboard <span class="sr-only">(current)</span></a></li>-->
                        <!-- find users' image if image not found then show dummy image -->
						
                        <li style="padding-left: 2px; padding-bottom: 5%; padding-top: 5%; display: flex; justify-content: space-between; align-items: center;">
							<?php 
							$timestamp = strtotime(date('Y-m-d'));
							$day = date('D', $timestamp);
							echo "<b>" .$day. "</b>";
							?>
						<a href="javascript:void(0)" id="closebtn" class="closebtn" onclick="closeNav()" style="font-size: 30px; color: black; text-decoration: none;">&times;</a>
						</li>
  

						<?php if($UserRole == 'Adm') { ?>
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">User List
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_loginuser">New Login</a></li>
                                <li><a href="index.php?page=listing_loginuser">User Listing</a></li>
                            </ul>
                        </li>
						<?php } ?>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add New Student
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_student">Create</a></li>
                                <li><a href="index.php?page=add_student_import">Import</a></li>
                            </ul>
                        </li>
						
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Student Database
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a  href="index.php?page=listing_student">Search</a></li>
								
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Enrolment List 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=listing_enrolment">Enrolment List</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Payment List 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_payment">Add Payment</a></li>
								<li><a href="index.php?page=listing_payment">Payment List</a></li>
                                <li><a href="index.php?page=listing_checkpayment">Check List</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Product List 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_product">Add Product</a></li>
								<li><a href="index.php?page=listing_product">Product List</a></li>
                            </ul>
                        </li>

                        <?php if($UserRole == 'Adm') { ?>
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Expense List
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_expense">New Expense</a></li>
                                <li><a href="index.php?page=listing_expense">Expense List</a></li>
                            </ul>
                        </li>
						<?php } ?>

						<hr style="margin-top:1%; margin-bottom:1%;">
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> Counsellor 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=Counsellor">Add Counsellor</a></li>
								<li><a href="index.php?page=listing_parameter&pname=Counsellor">Counsellor Listing</a></li>
                            </ul>
                        </li>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> Engagement 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=Engagement">Add Engagement</a></li>
								<li><a href="index.php?page=listing_parameter&pname=Engagement">Engagement Listing</a></li>
                            </ul>
                        </li>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> Event/Batch
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=Event">Add Event</a></li>
								<li><a href="index.php?page=listing_parameter&pname=Event">Event Listing</a></li>
                            </ul>
                        </li>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> State 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=State" >Add State</a></li>
								<li><a href="index.php?page=listing_parameter&pname=State">State Listing</a></li>
                            </ul>
                        </li>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> Country 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=Country">Add Country</a></li>
								<li><a href="index.php?page=listing_parameter&pname=Country">Country Listing</a></li>
                            </ul>
                        </li>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> School 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=School">Add School</a></li>
								<li><a href="index.php?page=listing_parameter&pname=School">School Listing</a></li>
                            </ul>
                        </li>
						
						<!-- <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> Institution 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_institution_link">Add Institution</a></li>
								<li><a href="index.php?page=listing_institution_link">Institution Listing</a></li>
                            </ul>
                        </li> -->
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> Course 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=Course">Add Course</a></li>
								<li><a href="index.php?page=listing_parameter&pname=Course">Course Listing</a></li>
                            </ul>
                        </li>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span> Qualification 
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=Qualification">Add Qualification</a></li>
								<li><a href="index.php?page=listing_parameter&pname=Qualification">Qualification Listing</a></li>
                            </ul>
                        </li>
						
						<li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style='color:#B2A92E'> <span class="glyphicon glyphicon-wrench"> </span>  Program Level  
							<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?page=add_parameter&pname=Level">Add Program Level</a></li>
								<li><a href="index.php?page=listing_parameter&pname=Level">Program Level Listing</a></li>
                            </ul>
                        </li>
						
                    </ul>
                </div>
            </div>
        </div>

        <div id="main" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" >
            <div style="width:25%; float:left">
                <a href="javascript:void(0)" id="openbtn" class="openbtn" onclick="openNav()" style=" font-size:30px;"> &#9776;</a>

            </div>
			<br>
            <!-- container-->


      <?php 
	  
	
	 @$page=$_GET['page'];
		  if($page!="")
		  {
			 if($page=="add_loginuser")
			{
				include('add_loginuser.php');
      		}
	         if($page=="listing_loginuser")
			{
				include('listing_loginuser.php');
      		}
              if($page=="del_loginuser")
			{
				include('del_loginuser.php');
      		}
             if($page=="upd_loginuser")
			{
				include('upd_loginuser.php');
      		}
			if($page=="update_password")
			{
				include('update_password.php');
      		}
			
			if($page=="add_student")
			{
				include('add_student.php');
      		}
			
			if($page=="add_student_import")
			{
				include('add_student_import.php');
      		}
			
			if($page=="listing_student")
			{
				include('listing_student.php');
      		}
			if($page=="upd_student")
			{
				include('upd_student.php');
      		}
			if($page=="del_student")
			{
				include('del_student.php');
      		}
			if($page=="add_followup")
			{
				include('add_followup.php');
      		}
			
			if($page=="listing_enrolment")
			{
				include('listing_enrolment.php');
      		}
			if($page=="listing_enrolment_detail")
			{
				include('listing_enrolment_detail.php');
      		}
			
			if($page=="add_parameter")
			{
				include('add_parameter.php');
      		}
			if($page=="listing_parameter")
			{
				include('listing_parameter.php');
      		}
			if($page=="del_parameter")
			{
				include('del_parameter.php');
      		}
			if($page=="upd_parameter")
			{
				include('upd_parameter.php');
      		}
			
			if($page=="add_institution_link")
			{
				include('add_institution_link.php');
      		}
			if($page=="upd_institution_link")
			{
				include('upd_institution_link.php');
      		}
			if($page=="listing_institution_link")
			{
				include('listing_institution_link.php');
      		}
			
			if($page=="add_enrolment")
			{
				include('add_enrolment.php');
      		}
			if($page=="upd_enrolment")
			{
				include('upd_enrolment.php');
      		}
			if($page=="del_enrolment")
			{
				include('del_enrolment.php');
      		}
			if($page=="listing_dashboard")
			{
				include('listing_dashboard.php');
      		}
			if($page=="listing_dashboard_detail")
			{
				include('listing_dashboard_detail.php');
      		}
			if($page=="add_payment")
			{
				include('add_payment.php');
      		}
			if($page=="listing_payment")
			{
				include('listing_payment.php');
      		}
            if($page=="upd_payment")
			{
				include('upd_payment.php');
      		}
			 if($page=="del_payment")
			{
				include('del_payment.php');
      		}
			if($page=="print_invoice")
			{
				include('print_invoice.php');
      		}
		if($page=="print_receipt")
			{
				include('print_receipt.php');
      		}

            if($page=="listing_checkpayment")
            {
                include('listing_checkpayment.php');
            }
            if($page=="listing_product")
			{
				include('listing_product.php');
      		}
             if($page=="add_product")
			{
				include('add_product.php');
      		}
             if($page=="del_product")
			{
				include('del_product.php');
      		}
             if($page=="upd_product")
			{
				include('upd_product.php');
      		}
            if($page=="listing_expense")
			{
				include('listing_expense.php');
      		}
            if($page=="add_expense")
			{
				include('add_expense.php');
      		}


		  }
		 // default
			
		 
		 
			else
			{
				include('listing_dashboard.php');
			}
	
		  ?>

        </div>
        <!-- Bootstrap core JavaScript
    ================================================== -->

      
        
    </body>

    </html>
	<?php
ob_end_flush(); // Flush buffer at the end
?>