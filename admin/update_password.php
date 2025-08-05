<?php 



extract($_POST);
if(isset($btnSave))
{

	if($txtOldPass=="" || $txtNewPass=="" || $txtConfPass=="")
	{
	$err="<font color='red'>[failed] fill all the fileds first</font>";	
	}
	else
	{

		$txtOldPass2 = hash('sha512', $txtOldPass);
		
		$chk=mysqli_query($conn,"select * from tbllogin where Username='$Username' and ( Password='$txtOldPass2' or ResetToken = '$txtOldPass')");
		
		$r=mysqli_num_rows($chk);
		
		if($r==true){
			if($txtNewPass==$txtConfPass )
			{
			$txtConfPass2 = hash('sha512', $txtConfPass);
			$sql=mysqli_query($conn,"update tbllogin set password='$txtConfPass2' where Username='$Username'");
			
			$err1 = "[updated successfully] The password of ".$Username." have been updated.";
			echo '<script type="text/javascript">alert("'.$err1.'"); </script>';
			
			//$err="<font color='blue'>Password updated </font>";
			}
			else
			{
			$err="<font color='red'>[failed] New password not matched with confirm password !</font>";
			}
		}
		else{
			$err="<font color='red'>[failed] Incorrect current password !</font>";
			}
	 }
}

?>

<h1 class="page-header">Update Password</h1>
<form method="post">
	
	<div class="row" style="margin-top:10px">
		
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Enter Current Password</div>
		<div class="col-sm-5">
		<input type="password" name="txtOldPass" class="form-control" required="required"/></div>
	</div>
	
	<div class="row" style="margin-top:10px"> 
		<div class="col-sm-4">Enter New Password</div>
		<div class="col-sm-5">
		<input type="password" name="txtNewPass" class="form-control" required="required"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Enter Confirm Password</div>
		<div class="col-sm-5">
		<input type="password" name="txtConfPass" class="form-control" required="required"/></div>
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