<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
	
if(isset($_POST['btnordstssbmt']) && (trim($_POST['btnordstssbmt']) != "") &&
  // isset($_POST['lstprodcat']) && (trim($_POST['lstprodcat']) != "") && 	
	isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && 
	isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	//$emp = $_SESSION['sesadmin'];
  $sqryprodsubcat_mst = "SELECT szm_name from sz_mst where szm_name ='$name'";
	$srsprodsubcat_mst = mysqli_query($conn,$sqryprodsubcat_mst);
	$rows = mysqli_num_rows($srsprodsubcat_mst);
	if($rows < 1)
	{
		$iqryprodsubcat_mst="INSERT INTO sz_mst(szm_name, szm_desc, szm_prty, szm_sts, szm_crtdon, szm_crtdby)values('$name','$desc','$prior','$sts','$curdt','$ses_admin')";	
		$irsprodsubcat_mst= mysqli_query($conn,$iqryprodsubcat_mst);
		if($irsprodsubcat_mst==true)
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