<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btneachmntsbmt']) && (trim($_POST['btneachmntsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnachmntid']);
	$name = glb_func_chkvl($_POST['txtname']);
	$prior = glb_func_chkvl($_POST['txtprior']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$sdesc = addslashes(trim($_POST['txtsdesc']));
	$link = glb_func_chkvl($_POST['txtlnk']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$hdnachmntimg = glb_func_chkvl($_REQUEST['hdnachmntimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqryachmnt_mst = "SELECT achmntm_name from achmnt_mst where achmntm_name = '$name' and achmntm_id != $id";
	$srsachmnt_mst = mysqli_query($conn,$sqryachmnt_mst);
	 $cntachmntm = mysqli_num_rows($srsachmnt_mst); 
	if($cntachmntm < 1)
	{
 $uqryachmnt_mst="UPDATE achmnt_mst set achmntm_name = '$name', achmntm_sdesc = '$sdesc',achmntm_desc = '$desc', achmntm_lnk = '$link', achmntm_sts = '$sts', achmntm_prty = '$prior', achmntm_mdfdon = '$curdt', achmntm_mdfdby = '$ses_admin'";

	if(isset($_FILES['fleachmntimg']['tmp_name']) && ($_FILES['fleachmntimg']['tmp_name']!=""))
		{
			$brndmigval = funcUpldImg('fleachmntimg','achmntimg');
			if($brndmigval != "")
			{
				$achmntimgary = explode(":",$brndmigval,2);
				$achmntdest = $achmntimgary[0];					
				$achmntsource = $achmntimgary[1];	
			}							
			$uqryachmnt_mst .= ", achmntm_imgnm = '$achmntdest'";
 		}
	$uqryachmnt_mst .= " where achmntm_id = '$id'"; 
		$ursachmnt_mst = mysqli_query($conn,$uqryachmnt_mst);
		if($ursachmnt_mst == true)
		{
			if(($achmntsource!='none') && ($achmntsource!='') && ($achmntdest != ""))
			{
				$smlimgpth = $gachmnt_fldnm.$hdnachmntimg;
				if(($hdnachmntimg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($achmntsource,$gachmnt_fldnm.$achmntdest);
			}
			?>
			<script>location.href="view_detail_achievements.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_achievements.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_achievements.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
		</script>
		<?php
	}
}
?>