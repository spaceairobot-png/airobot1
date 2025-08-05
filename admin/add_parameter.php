
<?php 

$Type1 = $_GET['pname'];
				
				if ($Type1 == "Counsellor")
				{
					$mylength = "20";
				}else if ($Type1 == "Engagement"){
					$mylength = "5";
				}else if ($Type1 == "Event"){
					$mylength = "20";
				}else if ($Type1 == "Country"){
					$mylength = "5";
				}else if ($Type1 == "Course"){
					$mylength = "25";
				}else if ($Type1 == "Qualification"){
					$mylength = "20";
				}else if ($Type1 == "Level"){
					$mylength = "20";
				}else if ($Type1 == "State"){
					$mylength = "5";
				}else if ($Type1 == "School"){
					$mylength = "50";
				}
			


extract($_POST);
	if(isset($btnSave))
	{

		if($txtName=="" || $txtCode=="" )
		{
			$err="<font color='red'>Fill all the fileds first</font>";	
		}
		else
		{	
			$mySqlStr= "";
			$filterPName = $_GET['pname'];
			$txtCode = mysqli_real_escape_string ($conn, $txtCode);
			
				if ($filterPName == "Counsellor")
				{
					$mySqlStr = "select * from cfgcounsellor where code = '$txtCode'";
				}else if ($filterPName == "Engagement"){
					$mySqlStr = "select * from cfgengagement where code = '$txtCode'";
				}else if ($filterPName == "Event"){
					$mySqlStr = "select * from cfgbatch where code = '$txtCode'";
				}else if ($filterPName == "Country"){
					$mySqlStr = "select * from cfgcountry where code = '$txtCode'";
				}else if ($filterPName == "Course"){
					$mySqlStr = "select * from cfgcourse where code = '$txtCode'";
				}else if ($filterPName == "Qualification"){
					$mySqlStr = "select * from cfgqualification where code = '$txtCode'";
				}else if ($filterPName == "Level"){
					$mySqlStr = "select * from cfgproglevel where code = '$txtCode'";
				}else if ($filterPName == "State"){
					$mySqlStr = "select * from cfgstate where code = '$txtCode'";
				}else if ($filterPName == "School"){
					$mySqlStr = "select * from cfgschool where code = '$txtCode'";
				}
			
			$chk=mysqli_query($conn,$mySqlStr);
			$r=mysqli_num_rows($chk);
			
			// if($r!=true)
			if($r == 0)
			{
				$add = "";
				
				$txtCode = mysqli_real_escape_string ($conn, $_POST['txtCode']);
				$txtName = mysqli_real_escape_string ($conn, $txtName);
				
				if ($filterPName == "Counsellor")
				{
					$add = "insert into cfgcounsellor (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "Engagement"){
					$add = "insert into cfgengagement (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "Event"){
					$add = "insert into cfgbatch (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "Country"){
					$add = "insert into cfgcountry (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "Course"){
					$add = "insert into cfgcourse (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "Qualification"){
					$add = "insert into cfgqualification (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "Level"){
					$add = "insert into cfgproglevel (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "State"){
					$add = "insert into cfgstate (Code, Des ) values('$txtCode','$txtName')";
				}else if ($filterPName == "School"){
					$add = "insert into cfgschool (Code, Des ) values('$txtCode','$txtName')";
				}
				
				$sqladd = mysqli_query($conn, $add);
				  
				if($sqladd==1)
				{
					$err="[insert successfully] The record of ".$txtName ." have been added.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_parameter&pname='.$filterPName.'";</script>';	
				}
				else
				{
					$err="<font color='red'>[failed] data ".$txtName ." is not added </font>";
				}
				
			}
			else
			{
					$err="<font color='red'>[failed] data ".$txtName ." is Existed</font>";
			}
	
	}
	}
	
?>


<h1 class="page-header">Add New <?php echo $_GET['pname']; ?></h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Code</div>
		<div class="col-sm-5">
		<input type="text" name="txtCode" maxlength="<?php echo $mylength; ?>" class="form-control"  required/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Description</div>
		<div class="col-sm-5">
		<input type="text" name="txtName"  class="form-control" required/></div>
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

