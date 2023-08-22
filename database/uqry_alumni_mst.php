<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnealumnisbmt']) && (trim($_POST['btnealumnisbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnalumniid']);
	$name = glb_func_chkvl($_POST['txtname']);
	
	$prior = glb_func_chkvl($_POST['txtprior']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$link = glb_func_chkvl($_POST['txtlnk']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);
    $batch = glb_func_chkvl($_POST['txtbatch']);
    $job = glb_func_chkvl($_POST['txtjob']);
	
	$hdnalumniimg = glb_func_chkvl($_REQUEST['hdnalumniimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqryalumni_mst = "SELECT alumnim_name from alumni_mst where alumnim_name = '$name' and alumnim_id != $id";
	$srsalumni_mst = mysqli_query($conn,$sqryalumni_mst);
	$cntalumnim = mysqli_num_rows($srsalumni_mst);
	if($cntalumnim < 1)
	{
		$uqryalumni_mst="UPDATE alumni_mst set alumnim_name = '$name', alumnim_desc = '$desc', alumnim_lnk = '$link',alumnim_batch = '$batch',alumnim_job = '$job', alumnim_sts = '$sts', alumnim_prty = '$prior', alumnim_mdfdon = '$curdt', alumnim_mdfdby = '$ses_admin'";
		if(isset($_FILES['flealumniimg']['tmp_name']) && ($_FILES['flealumniimg']['tmp_name']!=""))
		{
			$brndmigval = funcUpldImg('flealumniimg','alumniimg');
			if($brndmigval != "")
			{
				$alumniimgary = explode(":",$brndmigval,2);
				$alumnidest = $alumniimgary[0];					
				$alumnisource = $alumniimgary[1];	
			}							
			$uqryalumni_mst .= ", alumnim_imgnm = '$alumnidest'";
 		}
		$uqryalumni_mst .= " where alumnim_id = '$id'";
        // echo $uqryalumni_mst;exit;
		$ursalumni_mst = mysqli_query($conn,$uqryalumni_mst);
		if($ursalumni_mst == true)
		{
			if(($alumnisource!='none') && ($alumnisource!='') && ($alumnidest != ""))
			{
				$smlimgpth = $galumni_fldnm.$hdnalumniimg;
				if(($hdnalumniimg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($alumnisource,$galumni_fldnm.$alumnidest);
			}
			?>
			<script>location.href="view_detail_alumni.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_alumni.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_alumni.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
		</script>
		<?php
	}
}
?>