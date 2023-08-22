<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnpopupsbmt']) && (trim($_POST['btnpopupsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$link= glb_func_chkvl($_POST['txtlnk']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$popupimg = glb_func_chkvl($_POST['flepopupimg']);

	$sts = glb_func_chkvl($_POST['lststs']);
	
	$curdt = date('Y-m-d h-i-s');
	$sqrypopup_mst = "SELECT popupm_name from popup_mst where popupm_name ='$name'";
	$srspopup_mst = mysqli_query($conn,$sqrypopup_mst);
	$rows = mysqli_num_rows($srspopup_mst);
	if($rows < 1)
	{
		if(isset($_FILES['flepopupimg']['tmp_name']) && ($_FILES['flepopupimg']['tmp_name']!=""))
		{
			$popupimgval = funcUpldImg('flepopupimg','popupimg');
			if($popupimgval != "")
			{
				$popupimgary = explode(":",$popupimgval,2);
				$popupdest = $popupimgary[0];
				$popupsource = $popupimgary[1];
			}
		}
		$iqrypopup_mst="INSERT into popup_mst(popupm_name,popupm_desc, popupm_lnk, popupm_prty, popupm_sts, popupm_imgnm, popupm_crtdon, popupm_crtdby) values ('$name', '$desc', '$link', '$prior', '$sts', '$popupdest', '$curdt', '$ses_admin')";
		$irspopup_mst= mysqli_query($conn,$iqrypopup_mst) or die(mysqli_error($conn));
		if($irspopup_mst==true)
		{
			if(($popupsource!='none') && ($popupsource!='') && ($popupdest != ""))
			{ 			
				move_uploaded_file($popupsource,$gbnr_fldnm.$popupdest);					
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