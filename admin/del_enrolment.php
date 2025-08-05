<?php 

$DelQry=mysqli_query($conn,"delete from tblstudent where Id='".$_GET['id']."'");


if (mysqli_affected_rows($conn) >= 1)
	{
	echo '<script type="text/javascript">alert("[Delete Successfully]"); window.location.href="index.php?page=listing_enrolment_detail&YrTo='.$_GET['YrTo'].'";</script>';
	}
else
	{
	$err1 = '[Failed] Invalid process because this record have been delete';
	echo '<script type="text/javascript">alert("'.$err1.'"); window.location.href="index.php?page=listing_enrolment_detail&YrTo='.$_GET['YrTo'].'";</script>';
	}

	echo $DelQry;
?>