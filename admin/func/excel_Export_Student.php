<?php

include('../../connection.php');

if(isset($_POST["excelGenerateStu"]))
{
		$sql = $_POST["sqlSP"];
	 
		
		$result = mysqli_query($conn, $sql);
 
		$result_array = array();
		
		$result_array = array( ['Creation Date', 'Counsellor', 'Name', 'Register No.', 'Mobile No.', 'Date Of Birth', 'Email' , 'Address' , 'States' , 'Country' , 'School', 'Qualification' , 'Year' , 'Course' ,  'Engagement' , 'Institution' , 'Intake' , 'Batch' , 'Program' , 'ProgramLvl' ] );
		

		 while($row = mysqli_fetch_assoc($result))
		{
			$result_array[] = $row;
			
		}

header("Content-Type: text/csv");
header("Content-Disposition: attach; filename=Student.csv");
$h = fopen("php://output", "w");

foreach($result_array as $data) {
	
    fputcsv($h, $data);
}
fclose($h);

}else{
    echo "Error: ".$_POST["excelGenerateStu"];
}
?>