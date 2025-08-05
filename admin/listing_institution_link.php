<?php 

$filterCode ='' ;
$filterDesc ='' ;


if((isset($_GET['Code']) && !empty($_GET['Code'])) || (isset($_GET['Desc']) && !empty($_GET['Desc'])) )
{
	$filterCode = $_GET['name'];
	$filterDesc = $_GET['contact'];
	
	
$appendSql="ifnull(A.Code,'') like '%".$filterCode."%' and ifnull(A.Des,'') like '%".$filterDesc."%' ";
}
else{
if(isset($_POST['btnSearch']))
{

	$filterCode =$_POST['txtCode'];
	$filterDesc =$_POST['txtDesc'];
	
	
	$appendSql="ifnull(A.Code,'') like '%".$filterCode."%' and ifnull(A.Des,'') like '%".$filterDesc."%' ";
}
//default 
	else
	{
		$appendSql=' 1=1 ';
	}
}


	$sql ="select  * from cfginstitution A where ".$appendSql."";


$q=mysqli_query($conn, $sql);
$rr=mysqli_num_rows($q);

include_once('pagination.php');
?>

<script>
	function DeleteItem(id , page )
	{
		if(confirm("You want to delete it ?"))
		{
			window.location.href="index.php?page=del_parameter&pname=Institution&id="+id ;
		}
			
	}
</script>

<h1 class="page-header">Institution Listing</h1>

<table class="table table-bordered">
	<form method="post" action="index.php?page=listing_institution_link">
	<tr>
		<td style="border:hidden;" colspan="1">Code</td>
		<td style="border:hidden;" colspan="1"><input type="text" style="width:80%" placeholder="Code" name="txtCode" value='<?php echo $filterCode?>'  class="form-control"></td>
		<td style="border:hidden;" colspan="1">Description</td>
		<td style="border:hidden;" colspan="1"><input type="text" style="width:80%" placeholder="Description" name="txtDesc" value='<?php echo $filterDesc?>'  class="form-control"></td>
		
		<td style="border:hidden;" colspan="1"></td>
		<td style="border:hidden;" colspan="2"></td>
		
		<td style="border:hidden;"colspan="1"></td>
		<td style="border:hidden;" colspan="2"><input type="submit" value="Search" name="btnSearch" class="btn btn-success"/></td>
	</tr>
	

	</form>
	
	<tr style="border:hidden">
		<td style="border:hidden" colspan="1"><a href="index.php?page=add_institution_link">+ Add Institution </a></td>
	</tr>

		<?php
//error_reporting(1);
         $rec_limit =10;
         
		
		$sql = "SELECT count(DISTINCT A.Id) FROM cfginstitution A where ".$appendSql. "";
	

		 
		$Sqlpagination =$sql;
		$retval = mysqli_query($conn,$sql);
		 
         if(! $retval )
		 {
            die('Could not get data count: ' . mysqli_error());
         }
         $row = mysqli_fetch_array($retval, MYSQLI_NUM );
         $rec_count = $row[0];
         
         if( isset($_GET{'pg'} ) ) {
            $pg = $_GET{'pg'} - 1;
            $offset = $rec_limit * $pg ;
         }else {
            $pg = 0;
            $offset = 0;
         }
          
		 
         $left_rec = $rec_count - ($pg * $rec_limit);
		 
		
		 
		 
		 $sql = "SELECT  * from cfginstitution A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		
		 
		//echo $sql;
		
         $retval = mysqli_query($conn, $sql);
         
         if(! $retval )
		  {
            die('Could not get data : ' . mysqli_error());
         }
         	
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" width='4%'>No</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Code</th>";
		 echo "<th id=\"headerSortUp\" >Description</th>";
		 echo "<th id=\"headerSortUp\" >Country</th>";
		 //echo "<th id=\"headerSortUp\" width='8%'>Status</th>";
		 echo "<th id=\"headerSortUp\" width='6%'>Update</th>";
		 echo "<th id=\"headerSortUp\" width='6%'>Delete</th>";
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
			echo "<td data-label='Code'>".$row['Code']."</td>";
			echo "<td data-label='Description'>".$row['Des']."</td>";
			echo "<td data-label='Country'>".$row['Country']."</td>";
			//if ($row['isActive'] == 'I') { $Data = "Inactivate"; } else {$Data = "Activate" ;}
			//echo "<td data-label='Active'>". $Data ."</td>";
?>
			<Td data-label='Update'><a href="index.php?page=upd_institution_link&PCode=<?php echo $row['Id']; ?>" style='color:blue'><span class='glyphicon glyphicon-new-window'></span></a></td>
			
			<Td data-label='Delete'><a href="javascript:DeleteItem('<?php echo $row['Id']; ?>', 'Institution')" style='color:red'><span class='glyphicon glyphicon-remove'></span></a></td>
			
<?php		
echo "</Tr>";
$inc++;
}
echo "</table><br />\n";
?>
</table>


<?php
//for showing Pagination	
$page = (int)(!isset($_GET{'pg'}) ? 1 : $_GET{'pg'});
if ($page <= 0) $page = 1;

$per_page = 10; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$url ="index.php?page=listing_institution_link&Code=".$filterCode."&Desc=".$filterDesc."";

echo pagination($Sqlpagination,$per_page,$page,$url, $conn);
		
?>


