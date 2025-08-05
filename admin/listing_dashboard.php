<?php 
include_once('pagination.php');
?>

<h1 class="page-header mb-2">Dashboard</h1>

<head>

  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 20;
    }
    
  .carousel-inner img {
      width: 100%; /* Set width to 100% */
      margin: auto;
      min-height:200px;
  }

  /* Hide the carousel text when the screen is less than 600 pixels wide */
   
     .carousel-caption {
		position: initial;
		top: 0;
     }

  [data-tip] {
	position:relative;

}
[data-tip]:before {
	content:'';
	/* hides the tooltip when not hovered */
	display:none;
	content:'';
	border-left: 5px solid transparent;
	border-right: 5px solid transparent;
	border-bottom: 5px solid #1a1a1a;	
	position:absolute;
	top:30px;
	left:35px;
	z-index:8;
	font-size:0;
	line-height:0;
	width:0;
	height:0;
}
[data-tip]:after {
	display:none;
	content:attr(data-tip);
	position:absolute;
	top:35px;
	left:0px;
	padding:5px 8px;
	background:white;
	color:blue;
	z-index:9;
	font-size: 0.75em;
	height:18px;
	line-height:18px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
	white-space:nowrap;
	word-wrap:normal;
}
[data-tip]:hover:before,
[data-tip]:hover:after {
	display:block;
}
  </style>
</head>
<body>

<?php 
$visible = false;

if(isset($_POST['btnSearch']))
	{
		$filterYr = $_POST['txtYear'];
		if ($filterYr != "")
		$visible = true;
	}
	else 
	{
		$filterYr = date("Y");
		$visible = false;
	}
?>


<form method="post" action="index.php?page=listing_dashboard">
	<div data-tip="Press <Enter> to Continue">
  <input type="number" name="txtYear" style="width:13%" value='<?php echo $filterYr?>' placeholder="Input Selected Year" oninput="validity.valid||(value='');" class="form-control"/>
  </div>
  <input type="submit" value="Search" name="btnSearch" class="btn btn-success" style='visibility: hidden;' />
 
 </form>
 
 <div id="myCarousel02" class="carousel slide mb-4" data-ride="carousel" data-interval="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel2" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" style="overflow: initial; !importance" role="listbox">
	
	  <!-- t2  School -->
      <div class="item" style="min-height: 400px;">
	  <div class="carousel-caption mb-4">
          <p style="color: black; margin-bottom: auto; font-size:120%;">School Origin</p>
        </div>   
         <table class="table table-bordered" >
	<?php
		$sql = " select Des,  sum(year3) as year3 , sum(year2) as year2 , sum(year1) as year1 , sum(year) as year , sum(year0) as year0  from ( 
		SELECT tblB.Des ,
		case when year(Intake) =  YEAR(CURDATE()) -3  then count(tblA.ID) else 0  end as 'year3',
		case when year(Intake) =  YEAR(CURDATE()) -2  then count(tblA.ID) else 0  end as 'year2',
		case when year(Intake) =  YEAR(CURDATE()) -1  then count(tblA.ID) else 0  end as 'year1',
		case when year(Intake) =  YEAR(CURDATE())   then count(tblA.ID) else 0  end as 'year',
		case when year(Intake) =  '".$filterYr."'   then count(tblA.ID) else 0  end as 'year0'
		FROM tblstudent tblA left join cfgschool tblB on tblA.School = tblB.Code 
		WHERE ((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '".$filterYr."' )) and tblA.isActive = 'A' and tblA.EngageStatus = 'S'
		group by tblB.Des , year(Intake) ) A group by Des  ";
		//echo $sql;
		
         $retval = mysqli_query($conn, $sql);
         $rr=mysqli_num_rows($retval);
		 
         if(! $retval )
		  {
            die('Could not get data 2: ' . mysqli_error());
         }
         
		$Yr3 = date('Y', strtotime('-3 year'));
		$Yr2 = date('Y', strtotime('-2 year'));
		$Yr1 = date('Y', strtotime('-1 year'));
		$Yr = date('Y', strtotime('0 year'));
			
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" >School</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr3</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr2</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr1</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr</th>";
		if ($visible == true){
		 echo "<th id=\"headerSortUp\" width='16%' style='background-color: #d45d5d;'>$filterYr</th>";
		}
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='15'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
				
				echo "<Tr>";
				   echo "<td data-label='School'>".$row['Des']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr3'>".$row['year3']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr2'>".$row['year2']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr1'>".$row['year1']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr'>".$row['year']."</td>";
				   if ($visible == true){
				   echo "<td style='text-align:right' data-label='$filterYr'>".$row['year0']."</td>";
				   }
				echo "</Tr>";
				
			}
			
			$sqlTotal = " 
			select ifnull(sum(year3),0) as year3 , ifnull(sum(year2),0) as year2 , ifnull(sum(year1),0) as year1 , ifnull(sum(year),0) as year , ifnull(sum(year0),0) as year0  from (
			SELECT School ,
			case when year(Intake) = YEAR(CURDATE()) -3   then count(ID) else 0  end as 'year3',
			case when year(Intake) = YEAR(CURDATE()) -2   then count(ID) else 0  end as 'year2',
			case when year(Intake) = YEAR(CURDATE()) -1  then count(ID) else 0  end as 'year1',
			case when year(Intake) = YEAR(CURDATE())    then count(ID) else 0  end as 'year',
			case when year(Intake) =  '".$filterYr."'   then count(ID) else 0  end as 'year0'
			FROM `tblstudent` 
			WHERE ((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '".$filterYr."' ))  and isActive = 'A' and EngageStatus = 'S'
			group by School , year(Intake)) A";
			
			$result = $conn->query($sqlTotal);
			if ($result->num_rows > 0) {
			  while($row02 = $result->fetch_assoc()) 
			  {
				  	echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R3'>".$row02['year3']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R3'>".$row02['year2']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R3'>".$row02['year1']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R3'>".$row02['year']."</a></td>";
					    if ($visible == true){
						 echo "<td style='text-align:right' data-label='$filterYr' ><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R3'>".$row02['year0']."</a></td>";
						}
					echo "</Tr>";
			  }
			} else {
					echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R3'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R3'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R3'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R3'>0</a></td>";
					   if ($visible == true){
					    echo "<td style='text-align:right' data-label='$filterYr'><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R3'>0</a></td>";
					   }
					echo "</Tr>";
			}
			
			
			
			
			echo "</table><br />\n";
		?>
	</table> 
      </div>
	   <!-- t2 -->
	
	
	
	
	
      <div class="item" style="min-height: 400px;">
	     <div class="carousel-caption">
          <p style="color: black; margin-bottom: auto; font-size:120%;">Registered Program Level</p>
        </div>   
		
         <table class="table table-bordered" >

		 <!--T1 Registered Institution -->
	<?php

		$sql = " select Des, Country ,  sum(year3) as year3 , sum(year2) as year2 , sum(year1) as year1 , sum(year) as year  
		, sum(year0) as year0 from (
			SELECT tblB.Des  , tblB.Country  ,
			case when year(Intake) =  YEAR(CURDATE()) -3  then count(tblA.ID) else 0  end as 'year3',
			case when year(Intake) =  YEAR(CURDATE()) -2  then count(tblA.ID) else 0  end as 'year2',
			case when year(Intake) =  YEAR(CURDATE()) -1  then count(tblA.ID) else 0  end as 'year1',
			case when year(Intake) =  YEAR(CURDATE())   then count(tblA.ID) else 0  end as 'year',
			case when year(Intake) =  '".$filterYr."'   then count(tblA.ID) else 0  end as 'year0'
			FROM tblstudent tblA left join 
			cfginstitution tblB on tblA.Institution = tblB.code 			
			WHERE ((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '".$filterYr."' )) and tblB.Country ='MY' and tblA.isActive = 'A'
			and `EngageStatus` = 'S' 
			group by tblB.Des , tblB.Country , year(Intake)) A group by Des , Country";
		//echo $sql;
		
         $retval = mysqli_query($conn, $sql);
         $rr=mysqli_num_rows($retval);
		 
         if(! $retval )
		  {
            die('Could not get data : ' . mysqli_error());
         }
         
			$Yr3 = date('Y', strtotime('-3 year'));
			$Yr2 = date('Y', strtotime('-2 year'));
			$Yr1 = date('Y', strtotime('-1 year'));
			$Yr = date('Y', strtotime('0 year'));
			
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable2\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" >Institution</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr3</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr2</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr1</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr</th>";
		 if ($visible == true){
		 echo "<th id=\"headerSortUp\" style='background-color: #d45d5d;' width='16%'>$filterYr</th>";
		 }
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='15'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
				
				echo "<Tr>";
				   echo "<td data-label='Institution'>".$row['Des']." - ".$row['Country']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr3'>".$row['year3']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr2'>".$row['year2']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr1'>".$row['year1']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr'>".$row['year']."</td>";
				   if ($visible == true){
				   echo "<td style='text-align:right' style='background-color: #d45d5d;' data-label='$filterYr'>".$row['year0']."</td>";
					}
				echo "</Tr>";
				
			}
			
			$sqlTotal = "select ifnull(sum(year3),0) as year3 , ifnull(sum(year2),0) as year2 , ifnull(sum(year1),0) as year1 , ifnull(sum(year),0) as year , ifnull(sum(year0),0) as year0 from (
			SELECT tblB.Des ,
			case when year(Intake) =  YEAR(CURDATE()) -3  then count(tblA.ID) else 0  end as 'year3',
			case when year(Intake) =  YEAR(CURDATE()) -2  then count(tblA.ID) else 0  end as 'year2',
			case when year(Intake) =  YEAR(CURDATE()) -1  then count(tblA.ID) else 0  end as 'year1',
			case when year(Intake) =  YEAR(CURDATE())   then count(tblA.ID) else 0  end as 'year',
			case when year(Intake) =  '".$filterYr."'   then count(tblA.ID) else 0  end as 'year0'
			FROM tblstudent tblA left join 
			cfginstitution tblB on tblA.Institution = tblB.code 			
			WHERE ((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '".$filterYr."' )) and tblB.Country ='MY' and tblA.isActive = 'A'
			and `EngageStatus` = 'S' group by tblB.Des ,tblA.Intake  ) A
			";
		
			$result = $conn->query($sqlTotal);
			if ($result->num_rows > 0) {
			  while($row02 = $result->fetch_assoc()) 
			  {
					echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R1'>".$row02['year3']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R1'>".$row02['year2']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R1'>".$row02['year1']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R1'>".$row02['year']."</a></td>";
					   if ($visible == true){
					   echo "<td style='text-align:right' data-label='$filterYr' style='background-color: #d45d5d;'><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R1'>".$row02['year0']."</a></td>";
					   }
					echo "</Tr>";
			  }
			} else {
			  echo "<Tr>";
			  
			  echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R1'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R1'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R1'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R1'>0</a></td>";
					   if ($visible == true){
					   echo "<td style='text-align:right' data-label='$filterYr' style='background-color: #d45d5d;'><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R1'>0</a></td>";
					   }
					echo "</Tr>";
			}
			
			
			echo "</table><br />\n";
		?>
		
		
		 
</table>
      </div>

	
	  
	   
	<!-- t4  Student  -->
      <div class="item active" style="min-height: 400px;">
	  <div class="carousel-caption mb-4">
          <p style="color: black; margin-bottom: auto; font-size:120%;">Total Active Student</p>
        </div>   
         <table class="table table-bordered" >
	<?php
		$sql = " select  sum(year3) as year3 , sum(year2) as year2 , sum(year1) as year1 , sum(year) as year ,  sum(year0) as year0  from ( 
		SELECT 
		case when year(A.Intake) =  YEAR(CURDATE()) -3  then count(A.ID) else 0  end as 'year3',
		case when year(A.Intake) =  YEAR(CURDATE()) -2  then count(A.ID) else 0  end as 'year2',
		case when year(A.Intake) =  YEAR(CURDATE()) -1  then count(A.ID) else 0  end as 'year1',
		case when year(A.Intake) =  YEAR(CURDATE())   then count(A.ID) else 0  end as 'year',
		case when year(A.Intake) =  '".$filterYr."'   then count(A.ID) else 0  end as 'year0'
		FROM `tblstudent` A 
		WHERE ((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '".$filterYr."' )) and A.isActive = 'A' and A.EngageStatus = 'S'
		group by year(A.Intake) ) A ";
		//echo $sql;
		
         $retval = mysqli_query($conn, $sql);
         $rr=mysqli_num_rows($retval);
		 
         if(! $retval )
		  {
            die('Could not get data 2: ' . mysqli_error());
         }
         
		$Yr3 = date('Y', strtotime('-3 year'));
		$Yr2 = date('Y', strtotime('-2 year'));
		$Yr1 = date('Y', strtotime('-1 year'));
		$Yr = date('Y', strtotime('0 year'));
			
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable6\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" >Total</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr3</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr2</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr1</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr</th>";
		 if ($visible == true){
			echo "<th id=\"headerSortUp\" width='16%' style='background-color: #d45d5d;'>$filterYr</th>";
		 }
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='15'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
				
				echo "<Tr>";
				   echo "<td style='text-align:right' data-label='$Yr3'></td>";
				   echo "<td style='text-align:right' data-label='$Yr3'>".$row['year3']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr2'>".$row['year2']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr1'>".$row['year1']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr'>".$row['year']."</td>";
				    if ($visible == true){
						 echo "<td style='text-align:right' data-label='$filterYr'>".$row['year0']."</td>";
					}
				echo "</Tr>";
				
			}
			
			$sqlTotal = " 
			select ifnull(sum(year3),0) as year3 , ifnull(sum(year2),0) as year2 , ifnull(sum(year1),0) as year1 , ifnull(sum(year),0) as year , ifnull(sum(year0),0) as year0 from (
			SELECT
			case when year(Intake) =  YEAR(CURDATE()) -3  then count(A.ID) else 0  end as 'year3',
			case when year(Intake) =  YEAR(CURDATE()) -2  then count(A.ID) else 0  end as 'year2',
			case when year(Intake) =  YEAR(CURDATE()) -1  then count(A.ID) else 0  end as 'year1',
			case when year(Intake) =  YEAR(CURDATE())   then count(A.ID) else 0  end as 'year',
			case when year(Intake) =  '".$filterYr."'   then count(A.ID) else 0  end as 'year0'
			FROM `tblstudent` A 
			WHERE 
			((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '".$filterYr."' )) and 
			A.isActive = 'A'
			and EngageStatus = 'S'
			group by year(Intake)) A";
			
			$result = $conn->query($sqlTotal);
			if ($result->num_rows > 0) {
			  while($row02 = $result->fetch_assoc()) 
			  {
				  	echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R6'>".$row02['year3']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R6'>".$row02['year2']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R6'>".$row02['year1']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R6'>".$row02['year']."</a></td>";
						if ($visible == true){
						echo "<td style='text-align:right' data-label='$filterYr'><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R6'>".$row02['year0']."</a></td>";
						}
					echo "</Tr>";
			  }
			} else {
					echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R6'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R6'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R6'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R6'>0</a></td>";
					   if ($visible == true){
					    echo "<td style='text-align:right' data-label='$filterYr'><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R6'>0</a></td>";
					   }
					echo "</Tr>";
			}
			
			
			
			
			echo "</table><br />\n";
		?>
	</table> 
      </div>
	   <!-- t4 -->   
	   
	   
	   <!-- t5  Engagement  -->
      <div class="item" style="min-height: 400px;">
	  <div class="carousel-caption mb-4">
          <p style="color: black; margin-bottom: auto; font-size:120%;">Engagement</p>
        </div>   
         <table class="table table-bordered" >
	<?php
		$sql = " 
		select Des,  sum(year3) as year3 , sum(year2) as year2 , sum(year1) as year1 , sum(year) as year , sum(year0) as year0 from (
		SELECT B.Des ,
		case when year(A.Intake) =  YEAR(CURDATE()) -3  then count(A.ID) else 0  end as 'year3',
		case when year(A.Intake) =  YEAR(CURDATE()) -2  then count(A.ID) else 0  end as 'year2',
		case when year(A.Intake) =  YEAR(CURDATE()) -1  then count(A.ID) else 0  end as 'year1',
		case when year(A.Intake) =  YEAR(CURDATE())   then count(A.ID) else 0  end as 'year', 
		case when year(A.Intake) =   '".$filterYr."'   then count(A.ID) else 0  end as 'year0'
		FROM tblstudent  A 
		left join cfgengagement B  on A.Engagement = B.Code
		WHERE ((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '2021' )) and A.isActive = 'A' and A.EngageStatus = 'S'
		group by A.Engagement , A.Intake order by B.Code ) 
		A group by Des ";
	
         $retval = mysqli_query($conn, $sql);
         $rr=mysqli_num_rows($retval);
		 
         if(! $retval )
		  {
            die('Could not get data 2: ' . mysqli_error());
         }
         
		$Yr3 = date('Y', strtotime('-3 year'));
		$Yr2 = date('Y', strtotime('-2 year'));
		$Yr1 = date('Y', strtotime('-1 year'));
		$Yr = date('Y', strtotime('0 year'));
			
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable7\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" >Engagement</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr3</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr2</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr1</th>";
		 echo "<th id=\"headerSortUp\" width='16%'>$Yr</th>";
		 if ($visible == true){
		  echo "<th id=\"headerSortUp\" width='16%' style='background-color: #d45d5d;'>$filterYr</th>";
		 }
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='15'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
				
				echo "<Tr>";
				   echo "<td data-label='Country'>".$row['Des']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr3'>".$row['year3']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr2'>".$row['year2']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr1'>".$row['year1']."</td>";
				   echo "<td style='text-align:right' data-label='$Yr'>".$row['year']."</td>";
				    if ($visible == true){
					 echo "<td style='text-align:right' data-label='$filterYr'>".$row['year0']."</td>";
					}
				echo "</Tr>";
				
			}
			
			$sqlTotal = " 
			select ifnull(sum(year3),0) as year3 , ifnull(sum(year2),0) as year2 , ifnull(sum(year1),0) as year1 , ifnull(sum(year),0) as year , ifnull(sum(year0),0) as year0 from (
			SELECT B.Des ,
			case when year(Intake) =  YEAR(CURDATE()) -3  then count(A.ID) else 0  end as 'year3',
			case when year(Intake) =  YEAR(CURDATE()) -2  then count(A.ID) else 0  end as 'year2',
			case when year(Intake) =  YEAR(CURDATE()) -1  then count(A.ID) else 0  end as 'year1',
			case when year(Intake) =  YEAR(CURDATE())  then count(A.ID) else 0  end as 'year',
			case when year(Intake) =  '".$filterYr."'   then count(A.ID) else 0  end as 'year0'
			FROM tblstudent  A left join cfgengagement B  on A.Engagement = B.Code
			WHERE ((year(Intake) between YEAR(CURDATE()) -3 and YEAR(CURDATE())) or (year(Intake) = '".$filterYr."' )) and A.isActive = 'A' and EngageStatus = 'S'
			group by B.Des , year(Intake)) A";
			
			$result = $conn->query($sqlTotal);
			if ($result->num_rows > 0) {
			  while($row02 = $result->fetch_assoc()) 
			  {
				  	echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R7'>".$row02['year3']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R7'>".$row02['year2']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R7'>".$row02['year1']."</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R7'>".$row02['year']."</a></td>";
					   if ($visible == true){
						 echo "<td style='text-align:right' data-label='$filterYr'><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R7'>".$row02['year0']."</a></td>";
					   }
					echo "</Tr>";
			  }
			} else {
					echo "<Tr>";
					   echo "<td style='text-align:right' data-label='Total'><b>Total</b></td>";
					   echo "<td style='text-align:right' data-label='$Yr3'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr3."&R=R7'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr2'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr2."&R=R7'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr1'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr1."&R=R7'>0</a></td>";
					   echo "<td style='text-align:right' data-label='$Yr'><a href='index.php?page=listing_dashboard_detail&Yr=".$Yr."&R=R7'>0</a></td>";
					   if ($visible == true){
						echo "<td style='text-align:right' data-label='$filterYr'><a href='index.php?page=listing_dashboard_detail&Yr=".$filterYr."&R=R7'>0</a></td>";
					   }
					echo "</Tr>";
			}
			
			
			
			
			echo "</table><br />\n";
		?>
	</table> 
      </div>
	   <!-- t5 -->  
	   
	   
    </div>

    <!-- Left and right controls -->
    <a class="left" href="#myCarousel02" role="button" data-slide="prev" style="left: 0; top: 0; position: absolute;">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right" href="#myCarousel02" role="button" data-slide="next" style="right: 0; top: 0; position: absolute;">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
</div>
  
  

<br>
<br>



<?php 
$sql = mysqli_query($conn, "select ifnull(count(ID),0) as count1 from tblstudent A where YEARWEEK(`Intake`, 1) = YEARWEEK(CURDATE(), 1) and isActive = 'A' ");
$r = mysqli_fetch_array($sql);


$sql02 = mysqli_query($conn, "select ifnull(count(ID),0) as count1 from tblstudent A where YEARWEEK(`CreationDate`, 1) = YEARWEEK(CURDATE(), 1) and isActive = 'A'");
$r02 = mysqli_fetch_array($sql02);


?>



<footer class="container-fluid text-center">

<div id="content">

  <div id="left" style="width: 30%; float:left">
	 <h3 style='text-align:left'>Info  </h3>
     <div id="object1"><p  style='text-align:left'>New student by this week :: <?php echo $r02['count1'] ?></p> </div>
     <div id="object2"><p  style='text-align:left'>Total Intake by this week :: <?php echo $r['count1'] ?></p> </div>
  </div>
	
  <div id="right" style="width: 60%; float:right">
  <h3 style='text-align:left'>Reminder </h3>
     <?php
		 $sql = "SELECT count(ID) as count, Counsellors,  Reminder FROM tblstudent WHERE Reminder >= CURDATE() group by Reminder, Counsellors";
		  
         $retval = mysqli_query($conn, $sql);
         
         if(! $retval )
		  {
            die('Could not get data : ' . mysqli_error());
         }
         	
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th  width='4%'>Date</th>";
		 echo "<th  width='4%'>Counsellors</th>";
		 echo "<th  width='4%'>Total</th>";
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
 
		  if(!$rr)
			{
			echo "<tr style='color:red'><td colspan='15'>No matches found</td></tr>";
			}
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
		  
            echo "<Tr>";
			echo "<td data-label='Date'>".$row['Reminder']."</td>";
			echo "<td data-label='Date'>".$row['Counsellors']."</td>";
			
		?>
		<Td data-label='Total'><a href="index.php?page=listing_student&reminder=<?php echo $row['Reminder']; ?>&counsellor=<?php echo $row['Counsellors']; ?>" style='color:blue'><?php echo $row['count']; ?></a></td>
		
		<?php
			echo "</Tr>";
			
			}
			
			echo "</table>";
?>
  </div>
</div>

 
  
</footer>

</body>
</html>
