<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$filterName = isset($_GET['txtSearchCustName']) ? $_GET['txtSearchCustName'] : '';
$filterContact = isset($_GET['txtContact']) ? $_GET['txtContact'] : '';
$filterCounsellor = isset($_GET['txtCounsellor']) ? $_GET['txtCounsellor'] : '';
$filterFinalEng = isset($_GET['dropFinal']) ? $_GET['dropFinal'] : '';

$filterICNo = isset($_GET['txtregisterNo']) ? $_GET['txtregisterNo'] : '';
$filterYear =isset($_GET['txtYear']) ? $_GET['txtYear'] : '';
$filterBatch =isset($_GET['dropBatch']) ? $_GET['dropBatch'] : '';
$filterSchool=isset($_GET['txtSchool']) ? $_GET['txtSchool'] : '';


// Build WHERE clause
$appendSql = " WHERE 1=1";
if ($filterName != '') {
    $appendSql .= " AND IFNULL(A.Name,'') LIKE '%$filterName%'";
}
if ($filterContact != '') {
    $appendSql .= " AND IFNULL(A.MobileNo,'') LIKE '%$filterContact%'";
}
if ($filterCounsellor != '') {
    $appendSql .= " AND IFNULL(A.Counsellors,'') LIKE '%$filterCounsellor%'";
}
if ($filterFinalEng != '') {
    $appendSql .= " AND IFNULL(A.EngageStatus,'') LIKE '%$filterFinalEng%'";
}

if ($filterICNo != '') {
    $appendSql .= " AND IFNULL(A.RegisterNo,'') LIKE '%$filterICNo%'";
}
if ($filterYear != '') {
    $appendSql .= " AND IFNULL(A.Year,'') LIKE '%$filterYear%'";
}
if ($filterBatch != '') {
    $appendSql .= " AND IFNULL(A.Batch,'') LIKE '%$filterBatch%'";
}
if ($filterSchool != '') {
    $appendSql .= " AND IFNULL(A.School,'') LIKE '%$filterSchool%'";
}

 $sql = "SELECT A.Id,CreationDate, A.Counsellors ,Name,MobileNo,Email,School, A.Qualification,Year,Course,RegisterNo, B.Des as Engage , case 
		 when A.EngageStatus  = 'U' then 'Urgent' 
		 when A.EngageStatus  = 'A' then 'Active'  
		 when A.EngageStatus  = 'F' then 'unfollow' 
		 when A.EngageStatus  = 'S' then 'Success' 
		 when A.EngageStatus  = 'N' then 'No Status'
		 else '' end 
		 as 'ES'
		 FROM tblstudent A 
		 LEFT JOIN cfgengagement  B ON A.Engagement = B.Code 
		 $appendSql";


$q = mysqli_query($conn, $sql);
if (!$q) {
    die("SQL Error: " . mysqli_error($conn));
}
$rr = mysqli_num_rows($q);

?>

<h1 class="page-header">Student Listing</h1>

<form method="post" action="index.php?page=listing_student">
    <input type="hidden" name="page" value="listing_student">
    <table class="table table-bordered">
	<tr>
		<td >Student </td>
		<td ><input type="text" style="width:80%" placeholder="Student Name" name="txtSearchCustName" value='<?php echo htmlspecialchars($filterName);?>'  class="form-control"></td>
		<td >IC No.</td>
		<td ><input type="text" style="width:80%" placeholder="Register No." name="txtregisterNo" value='<?php echo $filterICNo?>'  class="form-control"></td>
		
	</tr>
	<tr>
		<td >Year</td>
		<td>
			<input type="number" name="txtYear" style="width:80%" value='<?php echo $filterYear?>' placeholder="Year" oninput="validity.valid||(value='');" class="form-control" />
		</td>
		
		<td>Mobile No.</td>
		<td><input type="text" style="width:80%" placeholder="Contact No." name="txtContact" value='<?php echo $filterContact?>'  class="form-control"></td>
	</tr>
	
	<tr>
		<td>Counsellor</td>
		<td>
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
		
		<td>School</td>
		<td><input type="text" style="width:80%" placeholder="School" name="txtSchool" value='<?php echo $filterSchool?>'  class="form-control"></td>

	</tr>
		
	<tr>
		<td>Batch</td>
		<td>
		<select name="dropBatch" class="form-control" style="width:80%">
			<option value=""></option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgbatch where isActive ='A'");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($filterBatch == $r1['Id']){
					  echo "<option value='".$r1['Id']."' selected>".$r1['Des']."</option>";
					}else{
					  echo "<option value='".$r1['Id']."' >".$r1['Des']."</option>";
					}
				}
			?>
		</select> 
		</td>
	
		<td>Final Engagement</td>
		<td>
			<select name="dropFinal" class="form-control" style="width:80%">
					<option value="" ></option>
					<option value="N" <?=$filterFinalEng == 'N' ? ' selected="selected"' : '';?>>No status</option>
					<option value="U" <?=$filterFinalEng == 'U' ? ' selected="selected"' : '';?>> Urgent </option>
					<option value="A" <?=$filterFinalEng == 'A' ? ' selected="selected"' : '';?>> Active </option>
					<option value="F" <?=$filterFinalEng == 'F' ? ' selected="selected"' : '';?>> No follow up </option>
					<option value="S" <?=$filterFinalEng == 'S' ? ' selected="selected"' : '';?>> Successful </option>
			</select>
		</td>
	</tr>	
		
	<tr>
		<td><input type="submit" value="Search" name="btnSearch" class="btn btn-success"/></td>
	</tr>
	</table>
	</form>
	
	<table style="width: 40%; margin-bottom:1%;">
	<tr style="border:hidden">
		<td style="border:hidden" ><a href="index.php?page=add_student">+ Add Student <span class="glyphicon glyphicon-user"> </span></a></td>
		
		<td style="border:hidden" ><a href="index.php?page=add_student_import">+ Import Excel <span class="glyphicon glyphicon-folder-open"> </span></a></td>
		
		<td style="border:hidden" >
		<form method="post" action="func/excel_Export_Student.php">
			<input type="submit" value="Export Excel" name="excelGenerateStu"  class="btnExport" style="margin-bottom:1%"/>
			<input type="hidden" value="<?php echo $sql ?>" name="sqlSP" />
		</form>
		</td>
		
	</tr>
	</table>


<table id="sortedtable" class="table table-bordered" cellspacing="0">
    <thead>
        <tr>
            <th id="headerSortUp">No.</th>
            <th id="headerSortUp">Creation Date</th>
            <th id="headerSortUp">Counsellor</th>
            <th id="headerSortUp">Name</th>
            <th id="headerSortUp">Mobile</th>
            <th id="headerSortUp">Email</th>
            <th id="headerSortUp">School</th>
			<th id="headerSortUp">Qualification</th>
			<th id="headerSortUp">Year</th>
			<th id="headerSortUp">Course</th>
			<th id="headerSortUp">IC No.</th>
			<th id="headerSortUp">Engagement</th>
			<th id="headerSortUp">Status</th>
			<th id="headerSortUp">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php

	 $inc=1;

    if ($rr > 0) {
        while ($row = mysqli_fetch_assoc($q)) {
            echo "<tr>

                <td>".$inc."</td>
                <td>{$row['CreationDate']}</td>
                <td>{$row['Counsellors']}</td>
                <td><a href='index.php?page=add_followup&stuId=".$row['Id']."'>".$row['Name']."</a></td>
                <td>{$row['MobileNo']}</td>
                <td>{$row['Email']}</td>
				<td>{$row['School']}</td>
				<td>{$row['Qualification']}</td>
				<td>{$row['Year']}</td>
				<td>{$row['Course']}</td>
				<td>{$row['RegisterNo']}</td>
				<td>{$row['Engage']}</td>
				<td>{$row['ES']}</td>

                <td>
					 <a href='index.php?page=upd_student&stuId={$row['Id']}&mode=view' class='btn btn-info'>View</a>
                    <a href='index.php?page=upd_student&stuId={$row['Id']}' class='btn btn-warning'>Edit</a>
                    <a href='javascript:DeleteStudent({$row['Id']})' class='btn btn-danger'>Delete</a>
                   
                </td>
            </tr>";

			$inc++;
        }
    } else {
        echo "<tr><td colspan='13' style='color:red;'>No matches found</td></tr>";
    }
    ?>
    </tbody>
</table>

<script>
 $(document).ready(function () {
  $('#sortedtable').DataTable({
    order: [[1, 'desc']],
    pageLength: 10 
    
  });
});

	function DeleteStudent(id)
	{
		if(confirm("You want to delete this student ?"))
		{
			window.location.href="index.php?page=del_student&id="+id ;
		}
			
	}
</script>