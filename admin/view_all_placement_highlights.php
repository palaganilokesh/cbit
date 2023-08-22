<?php
include_once '../includes/inc_config.php'; //Making paging validation 
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation 
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_all_placement_highlights.php
Purpose : For Viewing placement_highlights
Created By : Lokesh palagani
Created On :07-06-2023
Modified By : 
Modified On :
Company : Adroit
 ************************************************************/
global $msg, $loc, $rowsprpg, $dispmsg, $disppg;
$clspn_val = "8";
$rd_adpgnm = "add_placement.php";
$rd_edtpgnm = "edit_placement.php";
$rd_crntpgnm = "view_all_placement_highlights.php";
$rd_vwpgnm = "view_detail_placement.php";
$loc = "";
/*****header link********/
$pagemncat = "Placements";
$pagecat = "Placement Higilights";
$pagenm = "Placement Higilights";
/*****header link********/
if (isset($_POST['hdnchksts']) && (trim($_POST['hdnchksts']) != "") || isset($_POST['hdnallval']) && (trim($_POST['hdnallval']) != "")) {
	$dchkval = substr($_POST['hdnchksts'], 1);
	$id = glb_func_chkvl($dchkval);
	$chkallval = glb_func_chkvl($_POST['hdnallval']);
	$updtsts = funcUpdtAllRecSts('plcmt_mst', 'plcmtm_id', $id, 'plcmtm_sts', $chkallval);
	if ($updtsts == 'y') {
		$msg = "<font color=red>Record updated successfully</font>";
	} elseif ($updtsts == 'n') {
		$msg = "<font color=red>Record not updated</font>";
	}
}
if (($_POST['hdnchkval'] != "") && isset($_REQUEST['hdnchkval'])) {
	$dchkval = substr($_POST['hdnchkval'], 1);
	$did = glb_func_chkvl($dchkval);
	$del = explode(',', $did);
	$count = sizeof($del);
	$delsts = funcDelAllRec('plcmt_mst', 'plcmtm_id', $did);
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
$rowsprpg = 20; //maximum rows per page
include_once '../includes/inc_paging1.php'; //Includes pagination
$sqryplcmt_mst1 = "SELECT plcmtm_id,plcmtm_name,plcmtm_img,plcmtm_sts,plcmtm_prty,plcmtm_compny,plcmtm_ofer,plcmtm_pkg, plcmtm_percnt from plcmt_mst";

if (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "t")) {
	$val = trim($_REQUEST['val']);
	if (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
		$loc = "&optn=t&val=" . $val . "&chk=y";
		$sqryplcmt_mst1 .= " where plcmtm_name='$val'";
	} else {
		$loc = "&optn=t&val=" . $val;
		$sqryplcmt_mst1 .= " where plcmtm_name like '%$val%'";
	}
}
if (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "a")) {
	$val = $_REQUEST['val'];
	$loc = "&optn=a&val=" . $val . "&chka=y";
	$sqryplcmt_mst1 .= " where plcmtm_sts='$val'";
}
$sqryplcmt_mst1 = $sqryplcmt_mst1;
$sqryplcmt_mst = $sqryplcmt_mst1 . " order by plcmtm_name limit $offset, $rowsprpg";
//echo $sqryplcmt_mst; exit;
$srsplcmt_mst = mysqli_query($conn, $sqryplcmt_mst);
$cnt_recs = mysqli_num_rows($srsplcmt_mst);
include_once 'script.php';
?>
<script language="javascript">
	function addnew() {
		document.frmbnrmst.action = "<?php echo $rd_adpgnm; ?>";
		document.frmbnrmst.submit();
	}

	function chng() {
		var div1 = document.getElementById("div1");
		var div2 = document.getElementById("div2");
		if (document.frmbnrmst.lstsrchby.value == 't') {
			div1.style.display = "block";
			div2.style.display = "none";
		} else if (document.frmbnrmst.lstsrchby.value == 'a') {
			div1.style.display = "none";
			div2.style.display = "block";
		}
	}

	function validate() {
		if (document.frmbnrmst.lstsrchby.value == "") {
			alert("Please Select Search Criteria");
			document.frmbnrmst.lstsrchby.focus();
			return false;
		}
		if (document.frmbnrmst.lstsrchby.value == "t") {
			if (document.frmbnrmst.txtname.value == "") {
				alert("Please Enter Name");
				document.frmbnrmst.txtname.focus();
				return false;
			}
		}
		if (document.frmbnrmst.lstsrchby.value == "a") {
			if (document.frmbnrmst.lstprodcatname.value == "") {
				alert("Please select Any One");
				document.frmbnrmst.lstprodcatname.focus();
				return false;
			}
		}
		var optn = document.frmbnrmst.lstsrchby.value;
		if (optn == 't') {
			var val = document.frmbnrmst.txtname.value;
			if (document.frmbnrmst.chkexactt.checked == true) {
				document.frmbnrmst.action = "view_all_placement_highlights.php?optn=t&val=" + val + "&chk=y";
				document.frmbnrmst.submit();
			} else {
				document.frmbnrmst.action = "view_all_placement_highlights.php?optn=t&val=" + val;
				document.frmbnrmst.submit();
			}
		} else if (optn == 'a') {
			var val = document.frmbnrmst.lstprodcatname.value;
			document.frmbnrmst.action = "view_all_placement_highlights.php?optn=a&val=" + val;
			document.frmbnrmst.submit();
		}
		return true;
	}

	function onload() {
		<?php
		if (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 't') {
		?>
			div1.style.display = "block";
			div2.style.display = "none";
		<?php
		} elseif (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 'a') {
		?>
			div1.style.display = "none";
			div2.style.display = "block";
		<?php
		}
		?>
	}
</script>
<script language="javascript" type="text/javascript" src="../includes/chkbxvalidate.js"></script>
<link href="docstyle.css" rel="stylesheet" type="text/css">

<body onLoad="onload()">
	<?php include_once $inc_adm_hdr; ?>
	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">View All Placement Highlights</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">View All Placement Highlights</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- Default box -->
		<div class="card">
			<?php if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) { ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert" id="delids" style="display:none">
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
				<form method="post" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" name="frmbnrmst" id="frmbnrmst">
					<input type="hidden" name="hdnchkval" id="hdnchkval">
					<input type="hidden" name="hdnchksts" id="hdnchksts">
					<input type="hidden" name="hdnallval" id="hdnallval">
					<div class="col-md-12">
						<div class="row justify-content-left align-items-center mt-3">
							<div class="col-sm-7">
								<div class="form-group">
									<div class="col-8">
										<div class="row">
											<div class="col-10">
												<td width="9%">
													<select name="lstsrchby" onChange="chng()" class="form-control">
														<option value="">--Select--</option>
														<option value="t" <?php if (isset($_REQUEST['lstsrchby']) && (trim($_REQUEST['lstsrchby']) == 't')) {
																								echo 'selected';
																							} elseif (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == 't')) {
																								echo 'selected';
																							} ?>>Name</option>
														<option value="a" <?php if (isset($_REQUEST['lstsrchby']) && (trim($_REQUEST['lstsrchby']) == 'a')) {
																								echo 'selected';
																							} elseif (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == 'a')) {
																								echo 'selected';
																							} ?>>Status</option>
													</select>
												</td>
												<!-- <input type="text" name="txtname" placeholder="Search by name" id="txtname" class="form-control" value="<?php if (isset($_REQUEST['txtname']) && $_REQUEST['txtname'] != "") {
																																																																				echo $_REQUEST['txtname'];
																																																																			} ?>"> -->


												<div id="div1" <?php if ((isset($_REQUEST['optn']) &&
																					(trim($_REQUEST['optn']) == 't')) || (!isset($_REQUEST['optn']))) { ?> style="display:block" <?php  } else { ?>style="display:none" <?php } ?>>
													<input type="text" class="form-control" name="txtname" id="txtname" value="<?php
																																																			if (isset($_REQUEST['txtname']) && (trim($_REQUEST['txtname']) != "")) {
																																																				echo $_POST['txtname'];
																																																			} elseif (
																																																				isset($_REQUEST['val']) && (trim($_REQUEST['val']) != "") &&
																																																				isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "t")
																																																			) {
																																																				echo $_REQUEST['val'];
																																																			}
																																																			?>" />
													Exact
													<input type="checkbox" name="chkexactt" id="chkexactt" value="1" <?php
																																														if (isset($_POST['chkexactt']) && (trim($_POST['chkexactt']) == 1)) {
																																															echo 'checked';
																																														} elseif (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
																																															echo 'checked';
																																														}
																																														?> />





												</div>
												<div id="div2" <?php if (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == 'a')) { ?> style="display:block" <?php  } else { ?>style="display:none" <?php } ?>>
													<select name="lstprodcatname" id="lstprodcatname" class="form-control">
														<option value="">--Select--</option>
														<option value='a' <?php if ($_REQUEST['optn'] == 'a' && $_REQUEST['val'] == 'a') {
																								echo 'selected';
																							} ?>>Active</option>
														<option value='i' <?php if ($_REQUEST['optn'] == 'a' && $_REQUEST['val'] == 'i') {
																								echo 'selected';
																							} ?>>Inactive</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<!-- Exact -->
									<!-- <input type="checkbox" name="chkexact" value="1" <?php if (isset($_POST['chkexact']) && ($_POST['chkexact'] == 1)) {
																																					echo 'checked';
																																				} elseif (isset($_REQUEST['chk']) && ($_REQUEST['chk'] == 'y')) {
																																					echo 'checked';
																																				} ?>> -->
									&nbsp;&nbsp;&nbsp;
									<input type="submit" value="Search" class="btn btn-primary" name="btnsbmt" onClick="validate();">
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
									<td colspan="<?php echo $clspn_val; ?>" align='center'></td>

									<td width="7%" align="right" valign="bottom">
										<div align="right">

											<input name="btnsts" id="btnsts" type="button" class="btn btn-xs btn-primary" value="Status" onClick="updatests('hdnchksts','frmbnrmst','chksts')">
										</div>
									</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btndel" id="btndel" type="button" class="btn btn-xs btn-primary" value="Delete" onClick="deleteall('hdnchkval','frmbnrmst','chkdlt');">
										</div>
									</td>
								</tr>
								<tr>
									<td width="11%" class="td_bg"><strong>SL.No.</strong></td>
									<td width="15%" class="td_bg"><strong>Placement Year</strong></td>
									<td width="15%" class="td_bg"><strong>Companies</strong></td>
									<td width="15%" class="td_bg"><strong>Placement Offers</strong></td>
									<td width="15%" class="td_bg"><strong>Highest Package </strong></td>
									<td width="10%" class="td_bg"><strong>Of Placement</strong></td>
									<td width="6%" align="center" class="td_bg"><strong>Rank</strong></td>
									<td width="7%" align="center" class="td_bg"><strong>Edit</strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onClick="Check(document.frmbnrmst.chksts,'Check_ctr','hdnallval')"></strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_dctr" id="Check_dctr" value="yes" onClick="Check(document.frmbnrmst.chkdlt,'Check_dctr')"></strong></td>
								</tr>
								<?php
								$cnt = $offset;
								if ($cnt_recs > 0) {
									while ($srowplcmt_mst = mysqli_fetch_assoc($srsplcmt_mst)) {
										$pgval_srch = $pgnum . $loc;
										$db_subid = $srowplcmt_mst['plcmtm_id'];
										$db_subname = $srowplcmt_mst['plcmtm_name'];
										$db_cmpny= $srowplcmt_mst['plcmtm_compny'];
										$db_prty = $srowplcmt_mst['plcmtm_prty'];
										$db_sts  = $srowplcmt_mst['plcmtm_sts'];
										$db_ofr  = $srowplcmt_mst['plcmtm_ofer'];
										$db_pkg = $srowplcmt_mst['plcmtm_pkg'];
										$db_percnt = $srowplcmt_mst['plcmtm_percnt'];
										$cnt += 1;
								?>
										<tr <?php if ($cnt % 2 == 0) {
													echo "";
												} else {
													echo "";
												} ?>>
											<td><?php echo $cnt; ?></td>
											<!-- <td><?php echo $db_subid; ?></td> -->
											<td>
												<a href="<?php echo $rd_vwpgnm; ?>?vw=<?php echo $db_subid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="links"><?php echo $db_subname; ?></a>
											</td>
											<!-- <td align="left">
												<?php
												$imgnm = $db_szchrt;
												$imgpath = $gplcmt_upldpth . $imgnm;
												if (($imgnm != "") && file_exists($imgpath)) {
													echo "<img src='$imgpath' width='50pixel' height='50pixel'>";
												} else {
													echo "NA";
												}
												?>
											</td> -->
											<td align="center"><?php echo $db_cmpny; ?></td> 
											<td align="center"><?php echo $db_ofr; ?></td> 
											<td align="center"><?php echo $db_pkg; ?></td> 
											<td align="center"><?php echo $db_percnt; ?></td> 
											<td align="center"><?php echo $db_prty; ?></td>
											<td align="center">
												<a href="<?php echo $rd_edtpgnm; ?>?edit=<?php echo $db_subid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="orongelinks">Edit</a>
											</td>
											<td align="center">
												<input type="checkbox" name="chksts" id="chksts" value="<?php echo $db_subid; ?>" <?php if ($db_sts == 'a') {
																																																						echo "checked";
																																																					} ?> onClick="addchkval(<?php echo $db_subid; ?>,'hdnchksts','frmbnrmst','chksts');">
											</td>
											<td align="center">
												<input type="checkbox" name="chkdlt" id="chkdlt" value="<?php echo $db_subid; ?>">
											</td>
										</tr>
								<?php
									}
								} else {
									$msg = "<font color=red>No Records In Database</font>";
								}
								?>
								<tr>
									<td colspan="<?php echo $clspn_val; ?>">&nbsp;</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btnsts" id="btnsts" type="button" value="Status" onClick="updatests('hdnchksts','frmbnrmst','chksts')" class="btn btn-xs btn-primary">
										</div>
									</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btndel" id="btndel" type="button" value="Delete" onClick="deleteall('hdnchkval','frmbnrmst','chkdlt');" class="btn btn-xs btn-primary">
										</div>
									</td>
								</tr>
								<?php
								$disppg = funcDispPag($conn, 'links', $loc, $sqryplcmt_mst1, $rowsprpg, $cntstart, $pgnum);
								$colspanval = $clspn_val + 2;
								if ($disppg != "") {
									$disppg = "<br><tr><td colspan='$colspanval' align='center' >$disppg</td></tr>";
									echo $disppg;
								}
								if ($msg != "") {
									$dispmsg = "<tr><td colspan='$colspanval' align='center' >$msg</td></tr>";
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