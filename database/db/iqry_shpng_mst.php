<?php	
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
if(isset($_POST['btnshpngsbmt']) && (trim($_POST['btnshpngsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	/*$prior = glb_func_chkvl($_POST['txtprior']);
	$minwt = glb_func_chkvl($_POST['txtminwt']);
  $maxwt = glb_func_chkvl($_POST['txtmaxwt']);*/
  $prc = glb_func_chkvl($_POST['txtprc']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$curdt = date('Y-m-d h-i-s');
	$iqryshpng_mst="INSERT into shpng_mst(shpngm_cntryid, shpngm_prc, shpngm_desc, shpngm_sts, shpngm_crtdon, shpngm_crtdby) values ('$name', '$prc', '$desc', '$sts', '$curdt', '$ses_admin')";
	$irsshpng_mst= mysqli_query($conn,$iqryshpng_mst) or die(mysqli_error());
	if($irsshpng_mst==true)
	{
		$insert_id  = mysqli_insert_id($conn);
		$uqryshng_mst = "UPDATE shpng_mst set shpngm_sts = 'i' where shpngm_cntryid = '$name' and shpngm_id != $insert_id";
		$ursshpng_mst = mysqli_query($conn,$uqryshng_mst);
		$gmsg = "Record saved successfully";
	}
	else
	{
		$gmsg = "Record not saved";
	}
}
?>