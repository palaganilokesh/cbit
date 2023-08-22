<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
if(isset($_POST['btnedtcert']) && (trim($_POST['btnedtcert']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['hdncertid']) && (trim($_POST['hdncertid']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl(trim($_POST['hdncertid']));
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
	$sqrycert_mst ="SELECT certm_name from cert_mst where certm_name='$name' and certm_id!=$id";
	$srscert_mst   = mysqli_query($conn,$sqrycert_mst);
	$rowscert_mst  = mysqli_num_rows($srscert_mst);
	if($rowscert_mst < 1)
	{
		$uqrycert_mst= "UPDATE cert_mst set  certm_name='$name', certm_sts='$sts', certm_desc='$desc', certm_prty ='$prior', certm_mdfdon ='$dt', certm_mdfdby='$cur_sesadmin'";
		if(isset($_FILES['flesmlimg']['tmp_name']) && ($_FILES['flesmlimg']['tmp_name']!=""))
		{
			$simgval = funcUpldImg('flesmlimg','simg');
			if($simgval != "")
			{
				$simgary = explode(":",$simgval,2);
				$sdest = $simgary[0];					
				$ssource = $simgary[1];	
			}
			$uqrycert_mst .= ", certm_imgnm = '$sdest'";
		}
		$uqrycert_mst .= " where certm_id=$id";
		$urscert_mst = mysqli_query($conn,$uqrycert_mst);
		if($urscert_mst==true)
		{
			if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
			{ 
				$smlimgpth = $gcert_upldpth.$himg;
				if(($himg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($ssource,$gcert_upldpth.$sdest);
			}
			?>
			<script>location.href="view_cert_details.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_cert_details.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_cert_details.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";</script>
		<?php
	}
}
?>