<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnedtphcat']) && (trim($_POST['btnedtphcat']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnbnrid']);//id
	$name = glb_func_chkvl($_POST['txtname']);//name
	$prior = glb_func_chkvl($_POST['txtprior']);//proirity
	$desc = addslashes(trim($_POST['txtdesc']));//description
	$dept_id = glb_func_chkvl($_POST['lstprodcat']);//department id
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);//status
	$typ = glb_func_chkvl($_POST['txttyp']);//type college or department
	$hdnbnrimg = glb_func_chkvl($_REQUEST['hdnbnrimg']);//image
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqryphtcat_mst = "SELECT phtcatm_name from phtcat_mst where phtcatm_name = '$name' and phtcatm_id != $id";
	$srsphtcat_mst = mysqli_query($conn,$sqryphtcat_mst);
	$cntbnrm = mysqli_num_rows($srsphtcat_mst);
	if($cntbnrm < 1)
	{
		$uqryphtcat_mst="UPDATE phtcat_mst set phtcatm_name = '$name', phtcatm_desc = '$desc', phtcatm_typ = '$typ',phtcatm_deprtmnt='$dept_id', phtcatm_sts = '$sts', phtcatm_prty = '$prior', phtcatm_mdfdon = '$curdt', phtcatm_mdfdby = '$ses_admin'";
		if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name']!=""))
		{
			$brndmigval = funcUpldImg('flebnrimg','bnrimg');
			if($brndmigval != "")
			{
				$bnrimgary = explode(":",$brndmigval,2);
				$bnrdest = $bnrimgary[0];					
				$bnrsource = $bnrimgary[1];	
			}							
			$uqryphtcat_mst .= ", phtcatm_img = '$bnrdest'";
 		}
		$uqryphtcat_mst .= " where phtcatm_id = '$id'";
		$ursphtcat_mst = mysqli_query($conn,$uqryphtcat_mst);
		if($ursphtcat_mst == true)
		{
			if(($bnrsource!='none') && ($bnrsource!='') && ($bnrdest != ""))
			{
				$smlimgpth = $galry_fldnm.$hdnbnrimg;
				if(($hdnbnrimg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($bnrsource,$galry_fldnm.$bnrdest);
			}
			?>
			<script>location.href="view_detail_photocategory.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_photocategory.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_photocategory.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
		</script>
		<?php
	}
}
?>