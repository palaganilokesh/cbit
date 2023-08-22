<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
if(isset($_POST['btnedtliamvdo']) && (trim($_POST['btnedtliamvdo']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtvdolnk']) && (trim($_POST['txtvdolnk']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl(trim($_POST['hdnliamvdoid']));
	$name = glb_func_chkvl(trim($_POST['txtname']));
	$vdolnk = glb_func_chkvl($_POST['txtvdolnk']);
	$prior = glb_func_chkvl(trim($_POST['txtprior']));
	$desc = addslashes(trim($_POST['txtdesc'])); 
	$pg = $_REQUEST['hdnpage'];
	$countstart = $_REQUEST['hdncnt'];
	$sts = $_POST['lststs'];
	$dt = date('Y-m-d h:i:s');		
	$himg = $_POST['hdnsmlimg'];
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);	
	$sts = glb_func_chkvl($_POST['lststs']);
	$hdnszchrt = glb_func_chkvl($_REQUEST['hdnszimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqryliamvdo_mst ="SELECT liamvdom_name from liamvdo_mst where liamvdom_name='$name' and liamvdom_id!=$id";
	$srsliamvdo_mst   = mysqli_query($conn,$sqryliamvdo_mst);
	$rowsliamvdo_mst  = mysqli_num_rows($srsliamvdo_mst);
	if($rowsliamvdo_mst < 1)
	{
		$uqryliamvdo_mst= "UPDATE liamvdo_mst set liamvdom_name='$name', liamvdom_vdolnk='$vdolnk', liamvdom_sts='$sts', liamvdom_desc='$desc', liamvdom_prty ='$prior', liamvdom_mdfdon ='$dt', liamvdom_mdfdby='$cur_sesadmin' where liamvdom_id=$id";
		$ursliamvdo_mst = mysqli_query($conn,$uqryliamvdo_mst);
		if($ursliamvdo_mst==true)
		{ ?>
			<script>location.href="view_liamvdo_details.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_liamvdo_details.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_liamvdo_details.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";</script>
		<?php
	}
}
?>