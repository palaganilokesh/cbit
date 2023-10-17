<?php
error_reporting(0);
session_start();
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************/
//Programm 	  : photocategory
//Purpose 	  : For Viewing New photocategory
//Created By  :Lokesh Palagani
//Created On  :	01-07-2023
//Modified By :
//Modified On :
//Company 	  : Adroit
/************************************************************/
global $msg, $loc, $rowsprpg, $dispmsg, $disppg;
/*****header link********/
$pagemncat = "Users";
$pagecat = "Users";
$pagenm = "Users";
$clspn_val = "5";
$rd_adpgnm = "add_users.php";
$rd_edtpgnm = "edit_users.php";
$rd_crntpgnm = "view_all_users.php";
$rd_vwpgnm = "view_detail_users.php";
$loc = "";
if($ses_admtyp=='wm' || $ses_admtyp=='d'){
  ?>
		<script language="javascript">
			location.href = "../admin/index.php";
		</script>
	<?php
		exit();
}
/*****header link********/
if (($_POST['hidchksts'] != "") && isset($_REQUEST['hidchksts'])) {
	$dchkval = substr($_POST['hidchksts'], 1);
	$id  	 = glb_func_chkvl($dchkval);

	$updtsts = funcUpdtAllRecSts('lgn_mst', 'lgnm_id', $id, 'lgnm_sts');
	if ($updtsts == 'y') {
		$msg = "<font color=red>Record updated successfully</font>";
	} elseif ($updtsts == 'n') {
		$msg = "<font color=red>Record not updated</font>";
	}
}

if (($_POST['hidchkval'] != "") && isset($_REQUEST['hidchkval'])) {
	$dchkval = substr($_POST['hidchkval'], 1);
	$did = glb_func_chkvl($dchkval);
	$del = explode(',', $did);
	$count = sizeof($del);
	$smlimg = array();
	$smlimgpth = array();
	for ($i = 0; $i < $count; $i++) {
		$sqryprodimgd_dtl = "SELECT phtcatm_img from lgn_mst where lgnm_id=$del[$i]";
		$srsprodimgd_dtl = mysqli_query($conn, $sqryprodimgd_dtl);
		$cntrecprodimgd_dtl = mysqli_num_rows($srsprodimgd_dtl);
		while ($srowprodimgd_dtl = mysqli_fetch_assoc($srsprodimgd_dtl)) {
			$smlimg[$i] = glb_func_chkvl($srowprodimgd_dtl['phtcatm_img']);
			$smlimgpth[$i] = $galry_fldnm . $smlimg[$i];
			for ($j = 0; $j < $cntrecprodimgd_dtl; $j++) {
				if (($smlimg[$i] != "") && file_exists($smlimgpth[$i])) {
					unlink($smlimgpth[$i]);
				}
			}
		}
	}
	$delsts = funcDelAllRec($conn, 'lgn_mst', 'lgnm_id', $did);
	if ($delsts == 'y') {
		$msg = "<font color=red>Record deleted successfully</font>";
	} elseif ($delsts == 'n') {
		$msg = "<font color=red>Record can't be deleted(child records exist)</font>";
	}
}


if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) {
	$msg = "<font color=red>Record updated successfully</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "n")) {
	$msg = "<font color=red>Record not updated</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "d")) {
	$msg = "<font color=red>Duplicate Recored Name Exists & Record Not updated</font>";
}

$rowsprpg  = 20; //maximum rows per page
include_once '../includes/inc_paging1.php'; //Includes pagination

$sqrylgn_mst1 = "SELECT lgnm_id,lgnm_uid,lgnm_dept_id,lgnm_typ, lgnm_sts from lgn_mst";
if (isset($_REQUEST['val']) && trim($_REQUEST['val']) != "") {
	$val = glb_func_chkvl($_REQUEST['val']);
	if (isset($_REQUEST['chk']) && trim($_REQUEST['chk']) == 'y') {
		$loc = "&opt=n&val=" . $val . "&chk=y";
		$sqrylgn_mst1 .= " where lgnm_uid='$val'";
	} else {
		$loc = "&opt=n&val=" . $val;
		$sqrylgn_mst1 .= " where lgnm_uid like '%$val%'";
	}
}
$sqrylgn_mst = $sqrylgn_mst1 . " order by lgnm_uid desc limit $offset,$rowsprpg";
$srslgn_mst = mysqli_query($conn, $sqrylgn_mst) or die(mysqli_error($conn));
$cnt_recs = mysqli_num_rows($srslgn_mst);

include_once 'script.php';
?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title> <?php echo $pgtl; ?></title>
	<?php include_once 'script.php'; ?>
	<script language="javascript">
		function addnew() {
			document.frmuser.action = "<?php echo $rd_adpgnm; ?>";
			document.frmuser.submit();
		}
	</script>
	<script language="javascript">
		function srch() {

			if (document.frmuser.txtsrchval.value == "") {
				alert("Please Enter Photocategory Name");
				document.frmuser.txtsrchval.focus();
				return false;
			}



			var val = document.frmuser.txtsrchval.value;
			if (document.frmuser.chkexact.checked == true) {
				document.frmuser.action = "view_all_users.php?val=" + val + "&chk=y";
				document.frmuser.submit();
			} else {
				document.frmuser.action = "view_all_users.php?val=" + val;
				document.frmuser.submit();
			}
			return true;
		}
	</script>
	<script language="javascript" type="text/javascript" src="../includes/chkbxvalidate.js"></script>
	<link href="docstyle.css" rel="stylesheet" type="text/css">

</head>

<body>
	<?php include_once $inc_adm_hdr; ?>
	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">View All Users</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">View All Users</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- Default box -->
		<div class="card">
			<?php if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) { ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert" id="delids">
					<strong>Deleted Successfully !</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php
			}
			?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert" id="updid" style="display:none">
				<strong>Updated Successfully !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="alert alert-info alert-dismissible fade show" role="alert" id="sucid" style="display:none">
				<strong>Added Successfully !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="card-body p-0">
				<form method="post" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" name="frmuser" id="frmuser">
					<input type="hidden" name="hidchkval" id="hidchkval">
					<input type="hidden" name="hidchksts" id="hidchksts">

					<div class="col-md-12">
						<div class="row justify-content-left align-items-center mt-3">
							<div class="col-sm-7">
								<div class="form-group">
									<div class="col-8">
										<div class="row">
											<div class="col-10">
												<input type="text" name="txtsrchval" placeholder="Search by name" id="txtsrchval" class="form-control" value="<?php if (isset($_REQUEST['txtsrchval']) && $_REQUEST['txtsrchval'] != "") {
																																																																				echo $_REQUEST['txtsrchval'];
																																																																			} ?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">Exact
									<input type="checkbox" name="chkexact" value="1" <?php if (isset($_POST['chkexact']) && ($_POST['chkexact'] == 1)) {
																																			echo 'checked';
																																		} elseif (isset($_REQUEST['chk']) && ($_REQUEST['chk'] == 'y')) {
																																			echo 'checked';
																																		} ?>>
									&nbsp;&nbsp;&nbsp;
									<input type="submit" value="Search" class="btn btn-primary" name="btnsbmt" onClick="srch();">
									<a href="<?php echo $rd_crntpgnm; ?>" class="btn btn-primary">Refresh</a>
									<button type="submit" class="btn btn-primary" onClick="addnew();">+ Add</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body p-0">
						<div class="table-responsive">
							<table width="100%" border="0" cellpadding="3" cellspacing="1" class="table table-striped projects">
								<tr>
									<td colspan="<?php echo $clspn_val; ?>" align='center'><?php echo $msg; ?></td>
									<td width="7%" align="center" valign="bottom">
										<div align="center">

											<input name="btnsts" id="btnsts" type="button" class="btn btn-xs btn-primary" value="Status" onClick="updatests('hidchksts','frmuser','chksts')">
										</div>
									</td>
									<td width="7%" align="center" valign="bottom">
										<div align="center">
											<input name="btndel" id="btndel" type="button" class="btn btn-xs btn-primary" value="Delete" onClick="deleteall('hidchkval','frmuser','chkdlt');">
										</div>
									</td>
								</tr>
								<tr>
									<td width="8%" class="td_bg"><strong>SL.No.</strong></td>
									<td width="25%" class="td_bg"><strong> User Name</strong></td>
									<td width="15%" class="td_bg"><strong>Type</strong></td>
									<td width="15%" class="td_bg"><strong>Department</strong></td>
									<td width="7%" align="center" class="td_bg"><strong>Edit</strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onClick="Check(document.frmuser.chksts,'Check_ctr')"></strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_dctr" id="Check_dctr" value="yes" onClick="Check(document.frmuser.chkdlt,'Check_dctr')"></strong></td>
								</tr>
								<?php
								$cnt = $offset;
								if ($cnt_recs > 0) {
									$cnt = 0;
									while ($srowlgn_mst = mysqli_fetch_assoc($srslgn_mst)) {
										$cnt += 1;
										$pgval_srch = $pgnum . $loc;
										$db_subid = $srowlgn_mst['lgnm_id'];
										$db_subname = $srowlgn_mst['lgnm_uid'];
										$db_typ = $srowlgn_mst['lgnm_typ'];
										$db_sts  = $srowlgn_mst['lgnm_sts'];
										$db_dpt  = $srowlgn_mst['lgnm_dept_id'];

								?>
										<tr <?php if ($cnt % 2 == 0) {
													echo "";
												} else {
													echo "";
												} ?>>
											<td><?php echo $cnt; ?></td>

											<td>
												<a href="<?php echo $rd_vwpgnm; ?>?vw=<?php echo $db_subid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="links"><?php echo $db_subname; ?></a>
											</td>


											<td align="left"> <?php if ($db_typ == 'wm') echo 'Website Management'; ?>
												<?php if ($db_typ == 'd') echo 'Department'; ?>
											</td>
											<td align="left">
												<?php

												$dept = "SELECT prodcatm_name,prodcatm_id from prodcat_mst where prodcatm_id='$db_dpt'";
												$res = mysqli_query($conn, $dept);
												$result = mysqli_fetch_assoc($res);
												echo $result['prodcatm_name'];
												?>
											</td>
											<td align="center">
												<a href="<?php echo $rd_edtpgnm; ?>?edit=<?php echo $db_subid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="orongelinks">Edit</a>
											</td>
											<td align="center">
												<input type="checkbox" name="chksts" id="chksts" value="<?php echo $db_subid; ?>" <?php if ($db_sts == 'a') {
																																																						echo "checked";
																																																					} ?> onClick="addchkval(<?php echo $db_subid; ?>,'hidchksts','frmuser','chksts');">
											</td>
											<td align="center">
												<input type="checkbox" name="chkdlt" id="chkdlt" value="<?php echo $db_subid; ?>">
											</td>
										</tr>
								<?php
									}
								} else {
									$nomsg = "<font color=red>No Records In Database</font>";
								}
								?>
								<tr>
									<td colspan="<?php echo $clspn_val; ?>">&nbsp;</td>
									<td width="7%" align="center" valign="bottom">
										<div align="center">
											<input name="btnsts" id="btnsts" type="button" value="Status" onClick="updatests('hidchksts','frmuser','chksts')" class="btn btn-xs btn-primary">
										</div>
									</td>
									<td width="7%" align="center" valign="bottom">
										<div align="center">
											<input name="btndel" id="btndel" type="button" value="Delete" onClick="deleteall('hidchkval','frmuser','chkdlt');" class="btn btn-xs btn-primary">
										</div>
									</td>
								</tr>
								<?php
								$disppg = funcDispPag($conn, 'links', $loc, $sqrylgn_mst1, $rowsprpg, $cntstart, $pgnum);
								$colspanval = $clspn_val + 2;
								if ($disppg != "") {
									$disppg = "<br><tr><td colspan='$colspanval' align='center' >$disppg</td></tr>";
									echo $disppg;
								}
								if ($nomsg != "") {
									$dispmsg = "<tr><td colspan='$colspanval' align='center' >$nomsg</td></tr>";
									echo $dispmsg;
								}
								?>
							</table>
						</div>
					</div>
				</form>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</section>
</body>
<?php include_once "../includes/inc_adm_footer.php"; ?>