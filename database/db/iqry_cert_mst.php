<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btncertsbmt']) && (trim($_POST['btncertsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$szchrt = glb_func_chkvl($_POST['txtszchrt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	$sqrycert_mst = "SELECT certm_name from cert_mst where certm_name='$name'";
	$srscert_mst = mysqli_query($conn,$sqrycert_mst);
	$cnt_certm   = mysqli_num_rows($srscert_mst);
	if($cnt_certm < 1)
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
		$iqrycert_mst="INSERT INTO cert_mst(certm_name, certm_desc, certm_imgnm, certm_sts, certm_prty, certm_crtdon, certm_crtdby) values ('$name','$desc','$sdest','$sts','$prior','$curdt','$ses_admin')";
		$irscert_mst= mysqli_query($conn,$iqrycert_mst) or die(mysqli_error());
		if($irscert_mst==true)
		{
			if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
			{
				move_uploaded_file($ssource,$gcert_upldpth.$sdest);
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