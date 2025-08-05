
<?php
	$sql = mysqli_query($conn, "select * from tblpayments A where A.Id='" . $_GET['payment_id'] . "'");
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
			$payment_id = $_GET['payment_id'];
			// Step 1: Delete existing items for this payment
			mysqli_query($conn, "DELETE FROM tblpayment_items WHERE payment_id = '$payment_id'");

			// Step 2: Re-insert updated items
			foreach ($_POST['item_name'] as $index => $itemName) {
				$itemPrice = $_POST['item_price'][$index];
				$itemQty = $_POST['item_qty'][$index];

				$itemSQL = "INSERT INTO tblpayment_items (payment_id, item_name, item_price, quantity)
							VALUES ('$payment_id', '$itemName', '$itemPrice', '$itemQty')";
				mysqli_query($conn, $itemSQL);

				$total += $itemPrice * $itemQty;
			}
			
				$add = "update tblpayments set student_id = '$dropStudent' , amount = '$total' , payment_date = '$DateTo' , mode = '$dropPayMode' , updated_at = now() where ID = " . $_GET['payment_id'] . "";
				
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
	
<?php
$payment_id = $_GET['payment_id'];
$items = [];
$itemQuery = mysqli_query($conn, "SELECT * FROM tblpayment_items WHERE payment_id = '$payment_id'");
while($item = mysqli_fetch_assoc($itemQuery)) {
    $items[] = $item;
}
?>

	<h4>Items</h4>
	<table class="table table-bordered" id="itemTable">
		<thead>
			<tr>
				<th>Item Name</th>
				<th>Price (RM)</th>
				<th>Quantity</th>
				<th><button type="button" onclick="addRow()">+</button></th>
			</tr>
		</thead>
		<tbody>
<?php if (count($items) > 0): ?>
    <?php foreach ($items as $item): ?>
    <tr>
        <td><input name="item_name[]" type="text" class="form-control" value="<?= htmlspecialchars($item['item_name']) ?>" required></td>
        <td><input name="item_price[]" type="number" step="0.01" class="form-control" value="<?= htmlspecialchars($item['item_price']) ?>" required></td>
        <td><input name="item_qty[]" type="number" class="form-control" value="<?= htmlspecialchars($item['quantity']) ?>" required></td>
        <td><button type="button" onclick="removeRow(this)">x</button></td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td><input name="item_name[]" type="text" class="form-control" required></td>
        <td><input name="item_price[]" type="number" step="0.01" class="form-control" required></td>
        <td><input name="item_qty[]" type="number" class="form-control" required></td>
        <td><button type="button" onclick="removeRow(this)">x</button></td>
    </tr>
<?php endif; ?>
</tbody>
	</table>

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

function addRow() {
    var row = document.querySelector("#itemTable tbody tr");
    var clone = row.cloneNode(true);
    clone.querySelectorAll("input").forEach(input => input.value = "");
    document.querySelector("#itemTable tbody").appendChild(clone);
}

function removeRow(btn) {
    var rows = document.querySelectorAll("#itemTable tbody tr");
    if (rows.length > 1) {
        btn.closest("tr").remove();
    }
}
</script>