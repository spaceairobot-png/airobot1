<?php 

$DelQry=mysqli_query($conn,"update tblpayments set status = 'I' where id='".$_GET['id']."'");

//echo $DelQry;
if (mysqli_affected_rows($conn) >= 1)
	{
	echo '<script type="text/javascript">alert("[Delete Successfully]"); window.location.href="index.php?page=listing_payment";</script>';
	}
else
	{
	$err1 = '[Failed] Invalid process because this record have been delete';
	echo '<script type="text/javascript">alert("'.$err1.'"); window.location.href="index.php?page=listing_payment";</script>';
	}

	//echo $DelQry;
?>