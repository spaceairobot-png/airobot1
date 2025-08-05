
<?php 

	$sql = mysqli_query($conn, "select * from cfginstitution A where A.Id='" . $_GET['PCode'] . "'");
	$r = mysqli_fetch_array($sql);
	
extract($_POST);
	if(isset($btnSave))
	{

		if($txtName=="" || $txtCode=="" )
		{
			$err="<font color='red'>Fill all the fileds first</font>";	
		}
		else
		{		
				//echo $r['Code'];
				$InsCode = mysqli_real_escape_string ($conn, $r['Code']);
				$txtName = mysqli_real_escape_string ($conn, $txtName);
				
				$add = "update cfginstitution set Des = '$txtName' , country ='$dropCountry' , LastUpdDt = now() where Code='" . $InsCode . "'";
				mysqli_query($conn,$add);
				
				$add01 = "delete from tblinstprog where InstituitionID ='$InsCode'";
				$del = mysqli_query($conn,$add01);
				if($del==1)
				{
					foreach ($_POST['check'] as $Cid => $value) 
					{
						$add02 = "insert into tblinstprog (InstituitionID, ProgramLevelID  ) values('$InsCode','$Cid')";
						mysqli_query($conn,$add02);
					}	
					//echo $add02;
					$err="[insert successfully] The record of ".$txtName ." have been added.";
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_institution_link";</script>';
				}
				else
				{
					$err="<font color='red'>[failed] data ".$txtName ." is not added </font>";
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

<h1 class="page-header">Update Institution</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Code</div>
		<div class="col-sm-5">
		<input type="text" name="txtCode" value="<?php echo $r["Code"]; ?>" class="form-control" readonly/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Description</div>
		<div class="col-sm-5">
		<input type="text" name="txtName" value="<?php echo $r["Des"]; ?>"  class="form-control" required/></div>
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
					  if($r1['Code'] == $r['Country'] ){
					  echo "<option value='".$r1['Code']."' selected>".$r1['Des']."</option>";
					}else{
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
					}
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Level</div>
		<div class="col-sm-5">
		
		<?php
		$Code = mysqli_real_escape_string ($conn, $r['Code']);
		$result = mysqli_query($conn, "select ProgramLevelID from tblinstprog A where A.InstituitionID='" . $Code  . "' order by A.ProgramLevelID asc");
		
		$SelLevel= array(); 

		while($row = $result->fetch_assoc())
		{
			$SelLevel[] = $row['ProgramLevelID']; // store in an array
		}
		?>
		
		
		<?php
			$sql = "SELECT * FROM cfgproglevel A WHERE isActive ='A' order by Des asc";
			
			$retval = mysqli_query($conn,$sql);
	
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
		?>
		
		<input type="checkbox" name="check[<?= $row['Code']; ?>]" <?=(in_array($row['Code'],$SelLevel) ? 'checked="checked"' : '') ?> 
			class="myinput large"> <?php echo $row["Des"]; ?><br>
		<?php
			}
		?>
		
		</div>
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
			
			<input type="hidden" name="txtActive" id="txtActive" style="display:hidden" value="<?php if($r['isActive'] == 'A') echo "A"; else echo "I";?>"/>
			
		</div>
	</div>
	-->
	
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

<script>
jQuery(function($) {
$('#chkIsActive').click(function () {
    if ($('#chkIsActive').is(':checked')) {
        $('#txtStatus').val('Active');
		$('#txtActive').val('A');
    }
    else{
        $('#txtStatus').val('Deactive');
		$('#txtActive').val('I');
    }
});
});
</script>
