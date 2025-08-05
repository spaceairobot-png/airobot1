<?php
session_start();
include('../../connection.php');

		if(!empty($_POST["txtName"])) {
				$query = "SELECT * FROM tblstudent WHERE Name='" . $_POST["txtName"] . "'";
			
			
			$chk=mysqli_query($conn,$query);
			$r=mysqli_num_rows($chk);
			
			// if($r!=true)
			if($r == 0)
			{
				 echo "<span class='status-available glyphicon glyphicon-ok' style='color:blue'> Username is Available .</span>";
			}
			else{
				  echo "<span class='status-not-available glyphicon glyphicon-alert' style='color:orange'> Username is Exists.</span>";
				  echo '<script type="text/javascript">alert("Duplicate username is detected"); </script>';
			}
}


?>

