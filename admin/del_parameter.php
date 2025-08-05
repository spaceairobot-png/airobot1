<?php 

$PageName = $_GET['pname'];
$PId = $_GET['id'];

if ($PageName == 'Counsellor')
{
	$SQL = "delete from cfgcounsellor where Id='".$PId."' and IsActive = 'A' ";
}
else if ($PageName == 'Engagement')
{
	//$SQL = "update cfgengagement set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfgengagement where Id='".$PId."' and IsActive = 'A' ";
}
else if ($PageName == 'Event')
{
	//$SQL = "update cfgbatch set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfgbatch where Id='".$PId."' and IsActive = 'A' ";
}
else if ($PageName == 'Institution')
{
	$DSQL = " delete A from tblinstprog A inner join cfginstitution B on A.InstituitionID = B.code where B.Id='".$PId."' and B.IsActive = 'A' ";
	$D2SQL= mysqli_query($conn, $DSQL );
	
	//$SQL = "update cfginstitution set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfginstitution where Id='".$PId."' and IsActive = 'A' ";
	
}
else if ($PageName == 'Course')
{
	//$SQL = "update cfgcourse set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfgcourse where Id='".$PId."' and IsActive = 'A' ";
}
else if ($PageName == 'Qualification')
{
	//$SQL = "update cfgqualification set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfgqualification where Id='".$PId."' and IsActive = 'A' ";
}
else if ($PageName == 'Level')
{
	//$SQL = "update cfgproglevel set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfgproglevel where Id='".$PId."' and IsActive = 'A' ";
}
else if ($PageName == 'School')
{
	//$SQL = "update cfgschool set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfgschool where Id='".$PId."' and IsActive = 'A' ";
}
else if ($PageName == 'Country')
{
	//$SQL = "update cfgschool set IsActive = 'I' ,  LastUpdDt = now() where Id='".$PId."' and IsActive = 'A' ";
	$SQL = "delete from cfgcountry where Id='".$PId."' and IsActive = 'A' ";
}


$DelQry=mysqli_query($conn, $SQL );

if (mysqli_affected_rows($conn) >= 1)
	{
		if ($PageName == 'Institution')
	{
		echo '<script type="text/javascript">alert("[Delete Successfully]"); window.location.href="index.php?page=listing_institution_link";</script>';
	}else {
		echo '<script type="text/javascript">alert("[Delete Successfully]"); window.location.href="index.php?page=listing_parameter&pname='.$PageName.'";</script>';
	}
	}
else
	{
	$err1 = '[Failed] Invalid process because this record have been delete';
	if ($PageName == 'Institution')
	{
		echo '<script type="text/javascript">alert("'.$err1.'"); window.location.href="index.php?page=listing_institution_link";</script>';
	}
	else{
		echo '<script type="text/javascript">alert("'.$err1.'"); window.location.href="index.php?page=listing_parameter&pname='.$PageName.'";</script>';
	}
	
	}

	//echo $DelQry;
?>