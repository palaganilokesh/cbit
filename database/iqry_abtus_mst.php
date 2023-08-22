<?php
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session
include_once '../includes/inc_usr_functions.php'; //Use function for validation and more	
include_once '../includes/inc_connection.php'; //Making database Connection	

if (
	isset($_POST['btnaddabtus']) && (trim($_POST['btnaddabtus']) != "") &&
	isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")
) {

	$name     = glb_func_chkvl($_POST['txtname']);
	$lnk      = glb_func_chkvl($_POST['txtlnk']);
	$prior    = glb_func_chkvl($_POST['txtprior']);
	$desc     = addslashes(trim($_POST['txtdesc']));
	$sts      = glb_func_chkvl($_POST['lststs']);
	$curdt    = date('Y-m-d h:i:s');

	$sqryabtus_mst = "select 
							abtusm_name
						from 
							abtus_mst
						where 
							abtusm_name='$name'";
	$srsabtus_mst = mysqli_query($conn, $sqryabtus_mst);
	$cnt_abtusm   = mysqli_num_rows($srsabtus_mst);
	if ($cnt_abtusm < 1) {
		if (isset($_FILES['flesmlimg']['tmp_name']) && ($_FILES['flesmlimg']['tmp_name'] != "")) {
			$simgval = funcUpldImg('flesmlimg', 'simg');
			if ($simgval != "") {
				$simgary    = explode(":", $simgval, 2);
				$sdest 		= $simgary[0];
				$ssource 	= $simgary[1];
			}
		}
		$iqryabtus_mst = "insert into abtus_mst(
						  abtusm_name,abtusm_desc,abtusm_imgnm,abtusm_lnk,
						  abtusm_prty,abtusm_sts,abtusm_crtdon,abtusm_crtdby)values(
						 '$name','$desc','$sdest','$lnk',
						 '$prior','$sts','$curdt','$admin')";
		$irsabtus_mst = mysqli_query($conn, $iqryabtus_mst);
		if ($irsabtus_mst == true) {
			if (($ssource != 'none') && ($ssource != '') && ($sdest != "")) {
				move_uploaded_file($ssource, $gabtus_fldnm . $sdest);
			}
			$gmsg = "Record saved successfully";
		} else {
			$gmsg = "Record not saved";
		}
	} else {
		$gmsg = "Duplicate  name . Record not saved";
	}
}
