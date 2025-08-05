<?php

include('../../connection.php');

if(isset($_POST["excelGenerate"]))
{
		$sql = $_POST["sqlSP"];
	 
		
		$result = mysqli_query($conn, $sql);
 
		$result_array = array();
		
		$result_array = array( ['Created Date', 'Counsellor', 'Name',  'IC No' , 'Mobile No.' , 'Email' ,  'Institution', 'Country', 'Intake', 'Program' , 'Level' , 'School' , 'Qualification' ,  'Year' , 'Remark'] );
		
		 while($row = mysqli_fetch_assoc($result))
		{
			$result_array[] = $row;
			
		}

header("Content-Type: text/csv");
header("Content-Disposition: attach; filename=Enrolment.csv");
$h = fopen("php://output", "w");

foreach($result_array as $data) {
	
    fputcsv($h, $data);
}
fclose($h);

}else{
    echo "Error: ".$_POST["excelGenerate"];
}
?>