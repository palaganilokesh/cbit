<?php
error_reporting(0);
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************/
//Programm 	  : Pagecontain.php
//Purpose 	  : Viewing Pagecontain
//Company 	  : Adroit
/************************************************************/
global $msg, $loc, $rowsprpg, $dispmsg, $disppg, $clspn_val, $rd_crntpgnm, $rd_adpgnm,
$rd_vwpgnm, $rd_edtpgnm;
$clspn_val   = "8";
$rd_adpgnm   = "add_pagecontain.php";
$rd_edtpgnm  = "edit_pagecontain.php";
$rd_crntpgnm = "view_all_pagecontain.php";
$rd_vwpgnm   = "view_pagecontain_detail.php";
/*****header link********/
$pagemncat = "Page Content";
$pagecat = "Page Contents";
$pagenm = "Page Contents";
/*****header link********/
if (($_POST['hdnchksts'] != "") && isset($_REQUEST['hdnchksts'])) {
	$dchkval = substr($_POST['hdnchksts'], 1);
	$id  	 = glb_func_chkvl($dchkval);
	$updtsts = funcUpdtAllRecSts('pgcnts_dtl', 'pgcntsd_id', $id, 'pgcntsd_sts');
	if ($updtsts == 'y') {
		$msg = "<font color=red>Record updated successfully</font>";
	} elseif ($updtsts == 'n') {
		$msg = "<font color=red>Record not updated</font>";
	}
}
if (($_POST['hdnchkval'] != "") && isset($_REQUEST['hdnchkval'])) {
	$dchkval    =  substr($_POST['hdnchkval'], 1);
	$did 	    =  glb_func_chkvl($dchkval);
	$del        =  explode(',', $did);
	$count      =  sizeof($del);
	$smlimg     =  array();
	$smlimgpth  =  array();
	//$bgimg      =  array();
	//$bgimgpth   =  array();
	$dskimg      =  array();
	$dskimgpth   =  array();
	for ($i = 0; $i < $count; $i++) {
		$sqrypgprc_dtl = "select
							   pgimgd_id
							from
							   pgimg_dtl
							where
								pgimgd_pgcntsd_id=$del[$i]";
		$srspgclr_dtl     = mysqli_query($conn, $sqrypgprc_dtl);
		$srowprodprc_dtl  = mysqli_fetch_assoc($srspgclr_dtl);
		$sqrypgimgd_dtl	  = "select
								    pgimgd_img
								 from
								    pgimg_dtl
								 where
									pgimgd_pgcntsd_id=$del[$i]";
		$srspgimgd_dtl      = mysqli_query($conn, $sqrypgimgd_dtl);
		$cntrecpgimgd_dtl   = mysqli_num_rows($srspgimgd_dtl);
		while ($srowpgimgd_dtl = mysqli_fetch_assoc($srspgimgd_dtl)) {
			$smlimg[$i]        = glb_func_chkvl($srowpgimgd_dtl['pgimgd_img']);
			$smlimgpth[$i]    = $a_phtgalspath . $smlimg[$i];
			for ($j = 0; $j < $cntrecpgimgd_dtl; $j++) {
				if (($smlimg[$i] != "") && file_exists($smlimgpth[$i])) {
					unlink($smlimgpth[$i]);
				}
			}
		}
		$sqrypgcntsd_dtl  = "SELECT
								    pgcntsd_dskimg
								 from
								    pgcnts_dtl
								 where
									pgcntsd_id=$del[$i]";
		$srspgcntsd_dtl    = mysqli_query($conn, $sqrypgcntsd_dtl);
		$cntrec_dtl = mysqli_num_rows($srspgcntsd_dtl);
		if ($cntrec_dtl > 0) {
			$srowpgcntsd_dtl = mysqli_fetch_assoc($srspgcntsd_dtl);
			$dskimg[$i]      = glb_func_chkvl($srowpgcntsd_dtl['pgcntsd_dskimg']);
			$dskimgpth[$i]   = $a_pgcnt_bnrfldnm . $dskimg[$i];
			for ($j = 0; $j < $cntrec_dtl; $j++) {
				if (($dskimg[$i] != "") && file_exists($dskimgpth[$i])) {
					unlink($dskimgpth[$i]);
				}
			}
		}
	}
	$delsts2 = funcDelAllRec($conn, 'pgvdo_dtl', 'pgvdod_pgcntsd_id', $did);
	$delsts1 = funcDelAllRec($conn, 'pgimg_dtl', 'pgimgd_pgcntsd_id', $did);
	$delsts = funcDelAllRec($conn, 'pgcnts_dtl', 'pgcntsd_id', $did);
	if ($delsts == 'y' && $delsts1 == 'y') {
		$msg   = "<font color=red>Record deleted successfully</font>";
	} elseif ($delsts == 'n' && $delsts1 == 'y') {
		$msg  = "<font color=red>Record can't be deleted(child records exist)</font>";
	}
}
if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) != '')) {
	if ($_REQUEST['sts'] == 'y') {
		$msg = "<font color=red>Record updated successfully</font>";
	} elseif ($_REQUEST['sts'] == 'n') {
		$msg = "<font color=red>Record not updated</font>";
	} elseif ($_REQUEST['sts'] == 'd') {
		$msg = "<font color=red>Duplicate Record Exists & Record Not updated</font>";
	}
}
$rowsprpg  = 20; //maximum rows per page
include_once '../includes/inc_paging1.php'; //Includes pagination
$rqst_stp      	= $rqst_arymdl[1];
$rqst_stp_attn     = explode("::", $rqst_stp);
$rqst_stp_chk      	= $rqst_arymdl[0];
$rqst_stp_attn_chk     = explode("::", $rqst_stp_chk);
if ($rqst_stp_attn_chk[0] == '2') {
	$rqst_stp      	= $rqst_arymdl[0];
	$rqst_stp_attn     = explode("::", $rqst_stp);
}

$sesvalary = explode(",", $_SESSION['sesmod']);

// if (!in_array(2, $sesvalary)) {
// 	if ($ses_admtyp != 'a' ) {
// 		header("Location:main.php");
// 		exit();
// 	}
// }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>

	<title><?php echo $pgtl; ?></title>
	<?php include_once 'script.php'; ?>
	<script language="javascript">
		function addnew() {
			location.href = "<?php echo $rd_adpgnm; ?>";
		}

		function chng() {
			var div1 = document.getElementById("div1");
			var div2 = document.getElementById("div2");
			var div3 = document.getElementById("div3");
			var div4 = document.getElementById("div4");

			if (document.frmpgcntn.lstsrchby.value == 'nm') {
				div1.style.display = "block";
				div2.style.display = "none";
				div3.style.display = "none";
				div4.style.display = "none";
			} else if (document.frmpgcntn.lstsrchby.value == 'd') {
				div1.style.display = "none";
				div2.style.display = "block";
				div3.style.display = "none";
				div4.style.display = "none";
			} else if (document.frmpgcntn.lstsrchby.value == 'catone') {
				div1.style.display = "none";
				div2.style.display = "none";
				div3.style.display = "block";
				div4.style.display = "none";
			} else if (document.frmpgcntn.lstsrchby.value == 'cattwo') {
				div1.style.display = "none";
				div2.style.display = "none";
				div3.style.display = "none";
				div4.style.display = "block";
			}

		}

		function validate() {
			if (document.frmpgcntn.lstsrchby.value == "") {
				alert("Select Search Criteria");
				document.frmpgcntn.lstsrchby.focus();
				return false;
			}
			if (document.frmpgcntn.lstsrchby.value == "nm") {
				if (document.frmpgcntn.txtsrchval.value == "") {
					alert("Enter name");
					document.frmpgcntn.txtsrchval.focus();
					return false;
				}
			}
			if (document.frmpgcntn.lstsrchby.value == "d") {
				if (document.frmpgcntn.lstdept.value == "") {
					alert("Select Department name");
					document.frmpgcntn.lstdept.focus();
					return false;
				}
			}
			if (document.frmpgcntn.lstsrchby.value == "catone") {
				if (document.frmpgcntn.lstcatone.value == "") {
					alert("Select Categoryone name");
					document.frmpgcntn.lstcatone.focus();
					return false;
				}
			}
			if (document.frmpgcntn.lstsrchby.value == "cattwo") {
				if (document.frmpgcntn.lstcattwo.value == "") {
					alert("Select Categorytwo name");
					document.frmpgcntn.lstcattwo.focus();
					return false;
				}
			}
			var optn = document.frmpgcntn.lstsrchby.value;
			if (optn == 'nm') {
				var val = document.frmpgcntn.txtsrchval.value;
				if (document.frmpgcntn.chkexact.checked == true) {
					document.frmpgcntn.action = "<?php echo $rd_crntpgnm; ?>?optn=nm&txtsrchval=" + val + "&chkexact=y";
					document.frmpgcntn.submit();
				} else {
					document.frmpgcntn.action = "<?php echo $rd_crntpgnm; ?>?optn=nm&txtsrchval=" + val;
					document.frmpgcntn.submit();
				}
			} else if (optn == 'd') {
				var lstdept = document.frmpgcntn.lstdept.value;
				document.frmpgcntn.action = "<?php echo $rd_crntpgnm; ?>?optn=d&lstdept=" + lstdept;
				document.frmpgcntn.submit();
			} else if (optn == 'catone') {
				var lstcatone = document.frmpgcntn.lstcatone.value;
				document.frmpgcntn.action = "<?php echo $rd_crntpgnm; ?>?optn=catone&lstcatone=" + lstcatone;
				document.frmpgcntn.submit();
			} else if (optn == 'cattwo') {
				var lstcattwo = document.frmpgcntn.lstcattwo.value;
				document.frmpgcntn.action = "<?php echo $rd_crntpgnm; ?>?optn=cattwo&lstcattwo=" + lstcattwo;
				document.frmpgcntn.submit();
			}
			return true;
		}

		function onload() {
			<?php
			if (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 'nm') {
			?>
				div1.style.display = "block";
				div2.style.display = "none";
				div3.style.display = "none";
				div4.style.display = "none";
			<?php
			} elseif (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 'd') {
			?>
				div1.style.display = "none";
				div2.style.display = "block";
				div3.style.display = "none";
				div4.style.display = "none";
			<?php
			} elseif (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 'catone') {
			?>
				div1.style.display = "none";
				div2.style.display = "none";
				div3.style.display = "block";
				div4.style.display = "none";
			<?php
			} elseif (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 'cattwo') {
			?>
				div1.style.display = "none";
				div2.style.display = "none";
				div3.style.display = "none";
				div4.style.display = "block";
			<?php
			}
			?>
		}
	</script>
	<script language="javascript" type="text/javascript" src="../includes/chkbxvalidate.js"></script>

</head>

<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View All
						Page Content</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">View All
							Page Content</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- Default box -->
	<div class="card">

		<form method="POST" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" name="frmpgcntn" id="frmpgcntn" onSubmit="return validate()">
			<input type="hidden" name="hdnchkval" id="hdnchkval">
			<input type="hidden" name="hdnchksts" id="hdnchksts">
			<div class="col-md-12">
				<div class="row justify-content-left align-items-center mt-3">
					<div class="col-sm-3">
						<div class="form-group">
							<div class="col-8">
								<div class="row">
									<div class="col-10">
										<select name="lstsrchby" id="lstsrchby" onChange="chng()" class="form-control">
											<option value="">--Select--</option>
											<option value="nm" <?php if (isset($_REQUEST['lstsrchby']) && trim($_REQUEST['lstsrchby']) == 'nm') {
																						echo 'selected';
																					} else if (isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'nm') {
																						echo 'selected';
																					} ?>>Name</option>
																					<option value="catone" <?php if (isset($_REQUEST['lstsrchby']) && trim($_REQUEST['lstsrchby']) == 'catone') {
																								echo 'selected';
																							} else if (isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'catone') {
																								echo 'selected';
																							} ?>>Category</option>
											<option value="cattwo" <?php if (isset($_REQUEST['lstsrchby']) && trim($_REQUEST['lstsrchby']) == 'cattwo') {
																								echo 'selected';
																							} else if (isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'cattwo') {
																								echo 'selected';
																							} ?>>Subcategory</option>
										</select>

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<div id="div1" <?php if (!isset($_REQUEST['optn']) || (trim($_REQUEST['optn']) == "nm") || (trim($_REQUEST['optn']) == "")) {
																echo "style=\"display:block\"";
															} else {
																echo "style=\"display:none\"";
															} ?>>
								<input type="text" name="txtsrchval" class="form-control" value="<?php if (isset($_REQUEST['txtsrchval']) && trim($_REQUEST['txtsrchval']) != "") {
																															echo $_REQUEST['txtsrchval'];
																														}
																														?>" id="txtsrchval">

							</div>

						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div id="div2" <?php if (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "d")) {
																echo "style=\"display:block\"";
															} else {
																echo "style=\"display:none\"";
															} ?>>
								<select name="lstdept" id="lstdept" class="form-control">
									<option value="">--Select--</option>
									<?php
									$sqrydept_mst = "select
													  deptm_id,deptm_name
												 from
													  vw_pgcnts_prodcat_prodscat_mst
												 where
													deptm_id !=''";
									if ($ses_admtyp == 'u') {
										$sqrydept_dtl = "select
															deptd_deptm_id
														from
															lgn_mst
															inner join dept_dtl on lgnm_id  = deptd_lgnm_id
														where
															deptd_lgnm_id ='$ses_adminid'";

										$srrsdept_dtl = mysqli_query($conn, $sqrydept_dtl);
										$cntrec_deptdtl = mysqli_num_rows($srrsdept_dtl);
										if ($cntrec_deptdtl > 0) {
											$srodept_drl = mysqli_fetch_assoc($srrsdept_dtl);
											$deptid = $srodept_drl['deptd_deptm_id'];
											$sqrydept_mst .= " and deptm_id = $deptid";
										}
									}
									$sqrydept_mst .= " group by
													  deptm_id
												 order by
													  deptm_name";
									$stsdept_mst = mysqli_query($conn, $sqrydept_mst);
									while ($rowsdept_mst = mysqli_fetch_assoc($stsdept_mst)) {
									?>
										<option value="<?php echo $rowsdept_mst['deptm_id']; ?>" <?php if (isset($_REQUEST['lstdept']) && trim($_REQUEST['lstdept']) == $rowsdept_mst['deptm_id']) {
																																								echo 'selected';
																																							} ?>><?php echo $rowsdept_mst['deptm_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div id="div3" <?php if (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "catone")) {
																echo "style=\"display:block\"";
															} else {
																echo "style=\"display:none\"";
															} ?>>
								<select name="lstcatone" id="lstcatone" class="form-control">
									<option value="">--Select--</option>
									<?php
									$sqrycatone_mst = "select
													  prodcatm_id,prodcatm_name
												   from
													  vw_pgcnts_prodcat_prodscat_mst
												   group by
													  prodcatm_id
												   order by
													  prodcatm_name";
									$stscatone_mst = mysqli_query($conn, $sqrycatone_mst);
									while ($rowscatone_mst = mysqli_fetch_assoc($stscatone_mst)) {
									?>
										<option value="<?php echo $rowscatone_mst['prodcatm_id']; ?>" <?php if (isset($_REQUEST['lstcatone']) && trim($_REQUEST['lstcatone']) == $rowscatone_mst['prodcatm_id']) {
																																										echo 'selected';
																																									} ?>><?php echo $rowscatone_mst['prodcatm_name']; ?>
										</option>
									<?php
									}
									?>
								</select>
							</div>


						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div id="div4" <?php if (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "cattwo")) {
																echo "style=\"display:block\"";
															} else {
																echo "style=\"display:none\"";
															} ?>>
								<select name="lstcattwo" id="lstcattwo" class="form-control">
									<option value="">--Select--</option>
									<?php
									$sqrycattwo_mst = "select
													  prodscatm_id,prodscatm_name
												 from
													  vw_pgcnts_prodcat_prodscat_mst
												 where
													prodscatm_id !=''
												 group by
													  prodscatm_id
												 order by
													  prodscatm_name";
									$stscattwo_mst = mysqli_query($conn, $sqrycattwo_mst);
									while ($rowscattwo_mst = mysqli_fetch_assoc($stscattwo_mst)) {
									?>
										<option value="<?php echo $rowscattwo_mst['prodscatm_id']; ?>" <?php if (isset($_REQUEST['lstcattwo']) && trim($_REQUEST['lstcattwo']) == $rowscattwo_mst['prodscatm_id']) {
																																											echo 'selected';
																																										} ?>><?php echo $rowscattwo_mst['prodscatm_name']; ?></option>
									<?php
									}
									?>
								</select>
							</div>

						</div>
					</div>

					<div class="col-sm-4">
						<div class="form-group">
						<strong>Exact</strong>
								<input type="checkbox" name="chkexact" id="chkexact" value="y" <?php
															if (isset($_REQUEST['chkexact']) && (trim($_REQUEST['chkexact']) == 'y')) {
																			echo 'checked';
																	}	?>>
																		<input type="submit" value="Search" class="btn btn-primary" name="btnsbmt">

								<a href="<?php echo $rd_crntpgnm; ?>" class="btn btn-primary">Refresh</a>
								<?php
								if (($rqst_stp_attn[1] == '2') || ($rqst_stp_attn[1] == '3') || ($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
								?>
									<input name="btn" type="button" class="btn btn-primary" value=" + Add" onClick="addnew()">
								<?php
								}
								?>

						</div>
					</div>

				</div>
			</div>


			<div class="card-body p-0">
				<div class="table-responsive">
					<table width="100%" border="0" cellpadding="3" cellspacing="1" class="table table-striped projects">
						<tr>
							<td colspan="<?php echo $clspn_val; ?>" align='center'><?php echo $msg; ?></td>

							<?php
							if (($rqst_stp_attn[1] == '3') || ($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
							?>
								<td width="8%" align="right" valign="bottom">
									<div align="right">
										<input name="btnsts" id="btnsts" type="button" value="Status" class="btn btn-xs btn-primary" onClick="updatests('hdnchksts','frmpgcntn','chksts')">

									</div>
								</td>
							<?php
							}

							if (($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
							?>
								<td width="8%" align="right" valign="bottom">
									<div align="right">
										<input name="btndel" id="btndel" type="button" value="Delete" class="btn btn-xs btn-primary" onClick="deleteall('hdnchkval','frmpgcntn','chkdlt');">
								</td>
							<?php
							}
							?>
						</tr>
						<tr>
							<td width="8%" class="td_bg"><strong>SL.No.</strong></td>
							<td width="28%" class="td_bg"><strong>Name</strong></td>
							<td width="15%" class="td_bg"><strong>Subcategory</strong></td>
							<td width="15%" class="td_bg"><strong>Category</strong></td>
							<td width="15%" class="td_bg"><strong> Image</strong></td>
							<td width="15%" class="td_bg"><strong>Type</strong></td>
							<td width="10%" align="center" class="td_bg"><strong>Rank</strong></td>
							<?php
							if (($rqst_stp_attn[1] == '3') || ($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
							?>
								<td width="10%" align="center" class="td_bg"><strong>Edit</strong></td>
								<td width="10%" class="td_bg" align="center"><strong>
										<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onClick="Check(document.frmpgcntn.chksts,'Check_ctr')"></strong></td>
							<?php
							}
							if (($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
							?>
								<td width="7%" class="td_bg" align="center"><strong>
										<input type="checkbox" name="Check_dctr" id="Check_dctr" value="yes" onClick="Check(document.frmpgcntn.chkdlt,'Check_dctr')"></strong></td>
							<?php
							}
							?>
						</tr>
						<!-- lok -->
						<?php
						 $sqrypgcnts_dtl1 =   "select
												pgcntsd_id,pgcntsd_name,pgcntsd_desc,pgcntsd_sts,
												pgcntsd_prty,prodcatm_name,prodscatm_name,pgcntsd_typ,pgcntsd_dskimg,pgcntsd_tabimg,pgcntsd_mobimg
										  from
												vw_pgcnts_prodcat_prodscat_mst
										  where
												pgcntsd_id	!= ''";

						// deptm_id,deptm_name,
						if ($ses_admtyp == 'u') {
							$sqrypgcnts_dtl1 .= "and pgcntsd_deptm_id = $_SESSION[sesdeptid]";
						}
						if (
							isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'nm' &&
							isset($_REQUEST['txtsrchval']) && trim($_REQUEST['txtsrchval']) != ""
						) {
							//$optn = glb_func_chkvl($_REQUEST['optn']);
							$val = glb_func_chkvl($_REQUEST['txtsrchval']);
							$loc = "&optn=nm&txtsrchval=" . $val;
							$sqrypgcnts_dtl1 .= " and pgcntsd_name";
							if (isset($_REQUEST['chkexact']) && trim($_REQUEST['chkexact']) == 'y') {
								$loc .= "&chkexact=y";
								$sqrypgcnts_dtl1 .= " ='$val'";
							} else {
								$sqrypgcnts_dtl1 .= " like '%$val%'";
							}
						} elseif (
							isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'd' &&
							isset($_REQUEST['lstdept']) && trim($_REQUEST['lstdept']) != ""
						) {
							//$optn = glb_func_chkvl($_REQUEST['optn']);
							$lstdpt = glb_func_chkvl($_REQUEST['lstdept']);
							$sqrypgcnts_dtl1 .= " and deptm_id";
							$loc = "&optn=d&lstdept=" . $lstdpt;
							$sqrypgcnts_dtl1 .= " ='$lstdpt'";
						} elseif (
							isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'catone' &&
							isset($_REQUEST['lstcatone']) && trim($_REQUEST['lstcatone']) != ""
						) {
							//$optn = glb_func_chkvl($_REQUEST['optn']);
							$lstctone = glb_func_chkvl($_REQUEST['lstcatone']);
							$sqrypgcnts_dtl1 .= " and prodcatm_id";
							$loc = "&optn=catone&lstcatone=" . $lstctone;
							$sqrypgcnts_dtl1 .= " ='$lstctone'";
						} elseif (
							isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'cattwo' &&
							isset($_REQUEST['lstcattwo']) && trim($_REQUEST['lstcattwo']) != ""
						) {
							//$optn = glb_func_chkvl($_REQUEST['optn']);
							$lstcttwo = glb_func_chkvl($_REQUEST['lstcattwo']);
							$sqrypgcnts_dtl1 .= " and prodscatm_id";
							$loc = "&optn=cattwo&lstcattwo=" . $lstcttwo;
							$sqrypgcnts_dtl1 .= " like '$lstcttwo'";
						}
						$sqrypgcnts_dtl = $sqrypgcnts_dtl1 . " order by prodcatm_name,prodscatm_name,pgcntsd_name asc
																						limit $offset,$rowsprpg";
						$srspgcnts_dtl = mysqli_query($conn, $sqrypgcnts_dtl) or die(mysqli_error($conn));
						$cnt = $offset;
						$cnt_rec = mysqli_num_rows($srspgcnts_dtl);

						if ($cnt_rec > 0) {
							while ($srowpgcnts_dtl = mysqli_fetch_assoc($srspgcnts_dtl)) {
								$cnt += 1;
								$db_pgcntsid	 = $srowpgcnts_dtl['pgcntsd_id'];
								$db_pgcntsctinm	 = $srowpgcnts_dtl['prodscatm_name'];
								$db_pgcntcatnm	 = $srowpgcnts_dtl['prodcatm_name'];
								$db_pgcntdeptnm	 = $srowpgcnts_dtl['deptm_name'];
								$db_pgcntsnm	 = $srowpgcnts_dtl['pgcntsd_name'];
								$db_pgcntsprty	 = $srowpgcnts_dtl['pgcntsd_prty'];
								$db_pgcntsts	 = $srowpgcnts_dtl['pgcntsd_sts'];
								$db_pgcntstyp	 = $srowpgcnts_dtl['pgcntsd_typ'];
						?>
								<tr <?php if ($cnt % 2 == 0) {
											echo "bgcolor='f1f6fd'";
										} else {
											echo "bgcolor='#f1f6fd'";
										} ?>>
									<td align="left" valign="top"><?php echo $cnt; ?></td>
									<td align="left" valign="top">
										<a href="<?php echo $rd_vwpgnm; ?>?edtpgcntid=<?php echo $db_pgcntsid; ?>&pg=<?php echo $pgnum; ?>&cntstart=<?php echo $cntstart . $loc; ?>" class="links"><?php echo $db_pgcntsnm; ?></a>
									</td>
									<td align="left" valign="top"><?php echo $db_pgcntsctinm; ?></td>
									<td align="left" valign="top"><?php echo $db_pgcntcatnm; ?></td>
									<td align="left" valign="top">
										<?php
										$imgnm   = $srowpgcnts_dtl['pgcntsd_dskimg'];
										$imgpath = $a_pgcnt_bnrfldnm . $imgnm;
										if (($imgnm != "") && file_exists($imgpath)) {
											echo "<img src='$imgpath' width='80pixel' height='80pixel'>";
										} else {
											echo "N.A.";
										}
										?>
									</td>
									<td align="left" valign="top"><?php echo funcDsplyCattwoTyp($db_pgcntstyp); ?> </td>
									<td align="right" valign="top"><?php echo $db_pgcntsprty; ?></td>
									<?php
									if (($rqst_stp_attn[1] == '3') || ($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
									?>
										<td align="center" valign="top">
											<a href="<?php echo $rd_edtpgnm; ?>?edtpgcntid=<?php echo $db_pgcntsid; ?>&pg=<?php echo $pgnum; ?>&cntstart=<?php echo $cntstart . $loc; ?>" class="mainlinks">Edit</a>
										</td>
										<td align="center" valign="top">
											<input type="checkbox" name="chksts" id="chksts" value="<?php echo $db_pgcntsid; ?>" <?php if ($db_pgcntsts == 'a') {
																																																							echo "checked";
																																																						} ?> onClick="addchkval(<?php echo $db_pgcntsid; ?>,'hdnchksts','frmpgcntn','chksts');">
										</td>
									<?php
									}
									if (($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
									?>
										<td align="center" valign="top">
											<input type="checkbox" name="chkdlt" id="chkdlt" value="<?php echo $db_pgcntsid; ?>">
										</td>
									<?php
									}
									?>
								</tr>
						<?php
							}
						} else {
							echo $msg = "<tr><td align='center' colspan='$clspn_val' bgcolor='#f1f6fd'><font color=red>Records is not available</font></td></tr>";
						}
						?>
						<tr>
							<?php
							if (($rqst_stp_attn[1] == '3') || ($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
							?>
								<td colspan="<?php echo $clspn_val; ?>">&nbsp;</td>
								<td width="7%" align="right" valign="bottom">
									<div align="right">
										<input name="btnsts" id="btnsts" type="button" value="Status" onClick="updatests('hdnchksts','frmpgcntn','chksts')" class="btn btn-xs btn-primary">
									</div>
								</td>
							<?php
							}
							if (($rqst_stp_attn[1] == '4') || $ses_admtyp == 'a') {
							?>
								<td width="7%" align="right" valign="bottom">
									<div align="right">
										<input name="btndel" id="btndel" type="button" value="Delete" onClick="deleteall('hdnchkval','frmpgcntn','chkdlt');" class="btn btn-xs btn-primary">
									</div>
								</td>
							<?php
							}
							?>
						</tr>
						<?php
						$disppg = funcDispPag($conn, 'links', $loc, $sqrybnr_mst1, $rowsprpg, $cntstart, $pgnum);
						$colspanval = $clspn_val + 2;
						if ($disppg != "") {
							$disppg = "<br><tr><td colspan='$colspanval' align='center' >$disppg</td></tr>";
							echo $disppg;
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