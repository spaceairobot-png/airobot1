<?php
session_start();
include('../../connection.php');


		$query = mysqli_query($conn, "select A.InstituitionID , B.Des  from tblinstprog A left join cfginstitution B on A.InstituitionID = B.Code where A.ProgramLevelID='".$_REQUEST['ProlvlCode']."' and B.isActive ='A' order by B.Des asc ");
			
		if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query))
            {
                echo '<option value="'.$row['InstituitionID'].'">'.$row['Des'].'</option>';
            }
		}else {
			
			echo '<option value=""></option>';
		}


?>