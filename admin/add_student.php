
<?php

?>

<?php 

function  createConfirmationmbox(){
    echo '<script type="text/javascript"> ';
    echo ' function openulr(newurl) {';
    echo '  if (confirm("Are you sure you want to open new URL")) {';
    echo '    document.location = newurl;';
    echo '  }';
    echo '}';
    echo '</script>';
}

	extract($_POST);
	if(isset($btnSave))
	{

		if($txtName=="" )
		{
			$err="<font color='red'>Name cannot be empty !</font>";	
			
		}
		else  if (!isset($_POST['chkDisclaimer']))  
		{
			$err="<font color='red'>Please indicate that you accept the term and condition !</font>";	
			
		}
		else
		{
			
			createConfirmationmbox();
			$DateTo=str_replace('/', '-', $_POST['txtdate_DOB']);
			$DateTo = date('Y-m-d', strtotime($DateTo));
			
				$add = "insert into tblstudent (Counsellors, Name, DOB , Address, States, MobileNo,Email,School,Qualification,Year, Course, RegisterNo, Engagement , Batch , Institution , ProgramLvl, EmergencyContactName, EmergencyContactNumber ) 
				values('$dropCounsellor','$txtName', '$DateTo' , '$txtAddress' , '$dropStates' ,'$txtContactNo','$txtEmail', '$dropSchool', '$dropQualification', '$txtYear', '$dropCourse', '$txtRegister' , '$dropEngagement' , '$dropBatch', '$dropInstitution' , '$dropProgLevel' , '$txtEmergencyName' , '$txtEmergencyContactNo' )";
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[insert successfully] The record of ".$txtName ." have been added.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=add_student";</script>';
				}
				else
				{
					$err="<font color='red'>[failed] data ".$txtName ." is not added </font>";
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


<script>
function checkAvailability() {

jQuery.ajax({
url: "func/check_availability.php",
data:'txtName='+$("#txtName").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);

},
error:function (){}
});
}

</script>

<style>
.myinput.large{
    height:20px;
    width: 20px;
	margin-right:1%;
}

</style>

<h1 class="page-header">Add New Student</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Counsellor</div>
		<div class="col-sm-5">
		<select name="dropCounsellor" class="form-control" >
			<option value="">Select Counsellor</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcounsellor where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					echo "<option value='".$r1['Code']."'>".$r1['Code']." :  ".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Name</div>
		<div class="col-sm-5">
		<input name="txtName" type="text" id="txtName" class="demoInputBox form-control" onBlur="checkAvailability()" required/><span id="user-availability-status"></span> </div>
		
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">IC No. </div>
		<div class="col-sm-5">
		<input type="number" name="txtRegister" onkeydown="javascript: return event.keyCode == 69 ? false : true" class="no-spin form-control" /></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Date Of Birth</div>
		<div class="col-sm-5">
		<input type="text" class="datepicker form-control " id="dtPick2" name="txtdate_DOB" style="width:50%; margin-right:1%; display:inline;" autocomplete="off"><span class="glyphicon glyphicon-calendar" ></span></div> 
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Contact No.</div>
		<div class="col-sm-5">
			
			<input type="number" name="txtContactNo" oninput="validity.valid||(value='');" class="no-spin form-control" /></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Address</div>
		<div class="col-sm-5">
			<textarea name="txtAddress" class="form-control" ></textarea></div>    
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">State</div>
		<div class="col-sm-5">
		<select name="dropStates" class="form-control" >
			<option value="">Select State</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgstate where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					echo "<option value='".$r1['Code']."'>".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Email</div>
		<div class="col-sm-5">
		<input type="email" name="txtEmail" class="form-control"/></div>       
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">School</div>
		<div class="col-sm-5">
		<select name="dropSchool" class="form-control" >
			<option value="">Select School</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgschool where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					echo "<option value='".$r1['Code']."'>".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Qualification</div>
		<div class="col-sm-5">
		<select name="dropQualification" class="form-control" >
			<option value="">Select Qualification</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgqualification where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					echo "<option value='".$r1['Code']."'>".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Year</div>
		<div class="col-sm-5">
			<input type="number" name="txtYear" oninput="validity.valid||(value='');" class="form-control"  style="width:40%;   display: inline-flex;"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Batch</div>
		<div class="col-sm-5">
		<select name="dropBatch" class="form-control" >
			<option value="">Select Batch</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgbatch where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Program Level</div>
		<div class="col-sm-5" style="display: inline-block;">
		<select name="dropProgLevel" onchange="getInstitution(this.value)" class="form-control" style="width:45%; display:inline-block;" >
			<option value="">Select Porgram Level</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgproglevel where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
				}
			?>
		</select>
		
		<select name="dropInstitution" id ="dropInstitution" class="form-control" style="width:53%; display:inline-block;">
		</select>
		
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Course</div>
		<div class="col-sm-5">
		<select name="dropCourse" class="form-control" >
			<option value="">Select Course</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcourse where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Engagement</div>
		<div class="col-sm-5">
		<select name="dropEngagement" class="form-control" >
			<option value="">Select Engagement</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgengagement where isActive ='A' order by Des asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					echo "<option value='".$r1['Code']."'>".$r1['Des']."</option>";
				}
			?>
		</select>
		</div>
	</div>

	<hr>	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Emergency Contact Name</div>
		<div class="col-sm-5">
		<input name="txtEmergencyName" type="text" id="txtEmergencyName" class="demoInputBox form-control" /></div>
	</div>	
			
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Emergency Contact No.</div>
		<div class="col-sm-5">	
		<input type="number" name="txtEmergencyContactNo" oninput="validity.valid||(value='');" class="no-spin form-control" /></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4" style="text-align-last: right;"><input type="checkbox" id="chkDisclaimer" name="chkDisclaimer" class="myinput large" value="" required/></div>
		<div class="col-sm-5">
	<label for="label"> You allow us to pass on your information to product providers and accept our Privacy Policy.</label><br>
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

