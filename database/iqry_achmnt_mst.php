<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnachmntsbmt']) && (trim($_POST['btnachmntsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
    $sdesc = addslashes(trim($_POST['txtsdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$achmntimg = glb_func_chkvl($_POST['fleachmntimg']);
	$link = glb_func_chkvl($_POST['txtlnk']);
	$sts = glb_func_chkvl($_POST['lststs']);
	
	$curdt = date('Y-m-d h-i-s');
	$sqryachmnt_mst = "SELECT achmntm_name from achmnt_mst where achmntm_name ='$name'";
	$srsachmnt_mst = mysqli_query($conn,$sqryachmnt_mst);
	$rows = mysqli_num_rows($srsachmnt_mst);
	if($rows < 1)
	{
		if(isset($_FILES['fleachmntimg']['tmp_name']) && ($_FILES['fleachmntimg']['tmp_name']!=""))
		{
			$achmntimgval = funcUpldImg('fleachmntimg','achmntimg');
			if($achmntimgval != "")
			{
				$achmntimgary = explode(":",$achmntimgval,2);
				$achmntdest = $achmntimgary[0];
				$achmntsource = $achmntimgary[1];
			}
		}
		$iqryachmnt_mst="INSERT into achmnt_mst(achmntm_name,achmntm_sdesc, achmntm_desc, achmntm_lnk, achmntm_prty, achmntm_sts, achmntm_imgnm, achmntm_crtdon, achmntm_crtdby) values ('$name', '$sdesc','$desc', '$link', '$prior', '$sts', '$achmntdest', '$curdt', '$ses_admin')";
		$irsachmnt_mst= mysqli_query($conn,$iqryachmnt_mst) or die(mysqli_error($conn));
		if($irsachmnt_mst==true)
		{
			if(($achmntsource!='none') && ($achmntsource!='') && ($achmntdest != ""))
			{ 			
				move_uploaded_file($achmntsource,$gachmnt_fldnm.$achmntdest);					
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