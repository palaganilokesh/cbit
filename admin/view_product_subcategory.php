<?php
include_once '../includes/inc_config.php'; //Making paging validation 
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation 
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_product_subcategory.php
Purpose : For Viewing Products sub category
Created By : Bharath
Created On : 25-12-2021
Modified By : 
Modified On :
Company : Adroit
 ************************************************************/
global $msg, $loc, $rowsprpg, $dispmsg, $disppg;
$clspn_val = "8";
$rd_adpgnm = "add_product_subcategory.php";
$rd_edtpgnm = "edit_product_subcategory.php";
$rd_crntpgnm = "view_product_subcategory.php";
$rd_vwpgnm = "view_detail_product_subcategory.php";
$loc = "";
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Product Group";
$pagenm = "Subcategory";
/*****header link********/
if (isset($_POST['hdnchksts']) && (trim($_POST['hdnchksts']) != "") || isset($_POST['hdnallval']) && (trim($_POST['hdnallval']) != "")) {
	$dchkval = substr($_POST['hdnchksts'], 1);
	$id = glb_func_chkvl($dchkval);
	$chkallval = glb_func_chkvl($_POST['hdnallval']);
	$updtsts = funcUpdtAllRecSts('prodscat_mst', 'prodscatm_id', $id, 'prodscatm_sts',$chkallval);
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

	$bnrimg = array();
	$bnrimgpth = array();
	for ($i = 0; $i < $count; $i++) {
		$sqryscat_mst = "SELECT prodscatm_bnrimg from prodscat_mst where prodscatm_id = $del[$i]";
		$srsscat_mst = mysqli_query($conn, $sqryscat_mst);
		$srowscat_mst = mysqli_fetch_assoc($srsscat_mst);

		$bnrimg[$i] = glb_func_chkvl($srowscat_mst['prodscatm_bnrimg']);
		$bnrimgpth[$i] = $a_scat_bnrfldnm . $bnrimg[$i];
	}
	$delsts = funcDelAllRec($conn,'prodscat_mst', 'prodscatm_id', $did);
	if ($delsts == 'y') {
		for ($i = 0; $i < $count; $i++) {

			if (($bnrimg[$i] != "") && file_exists($bnrimgpth[$i])) {
				unlink($bnrimgpth[$i]);
			}
		}
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
include_once "../includes/inc_paging1.php"; //Includes pagination

$sqryprodscat_mst1 = "select 
prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_bnrimg,
prodscatm_seotitle,prodscatm_seodesc,prodscatm_seokywrd,
prodscatm_seohone,prodscatm_seohtwo,prodscatm_typ,
prodscatm_sts,prodscatm_prty,prodscatm_prodcatm_id,
prodscatm_prodmnlnksm_id,prodcatm_id,prodcatm_name,
prodmnlnksm_id,prodmnlnksm_name
from	prodscat_mst
inner join	prodcat_mst
on		prodcat_mst.prodcatm_id=prodscat_mst.prodscatm_prodcatm_id
inner join	prodmnlnks_mst
on		prodmnlnks_mst.prodmnlnksm_id=prodscat_mst.prodscatm_prodmnlnksm_id";

if (isset($_REQUEST['lstprodmcat']) && (trim($_REQUEST['lstprodmcat']) != "")) {
	$lstprodmcat = glb_func_chkvl($_REQUEST['lstprodmcat']);
	$loc .= "&lstprodmcat=" . $lstprodmcat;
	if (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
		$sqryprodscat_mst1 .= " and prodscatm_prodmnlnksm_id = '$lstprodmcat'";
	} else {
		$sqryprodscat_mst1 .= " and prodscatm_prodmnlnksm_id like '%$lstprodmcat%'";
	}
}
if (isset($_REQUEST['lstprodcat']) && (trim($_REQUEST['lstprodcat']) != "")) {
	$lstprodcat = glb_func_chkvl($_REQUEST['lstprodcat']);
	$loc .= "&lstprodcat=" . $lstprodcat;
	if (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
		$sqryprodscat_mst1 .= " and prodscatm_prodcatm_id = '$lstprodcat'";
	} else {
		$sqryprodscat_mst1 .= " and prodscatm_prodcatm_id like '%$lstprodcat%'";
	}
}
if (isset($_REQUEST['txtname']) && (trim($_REQUEST['txtname']) != "")) {
	$txtname = glb_func_chkvl($_REQUEST['txtname']);
	$loc .= "&txtname=" . $txtname;
	if (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
		$sqryprodscat_mst1 .= " and prodscatm_name ='$txtname'";
	} else {
		$sqryprodscat_mst1 .= " and prodscatm_name like '%$txtname%'";
	}
}
//$sqryprodscat_mst1 = $sqryprodscat_mst1.$sqryprodscat_mst2;
$sqryprodscat_mst = $sqryprodscat_mst1 . " order by prodmnlnksm_name, prodcatm_name, prodscatm_name limit $offset, $rowsprpg";
// echo $sqryprodscat_mst;
$srsprodscat_mst = mysqli_query($conn, $sqryprodscat_mst);
$cnt_recs = mysqli_num_rows($srsprodscat_mst);
include_once 'script.php';
?>
<script language="javascript">
	function addnew() {
		document.frmprodsubcat.action = "<?php echo $rd_adpgnm; ?>";
		document.frmprodsubcat.submit();
	}

	function srch() {
		//alert("");
		var urlval = "";
		if ((document.frmprodsubcat.lstprodmcat.value == "") && (document.frmprodsubcat.lstprodcat.value == "") && (document.frmprodsubcat.txtname.value == "")) {
			alert("Select Search Criteria");
			document.frmprodsubcat.lstprodmcat.focus();
			return false;
		}
		var lstprodmcat = document.frmprodsubcat.lstprodmcat.value;
		var lstprodcat = document.frmprodsubcat.lstprodcat.value;
		var txtname = document.frmprodsubcat.txtname.value;
		if (lstprodmcat != '') {
			if (urlval == "") {
				urlval += "lstprodmcat=" + lstprodmcat;
			} else {
				urlval += "&lstprodmcat=" + lstprodmcat;
			}
		}
		if (lstprodcat != '') {
			if (urlval == "") {
				urlval += "lstprodcat=" + lstprodcat;
			} else {
				urlval += "&lstprodcat=" + lstprodcat;
			}
		}
		if (txtname != '') {
			if (urlval == "") {
				urlval += "txtname=" + txtname;
			} else {
				urlval += "&txtname=" + txtname;
			}
		}
		if (document.frmprodsubcat.chkexact.checked == true) {
			document.frmprodsubcat.action = "<?php echo $rd_crntpgnm; ?>?" + urlval + "&chk=y";
			document.frmprodsubcat.submit();
		} else {
			document.frmprodsubcat.action = "<?php echo $rd_crntpgnm; ?>?" + urlval;
			document.frmprodsubcat.submit();
		}
		return true;
	}
</script>
<script language="javascript" type="text/javascript" src="../includes/chkbxvalidate.js"></script>
<link href="docstyle.css" rel="stylesheet" type="text/css">

<body>
	<?php include_once $inc_adm_hdr; ?>
	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">View All Sub Categories</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">View All Sub Categories</li>
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
				<form method="post" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" name="frmprodsubcat" id="frmprodsubcat">
					<input type="hidden" name="hdnchkval" id="hdnchkval">
					<input type="hidden" name="hdnchksts" id="hdnchksts">
					<input type="hidden" name="hdnallval" id="hdnallval">
					<div class="col-md-12">
						<div class="row justify-content-left align-items-center mt-3">
							<div class="col-sm-3">
								<div class="form-group">
									<?php
									$sqryprodmcat_mst = "SELECT prodmnlnksm_id, prodmnlnksm_name from prodmnlnks_mst where prodmnlnksm_id != ''";
									$srsprodmcat_mst = mysqli_query($conn, $sqryprodmcat_mst);
									$cnt_prodmcat = mysqli_num_rows($srsprodmcat_mst);
									?>
									<select name="lstprodmcat" class="form-control">
										<option value="">--Select Main Link--</option>
										<?php
										if ($cnt_prodmcat > 0) {
											while ($rowsprodmcat_mst = mysqli_fetch_assoc($srsprodmcat_mst)) {
												$prodmnlnksm_id = $rowsprodmcat_mst['prodmnlnksm_id'];
												$prodmnlnksm_name = $rowsprodmcat_mst['prodmnlnksm_name'];
										?>
												<option value="<?php echo $prodmnlnksm_id; ?>" <?php if (isset($_REQUEST['lstprodmcat']) && trim($_REQUEST['lstprodmcat']) == $prodmnlnksm_id) {
																									echo 'selected';
																								} ?>><?php echo $prodmnlnksm_name; ?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="form-group">
									<?php
									$sqryprodcat_mst = "SELECT prodcatm_id, prodcatm_name from prodcat_mst where prodcatm_id != ''";
									$srsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
									$cnt_prodcat = mysqli_num_rows($srsprodcat_mst);
									?>
									<select name="lstprodcat" class="form-control">
										<option value="">--Select Category--</option>
										<?php
										if ($cnt_prodcat > 0) {
											while ($rowsprodcat_mst = mysqli_fetch_assoc($srsprodcat_mst)) {
												$prodcatm_id = $rowsprodcat_mst['prodcatm_id'];
												$prodcatm_name = $rowsprodcat_mst['prodcatm_name'];
										?>
												<option value="<?php echo $prodcatm_id; ?>" <?php if (isset($_REQUEST['lstprodcat']) && trim($_REQUEST['lstprodcat']) == $prodcatm_id) {
																								echo 'selected';
																							} ?>><?php echo $prodcatm_name; ?></option>
										<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-sm-5">
								<div class="form-group">
									<div class="col-8">
										<div class="row">
											<div class="col-10">
												<input type="text" name="txtname" placeholder="Search by name" id="txtname" class="form-control" value="<?php if (isset($_REQUEST['txtname']) && $_REQUEST['txtname'] != "") {
																																							echo $_REQUEST['txtname'];
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
									<td colspan="<?php echo $clspn_val; ?>" align="center">
									</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btnsts" id="btnsts" type="button" class="btn btn-xs btn-primary" value="Status" onClick="updatests('hdnchksts','frmprodsubcat','chksts')">
										</div>
									</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btndel" id="btndel" type="button" class="btn btn-xs btn-primary" value="Delete" onClick="deleteall('hdnchkval','frmprodsubcat','chkdlt');">
										</div>
									</td>
								</tr>
								<tr>
									<td width="8%" class="td_bg"><strong>SL.No.</strong></td>
									<td width="28%" class="td_bg"><strong>Name</strong></td>
									<td width="24%" class="td_bg"><strong>Main Link</strong></td>
									<td width="24%" class="td_bg"><strong>Category</strong></td>

									<td width="15%" class="td_bg"><strong>Banner Image</strong></td>
									<td width="15%" class="td_bg"><strong>Type</strong></td>
									<td width="6%" align="center" class="td_bg"><strong>Rank</strong></td>
									<td width="7%" align="center" class="td_bg"><strong>Edit</strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onClick="Check(document.frmprodsubcat.chksts,'Check_ctr','hdnallval')"></strong>
									</td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_dctr" id="Check_dctr" value="yes" onClick="Check(document.frmprodsubcat.chkdlt,'Check_dctr')"><b></b>
										</strong>
									</td>
								</tr>
								<?php
								$cnt = $offset;
								if ($cnt_recs > 0) {
									while ($srowveh_brnd_mst = mysqli_fetch_assoc($srsprodscat_mst)) {
										$cnt += 1;
										$pgval_srch = $pgnum . $loc;
										$db_subcatid = $srowveh_brnd_mst['prodscatm_id'];
										$db_subcatname = $srowveh_brnd_mst['prodscatm_name'];
										$db_catname = $srowveh_brnd_mst['prodcatm_name'];
										$db_mncatname = $srowveh_brnd_mst['prodmnlnksm_name'];
										$db_scttyp  	= $srowveh_brnd_mst['prodscatm_typ'];
										$db_prty = $srowveh_brnd_mst['prodscatm_prty'];
										$db_sts  = $srowveh_brnd_mst['prodscatm_sts'];

										$db_scatbnrimg = $srowveh_brnd_mst['prodscatm_bnrimg'];
								?>
										<tr <?php if ($cnt % 2 == 0) {
												echo "";
											} else {
												echo "";
											} ?>>
											<td><?php echo $cnt; ?></td>
											<!-- <td><?php echo $db_subcatid; ?></td> -->
											<td>
												<a href="<?php echo $rd_vwpgnm; ?>?vw=<?php echo $db_subcatid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="links"><?php echo $db_subcatname; ?></a>
											</td>
											<td align="left"><?php echo $db_mncatname; ?></td>
											<td align="left"><?php echo $db_catname; ?></td>

											<td align="left">
												<?php

												$imgnm   = $srowveh_brnd_mst['prodscatm_bnrimg'];
												$imgpath = $a_scat_bnrfldnm . $imgnm;
												if (($imgnm != "") && file_exists($imgpath)) {
													echo "<img src='$imgpath' width='80pixel' height='80pixel'>";
												} else {
													echo "N.A.";
												}
												?>

											</td>
											<td align="center"><?php echo funcDsplyCattwoTyp($db_scttyp); ?></td>
											<td align="center"><?php echo $db_prty; ?></td>
											<td align="center">
												<a href="<?php echo $rd_edtpgnm; ?>?edit=<?php echo $db_subcatid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="orongelinks">Edit</a>
											</td>
											<td align="center">
												<input type="checkbox" name="chksts" id="chksts" value="<?php echo $srowveh_brnd_mst['prodscatm_id']; ?>" <?php if ($srowveh_brnd_mst['prodscatm_sts'] == 'a') {
																																								echo "checked";
																																							} ?> onClick="addchkval(<?php echo $srowveh_brnd_mst['prodscatm_id']; ?>,'hdnchksts','frmprodsubcat','chksts');">
											</td>
											<td align="center">
												<input type="checkbox" name="chkdlt" id="chkdlt" value="<?php echo $srowveh_brnd_mst['prodscatm_id']; ?>">
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
											<input name="btnsts" id="btnsts" type="button" value="Status" onClick="updatests('hdnchksts','frmprodsubcat','chksts')" class="btn btn-xs btn-primary">
										</div>
									</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btndel" id="btndel" type="button" value="Delete" onClick="deleteall('hdnchkval','frmprodsubcat','chkdlt');" class="btn btn-xs btn-primary">
										</div>
									</td>
								</tr>
								<?php
								$disppg = funcDispPag($conn, 'links', $loc, $sqryprodscat_mst1, $rowsprpg, $cntstart, $pgnum);
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