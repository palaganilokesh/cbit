<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if(isset($_POST['btnedtuser']) && (trim($_POST['btnedtuser']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnbnrid']);//id
	$name = glb_func_chkvl($_POST['txtname']);//name

	$dept_id = glb_func_chkvl($_POST['lstprodcat']);//department id
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);//status
	$typ = glb_func_chkvl($_POST['txttyp']);//type college or department
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqrylgn_mst = "SELECT lgnm_uid from lgn_mst where lgnm_uid = '$name' and lgnm_id != $id";
	$srslgn_mst = mysqli_query($conn,$sqrylgn_mst);
	$cntbnrm = mysqli_num_rows($srslgn_mst);
	if($cntbnrm < 1)
	{
    // lgnm_dept_id='$dept_id',
		$uqrylgn_mst="UPDATE lgn_mst set lgnm_uid = '$name', lgnm_typ = '$typ', lgnm_sts = '$sts', lgnm_mdfdon = '$curdt', lgnm_mdfdby = '$ses_admin'";

		$uqrylgn_mst .= " where lgnm_id = '$id'";
		$urslgn_mst = mysqli_query($conn,$uqrylgn_mst);
		if($urslgn_mst == true)
		{

			?>
			<script>location.href="view_detail_users.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_users.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_users.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";
		</script>
		<?php
	}
}
?>