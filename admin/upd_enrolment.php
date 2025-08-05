
<?php 

$sql = mysqli_query($conn, "select A.* , B.Des from tblstudent A left join cfgcounsellor B on A.Counsellors = B.code where A.Id='" . $_GET['stuId'] . "' LIMIT 1");
	$r = mysqli_fetch_array($sql);
	
	extract($_POST);
	if(isset($btnSave))
	{
		
		if( $txtdate_intake==""  )
		{
			$err="<font color='red'>Fill all the fileds first</font>";	
		}
		else
		{
	
				$dropProg1 = $_POST['dropProgLevel']; // Dropdown Name

				list($dropProgID, $dropProgDes) = explode('|', $dropProg1);
				$dropProgID = mysqli_real_escape_string($conn, $dropProgID); // ProgramId
				$dropProgDes = mysqli_real_escape_string($conn, $dropProgDes); // Description
				$txtRem = mysqli_real_escape_string ($conn, $txtRemark);
			
				$DateTo=str_replace('/', '-', $_POST['txtdate_intake']);
				$DateTo = date('Y-m-d', strtotime($DateTo));
			
				$Upd = "update tblstudent set 
				Intake = '$DateTo',
				ProgramId = '$dropProgID',
				ProgramLvl = '$dropProgDes',
				Country = '$dropCountry',
				Remark = '$txtRem',
				LastUpdDt = now()
				where Id='" . $_GET['stuId'] . "' ";
				
				//echo $Upd;
				$retval = mysqli_query($conn, $Upd);
		
				 if(! $retval )
					{
						$err = "<font color='red'>[failed] Update record ".$r["Name"] ." fail ! </font>";
					}
				 else 
					{
						$err = "[updated successfully] The details of ".$r["Name"] ." have been updated.";
						echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=upd_enrolment&stuId='. $_GET['stuId'].'";</script>';
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

<h1 class="page-header">Update Enrolment</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Student</div>
		<div class="col-sm-5">
			<input type="text" class="form-control" name="txtName" value="<?php echo $r["Name"]; ?>"  title="Name display only"  readonly /> 
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Mobile No.</div>
		<div class="col-sm-5">
		<input type="text" class="form-control"  value="<?php echo $r["MobileNo"]; ?>"  name="txtMobileNo" readonly /> 
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Counsellors</div>
		<div class="col-sm-5">
		<input type="text" class="form-control"  value="<?php echo $r["Des"]; ?>" name="txtCounsellor" readonly /> 
		</div>
	</div>
	
	<div class="row" style="margin-top:20px">
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Intake</div>
		<div class="col-sm-5"> 
		<input type="text" class="datepicker form-control " id="dtPick2" name="txtdate_intake" value="<?php if(! isset($r["Intake"])) {echo date('d/m/Y', strtotime(date("Y/m/d")));} else{ echo date('d/m/Y', strtotime($r["Intake"]));  } ?>"  style="width:50%; margin-right:1%; display:inline;"  autocomplete="off" required><span class="glyphicon glyphicon-calendar" ></span></div> 
	</div>
	
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Program Level</div>
		<div class="col-sm-5" style="display: inline-block;">
		<select name="dropProgLevel" onchange="getInstitution(this.value)" class="form-control" style="width:45%; display:inline-block;" >
			<option value="">Select Program Level</option>
			<?php 
				$q1 = mysqli_query($conn, "select * from cfgproglevel where isActive ='A' order by Des asc");
				while($r1 = mysqli_fetch_assoc($q1))
				{	
				if($r1['Des'] == $r['ProgramLvl']) {
					echo "<option value='".$r1['Id']."|".$r1['Des']."' selected>".$r1['Des']."</option>";
				} else {
					echo "<option value='".$r1['Id']."|".$r1['Des']."'>".$r1['Des']."</option>";
				}
				}
			?>

		</select>
		</div>
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
		<div class="col-sm-4">Remark</div>
		<div class="col-sm-5">
		<input type="text" name="txtRemark" value="<?php echo $r["Remark"]; ?>" class="form-control" /></div>
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

