
<?php

?>

<?php 


	extract($_POST);
	if(isset($btnSave))
	{

		if($txtCategory=="" || $txtdate_payment =="" || $txtAmount == 0)
		{
			$err="<font color='red'>Required field cannot be empty !</font>";	
			
		}
		
		else
		{
			
			$DateTo=str_replace('/', '-', $_POST['txtdate_payment']);
			$DateTo = date('Y-m-d', strtotime($DateTo));
			
				$add = "insert into tblexpense ( expense_date , category , description , amount , payment_method , reference_no  ) values( '$DateTo' , '$txtCategory' , '$txtDesc' , '$txtAmount', '$dropPayMode' , '$txtRefno')";
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[insert successfully] The record of ".$txtCategory ." have been added.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_expense";</script>';
				}
				else
				{
					$err="<font color='red'>[failed] data ".$txtCategory ." is not added </font>";
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

<h1 class="page-header">Add New Expense</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Category</div>
		<div class="col-sm-5">
		<input name="txtCategory" type="text" id="txtCategory" class="demoInputBox form-control" required/></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Description</div>
		<div class="col-sm-5">
		<input name="txtDesc" type="text" id="txtDesc" class="demoInputBox form-control" /></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Expense Date </div>
		<div class="col-sm-5">
		<input type="text" class="datepicker form-control " id="dtPick2" name="txtdate_payment" style="width:50%; margin-right:1%; display:inline;" autocomplete="off"><span class="glyphicon glyphicon-calendar" required></span></div> 
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Amount</div>
		<div class="col-sm-5">
		<input name="txtAmount" type="number" id="txtAmount" class="demoInputBox form-control" min="0" required/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Reference no</div>
		<div class="col-sm-5">
		<input name="txtRefno" type="text" id="txtRefno" class="demoInputBox form-control" /></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Payment Mode</div>
		<div class="col-sm-5">
		<select name="dropPayMode" class="form-control">
			<option value="">Select Mode</option>
			<option value="Cash" <?= isset($row['dropPayMode']) && $row['dropPayMode'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
			<option value="Bank" <?= isset($row['dropPayMode']) && $row['dropPayMode'] == 'Bank' ? 'selected' : '' ?>>Bank Transfer</option>
			<option value="Ewallet" <?= isset($row['dropPayMode']) && $row['dropPayMode'] == 'Ewallet' ? 'selected' : '' ?>>Ewallet</option>
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

