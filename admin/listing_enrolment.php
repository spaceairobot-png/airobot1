
<?php 
	extract($_POST);
	if(isset($btnSave))
	{
	}
	
?>

<h1 class="page-header">Enrolment List</h1>
<form method="post" onkeypress="return event.keyCode != 13;">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<table class="table table-bordered">
	<?php
		$sql = " SELECT DISTINCT Year(Intake) as 'Year' FROM tblstudent where EngageStatus ='S' order by Year(Intake) Desc ";
		//echo $sql;
		
         $retval = mysqli_query($conn, $sql);
         $rr=mysqli_num_rows($retval);
		 
         if(! $retval )
		  {
            die('Could not get data : ' . mysqli_error());
         }
         	
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" width='4%'>Year</th>";
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='15'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
				if ($row['Year'] <> null ){
				echo "<Tr>";
				 echo "<td><a href='index.php?page=listing_enrolment_detail&YrTo=".$row['Year']."'>".$row['Year']."</a></td>";
				echo "</Tr>";
				}
			}
			echo "</table><br />\n";
		?>
</table>

</form>	

