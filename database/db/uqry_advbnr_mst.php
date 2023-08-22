<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnebnrsbmt']) && (trim($_POST['btnebnrsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnbnrid']);
	$name = glb_func_chkvl($_POST['txtname']);
	$prior = glb_func_chkvl($_POST['txtprior']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$link = glb_func_chkvl($_POST['txtlnk']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$hdnbnrimg = glb_func_chkvl($_REQUEST['hdnbnrimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqryadvbnr_mst = "SELECT advbnrm_name from advbnr_mst where advbnrm_name = '$name' and advbnrm_id != $id";
	$srsadvbnr_mst = mysqli_query($conn,$sqryadvbnr_mst);
	$cntbnrm = mysqli_num_rows($srsadvbnr_mst);
	if($cntbnrm < 1)
	{
		$uqryadvbnr_mst="UPDATE advbnr_mst set advbnrm_name = '$name', advbnrm_desc = '$desc', advbnrm_lnk = '$link', advbnrm_sts = '$sts', advbnrm_prty = '$prior', advbnrm_mdfdon = '$curdt', advbnrm_mdfdby = '$ses_admin'";
		if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name']!=""))
		{
			$brndmigval = funcUpldImg('flebnrimg','advbnrimg');
			if($brndmigval != "")
			{
				$bnrimgary = explode(":",$brndmigval,2);
				$bnrdest = $bnrimgary[0];					
				$bnrsource = $bnrimgary[1];	
			}							
			$uqryadvbnr_mst .= ", advbnrm_imgnm = '$bnrdest'";
 		}
		$uqryadvbnr_mst .= " where advbnrm_id = '$id'";
		$ursadvbnr_mst = mysqli_query($conn,$uqryadvbnr_mst);
		if($ursadvbnr_mst == true)
		{
			if(($bnrsource!='none') && ($bnrsource!='') && ($bnrdest != ""))
			{
				$smlimgpth = $gadvbnr_fldnm.$hdnbnrimg;
				if(($hdnbnrimg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($bnrsource,$gadvbnr_fldnm.$bnrdest);
			}
			?>
			<script>location.href="view_detail_advbanner.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_advbanner.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_advbanner.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
		</script>
		<?php
	}
}
?>