<?php 

if($UserRole != 'Adm' )
{
 echo "<script>window.location.replace('index.php');</script>";
}

$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

$readonly = ($mode == 'view') ? 'readonly' : '';

$sql = mysqli_query($conn, "select * from tbllogin A where A.Id='" . $_GET['id'] . "'");
$r = mysqli_fetch_array($sql);



extract($_POST);
if(isset($btnSave))
{

	if($txtName=="" || $txtEmail=="" )
	{
	$err="<font color='red'>[failed] fill all the fileds first</font>";	
	}
	else
	{
		if (!empty($txtPass)) {
			$txtPassA = hash('sha512', $txtPass);
			$add = "update tbllogin set UserName = '$txtName' , Email = '$txtEmail' , Password = '$txtPassA' , Counsellor = '$dropCounsellor' where id = " . $_GET['id'] . "";
		}else{

			$add = "update tbllogin set UserName = '$txtName' , Email = '$txtEmail' , Counsellor = '$dropCounsellor' where id = " . $_GET['id'] . "";
		}
		
		if ($conn->query($add) === TRUE) {
					$new_id = $conn->insert_id;
					$err="[insert successfully] The record of ".$txtName ." have been updated.";
				
					echo '<script type="text/javascript">alert("'.$err.'"); window.location.href="index.php?page=listing_loginuser";</script>';
				}
		
		else{
			$err="<font color='red'>[failed] data ".$txtName ." is not added </font>";
			}
	 }
}

?>

<h1 class="page-header">Add Login User</h1>
<form method="post">
	
	<div class="row" style="margin-top:10px">
		
		<div class="errmsg"><?php echo  @$err;?></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Name</div>
		<div class="col-sm-5">
		<input type="text" name="txtName"  value="<?php echo $r["UserName"]; ?>" class="form-control" required/></div>

	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">Counsellor</div>
		<div class="col-sm-5">
		<select name="dropCounsellor" class="form-control" >
			<option value="">Select Counsellor</option>
			<?php 
				$q1=mysqli_query($conn,"select * from cfgcounsellor where isActive ='A'");
				while($r1=mysqli_fetch_assoc($q1))
				{
					if($r1['Code'] == $r['Counsellor'] ){
					  echo "<option value='".$r1['Code']."' selected>".$r1['Des']."</option>";
					}else{
					  echo "<option value='".$r1['Code']."' >".$r1['Des']."</option>";
					}
				}
			?>
		</select>
		</div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Enter Current Password</div>
		<div class="col-sm-5">
		<input type="password" name="txtPass" class="form-control" placeholder="Leave blank to keep current password" /></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-4">* Email</div>
		<div class="col-sm-5">
		<input type="email" name="txtEmail" class="form-control" value="<?php echo $r["Email"]; ?>" required="required"/></div>
	</div>
	
	<div class="row" style="margin-top:10px">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">

	<?php if ($mode != 'view') { ?>
			<div class="btnMain">
			<input type="submit" value="Save" name="btnSave" class="btn btn-success"/>
			<input type="reset" class="btn btn-success"/>
			</div>
		<?php } ?>

		</div>
	</div>
</form>	