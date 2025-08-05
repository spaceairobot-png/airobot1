<?php 

$sql ="";

if ($_GET['pname'] == "Counsellor")
{
	$sql = "select * from cfgcounsellor where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "Engagement"){
	$sql = "select * from cfgengagement where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "Event"){
	$sql = "select * from cfgbatch where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "Country"){
	$sql = "select * from cfgCountry where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "Course"){
	$sql = "select * from cfgCourse where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "Qualification"){
	$sql = "select * from cfgqualification where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "Level"){
	$sql = "select * from cfgproglevel where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "State"){
	$sql = "select * from cfgstate where Id='" . $_GET['pid'] . "'";
}else if ($_GET['pname']  == "School"){
	$sql = "select * from cfgschool where Id='" . $_GET['pid'] . "'";
}

$sql = mysqli_query($conn, $sql);
$r = mysqli_fetch_array($sql);

extract($_POST);
	if(isset($btnSave))
	{
	
		if($txtName=="" )
		{
			$err="<font color='red'>Fill all the fileds first</font>";	
		}
		else
		{
			
				//$txtActive1 = $_POST['txtActive'] ;

				$add ="";
				$filterPName = $_GET['pname'];
				
				$DES = mysqli_real_escape_string ($conn,  $txtName);
				
				if ($filterPName == "Counsellor")
				{
					$add = "update cfgcounsellor set Des = '$DES'  ,  LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($filterPName == "Engagement"){
					$add = "update cfgengagement set Des = '$DES' , LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($filterPName == "Event"){
					$add = "update cfgbatch set Des = '$DES', LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($filterPName == "Country"){
					$add = "update cfgCountry set Des = '$DES' ,  LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($_GET['pname']  == "Course"){
					$add = "update cfgCourse set Des = '$DES' ,  LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($_GET['pname']  == "Qualification"){
					$add = "update cfgqualification set Des = '$DES' , LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($_GET['pname']  == "Level"){
					$add = "update cfgproglevel set Des = '$DES' , LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($_GET['pname']  == "State"){
					$add = "update cfgstate set Des = '$DES' , LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}else if ($_GET['pname']  == "School"){
					$add = "update cfgschool set Des = '$DES' ,  LastUpdDt = now() where Id='" . $_GET['pid'] . "'";
				}
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[updated successfully] The record of ".$txtName ." have been updated.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_parameter&pname='.$filterPName.'";</script>';
					
				}
				else
				{
					$err="<font color='red'>[failed] data ".$txtName ." is not update </font>";
				}
				
		}
	
	}
	
?>

<h1 class="page-header">Update <?php echo $_GET['pname']; ?></h1>
<form method="post" onkeypress="return event.keyCode != 13;" onSubmit="window.location.reload()">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Code</div>
		<div class="col-sm-5">
		<input type="text" name="txtCode"  class="form-control" value="<?php echo $r["Code"]; ?>" readonly /></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Description</div>
		<div class="col-sm-5">
		<input type="text" name="txtName"  class="form-control" value="<?php echo $r["Des"]; ?>" required /></div>
	</div>

	<!--
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Status</div>
		<div class="col-sm-5">
			<label class="switch">
				<input type="checkbox" id="chkIsActive" name="chkIsActive"  <?php if($r['isActive'] == 'A') echo "CHECKED";?>  />
				
				<span class="slider round"></span>
			</label>
			
			<input name="txtStatus" id="txtStatus" style="border:hidden;  margin-left: 5%;" type="text" value="<?php if($r['isActive'] == 'A') echo "Active"; else echo "Inactivate";?>" />
			
			<input type="hidden" name="txtActive" id="txtActive" style="display:hidden" value="<?php if($r['isActive'] == 'A') echo 'A'; else echo 'I'; ?>"/>
		</div>
	</div>
	 -->
	 
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
<!--
<script>
jQuery(function($) {
$('#chkIsActive').click(function () {
    if ($('#chkIsActive').is(':checked')) {
        $('#txtStatus').val('Active');
		$('#txtActive').val('A');
    }
    else{
        $('#txtStatus').val('Inactivate');
		$('#txtActive').val('I');
    }
});
});
</script>
 -->