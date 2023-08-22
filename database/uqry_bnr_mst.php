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
	$align = glb_func_chkvl($_POST['txtalin']);
	$hdnbnrimg = glb_func_chkvl($_REQUEST['hdnbnrimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqrybnr_mst = "SELECT bnrm_name from bnr_mst where bnrm_name = '$name' and bnrm_id != $id";
	$srsbnr_mst = mysqli_query($conn,$sqrybnr_mst);
	$cntbnrm = mysqli_num_rows($srsbnr_mst);
	if($cntbnrm < 1)
	{
		$uqrybnr_mst="UPDATE bnr_mst set bnrm_name = '$name', bnrm_desc = '$desc', bnrm_lnk = '$link',bnrm_text='$align', bnrm_sts = '$sts', bnrm_prty = '$prior', bnrm_mdfdon = '$curdt', bnrm_mdfdby = '$ses_admin'";
		if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name']!=""))
		{
			$brndmigval = funcUpldImg('flebnrimg','bnrimg');
			if($brndmigval != "")
			{
				$bnrimgary = explode(":",$brndmigval,2);
				$bnrdest = $bnrimgary[0];					
				$bnrsource = $bnrimgary[1];	
			}							
			$uqrybnr_mst .= ", bnrm_imgnm = '$bnrdest'";
 		}
		$uqrybnr_mst .= " where bnrm_id = '$id'";
		$ursbnr_mst = mysqli_query($conn,$uqrybnr_mst);
		if($ursbnr_mst == true)
		{
			if(($bnrsource!='none') && ($bnrsource!='') && ($bnrdest != ""))
			{
				$smlimgpth = $gbnr_fldnm.$hdnbnrimg;
				if(($hdnbnrimg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($bnrsource,$gbnr_fldnm.$bnrdest);
			}
			?>
			<script>location.href="view_detail_banner.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_banner.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_banner.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
		</script>
		<?php
	}
}
?>