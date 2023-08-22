<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btneshpngsbmt']) && (trim($_POST['btneshpngsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnbnrid']);
	$name = glb_func_chkvl($_POST['txtname']);
	$prior = glb_func_chkvl($_POST['txtprior']);
	$desc = addslashes(trim($_POST['txtdesc']));
  $prc = addslashes(trim($_POST['txtprc']));
	$link = glb_func_chkvl($_POST['txtminwt']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$maxwt = glb_func_chkvl($_REQUEST['txtmaxwt']);
  $minwt = glb_func_chkvl($_REQUEST['txtminwt']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');

		$uqrybnr_mst="UPDATE shpng_mst set shpngm_cntryid = '$name', shpngm_minwt = '$minwt', shpngm_maxwt = '$maxwt', shpngm_prc = '$prc', shpngm_prty = '$prior', shpngm_sts = '$sts',shpngm_desc = '$desc', shpngm_mdfdon = '$curdt', shpngm_mdfdby = '$ses_admin'";
		$uqrybnr_mst .= " where shpngm_id = '$id'";
    //exit;
   
		$ursbnr_mst = mysqli_query($conn,$uqrybnr_mst);
		if($ursbnr_mst == true)
		{
			
			?>
			<script>location.href="view_all_shpng.php?sts=y";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_all_shpng.php?sts=n";</script>
			<?php
		}

}
?>