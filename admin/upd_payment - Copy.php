
<?php
	$sql = mysqli_query($conn, "select * from tblpayments A where A.Id='" . $_GET['id'] . "'");
	$r = mysqli_fetch_array($sql);
?>

<?php 


	extract($_POST);
	if(isset($btnSave))
	{

		if($dropStudent=="" )
		{
			$err="<font color='red'>Name cannot be empty !</font>";	
			
		}
		
		else
		{
			
			$DateTo=str_replace('/', '-', $_POST['txtdate_payment']);
			$DateTo = date('Y-m-d', strtotime($DateTo));
			
				$add = "update tblpayments set student_id = '$dropStudent' , amount = '$txtAmount' , payment_date = '$DateTo' , mode = '$dropPayMode' , updated_at = now() where id = " . $_GET['id'] . "";
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[insert successfully] The record of ".$dropStudent ." have been updated.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_payment";</script>';
				}
				else
				{
					$err="<font color='red'>[failed] data ".$dropStudent ." is not updated </font>";
				}
				
		}
	
	}
	
?>



<style>
.myinput.large{
    height:20px;
    width: 20px;
	margin-right:1%;
}

</style>

<h1 class="page-header">Update Payment</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Student</div>
		<div class="col-sm-5">
		<select name="dropStudent" class="form-control" >
			<option value="">Select Student</option>
			<?php 
                $q1=mysqli_query($conn,"select * from tblstudent where isActive ='A' order by Id asc");
				while($r1=mysqli_fetch_assoc($q1))
				{	
					if($r1['Id'] == $r['student_id'] ){
					  echo "<option value='".$r1['Id']."' selected>".$r1['Name']."</option>";
					}else{
					  echo "<option value='".$r1['Id']."' >".$r1['Name']."</option>";
					}
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Amount</div>
		<div class="col-sm-5">
		<input name="txtAmount" type="number" id="txtAmount" value="<?php echo $r["amount"]; ?>"  class="demoInputBox form-control" min="0" required/></div>
		
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Payment date</div>
		<div class="col-sm-5">
		<input type="text" class="datepicker form-control " id="dtPick2" name="txtdate_payment" value="<?php echo $r["created_at"]; ?>" style="width:50%; margin-right:1%; display:inline;" autocomplete="off"><span class="glyphicon glyphicon-calendar" ></span></div> 
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Payment Mode</div>
		<div class="col-sm-5">
		<select name="dropPayMode" class="form-control">
			<option value="">Select Mode</option>
			<option value="Cash" <?= isset($r['mode']) && $r['mode'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
			<option value="Bank" <?= isset($r['mode']) && $r['mode'] == 'Bank' ? 'selected' : '' ?>>Bank Transfer</option>
			<option value="Ewallet" <?= isset($r['mode']) && $r['mode'] == 'Ewallet' ? 'selected' : '' ?>>Ewallet</option>
		</select>
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

