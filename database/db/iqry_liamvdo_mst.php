<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnliamvdosbmt']) && (trim($_POST['btnliamvdosbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtvdolnk']) && (trim($_POST['txtvdolnk']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$vdolnk = glb_func_chkvl($_POST['txtvdolnk']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$szchrt = glb_func_chkvl($_POST['txtszchrt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	$sqryliamvdo_mst = "SELECT liamvdom_name from liamvdo_mst where liamvdom_name='$name'";
	$srsliamvdo_mst = mysqli_query($conn,$sqryliamvdo_mst);
	$cnt_liamvdom   = mysqli_num_rows($srsliamvdo_mst);
	if($cnt_liamvdom < 1)
	{
		$iqryliamvdo_mst="INSERT INTO liamvdo_mst(liamvdom_name, liamvdom_desc, liamvdom_vdolnk, liamvdom_sts, liamvdom_prty, liamvdom_crtdon, liamvdom_crtdby) values ('$name','$desc','$vdolnk','$sts','$prior','$curdt','$ses_admin')";
		$irsliamvdo_mst= mysqli_query($conn,$iqryliamvdo_mst) or die(mysqli_error());
		if($irsliamvdo_mst==true)
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