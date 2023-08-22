<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnbnrsbmt']) && (trim($_POST['btnbnrsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$bnrimg = glb_func_chkvl($_POST['flebnrimg']);
	$link = glb_func_chkvl($_POST['txtlnk']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	$sqryadvbnr_mst = "SELECT advbnrm_name from advbnr_mst where advbnrm_name ='$name'";
	$srsadvbnr_mst = mysqli_query($conn,$sqryadvbnr_mst);
	$rows = mysqli_num_rows($srsadvbnr_mst);
	if($rows < 1)
	{
		if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name']!=""))
		{
			$bnrimgval = funcUpldImg('flebnrimg','advbnrimg');
			if($bnrimgval != "")
			{
				$bnrimgary = explode(":",$bnrimgval,2);
				$bnrdest = $bnrimgary[0];
				$bnrsource = $bnrimgary[1];
			}
		}
		$iqryadvbnr_mst="INSERT into advbnr_mst(advbnrm_name, advbnrm_desc, advbnrm_lnk, advbnrm_prty, advbnrm_sts, advbnrm_imgnm, advbnrm_crtdon, advbnrm_crtdby) values ('$name', '$desc', '$link', '$prior', '$sts', '$bnrdest', '$curdt', '$ses_admin')";
		$irsadvbnr_mst= mysqli_query($conn,$iqryadvbnr_mst) or die(mysqli_error());
		if($irsadvbnr_mst==true)
		{
			if(($bnrsource!='none') && ($bnrsource!='') && ($bnrdest != ""))
			{ 			
				move_uploaded_file($bnrsource,$gadvbnr_fldnm.$bnrdest);					
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