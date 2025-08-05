<?php 

if($UserRole != 'Adm' )
{
 echo "<script>window.location.replace('index.php');</script>";
}


extract($_POST);
if(isset($btnSave))
{

	if($txtName=="" || $txtPass=="" )
	{
	$err="<font color='red'>[failed] fill all the fileds first</font>";	
	}
	else
	{

		$txtPassA = hash('sha512', $txtPass);
		
			$add = "insert into tbllogin (UserName, Email , Password , Counsellor ) values('$txtName', '$txtEmail' , '$txtPassA' , '$dropCounsellor')";
		if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[insert successfully] The record of ".$txtName ." have been added.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=add_loginuser";</script>';
				}
		
		else{
			$err="<font color='red'>[failed] data ".$txtName ." is not added </font>";
			}
	 }
}

?>

<h1 class="page-header">Add Login User</h1>
<form method="post">
	
	<div class="row" style="margin-top:10px">
		
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Name</div>
		<div class="col-sm-5">
		<input type="text" name="txtName"  class="form-control" required/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Counsellor</div>
		<div class="col-sm-5">
		<select name="dropCounsellor" class="form-control" >
			<option value="">Select Counsellor</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcounsellor where isActive ='A'");
				while($r1=mysqli_fetch_assoc($q1))
				{
					echo "<option value='".$r1['Code']."'>".$r1['Code']." :  ".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Enter Current Password</div>
		<div class="col-sm-5">
		<input type="password" name="txtPass" class="form-control" required="required"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Email</div>
		<div class="col-sm-5">
		<input type="email" name="txtEmail" class="form-control" required="required"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		<div class="btnMain">
		<input type="submit" value="Save" name="btnSave" class="btn btn-success"/>
		<input type="reset" class="btn btn-success"/>
		</div>
		</div>
	</div>
</form>	