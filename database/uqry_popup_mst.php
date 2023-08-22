<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnepopupsbmt']) && (trim($_POST['btnepopupsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnpopupid']);
	$name = glb_func_chkvl($_POST['txtname']);
	
	$prior = glb_func_chkvl($_POST['txtprior']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$link = glb_func_chkvl($_POST['txtlnk']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	
	$hdnpopupimg = glb_func_chkvl($_REQUEST['hdnpopupimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqrypopup_mst = "SELECT popupm_name from popup_mst where popupm_name = '$name' and popupm_id != $id";
	$srspopup_mst = mysqli_query($conn,$sqrypopup_mst);
	$cntpopupm = mysqli_num_rows($srspopup_mst);
	if($cntpopupm < 1)
	{
		$uqrypopup_mst="UPDATE popup_mst set popupm_name = '$name', popupm_desc = '$desc', popupm_lnk = '$link', popupm_sts = '$sts', popupm_prty = '$prior', popupm_mdfdon = '$curdt', popupm_mdfdby = '$ses_admin'";
		if(isset($_FILES['flepopupimg']['tmp_name']) && ($_FILES['flepopupimg']['tmp_name']!=""))
		{
			$brndmigval = funcUpldImg('flepopupimg','popupimg');
			if($brndmigval != "")
			{
				$popupimgary = explode(":",$brndmigval,2);
				$popupdest = $popupimgary[0];					
				$popupsource = $popupimgary[1];	
			}							
			$uqrypopup_mst .= ", popupm_imgnm = '$popupdest'";
 		}
		$uqrypopup_mst .= " where popupm_id = '$id'";
		$urspopup_mst = mysqli_query($conn,$uqrypopup_mst);
		if($urspopup_mst == true)
		{
			if(($popupsource!='none') && ($popupsource!='') && ($popupdest != ""))
			{
				$smlimgpth = $gbnr_fldnm.$hdnpopupimg;
				if(($hdnpopupimg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($popupsource,$gbnr_fldnm.$popupdest);
			}
			?>
			<script>location.href="view_detail_popup.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_popup.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_popup.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
		</script>
		<?php
	}
}
?>