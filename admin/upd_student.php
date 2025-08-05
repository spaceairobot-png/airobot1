
<?php 
$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

$readonly = ($mode == 'view') ? 'readonly' : '';

$sql = mysqli_query($conn, "select * from tblstudent where Id='" . $_GET['stuId'] . "'");
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
		
			$DateTo=str_replace('/', '-', $_POST['txtdate_DOB']);
			$DateTo = date('Y-m-d', strtotime($DateTo));
		
		$Upd ="update tblstudent set 
			Counsellors='$dropCounsellor', 
			Name='$txtName', 
			DOB='$DateTo', 
			Address = '$txtAddress',
			States = '$dropStates',
			MobileNo='$txtContactNo', 
			Email='$txtEmail',
			School='$dropSchool', 
			Qualification='$dropQualification', 
			Year='$txtYear',
			Course='$dropCourse',
			RegisterNo='$txtRegister',
			Engagement='$dropEngagement',
			Batch = '$dropBatch',
			Institution = '$dropInstitution' , 
			ProgramLvl = '$dropProgLevel' ,
			LastUpdDt = now() ,
			EmergencyContactName = '$txtEmergencyName' , 
			EmergencyContactNumber = '$txtEmergencyContactNo'
		where Id='" . $_GET['stuId'] . "' ";
		
		$retval = mysqli_query($conn, $Upd);
		//echo $Upd;
		 if(! $retval )
			{
				$err = "<font color='red'>[failed] Update record ".$txtName ." fail ! </font>";
			}
		 else 
			{
				$err = "[updated successfully] The details of ".$txtName ." have been updated.";
				echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=upd_student&stuId='. $_GET['stuId'].'";</script>';
			}
		}
	
	}
	
?>

<script>
function getInstitution(Code)
{
    var html = $.ajax({
        type: "POST",
        url:"func/CheckInstitution.php",
        data: "ProlvlCode=" +Code,
        async: false
    }).responseText;
    if(html){
        $("#dropInstitution").html(html);
    }
}
</script>

<h1 class="page-header">
    <?php echo ($mode == 'view') ? 'View Student' : 'Update Student'; ?>
</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Counsellor</div>
		<div class="col-sm-5">
		<select name="dropCounsellor" class="form-control" <?php echo $readonly; ?>>
			<option value="">Select Counsellor</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcounsellor where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
				if($r['Counsellors'] == $r1['Code']){
				  echo "<option value='".$r1['Code']."' selected>".$r1['Code']." :  ".$r1['Des']."</option>";
                }else{
                  echo "<option value='".$r1['Code']."' >".$r1['Code']." :  ".$r1['Des']."</option>";
                }
					
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Name</div>
		<div class="col-sm-5">
		<input type="text" name="txtName"  value="<?php echo $r["Name"]; ?>" class="form-control" required <?php echo $readonly; ?>/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">IC No.</div>
		<div class="col-sm-5">
		<input type="text" name="txtRegister" value="<?php echo $r["RegisterNo"]; ?>" onkeydown="javascript: return event.keyCode == 69 ? false : true" class="no-spin form-control" <?php echo $readonly; ?>/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Date Of Birth</div>
		<div class="col-sm-5"> 
		<input type="text" class="datepicker form-control " id="dtPick2" name="txtdate_DOB" value="<?php if(! isset($r["DOB"])) {echo date('d/m/Y', strtotime(date("Y/m/d")));} else{ echo date('d/m/Y', strtotime($r["DOB"])); } ?>"  style="width:50%; margin-right:1%; display:inline;"autocomplete="off" <?php echo $readonly; ?>><span class="glyphicon glyphicon-calendar" ></span></div> 
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Contact No.</div>
		<div class="col-sm-5">
			
			<input type="number" name="txtContactNo" value="<?php echo $r["MobileNo"]; ?>" oninput="validity.valid||(value='');" class="no-spin form-control" <?php echo $readonly; ?>/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Address</div>
		<div class="col-sm-5">
			<textarea name="txtAddress" class="form-control" <?php echo $readonly; ?>><?php echo $r["Address"]; ?></textarea></div>    
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">State</div>
		<div class="col-sm-5">
		<select name="dropStates" class="form-control" <?php echo $readonly; ?>>
			<option value="">Select State</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgstate where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($r['States'] == $r1['Code']){
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
		<div class="col-sm-4">Email</div>
		<div class="col-sm-5">
		<input type="email" name="txtEmail" value="<?php echo $r["Email"]; ?>"  class="form-control" <?php echo $readonly; ?>/></div>       
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">School</div>
		<div class="col-sm-5">
		<select name="dropSchool" class="form-control" <?php echo $readonly; ?>>
			<option value="">Select School</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgschool where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($r['School'] == $r1['Code']){
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
		<div class="col-sm-4">Qualification</div>
		<div class="col-sm-5">
		<select name="dropQualification" class="form-control" <?php echo $readonly; ?>>
			<option value="">Select Qualification</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgqualification where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($r['Qualification'] == $r1['Code']){
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
		<div class="col-sm-4">Year</div>
		<div class="col-sm-5">
			<input type="number" name="txtYear" value="<?php echo $r["Year"]; ?>" oninput="validity.valid||(value='');" class="form-control"  style="width:40%;   display: inline-flex;" <?php echo $readonly; ?>/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Batch</div>
		<div class="col-sm-5">
		<select name="dropBatch" class="form-control" <?php echo $readonly; ?>>
			<option value="">Select Batch</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgbatch where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($r1['Code'] == $r['Batch'] ){
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
		<div class="col-sm-4">Program Level</div>
		<div class="col-sm-5" style="display: inline-block;">
		<select name="dropProgLevel" onchange="getInstitution(this.value)" class="form-control" style="width:45%; display:inline-block;" <?php echo $readonly; ?>>
			<option value="">Select Porgram Level</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgproglevel where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					 if($r1['Code'] == $r['ProgramLvl'] ){
					  echo "<option value='".$r1['Code']."' selected>".$r1['Des']."</option>";
					}else{
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
					}
				}
			?>
		</select>
		
		<select name="dropInstitution" id ="dropInstitution" class="form-control" style="width:53%; display:inline-block;" <?php echo $readonly; ?>>
				<?php 
				$q1=mysqli_query($conn,"select * from cfginstitution where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					  if($r1['Code'] == $r['Institution'] ){
					  echo "<option value='".$r1['Code']."' selected>".$r1['Des']."</option>";
					}
					  
				}
				?>
		</select>
		
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Course</div>
		<div class="col-sm-5">
		<select name="dropCourse" class="form-control" <?php echo $readonly; ?>>
			<option value="">Select Course</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcourse where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					  if($r1['Code'] == $r['Course'] ){
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
		<div class="col-sm-4">Engagement</div>
		<div class="col-sm-5">
		<select name="dropEngagement" class="form-control" <?php echo $readonly; ?>>
			<option value="">Select Engagement</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgengagement where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($r['Engagement'] == $r1['Code']){
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
		<div class="col-sm-4">Emergency Contact Name</div>
		<div class="col-sm-5">
		
		<input name="txtEmergencyName" type="text" id="txtEmergencyName" value="<?php echo $r["EmergencyContactName"]; ?>" class="form-control" <?php echo $readonly; ?>/></div>     
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Emergency Contact Number</div>
		<div class="col-sm-5">
		
		<input name="txtEmergencyContactNumber" type="text" id="txtEmergencyContactNumber" value="<?php echo $r["EmergencyContactNumber"]; ?>" class="form-control" <?php echo $readonly; ?>/></div>     
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">

		<?php if ($mode != 'view') { ?>
			<div class="btnMain">
			<input type="submit" value="Save" name="btnSave" class="btn btn-success"/>
			<input type="reset" class="btn btn-success"/>
			</div>
		<?php } ?>
		</div>
	</div>
</form>	

