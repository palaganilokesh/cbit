<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnrltnshpsbmt']) && (trim($_POST['btnrltnshpsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$szchrt = glb_func_chkvl($_POST['txtszchrt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	$sqryrltnshp_mst = "SELECT rltnshpm_name from rltnshp_mst where rltnshpm_name='$name'";
	$srsrltnshp_mst = mysqli_query($conn,$sqryrltnshp_mst);
	$cnt_rltnshpm   = mysqli_num_rows($srsrltnshp_mst);
	if($cnt_rltnshpm < 1)
	{
		if(isset($_FILES['flesmlimg']['tmp_name']) && ($_FILES['flesmlimg']['tmp_name']!=""))
		{
			$simgval = funcUpldImg('flesmlimg','simg');
			if($simgval != "")
			{
				$simgary = explode(":",$simgval,2);
				$sdest = $simgary[0];
				$ssource = $simgary[1];	
			}
		}
		$iqryrltnshp_mst="INSERT INTO rltnshp_mst(rltnshpm_name, rltnshpm_desc, rltnshpm_imgnm, rltnshpm_sts, rltnshpm_prty, rltnshpm_crtdon, rltnshpm_crtdby) values ('$name','$desc','$sdest','$sts','$prior','$curdt','$ses_admin')";
		$irsrltnshp_mst= mysqli_query($conn,$iqryrltnshp_mst) or die(mysqli_error());
		if($irsrltnshp_mst==true)
		{
			if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
			{
				move_uploaded_file($ssource,$grltnshp_upldpth.$sdest);
			}
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