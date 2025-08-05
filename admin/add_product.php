
<?php

?>

<?php 


	extract($_POST);
	if(isset($btnSave))
	{

		if($txtProductName=="" )
		{
			$err="<font color='red'>Product_name cannot be empty !</font>";	
			
		}
		
		else
		{
			
			
				$add = "insert into tblproduct (product_name , list_price , selling_price , quantity, status) values('$txtProductName', '$txtListPrice', '$txtSellPrice', '$txtQuantity' , '$dropStatus')";
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[insert successfully] The record of ".$dropStudent ." have been added.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_product";</script>';
				}
				else
				{
					$err="<font color='red'>[failed] data ".$dropStudent ." is not added </font>";
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

<h1 class="page-header">Add New Payment</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
     <div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Product Name</div>
		<div class="col-sm-5">
		<input type="text" name="txtProductName"  class="form-control" required/></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">List Price</div>
		<div class="col-sm-5">
		<input name="txtListPrice" type="number" id="txtListPrice" class="demoInputBox form-control" min="0" /></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Selling Price</div>
		<div class="col-sm-5">
		<input name="txtSellPrice" type="number" id="txtSellPrice" class="demoInputBox form-control" min="0" /></div>	
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Quantity</div>
		<div class="col-sm-5">
		<input name="txtQuantity" type="number" id="txtQuantity" class="demoInputBox form-control" min="0" /></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Status</div>
		<div class="col-sm-5">
		<select name="dropStatus" class="form-control">
			<option value="">Select Status</option>
			<option value="A" >Available</option>
			<option value="I" >Unavailable</option>
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

