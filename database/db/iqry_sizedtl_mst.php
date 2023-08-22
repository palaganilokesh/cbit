<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
if(isset($_POST['btnvrntdtlsbmt']) && (trim($_POST['btnvrntdtlsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$vrntmst = glb_func_chkvl($_POST['lstvrntmst']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	//$emp = $_SESSION['sesadmin'];
  $sqryvrntdtl_mst = "SELECT  szd_name from sz_dtl where  szd_name ='$name' and szd_szm_id='$vrntmst'";
	$srsvrntdtl_mst = mysqli_query($conn,$sqryvrntdtl_mst);
	$rows = mysqli_num_rows($srsvrntdtl_mst);
	if($rows < 1)
	{
		$iqryvrntdtl_mst = "INSERT into sz_dtl(szd_name,szd_desc,szd_szm_id,szd_prty,szd_sts,szd_crtdon,szd_crtdby)values('$name','$desc','$vrntmst','$prior','$sts','$curdt','$ses_admin')";	
		$irsvrntdtl_mst= mysqli_query($conn,$iqryvrntdtl_mst) or die(mysql_error());
		if($irsvrntdtl_mst==true)
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