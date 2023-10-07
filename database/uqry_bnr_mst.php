<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
if (isset($_POST['btnebnrsbmt']) && (trim($_POST['btnebnrsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")) {
	$id = glb_func_chkvl($_POST['hdnbnrid']);
	$name = glb_func_chkvl($_POST['txtname']);
	$prior = glb_func_chkvl($_POST['txtprior']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$link = glb_func_chkvl($_POST['txtlnk']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$align = glb_func_chkvl($_POST['txtalin']);
	$hdndskimg = glb_func_chkvl($_REQUEST['hdndskimg']);
	$hdntabimg = glb_func_chkvl($_REQUEST['hdntabimg']);
	$hdnmobimg = glb_func_chkvl($_REQUEST['hdnmobimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');
	$sqrybnr_mst = "SELECT bnrm_name from bnr_mst where bnrm_name = '$name' and bnrm_id != $id";
	$srsbnr_mst = mysqli_query($conn, $sqrybnr_mst);
	$cntbnrm = mysqli_num_rows($srsbnr_mst);
	if ($cntbnrm < 1) {
		$uqrybnr_mst = "UPDATE bnr_mst set bnrm_name = '$name', bnrm_desc = '$desc', bnrm_lnk = '$link',bnrm_text='$align', bnrm_sts = '$sts', bnrm_prty = '$prior', bnrm_mdfdon = '$curdt', bnrm_mdfdby = '$ses_admin'";


		if (isset($_FILES['fledskimg']['tmp_name']) && ($_FILES['fledskimg']['tmp_name'] != "")) {
			$dskdmigval = funcUpldImg('fledskimg', 'dskimg');
			if ($dskdmigval != "") {
				$dskimgary = explode(":", $dskdmigval, 2);
				$dskdest = $dskimgary[0];
				$dsksource = $dskimgary[1];
			}
			$uqrybnr_mst .= ", dskm_imgnm = '$dskdest'";

		}
			if (isset($_FILES['fletabimg']['tmp_name']) && ($_FILES['fletabimg']['tmp_name'] != "")) {

				$tabdmigval = funcUpldImg('fletabimg', 'tabimg');
				if ($tabdmigval != "") {
					$tabimgary = explode(":", $tabdmigval, 2);
					$tabdest = $tabimgary[0];
					$tabsource = $tabimgary[1];
				}
				 $uqrybnr_mst .= ", tabm_imgnm = '$tabdest'";
			}

		if (isset($_FILES['flemobimg']['tmp_name']) && ($_FILES['flemobimg']['tmp_name'] != "")) {
			$mobdmigval = funcUpldImg('flemobimg', 'mobimg');
			if ($mobdmigval != "") {
				$mobimgary = explode(":", $mobdmigval, 2);
				$mobdest = $mobimgary[0];
				$mobsource = $mobimgary[1];
			}
			$uqrybnr_mst .= ", mobm_imgnm = '$mobdest'";
		}
		$uqrybnr_mst .= " where bnrm_id = '$id'";
		$ursdsk_mst = mysqli_query($conn, $uqrybnr_mst);
		if ($ursdsk_mst == true) {
			if (($dsksource != 'none') && ($dsksource != '') && ($dskdest != "")) {
				$dskimgpth = $gbnr_fldnm . $hdndskimg;
				if (($hdndskimg != '') && file_exists($dskimgpth)) {
					unlink($dskimgpth);
				}
				move_uploaded_file($dsksource, $gbnr_fldnm . $dskdest);
			}

			if ($ursdsk_mst == true) {
				if (($tabsource != 'none') && ($tabsource != '') && ($tabdest != "")) {
					$tabimgpth = $gbnr_fldnm . $hdntabimg;
					if (($hdntabimg != '') && file_exists($tabimgpth)) {
						unlink($tabimgpth);
					}
					move_uploaded_file($tabsource, $gbnr_fldnm . $tabdest);
				}
				if ($ursdsk_mst == true) {
					if (($mobsource != 'none') && ($mobsource != '') && ($mobdest != "")) {
						$mobimgpth = $gbnr_fldnm . $hdnmobimg;
						if (($hdnmobimg != '') && file_exists($mobimgpth)) {
							unlink($mobimgpth);
						}
						move_uploaded_file($mobsource, $gbnr_fldnm . $mobdest);
					}


				}}
?>
			<script>
				location.href = "view_detail_banner.php?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $srchval; ?>";
			</script>
		<?php
		} else { ?>
			<script>
				location.href = "view_detail_banner.php?vw=<?php echo $id; ?>&sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $srchval; ?>";
			</script>
		<?php
		}
	} else { ?>
		<script>
			location.href = "view_detail_banner.php?vw=<?php echo $id; ?>&sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart; ?>";
		</script>
<?php
	}
}
?>