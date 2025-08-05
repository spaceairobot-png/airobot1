<?php 


$filterName ='' ;
$filterContact ='' ;

if ($CSRole != ''){
	$filterCounsellor = $CSRole ;
}else 
{
	$filterCounsellor ='' ;
}



$filterICNo = '';
$filterBatch ='' ;
$filterInstitution='' ;
$filterMonth ='';
$filterProgram ='';
$filterYear = $_GET['YrTo'];


if((isset($_GET['name']) && !empty($_GET['name'])) || (isset($_GET['contact']) && !empty($_GET['contact'])) || (isset($_GET['counsellor']) && !empty($_GET['counsellor'])) || (isset($_GET['registerNo']) && !empty($_GET['registerNo'])) || (isset($_GET['program']) && !empty($_GET['program']))
|| (isset($_GET['batch']) && !empty($_GET['batch'])) || (isset($_GET['institution']) && !empty($_GET['institution']) ))
{
	$filterName = $_GET['name'];
	$filterContact = $_GET['contact'];
	$filterCounsellor = $_GET['counsellor'];
	$filterICNo = $_GET['registerNo'];
	$filterProgram = $_GET['program'];
	
	$filterBatch = $_GET['batch'];
	$filterInstitution= $_GET['institution'];
	$filterMonth = $_GET['selMonth'];

$appendSql="ifnull(A.Name,'') like '%".$filterName."%' and ifnull(A.MobileNo,'') like '".$filterContact."%' and ifnull(A.Counsellors,'') like '".$filterCounsellor."%' and ifnull(A.RegisterNo,'') like '".$filterICNo."%' and Year(A.Intake) = '".$filterYear."' and ifnull(A.Batch,'') like '".$filterBatch."%' and ifnull(A.Institution,'') like '".$filterInstitution."%' and A.ProgramId like '".$filterProgram."%' and A.EngageStatus ='S'";


	if  (isset($filterMonth) && !empty($filterMonth))
	{
		$appendSql= $appendSql. "and Month(A.Intake) = '".$filterMonth."'";
	}
}
else{
if(isset($_POST['btnSearch']))
{

	$filterName =$_POST['txtSearchCustName'];
	$filterContact =$_POST['txtContact'];
	$filterCounsellor = $_POST['txtCounsellor'];
	$filterICNo = $_POST['txtregisterNo'];
	$filterProgram = $_POST['txtProgram'];
	$filterBatch = $_POST['dropBatch'];
	$filterInstitution=$_POST['dropInstitution'];
	$filterMonth = $_POST['dropMonth'];
	
	$appendSql="ifnull(A.Name,'') like '%".$filterName."%' and ifnull(A.MobileNo,'') like '".$filterContact."%' and ifnull(A.Counsellors,'') like '".$filterCounsellor."%' and ifnull(A.RegisterNo,'') like '".$filterICNo."%' and Year(A.Intake) = '".$filterYear."' and ifnull(A.Batch,'') like '".$filterBatch."%' and ifnull(A.institution,'') like '".$filterInstitution."%' and ifnull(A.ProgramId,'') like '".$filterProgram."%' and A.EngageStatus ='S'";
	
	if($filterMonth != "")
	{
		$appendSql= $appendSql. "and Month(A.Intake) = '".$filterMonth."'";
	}
}
//default 
	else
	{
		if ( $filterCounsellor != "" ) {
			$appendSql=" A.isActive = 'A' and A.EngageStatus ='S' and Year(A.Intake) = '".$filterYear."' and A.Counsellors = '$filterCounsellor'  ";
		}
		else {
			$appendSql=" A.isActive = 'A' and A.EngageStatus ='S' and Year(A.Intake) = '".$filterYear."'";
		}
	}
}


 $sql = "SELECT CreationDate, Counsellors, A.Name, case when RegisterNo <> '' then CONCAT('''', RegisterNo , '''') else null end , case when MobileNo <> '' then CONCAT('''', MobileNo , '''') else null end , Email,  Institution, ifnull(C.Des, D.Des) as 'CountryIns', Intake, ProgramId, ProgramLvl, School, Qualification, Year , Remark 
 FROM tblstudent A left join cfginstitution B on A.Institution = B.Code left join cfgcountry C on B.Country = C.Code
 left join cfgcountry D on A.Country = D.Code
 where  ".$appendSql. "";
 
//echo $sql;
 
$q=mysqli_query($conn, $sql);
$rr=mysqli_num_rows($q);

include_once('pagination.php');
?>

<script>
	function DeleteCustomer(id , yr)
	{
		if(confirm("You want to delete this student ?"))
		{
			window.location.href="index.php?page=del_enrolment&id="+id+"&YrTo="+yr ;
		}
			
	}
</script>

<h1 class="page-header">Enrollment <?php echo $_GET['YrTo']; ?></h1>

<table class="table table-bordered">

	<form method="post" action="index.php?page=listing_enrolment_detail&YrTo=<?php echo $_GET['YrTo']; ?>">
	<tr>
		<td style="border:hidden;" colspan="1">Student </td>
		<td style="border:hidden;" colspan="1"><input type="text" style="width:80%" placeholder="Student Name" name="txtSearchCustName" value='<?php echo $filterName?>'  class="form-control"></td>
		<td style="border:hidden;" colspan="1">IC No.</td>
		<td style="border:hidden;" colspan="1"><input type="text" style="width:80%" placeholder="Register No." name="txtregisterNo" value='<?php echo $filterICNo?>'  class="form-control"></td>
		
		<td style="border:hidden;" colspan="1"></td>
		<td style="border:hidden;" colspan="2"></td>
	</tr>
	<tr>
		<td style="border:hidden;" colspan="1">Intake Month</td>
		<td style="border:hidden;" colspan="1">
			<select name="dropMonth" class="form-control" style="width:80%">
			    <option value=""></option>
				<option value="1" <?=$filterMonth == '1' ? ' selected="selected"' : '';?> >January</option>
				<option value="2" <?=$filterMonth == '2' ? ' selected="selected"' : '';?> >Febuary</option>
				<option value="3" <?=$filterMonth == '3' ? ' selected="selected"' : '';?>>March</option>
				<option value="4" <?=$filterMonth == '4' ? ' selected="selected"' : '';?>>April</option>
				<option value="5" <?=$filterMonth == '5' ? ' selected="selected"' : '';?>>May</option>
				<option value="6" <?=$filterMonth == '6' ? ' selected="selected"' : '';?>>June</option>
				<option value="7" <?=$filterMonth == '7' ? ' selected="selected"' : '';?>>July</option>
				<option value="8" <?=$filterMonth == '8' ? ' selected="selected"' : '';?>>August</option>
				<option value="9" <?=$filterMonth == '9' ? ' selected="selected"' : '';?>>September</option>
				<option value="10" <?=$filterMonth == '10' ? ' selected="selected"' : '';?>>October</option>
				<option value="11" <?=$filterMonth == '11' ? ' selected="selected"' : '';?>>November</option>
				<option value="12" <?=$filterMonth == '12' ? ' selected="selected"' : '';?>>December</option>
			</select>
		</td>
		
		<td style="border:hidden;" colspan="1">Mobile No.</td>
		<td style="border:hidden;" colspan="1"><input type="text" style="width:80%" placeholder="Contact No." name="txtContact" value='<?php echo $filterContact?>'  class="form-control"></td>
		
		<td style="border:hidden;" colspan="1"></td>
		<td style="border:hidden;" colspan="2"></td>
		
		<td style="border:hidden;" colspan="1"></td>
		<td style="border:hidden;" colspan="2"></td>
	</tr>
	
	<tr>
		<td style="border:hidden;" colspan="1">Counsellor</td>
		<td style="border:hidden;" colspan="1">
		<select name="txtCounsellor" class="form-control" style="width:80%">
			<option value=""></option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcounsellor where isActive ='A'");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($filterCounsellor == $r1['Code']){
					  echo "<option value='".$r1['Code']."' selected>[".$r1['Code']."] ".$r1['Des']."</option>";
					}else{
					  echo "<option value='".$r1['Code']."' >[".$r1['Code']."] ".$r1['Des']."</option>";
					}
				}
			?>
		</select> 
		</td>
		
		<td style="border:hidden;" colspan="1">Program </td>
		<td style="border:hidden;" colspan="1"><input type="text" style="width:80%" placeholder="Program" name="txtProgram" value='<?php echo $filterProgram?>'  class="form-control"></td>
		
		<td style="border:hidden;" colspan="1"></td>
		<td style="border:hidden;" colspan="2"></td>
		
	</tr>
		
	<tr>
		
		<td style="border:hidden;" colspan="1">Institution</td>
		<td style="border:hidden;" colspan="1">
		<select name="dropInstitution" class="form-control" style="width:80%">
			<option value=""></option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfginstitution where isActive ='A'");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($filterInstitution == $r1['Code']){
					  echo "<option value='".$r1['Code']."' selected>".$r1['Des']." - ".$r1['Country']."</option>";
					}else{
					  echo "<option value='".$r1['Code']."' >".$r1['Des']." - ".$r1['Country']."</option>";
					}
				}
			?>
		</select> 
		</td>
		
		<td style="border:hidden;" colspan="1">Batch</td>
		<td style="border:hidden;" colspan="1">
		<select name="dropBatch" class="form-control" style="width:80%">
			<option value=""></option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgbatch where isActive ='A'");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($filterBatch == $r1['Code']){
					  echo "<option value='".$r1['Code']."' selected>".$r1['Des']."</option>";
					}else{
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
					}
				}
			?>
		</select> 
		</td>
		
		<td style="border:hidden;"colspan="1"></td>
		<td style="border:hidden;" colspan="2"><input type="submit" value="Search" name="btnSearch" class="btn btn-success"/></td>
	</tr>	
		
		</form>
	
	 <tr>	
		<td  style="border:hidden;" >
		<form method="post" action="func/excel_Export_Enrolment.php">
			<input type="submit" value="Export to Excel" name="excelGenerate"  class="btnExport" style="margin-bottom:1%; max-width: 80%;"/>
			<input type="hidden" value="<?php echo $sql ?>" name="sqlSP" />
		</form>
		</td>
	</tr>
		
	
	

		<?php
//error_reporting(1);
         $rec_limit =10;
         
		$sql =	"SELECT count(A.Id) FROM tblstudent A where  ".$appendSql. "";
			
		$Sqlpagination =$sql;
		$retval = mysqli_query($conn,$sql);
		 
         if(! $retval )
		 {
            die('Could not get data count: ' . mysqli_error());
         }
         $row = mysqli_fetch_array($retval, MYSQLI_NUM );
         $rec_count = $row[0];
         
        if (isset($_GET['pg'])) {
    		$pg = $_GET['pg'] - 1;
    		$offset = $rec_limit * $pg;
	} else {
   		 $pg = 0;
    		$offset = 0;
	}
          
         $left_rec = $rec_count - ($pg * $rec_limit);
		 
		 $sql = "SELECT A.* , ifnull(C.Des , D.Des) as 'CountryIns' FROM tblstudent A 
		 left join cfginstitution B on A.Institution = B.Code 
		 left join cfgcountry C on B.Country = C.Code
		 left join cfgcountry D on A.Country = D.Code
		 where  ".$appendSql. ""." order by A.CreationDate desc LIMIT $offset, $rec_limit";
		 
		 //echo $sql;
		
         $retval = mysqli_query($conn, $sql);
         
         if(! $retval )
		  {
            die('Could not get data : ' . mysqli_error());
         }
         	
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" width='3%'>No</th>";
		 echo "<th id=\"headerSortUp\" width='5%'>Counsellor</th>";
		echo "<th id=\"headerSortUp\" width='6%'>Created </th>";
		 echo "<th id=\"headerSortUp\" >Name</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>IC No.</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Mobile No.</th>";
		 echo "<th id=\"headerSortUp\" >Email</th>";
		 echo "<th id=\"headerSortUp\" >Institution </th>";
		 echo "<th id=\"headerSortUp\" >Country</th>";
		 echo "<th id=\"headerSortUp\" width='6%'>Intake</th>";
		 echo "<th id=\"headerSortUp\" width='4%'>Level</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>School</th>";
		 echo "<th id=\"headerSortUp\" width='6%'>Qualification</th>";
		 echo "<th id=\"headerSortUp\" width='4%'>Year</th>";
		 echo "<th id=\"headerSortUp\" width='4%'>Remark</th>";
		 echo "<th id=\"headerSortUp\" width='4%'>Update</th>";
		 echo "<th id=\"headerSortUp\" width='4%'>Delete</th>";
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
         $inc=1;
		 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='16'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
            echo "<Tr>";
			echo "<td data-label='No.'>".$inc."</td>";
			echo "<td data-label='Counsellors'>".$row['Counsellors']."</td>";
			echo "<td data-label='Creation Date'>".$row['CreationDate']."</td>";
			
			echo "<td data-label='Name'>".$row['Name']."</td>";
			echo "<td data-label='IC No.'>".$row['RegisterNo']."</td>";
			echo "<td data-label='Mobile No.'>".$row['MobileNo']."</td>";
			echo "<td data-label='Email'>".$row['Email']."</td>";
			echo "<td data-label='Institution'>".$row['Institution']."</td>";
			echo "<td data-label='Country Ins'>".$row['CountryIns']."</td>";
			echo "<td data-label='Intake'>".$row['Intake']."</td>";
			echo "<td data-label='Level'>".$row['ProgramLvl']."</td>";
			echo "<td data-label='School'>".$row['School']."</td>";
			echo "<td data-label='Qualification'>".$row['Qualification']."</td>";
			echo "<td data-label='Year'>".$row['Year']."</td>";
			echo "<td data-label='Remark'>".$row['Remark']."</td>";
			
?>
			<Td data-label='Update'><a href="index.php?page=upd_enrolment&stuId=<?php echo $row['Id']; ?>" style='color:blue'><span class='glyphicon glyphicon-new-window'></span></a></td>
			
			<Td data-label='Delete'>
			<a href="javascript:DeleteCustomer('<?php echo $row['Id']; ?>'  ,   '<?php echo $_GET['YrTo']; ?>'  )" style='color:red'><span class='glyphicon glyphicon-remove'></span></a>
</td>
<?php		
echo "</Tr>";
$inc++;
}
echo "</table><br />\n";
?>
</table>


<?php
			//for shoing Pagination	
$page = (int)(!isset($_GET['pg']) ? 1 : $_GET['pg']);
if ($page <= 0) $page = 1;

$per_page = 10; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$url ="index.php?page=listing_enrolment_detail&YrTo=".$filterYear."&name=".$filterName."&contact=".$filterContact."&counsellor=".$filterCounsellor."&registerNo=".$filterICNo."&selMonth=".$filterMonth."&batch=".$filterBatch."&institution=".$filterInstitution."&program=".$filterProgram;

echo pagination($Sqlpagination,$per_page,$page,$url, $conn);
		
?>


