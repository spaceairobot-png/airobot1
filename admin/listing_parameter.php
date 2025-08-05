<?php 

$filterCode ='' ;
$filterDesc ='' ;

if((isset($_GET['Code']) && !empty($_GET['Code'])) || (isset($_GET['Desc']) && !empty($_GET['Desc'])) )
{
	$filterCode = $_GET['name'];
	$filterDesc = $_GET['contact'];
	
	
$appendSql="ifnull(A.Code,'') like '%".$filterCode."%' and ifnull(A.Des,'') like '%".$filterDesc."%'";
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
		$appendSql='1=1';
	}
}

$sql ="";

if ($_GET['pname'] == 'Counsellor') 
{
	$sql ="select  * from cfgcounsellor A where ".$appendSql."";
}else if($_GET['pname'] == 'Engagement'){
	$sql ="select  * from cfgengagement A where ".$appendSql."";
}else if($_GET['pname'] == 'Event'){
	$sql ="select  * from cfgbatch A where ".$appendSql."";
}else if($_GET['pname'] == 'Country'){
	$sql ="select  * from cfgcountry A where ".$appendSql."";
}else if($_GET['pname'] == 'Course'){
	$sql ="select  * from cfgcourse A where ".$appendSql."";
}else if($_GET['pname'] == 'Qualification'){
	$sql ="select  * from cfgqualification A where ".$appendSql."";
}else if($_GET['pname'] == 'Level'){
	$sql ="select  * from cfgproglevel A where ".$appendSql."";
}else if($_GET['pname'] == 'State'){
	$sql ="select  * from cfgstate A where ".$appendSql."";
}else if($_GET['pname'] == 'School'){
	$sql ="select  * from cfgschool A where ".$appendSql."";
}

$q=mysqli_query($conn, $sql);
$rr=mysqli_num_rows($q);

include_once('pagination.php');
?>

<script>
	function DeleteItem(id , page )
	{
		if(confirm("You want to delete it ?"))
		{
			window.location.href="index.php?page=del_parameter&pname="+page+"&id="+id ;
		}
			
	}
</script>

<h1 class="page-header"><?php echo $_GET['pname']; ?> Listing</h1>

<table class="table table-bordered">
	<form method="post" action="index.php?page=listing_parameter&pname=<?php echo $_GET['pname']; ?>">
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
		<td style="border:hidden" colspan="1"><a href="index.php?page=add_parameter&pname=<?php echo $_GET['pname']; ?>">+ Add <?php echo $_GET['pname']; ?></a></td>
	</tr>

		<?php
//error_reporting(1);
         $rec_limit =10;
         
		 if ($_GET['pname'] == 'Counsellor') 
		{
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgcounsellor A where ".$appendSql. "";
		}else if($_GET['pname'] == 'Engagement'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgengagement A where ".$appendSql. "";
		}else if($_GET['pname'] == 'Event'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgbatch A where ".$appendSql. "";
		}else if($_GET['pname'] == 'Country'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgcountry A where ".$appendSql. "";
		}else if($_GET['pname'] == 'Course'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgcourse A where ".$appendSql. "";
		}else if($_GET['pname'] == 'Qualification'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgqualification A where ".$appendSql. "";
		}else if($_GET['pname'] == 'Level'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgproglevel A where ".$appendSql. "";
		}else if($_GET['pname'] == 'State'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgstate A where ".$appendSql. "";
		}else if($_GET['pname'] == 'School'){
			$sql = "SELECT count(DISTINCT A.Id) FROM cfgschool A where ".$appendSql. "";
		}

		 
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
		 
		
		 
		  if ($_GET['pname'] == 'Counsellor') 
		{
			 $sql = "SELECT  * from cfgcounsellor A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'Engagement'){
			 $sql = "SELECT  * from cfgengagement A where  ".$appendSql. ""." order by cast(Code as unsigned) asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'Event'){
			 $sql = "SELECT  * from cfgbatch A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'Country'){
			 $sql = "SELECT  * from cfgcountry A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'Course'){
			 $sql = "SELECT  * from cfgcourse A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'Qualification'){
			 $sql = "SELECT  * from cfgqualification A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'Level'){
			 $sql = "SELECT  * from cfgproglevel A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'State'){
			 $sql = "SELECT  * from cfgstate A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}else if($_GET['pname'] == 'School'){
			 $sql = "SELECT  * from cfgschool A where  ".$appendSql. ""." order by Code asc LIMIT $offset, $rec_limit";
		}
		 
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
				//if ($row['isActive'] == 'I') { $Data = "Inactivate"; } else {$Data = "Activate" ;}
			//echo "<td data-label='Active'>". $Data ."</td>";
			
?>
			<Td data-label='Update'><a href="index.php?page=upd_parameter&pname=<?php echo $_GET['pname']; ?>&pid=<?php echo $row['Id']; ?>" style='color:blue'><span class='glyphicon glyphicon-new-window'></span></a></td>
			
			<Td data-label='Delete'><a href="javascript:DeleteItem('<?php echo $row['Id']; ?>', '<?php echo $_GET['pname']; ?>')" style='color:red'><span class='glyphicon glyphicon-remove'></span></a></td>
			
<?php		
echo "</Tr>";
$inc++;
}
echo "</table><br />\n";
?>
</table>


<?php
//for showing Pagination	
$page = (int)(!isset($_GET['pg']) ? 1 : $_GET['pg']);
if ($page <= 0) $page = 1;

$per_page = 10; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$url ="index.php?page=listing_parameter&pname=".$_GET['pname']."&Code=".$filterCode."&Desc=".$filterDesc."";

echo pagination($Sqlpagination,$per_page,$page,$url, $conn);
		
?>


