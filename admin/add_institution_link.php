<?php 

extract($_POST);
	if(isset($btnSave))
	{

		if($txtName=="" || $txtCode=="" )
		{
			$err="<font color='red'>Fill all the fileds first</font>";	
		}
		else
		{
			$txtCode = mysqli_real_escape_string ($conn, $txtCode);
			$txtName = mysqli_real_escape_string ($conn, $txtName);
			$mySqlStr = "select * from cfginstitution where code = '$txtCode'";
				
			$chk=mysqli_query($conn,$mySqlStr);
			$r=mysqli_num_rows($chk);
			//echo $mySqlStr;
			// if($r!=true)
			if($r == 0)
			{
				
				$add = "insert into cfginstitution (Code, Des , country) values('$txtCode','$txtName','$dropCountry')";
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					
					foreach ($_POST['check'] as $Cid => $value) 
					{
					$add02 = "insert into tblinstprog (InstituitionID, ProgramLevelID ) values('$txtCode','$Cid')";
					mysqli_query($conn,$add02);
					}
				
					$err="[insert successfully] The record of ".$txtName ." have been added.";
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_institution_link";</script>';
				}
			}
			else
				{
					$err="<font color='red'>[failed] data ".$txtName ." is Existed </font>";
				}
				
		}
	
	}
	
?>

<head>
<style>
.myinput.large{
    height:20px;
    width: 20px;
	margin-right:1%;
}

</style>
</head>

<h1 class="page-header">Add New Institution</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Code</div>
		<div class="col-sm-5">
		<input type="text" name="txtCode" maxlength="25" class="form-control" required/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Description</div>
		<div class="col-sm-5">
		<input type="text" name="txtName"  class="form-control" required/></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Country</div>
		<div class="col-sm-5">
		<select name="dropCountry" class="form-control" >
			<option value="">Select Country</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcountry where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Level</div>
		<div class="col-sm-5">
		
		<?php
		
			$sql = "SELECT * FROM cfgproglevel A WHERE isActive ='A' order by Des asc";
			
			$retval = mysqli_query($conn,$sql);
		
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)){
		?>
			<input type="checkbox" name="check[<?= $row['Code']; ?>]" class="myinput large"> <?php echo $row["Des"]; ?><br>
		<?php
			}
		?>
		</div>
	</div>
	
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		
		<div class="btnMain">
		<input type="submit" value="Add" name="btnSave" class="btn btn-success"/>
		<input type="reset" class="btn btn-success"/>
		</div>
		</div>
	</div>
</form>	

