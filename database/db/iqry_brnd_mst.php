<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnprodbrndsbmt']) && (trim($_POST['btnprodbrndsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$szchrt = glb_func_chkvl($_POST['txtszchrt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	$sqrybrnd_mst = "SELECT brndm_name from brnd_mst where brndm_name='$name'";
	$srsbrnd_mst = mysqli_query($conn,$sqrybrnd_mst);
	$cnt_brndm   = mysqli_num_rows($srsbrnd_mst);
	if($cnt_brndm < 1)
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
		$iqrybrnd_mst="INSERT INTO brnd_mst(brndm_name, brndm_desc, brndm_imgnm, brndm_sts, brndm_prty, brndm_crtdon, brndm_crtdby) values ('$name','$desc','$sdest','$sts','$prior','$curdt','$ses_admin')";
		$irsbrnd_mst= mysqli_query($conn,$iqrybrnd_mst) or die(mysqli_error());
		if($irsbrnd_mst==true)
		{
			if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
			{
				move_uploaded_file($ssource,$gbrnd_upldpth.$sdest);
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