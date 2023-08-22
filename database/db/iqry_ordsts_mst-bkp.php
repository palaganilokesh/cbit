<?php	
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_connection.php"; //Making database Connection	
include_once "../includes/inc_usr_functions.php"; //Use function for validation and more
if(isset($_POST['btnordstssbmt']) && (trim($_POST['btnordstssbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$cur_dt = date('Y-m-d h:i:s');
	 $sqryordsts_mst = "SELECT ordstsm_name from ordsts_mst where ordstsm_name='$name'";
	$srsordsts_mst   = mysqli_query($conn,$sqryordsts_mst);
	$rowsordsts_mst  = mysqli_num_rows($srsordsts_mst);		
	if($rowsordsts_mst < 1)
	{
		$iqryordsts_mst = "INSERT into ordsts_mst( ordstsm_name, ordstsm_desc, ordstsm_sts, ordstsm_prty, ordstsm_crtdon, ordstsm_crtdby) values ('$name', '$desc', '$sts', $prior, '$cur_dt', '$ses_admin')";
		$irsveh_type_mst = mysqli_query($conn,$iqryordsts_mst) or die (mysqli_error());
		if($irsveh_type_mst == true)
		{
			$gmsg = "Record saved successfully";
		}
		else
		{
			$gmsg = "Record not saved";
		}
	}
	else
	{
		$gmsg = "Duplicate name. Record not saved";
	}
}
?>