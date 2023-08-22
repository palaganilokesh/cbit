<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
if(isset($_POST['btnedtbrnd']) && (trim($_POST['btnedtbrnd']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['hdnszdtlid']) && (trim($_POST['hdnszdtlid']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl(trim($_POST['hdnszdtlid']));
	$name = glb_func_chkvl(trim($_POST['txtname']));
	$szmst = glb_func_chkvl(trim($_POST['lstvrntmst']));
	$prior = glb_func_chkvl(trim($_POST['txtprior']));
	$desc = addslashes(trim($_POST['txtdesc'])); 
	$pg = $_REQUEST['hdnpage'];
	$countstart = $_REQUEST['hdncnt'];	
	$sts = $_POST['lststs'];
	$dt = date('Y-m-d h:i:s');		
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);	
	$sts = glb_func_chkvl($_POST['lststs']);
	$hdnszchrt = glb_func_chkvl($_REQUEST['hdnszimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqrybrnd_mst ="SELECT szd_name from sz_dtl where szd_name='$name' and szd_id!=$id";
	$srsbrnd_mst   = mysqli_query($conn,$sqrybrnd_mst);
	$rowsbrnd_mst  = mysqli_num_rows($srsbrnd_mst);
	if($rowsbrnd_mst < 1)
	{
		$uqrybrnd_mst= "UPDATE sz_dtl set szd_name='$name', szd_szm_id='$szmst', szd_sts='$sts', szd_desc='$desc', szd_prty ='$prior', szd_mdfdon ='$dt', szd_mdfdby='$cur_sesadmin'";
		$uqrybrnd_mst .= " where szd_id=$id";
		$ursbrnd_mst = mysqli_query($conn,$uqrybrnd_mst);
		if($ursbrnd_mst==true)
		{
			?>
			<script>location.href="view_all_sizedtl.php?vw=<?php echo $id;?>&updsts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_all_sizedtl.php?vw=<?php echo $id;?>&updsts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_all_sizedtl.php?vw=<?php echo $id;?>&updsts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";</script>
		<?php
	}
}
?>