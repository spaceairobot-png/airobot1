
<?php

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
 $total = 0;
    foreach ($_POST['item_name'] as $i => $itemName) {
        $price = floatval($_POST['item_price'][$i]);
        $qty   = intval($_POST['item_qty'][$i]);
        $total += $price * $qty;
    }
			
			$DateTo=str_replace('/', '-', $_POST['txtdate_payment']);
			$DateTo = date('Y-m-d', strtotime($DateTo));
			
				$add = "insert into tblpayments (student_id , amount , payment_date , mode) values('$dropStudent','$total', '$DateTo', '$dropPayMode' )";
				
				//echo $add;
				if ($conn->query($add) === TRUE) {
    $new_id = $conn->insert_id;

    // Loop through items
    foreach ($_POST['item_name'] as $index => $itemName) {
        $itemPrice = $_POST['item_price'][$index];
        $itemQty = $_POST['item_qty'][$index];

        $itemSQL = "INSERT INTO tblpayment_items (payment_id, item_name, item_price, quantity)
                    VALUES ('$new_id', '$itemName', '$itemPrice', '$itemQty')";
        $conn->query($itemSQL);
    }

    $err="[insert successfully] The record of ".$dropStudent ." have been added.";
    echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=add_payment";</script>';
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
		<div class="col-sm-4">Student</div>
		<div class="col-sm-5">
		<select name="dropStudent" class="form-control" >
			<option value="">Select Student</option>
			<?php 
				$q1=mysqli_query($conn,"select * from tblstudent where isActive ='A' order by Id asc");
				while($r1=mysqli_fetch_assoc($q1))
				{
					echo "<option value='".$r1['Id']."'>".$r1['Id']." :  ".$r1['Name']."</option>";
				}
			?>
		</select>
		</div>
	</div>
	

	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Payment date</div>
		<div class="col-sm-5">
		<input type="text" class="datepicker form-control " id="dtPick2" name="txtdate_payment" style="width:50%; margin-right:1%; display:inline;" autocomplete="off"><span class="glyphicon glyphicon-calendar" ></span></div> 
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
        <tr>
            <td><input name="item_name[]" type="text" class="form-control" required></td>
            <td><input name="item_price[]" type="number" step="0.01" class="form-control" required></td>
            <td><input name="item_qty[]" type="number" class="form-control" required></td>
            <td><button type="button" onclick="removeRow(this)">x</button></td>
        </tr>
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
