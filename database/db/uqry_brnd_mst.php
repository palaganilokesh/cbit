<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
if(isset($_POST['btnedtbrnd']) && (trim($_POST['btnedtbrnd']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['hdnbrndid']) && (trim($_POST['hdnbrndid']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl(trim($_POST['hdnbrndid']));
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
	$sqrybrnd_mst ="SELECT brndm_name from brnd_mst where brndm_name='$name' and brndm_id!=$id";
	$srsbrnd_mst   = mysqli_query($conn,$sqrybrnd_mst);
	$rowsbrnd_mst  = mysqli_num_rows($srsbrnd_mst);
	if($rowsbrnd_mst < 1)
	{
		$uqrybrnd_mst= "UPDATE brnd_mst set  brndm_name='$name', brndm_sts='$sts', brndm_desc='$desc', brndm_prty ='$prior', brndm_mdfdon ='$dt', brndm_mdfdby='$cur_sesadmin'";
		if(isset($_FILES['flesmlimg']['tmp_name']) && ($_FILES['flesmlimg']['tmp_name']!=""))
		{
			$simgval = funcUpldImg('flesmlimg','simg');
			if($simgval != "")
			{
				$simgary = explode(":",$simgval,2);
				$sdest = $simgary[0];					
				$ssource = $simgary[1];	
			}
			$uqrybrnd_mst .= ", brndm_imgnm = '$sdest'";
		}
		$uqrybrnd_mst .= " where brndm_id=$id";
		$ursbrnd_mst = mysqli_query($conn,$uqrybrnd_mst);
		if($ursbrnd_mst==true)
		{
			if(($ssource!='none') && ($ssource!='') && ($sdest != ""))
			{ 
				$smlimgpth = $gbrnd_upldpth.$himg;
				if(($himg != '') && file_exists($smlimgpth))
				{
					unlink($smlimgpth);
				}
				move_uploaded_file($ssource,$gbrnd_upldpth.$sdest);
			}
			?>
			<script>location.href="view_brand_details.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_brand_details.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_brand_details.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";</script>
		<?php
	}
}
?>