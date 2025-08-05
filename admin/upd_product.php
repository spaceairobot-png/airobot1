
<?php
	$sql = mysqli_query($conn, "select * from tblproduct A where A.Id='" . $_GET['id'] . "'");
	$r = mysqli_fetch_array($sql);
?>

<?php 


	extract($_POST);
	if(isset($btnSave))
	{

		if($txtProductName=="" )
		{
			$err="<font color='red'>Name cannot be empty !</font>";	
			
		}
		
		else
		{
			
			$DateTo=str_replace('/', '-', $_POST['txtdate_payment']);
			$DateTo = date('Y-m-d', strtotime($DateTo));
			
				$add = "update tblproduct set product_name = '$txtProductName' , list_price = '$txtListPrice' , selling_price = '$txtSellPrice' , quantity = '$txtQuantity' , status = '$dropStatus' , updated_at = now() where id = " . $_GET['id'] . "";
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[insert successfully] The record of ".$txtProductName ." have been updated.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_product";</script>';
				}
				else
				{
					$err="<font color='red'>[failed] data ".$txtProductName ." is not updated </font>";
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
		<div class="col-sm-4">* Product Name</div>
		<div class="col-sm-5">
		<input type="text" name="txtProductName"  value="<?php echo $r["product_name"]; ?>"  class="form-control" required/></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">List Price</div>
		<div class="col-sm-5">
		<input name="txtListPrice" type="number" value="<?php echo $r["list_price"]; ?>"  id="txtListPrice" class="demoInputBox form-control" min="0" /></div>
	</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Selling Price</div>
		<div class="col-sm-5">
		<input name="txtSellPrice" type="number" value="<?php echo $r["selling_price"]; ?>"  id="txtSellPrice" class="demoInputBox form-control" min="0" /></div>	
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Quantity</div>
		<div class="col-sm-5">
		<input name="txtQuantity" type="number" value="<?php echo $r["quantity"]; ?>"  id="txtQuantity" class="demoInputBox form-control" min="0" /></div>
	</div>
	


	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Status</div>
		<div class="col-sm-5">
		<select name="dropStatus" class="form-control">
			<option value=""  <?= isset($r['status']) && $r['status'] == '' ? 'selected' : '' ?>>Select Status</option>
			<option value="A" <?= isset($r['status']) && $r['status'] == 'A' ? 'selected' : '' ?>>Available</option>
			<option value="I" <?= isset($r['status']) && $r['status'] == 'I' ? 'selected' : '' ?>>Unavailable</option>
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

