<?php 
	
   $inc = 1;
   
   $sql = mysqli_query($conn, "SELECT A.Name, A.MobileNo, B.Des, A.EngageStatus FROM tblstudent A LEFT JOIN cfgcounsellor B ON A.Counsellors = B.code WHERE A.Id='" . $_GET['stuId'] . "'");
   $r = mysqli_fetch_array($sql, MYSQLI_ASSOC);



   if (isset($_POST['btnSave'])) { 

      $Msg = '';
      $TotalRec = $_POST['TotalRec'];

      for ($i = 1; $i <= $TotalRec; $i++) {
         $varAId = $_POST['txtId' . $i];
         $varWay = mysqli_real_escape_string($conn, $_POST['txtConnectWay' . $i]);
         $varFollow1 = mysqli_real_escape_string($conn, $_POST['txtFollowA' . $i]);
         $varFollow2 = mysqli_real_escape_string($conn, $_POST['txtFollowB' . $i]);
         $varFollow3 = mysqli_real_escape_string($conn, $_POST['txtFollowC' . $i]);
         $varFinal = mysqli_real_escape_string($conn, $_POST['dropFinal' . $i]);

         $varFollow4 = str_replace('/', '-', $_POST['dropFollowD' . $i]);
         $varFollow4 = date('Y-m-d', strtotime($varFollow4));
         $varFollow4 = mysqli_real_escape_string($conn, $varFollow4);

         $add = "";
         if ($varAId == "0") {
            if ($varWay != "" || $varFollow1 != "" || $varFollow2 != "" || $varFollow3 != "" || $varFollow4 != "" || $varFinal != "") {
               $add = "INSERT INTO tblfollowup (StudentId, ConnectWay, Follow1, Follow2, Follow3, Follow4, Final) ";
               $add .= "VALUES ('" . $_GET['stuId'] . "', '$varWay', '$varFollow1', '$varFollow2', '$varFollow3', '$varFollow4', '$varFinal')";
            }
         } else {
            $add = "UPDATE tblfollowup SET ConnectWay='$varWay', Follow1='$varFollow1', Follow2='$varFollow2', Follow3='$varFollow3', Follow4='$varFollow4', Final='$varFinal', LastUpdDt=now() ";
            $add .= "WHERE StudentId='" . $_GET['stuId'] . "' AND id='$varAId'";
         }

         if ($add != "") {
            $result = mysqli_query($conn, $add);
          
            if (!$result) {
               $Msg = "[Insert failed]";
            }
         }
      }

      $query = $conn->query("CALL spUpd_StudentEngage(" . $_GET['stuId'] . ",@oStatus, @oMsg)");

      if (mysqli_more_results($conn)) {
         mysqli_next_result($conn);
      }

      $results = $conn->query('SELECT @oStatus, @oMsg') or die("Error in.." . mysqli_error($conn));
      $row = $results->fetch_assoc();
      $errMsg = $row['@oMsg'];
      $OutputStatus = $row['@oStatus'];

	  echo $_GET['stuId'];
      if ($OutputStatus == 0) {
         $err1 = "";
      } else {
         $err1 = "<font color='red'>[failed] This process cannot continue to proceed due to: </br>" . $errMsg . "</font>";
      }

      if ($Msg != "") {
         $err = "<font color='red'>[failed] Update record fail ! </font>";
      } else {
         $err = "[updated successfully] The record(s) have been updated.";
         $chk = mysqli_query($conn, "SELECT EngageStatus FROM tblstudent WHERE Id='" . $_GET['stuId'] . "'");
         $r = mysqli_fetch_array($chk);

		if ($r["EngageStatus"] == "S")
		{
		echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=add_enrolment&stuId='. $_GET['stuId'].'";</script>';
		}else
		{
		echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=add_followup&stuId='. $_GET['stuId'].'";</script>';
		}
      }
   } 
?>


<div id="content"></div>

<h1 class="page-header"><div id="lbltitle" >Follow Up</div> </h1>
<form method="post" autocomplete="off" novalidate="novalidate">
	
	<div class="row">
		<div class="errmsg"><?php echo  @$err;?></div>
		<div class="errmsg"><?php echo  @$err1;?></div>
	</div>
	
	<div class="row" style="margin-top:10px; margin-left: 0%;">
		<div class="col-sm-4">Student</div>
		<div class="col-sm-5">
			<input type="text" class="form-control" style="width: 90%;"  name="txtStudent" value="<?php echo $r["Name"]; ?>"  title="Name display only"  readonly /> 
		</div>
	</div>
	
	<div class="row" style="margin-top:10px; margin-left: 0%;">
		<div class="col-sm-4">Mobile No.</div>
		<div class="col-sm-5">
		<input type="text" class="form-control" style="width: 90%;" value="<?php echo $r["MobileNo"]; ?>"  name="txtMobileNo" readonly /> 
		</div>
	</div>
	
	<div class="row" style="margin-top:10px; margin-left: 0%;">
		<div class="col-sm-4">Counsellors</div>
		<div class="col-sm-5">
		<input type="text" class="form-control" style="width: 90%;" value="<?php echo $r["Des"]; ?>" name="txtCounsellor" readonly /> 
		</div>
	</div>
		
		<hr />
		
		<table class="table table-bordered">
		<?php

		$sql = "SELECT * FROM tblfollowup A WHERE A.StudentId='" . $_GET['stuId'] . "'";
			
		//echo $sql;
		$retval = mysqli_query($conn,$sql);
		
		 
         if(! $retval )
		  {
            die('Could not get data : ' . mysqli_error());
         }
         	
		 echo "<tr class=\*active*\ style='border:hidden'>";
		 echo "<table id=\"sortedtable\" class=\"table table-bordered\" cellspacing=\"0\">\n";
		 echo "<thead>\n<tr>";
		 echo "<th id=\"headerSortUp\" width='3%'>No.</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Creation Date</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Ways of Connect</th>";
		 echo "<th id=\"headerSortUp\" width='15%'>Follow up 1</th>";
		 echo "<th id=\"headerSortUp\" width='15%'>Follow up 2</th>";
		 echo "<th id=\"headerSortUp\" width='15%'>Follow up 3</th>";
		 echo "<th id=\"headerSortUp\" width='15%'>Reminder</th>";
		 echo "<th id=\"headerSortUp\" width='8%'>Final Action</th>";
		 echo "</tr>\n</thead>\n";
		 echo "</tr>";
		 
			while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
			{
				
				$selUrg = (isset($row['Final']) && $row['Final'] == "Urgent") ? ' selected="selected"' : '';
				$selAct = (isset($row['Final']) && $row['Final'] == "Active") ? ' selected="selected"' : '';
				$selNfu = (isset($row['Final']) && $row['Final'] == "Nofollowup") ? ' selected="selected"' : '';
				$selSuc = (isset($row['Final']) && $row['Final'] == "Successful") ? ' selected="selected"' : '';
				
				echo '<input type="hidden" name="txtId'.$inc.'" value="'.$row['Id'].'">';
				
				echo "<Tr>";
				echo "<td data-label='No.'>".$inc."</td>";
				echo "<td data-label='Creation Date'>".date("m/d/Y h:i:s a" , strtotime($row['CreationDate']))."</td>";
				echo "<td data-label='Ways of Connect'><input type='text' name='txtConnectWay".$inc."' class='form-control' value=".$row['ConnectWay']."></td>";
				echo "<td data-label='Follow up 1'><textarea name='txtFollowA".$inc."' class='form-control' >".$row['Follow1']."</textarea></td>";
				echo "<td data-label='Follow up 2'><textarea name='txtFollowB".$inc."' class='form-control' >".$row['Follow2']."</textarea></td>";
				echo "<td data-label='Follow up 3'><textarea name='txtFollowC".$inc."' class='form-control' >".$row['Follow3']."</textarea></td>";
				echo "<td data-label='Reminder'>
					<input type='text' class='datepicker form-control' id='dtPick2".$inc."' name='dropFollowD".$inc."' 
					value='".date("d-m-Y", strtotime($row['Follow4']))."' style='width:50%; margin-right:1%; display:inline;' autocomplete='off'><span class='glyphicon glyphicon-calendar' ></span></div> 
				</td>";	
				echo "<td data-label='Final Action'>
				<select name='dropFinal".$inc."' class='form-control'>
					<option value=''  ></option>
					<option value='Urgent' ".$selUrg."> Urgent </option>
					<option value='Active' ".$selAct."> Active </option>
					<option value='Nofollowup' ".$selNfu."> No follow up </option>
					<option value='Successful' ".$selSuc."> Successful </option>
				</select>
				</td>";
				
		echo "</Tr>";
		$inc++;
		}
		
		if  ( $r["EngageStatus"] == "A" || ! isset($r["EngageStatus"]) ||   $r["EngageStatus"] == "" ) 
		{
			echo '<input type="hidden" name="txtId'.$inc.'" value="0">';
	
				echo "<Tr>";
				echo "<td data-label='No.'>".$inc."</td>";
				echo "<td data-label='Creation Date'><input type='text' name='txtDate".$inc."' class='form-control' placeholder='system::time' Readonly/></td>";
				echo "<td data-label='Ways of Connect'><input type='text' name='txtConnectWay".$inc."' class='form-control'/></td>";
				echo "<td data-label='Follow up 1'><textarea name='txtFollowA".$inc."' class='form-control' ></textarea></td>";
				echo "<td data-label='Follow up 2'><textarea name='txtFollowB".$inc."' class='form-control' ></textarea></td>";
				echo "<td data-label='Follow up 3'><textarea name='txtFollowC".$inc."' class='form-control' ></textarea></td>";
				echo "<td data-label='Reminder: '>
					<input type='text' class='datepicker form-control' id='dtPick2".$inc."' name='dropFollowD".$inc."' style='width:50%; margin-right:1%; display:inline;' autocomplete='off'><span class='glyphicon glyphicon-calendar' ></span></div> 
				</td>";
				echo "<td data-label='Final Action'>
				<select name='dropFinal".$inc."' class='form-control'>
					<option value=''  ></option>
					<option value='Urgent' > Urgent </option>
					<option value='Active' > Active </option>
					<option value='Nofollowup' > No follow up </option>
					<option value='Successful' > Successful </option>
				</select>
				</td>";
				
				echo "</Tr>";
				
		}
		else {
			$inc--;
		}
			echo "</table><br />\n";
			echo '<input type="hidden" name="TotalRec" value="'.$inc.'">';
		
		?>
			</table>

		</table>
		</div>

	<div class="row" style="margin-top:10px">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
		<div class="btnMain">
		<input type="submit" value="Add" name="btnSave" class="btn btn-success"/>
		<input type="reset" class="btn btn-success"/>
		</div>
		</div>
	</div>
</form>	
