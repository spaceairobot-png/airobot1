<?php 

if((isset($_GET['Yr']) && !empty($_GET['Yr'])) || (isset($_GET['R']) && !empty($_GET['R'])) )
{
	$filterYear = $_GET['Yr'];
	$appendSql='';
	
	if ($_GET['R'] == 'R1') {
		$appendSql="  year(A.Intake) = '".$filterYear."' and B.Country = 'MY' and A.EngageStatus ='S' and A.isActive = 'A'";
	}
	else if ($_GET['R'] == 'R2') {
		$appendSql="  year(A.Intake) = '".$filterYear."'  and B.Country <> 'MY' and A.EngageStatus ='S' and A.isActive = 'A'";
	}
	else if ($_GET['R'] == 'R3') {
		$appendSql="  year(A.Intake) = '".$filterYear."' and A.EngageStatus ='S' and A.isActive = 'A'";
	}
	else if ($_GET['R'] == 'R4') {
		$appendSql="  year(A.Intake) = '".$filterYear."' and A.EngageStatus ='S' and A.isActive = 'A'";
	}
	else if ($_GET['R'] == 'R5') {
		$appendSql="   year(A.Intake) = '".$filterYear."' and A.EngageStatus ='S' and A.isActive = 'A'";
	}
	else if ($_GET['R'] == 'R6') {
		$appendSql="   year(A.Intake) = '".$filterYear."' and A.EngageStatus ='S' and A.isActive = 'A'";
	}
	else if ($_GET['R'] == 'R7') {
		$appendSql="   year(A.Intake) = '".$filterYear."' and A.EngageStatus ='S' and A.isActive = 'A'";
	}
	
}

  $sql = "SELECT CreationDate , Counsellors , Name, RegisterNo, MobileNo, DOB, Email, Address, States,A.Country, School, Qualification, Year , Course ,  Engagement, Institution, Intake, Batch, Programid, ProgramLvl , C.Des as Engage
		  FROM tblstudent A 
		  left join cfginstitution  B on A.Institution = B.Code 
		  left join cfgengagement C on A.Engagement = C.Code 
 where  ".$appendSql."";
 
$q=mysqli_query($conn, $sql);
$rr=mysqli_num_rows($q);

//echo $sql;
?>

<script>
	function DeleteCustomer(id)
	{
		if(confirm("You want to delete this student ?"))
		{
			window.location.href="index.php?page=del_student&id="+id ;
		}
			
	}
</script>

<h1 class="page-header">Student Listing</h1>

<table class="table table-bordered">
	
		<?php
		  $sql = "SELECT CreationDate , Counsellors , Name, RegisterNo, MobileNo, DOB, Email, Address, States,A.Country, School, Qualification, Year , Course ,  Engagement, Institution, Intake, Batch, Programid, ProgramLvl , C.Des as Engage
		  FROM tblstudent A 
		  left join cfginstitution   B on A.Institution = B.Code 
		  left join cfgengagement C on A.Engagement = C.Code 
		  where  ".$appendSql." order by A.CreationDate desc ";
		  
		//echo $sql;
		
         $retval = mysqli_query($conn, $sql);
         
         if(! $retval )
		  {
            die('Could not get data : ' . mysqli_error());
         }
         	
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" width='4%'>No.</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Creation Date</th>";
		 echo "<th id=\"headerSortUp\" width='6%'>Counsellor</th>";
		 echo "<th id=\"headerSortUp\">Name</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Mobile</th>";
		 echo "<th id=\"headerSortUp\">Email</th>";
		 echo "<th id=\"headerSortUp\">School</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Qualification</th>";
		 echo "<th id=\"headerSortUp\" width='4%'>Year</th>";
		 echo "<th id=\"headerSortUp\" width='15%'>Course</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>IC No.</th>";
	     echo "<th id=\"headerSortUp\" width='8%'>Engagement</th>";
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
         $inc=1;
		 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='15'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
		  
            echo "<Tr>";
			echo "<td data-label='No.'>".$inc."</td>";
			echo "<td data-label='Creation Date'>".$row['CreationDate']."</td>";
			echo "<td data-label='Counsellors'>".$row['Counsellors']."</td>";
			echo "<td data-label='Name'>".$row['Name']."</a></td>";
			echo "<td data-label='Mobile No.'>".$row['MobileNo']."</td>";
			echo "<td data-label='Email'>".$row['Email']."</td>";
			echo "<td data-label='School'>".$row['School']."</td>";
			echo "<td data-label='Qualification'>".$row['Qualification']."</td>";
			echo "<td data-label='Year'>".$row['Year']."</td>";
			echo "<td data-label='Program Interest'>".$row['Course']."</td>";
			echo "<td data-label='IC No.'>".$row['RegisterNo']."</td>";
			echo "<td data-label='Engagement'>".$row['Engage']."</td>";
?>
			
</td>
<?php		
echo "</Tr>";
$inc++;
}
echo "</table><br />\n";
?>
</table>




