<?php


$uid ='';
$fileName ='';

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
		$rowExcel = 0;
        $file = fopen($fileName, "r");
        $uid = uniqid();
		$_SESSION['uid'] =$uid;
		
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
			if ($rowExcel > 0 ) {
            $Counsellors = "";
            if (isset($column[0])) {
                $Counsellors = mysqli_real_escape_string($conn, $column[0]);
            }
		   
            $Name = "";
            if (isset($column[1])) {
                $Name = mysqli_real_escape_string($conn, $column[1]);
            }
			
            $MobileNo = "";
            if (isset($column[2])) {
                $MobileNo = mysqli_real_escape_string($conn, $column[2]);
            }
            $Email = "";
            if (isset($column[3])) {
                $Email = mysqli_real_escape_string($conn, $column[3]);
            }
            $School = "";
            if (isset($column[4])) {
                $School = mysqli_real_escape_string($conn, $column[4]);
            }
            $Qualification = "";
            if (isset($column[5])) {
                $Qualification = mysqli_real_escape_string($conn, $column[5]);
            }
            $Year = "";
            if (isset($column[6])) {
                $Year = mysqli_real_escape_string($conn, $column[6]);
            }
			$Program = "";
            if (isset($column[7])) {
                $Program = mysqli_real_escape_string($conn, $column[7]);
            }
			$RegisterNo = "";
            if (isset($column[8])) {
                $RegisterNo = mysqli_real_escape_string($conn, $column[8]);
            }
			$Engagement = "";
            if (isset($column[9])) {
                $Engagement = mysqli_real_escape_string($conn, $column[9]);
            }
		

           $mySqlStr = "insert into tblstudent_wf (Counsellors,Name,MobileNo,Email,School,Qualification,Year,Course,RegisterNo,Engagement, Uniqid) values('$Counsellors','$Name','$MobileNo','$Email','$School','$Qualification','$Year','$Program','$RegisterNo','$Engagement' ,'$uid')";	
			
			$insert = mysqli_query($conn, $mySqlStr);
            
            if (! empty($insert)) {
                $type = "success";
                $message = "Please check confirm to proceed. ";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
			
         }
				$rowExcel++;
		 }
    }
}

extract($_POST);
	if(isset($btnSave))
	{
		$uid = $_SESSION['uid'];
		
		$SqlStr = "
		INSERT INTO tblstudent (Counsellors,Name,MobileNo,Email,School,Qualification,Year,Course,RegisterNo,Engagement)
		SELECT Counsellors,Name,MobileNo,Email,School,Qualification,Year,Course,RegisterNo,Engagement FROM tblstudent_wf where Uniqid = '$uid'";
		
		$insert_confirm = mysqli_query($conn, $SqlStr);	
		
		$SqlStr02 = "
		delete FROM tblstudent_wf where Uniqid = '$uid'";
		
		$delete_confirm = mysqli_query($conn, $SqlStr02);	
		
			$err="";
				if($insert_confirm==1){
					$err1="[insert successfully] The record(s) have been added.";
					
					echo '<script type="text/javascript">alert("'.$err1.'"); window.location.href="index.php?page=add_student_import";</script>';
					
				}
				else{
					$err="<font color='red'>[failed] Insert record failed !</font>";
				}
				
				if($delete_confirm<>1){
					$err="<font color='red'>[failed] Delete command failed !</font>";
				}
				
				$_SESSION['uid'] ='';
	}

?>

<style>


.outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
}

.input-row {
    margin-top: 0px;
    margin-bottom: 20px;
}

.btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
}

.outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
}

.outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

.outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display: none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
<script type="text/javascript">
jQuery(function ($) {
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
});
</script>
<h1 class="page-header">Import Student</h1>

	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<form method="post" action="func/excel_Export.php">
			<input type="submit" value=" Template" name="excelGenerate"  class="btnExport" style="width: 10%;  min-width: 25%; margin-bottom:1%"/>
	</form>
		
	<div id="response"
        class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
        <?php if(!empty($message)) { echo $message; } ?>
        </div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">

                    <button type="submit" id="submit" name="import"
                        class="btn-submit" style="margin-top: 2%;">Import & view</button>
                    <br />

                </div>

            </form>

        </div>
	
		
		 
		 <?php
            
			$sql = "SELECT * FROM tblstudent_wf where Uniqid = '".$uid. "'";
			//echo $sql;
			
			$retval = mysqli_query($conn, $sql);
			//$result = $conn->query($sql);
		 
			if(! $retval )
			{
				die('Could not get data : ' . mysqli_error());
			}
		 
           
         ?>
            <table id='userTable'>
            <thead>
                <tr>
					<th>No.</th>
                    <th>Creation Date</th>
					<th>Counsellors</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>Email</th>
					<th>School</th>
					<th>Qualification</th>
					<th>Year</th>
					<th>Course</th>
					<th>register No</th>
					<th>Engagement</th>	
                </tr>
            </thead>
		<?php
                $inc=1;
				
				 while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
				 {
				 
        ?>
                    
                <tbody>
                <tr>
				    <td data-label='No.'><?php  echo $inc; ?></td>
                    <td data-label='Creation Date'><?php  echo $row['CreationDate']; ?></td>
					<td data-label='Counsellors'><?php  echo $row['Counsellors']; ?></td>
                    <td data-label='Name'><?php  echo $row['Name']; ?></td>
                    <td data-label='Mobile No'><?php  echo $row['MobileNo']; ?></td>
					<td data-label='Email'><?php  echo $row['Email']; ?></td>
                    <td data-label='School'><?php  echo $row['School']; ?></td>
					<td data-label='Qualification'><?php  echo $row['Qualification']; ?></td>
					<td data-label='Year'><?php  echo $row['Year']; ?></td>
					<td data-label='Program Interest'><?php  echo $row['Course']; ?></td>
					<td data-label='register No'><?php  echo $row['RegisterNo']; ?></td>
					<td data-label='Engagement'><?php  echo $row['Engagement']; ?></td>
                </tr>
                    <?php
					$inc++;
                }
                ?>
                </tbody>	
        </table>
		
		<form method="post" onkeypress="return event.keyCode != 13;">
					<div class="btnMain">
						<input type="submit" value=" Confirm " name="btnSave" <?php if ($uid == ''){ ?> disabled <?php   } ?> class="btn btn-success"/>
						<td colspan="8"><a href="index.php?page=add_student_import">Refresh</a></td>
					</div>
				</form>	
        
	
	
