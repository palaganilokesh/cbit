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
	$dskimg = glb_func_chkvl($_POST['fledskimg']);
	$tabimg = glb_func_chkvl($_POST['fletabimg']);
	$mobimg = glb_func_chkvl($_POST['flemobimg']);
	$link = glb_func_chkvl($_POST['txtlnk']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$align = glb_func_chkvl($_POST['txtalin']);
	$curdt = date('Y-m-d h-i-s');
	$sqrybnr_mst = "SELECT bnrm_name from bnr_mst where bnrm_name ='$name'";
	$srsbnr_mst = mysqli_query($conn,$sqrybnr_mst);
	$rows = mysqli_num_rows($srsbnr_mst);
	if($rows < 1)
	{
		if(isset($_FILES['fledskimg']['tmp_name']) && ($_FILES['fledskimg']['tmp_name']!=""))
		{
			$dskimgval = funcUpldImg('fledskimg','dskimg');
			if($dskimgval != "")
			{
				$dskimgary = explode(":",$dskimgval,2);
				$dskdest = $dskimgary[0];
				$dsksource = $dskimgary[1];
			}
		}
		if(isset($_FILES['fletabimg']['tmp_name']) && ($_FILES['fletabimg']['tmp_name']!=""))
		{
			$tabimgval = funcUpldImg('fletabimg','tabimg');
			if($tabimgval != "")
			{
				$tabimgary = explode(":",$tabimgval,2);
				$tabdest = $tabimgary[0];
				$tabsource = $tabimgary[1];
			}
		}
		if(isset($_FILES['flemobimg']['tmp_name']) && ($_FILES['flemobimg']['tmp_name']!=""))
		{
			$mobimgval = funcUpldImg('flemobimg','mobimg');
			if($mobimgval != "")
			{
				$mobimgary = explode(":",$mobimgval,2);
				$mobdest = $mobimgary[0];
				$mobsource = $mobimgary[1];
			}
		}
		$iqrybnr_mst="INSERT into bnr_mst(bnrm_name, bnrm_desc, bnrm_lnk,bnrm_text, bnrm_prty, bnrm_sts, dskm_imgnm, tabm_imgnm, mobm_imgnm, bnrm_crtdon, bnrm_crtdby) values ('$name', '$desc', '$link','$align', '$prior', '$sts', '$dskdest','$tabdest','$mobdest', '$curdt', '$ses_admin')";
		$irsbnr_mst= mysqli_query($conn,$iqrybnr_mst) or die(mysqli_error($conn));
		if($irsbnr_mst==true)
		{
			if(($dsksource!='none') && ($dsksource!='') && ($dskdest != ""))
			{
				move_uploaded_file($dsksource,$gbnr_fldnm.$dskdest);
			}
			if(($tabsource!='none') && ($tabsource!='') && ($tabdest != ""))
			{
				move_uploaded_file($tabsource,$gbnr_fldnm.$tabdest);
			}
			if(($mobsource!='none') && ($mobsource!='') && ($mobdest != ""))
			{
				move_uploaded_file($mobsource,$gbnr_fldnm.$mobdest);
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
