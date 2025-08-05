<?php



if(isset($_POST["excelGenerate"]))
{

	$filename = "template";

		echo "Counsellors,Name,Mobile No.,Email,School,Qualification,Year,Course,IC No.,Engagement \n";
 
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=".$filename.".csv");
		header("Pragma: no-cache");
		header("Expires: 0");
}

?>