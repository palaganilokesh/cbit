<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
if(isset($_POST['btnedtrltnshp']) && (trim($_POST['btnedtrltnshp']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['hdnrltnshpid']) && (trim($_POST['hdnrltnshpid']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl(trim($_POST['hdnrltnshpid']));
	$name = glb_func_chkvl(trim($_POST['txtname']));
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
	$sqryrltnshp_mst ="SELECT rltnshpm_name from rltnshp_mst where rltnshpm_name='$name' and rltnshpm_id!=$id";
	$srsrltnshp_mst   = mysqli_query($conn,$sqryrltnshp_mst);
	$rowsrltnshp_mst  = mysqli_num_rows($srsrltnshp_mst);
	if($rowsrltnshp_mst < 1)
	{
		$uqryrltnshp_mst= "UPDATE rltnshp_mst set  rltnshpm_name='$name', rltnshpm_sts='$sts', rltnshpm_desc='$desc', rltnshpm_prty ='$prior', rltnshpm_mdfdon ='$dt', rltnshpm_mdfdby='$cur_sesadmin'";
		if(isset($_FILES['flesmlimg']['tmp_name']) && ($_FILES['flesmlimg']['tmp_name']!=""))
		{
			$simgval = funcUpldImg('flesmlimg','simg');
			if($simgval != "")
			{
				$simgary = explode(":",$simgval,2);
				$sdest = $simgary[0];					
				$ssource = $simgary[1];	
			}
			$uqryrltnshp_mst .= ", rltnshpm_imgnm = '$sdest'";
		}
		$uqryrltnshp_mst .= " where rltnshpm_id=$id";
		$ursrltnshp_mst = mysqli_query($conn,$uqryrltnshp_mst);
		if($ursrltnshp_mst==true)
		{
			if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
			{ 
				$smlimgpth = $grltnshp_upldpth.$himg;
				if(($himg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($ssource,$grltnshp_upldpth.$sdest);
			}
			?>
			<script>location.href="view_rltnshp_details.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_rltnshp_details.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_rltnshp_details.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";</script>
		<?php
	}
}
?>