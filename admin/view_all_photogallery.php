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
//Programm 	  : photogallery.php	
//Package 	  : ICAI
//Purpose 	  : For Viewing New photogallery 
//Created By  : Lokesh Palagani
//Created On  :	
//Modified By : 
//Modified On : 
//Company 	  : Adroit
/************************************************************/
global $msg, $loc, $rowsprpg, $dispmsg, $disppg, $a_phtgalspath;
/*****header link********/
$pagemncat = "Gallery";
$pagecat = "Photos";
$pagenm = "Photos";
/*****header link********/
$clspn_val = "6";
$rd_adpgnm = "add_photogallery.php";
$rd_edtpgnm = "edit_photogallery.php";
$rd_crntpgnm = "view_all_photogallery.php";
$rd_vwpgnm = "view_detail_photogallery.php";
$loc = "";
if (($_POST['hidchksts'] != "") && isset($_REQUEST['hidchksts'])) {
	$dchkval = substr($_POST['hidchksts'], 1);
	$id = glb_func_chkvl($dchkval);
	$updtsts = funcUpdtAllRecSts('pht_dtl', 'phtd_id', $id, 'phtd_sts');
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
	$simg = array();
	$bimg = array();
	$simgpth = array();
	$bimgpth = array();
	for ($i = 0; $i < $count; $i++) {
		$sqryprod_mst = "SELECT 
			                       phtm_simg
					            from 
					               pht_mst
					            where
					              phtm_phtd_id=$del[$i]";
		$srsprod_mst = mysqli_query($conn, $sqryprod_mst);
		$srowprod_mst = mysqli_fetch_assoc($srsprod_mst);
		$simg[$i] = glb_func_chkvl($srowprod_mst['phtm_simg']);
		//$bimg[$i]    = glb_func_chkvl($srowprod_mst['phtm_bimgnm']);				
		$simgpth[$i] = $a_phtgalspath . $simg[$i];
		//$bimgpth[$i] = $bgimgfldnm.$bimg[$i];
	}
	$delsts = funcDelAllRec($conn, 'pht_dtl', 'phtd_id', $did);
	if ($delsts == 'y') {
		for ($i = 0; $i < $count; $i++) {
			if (($simg[$i] != "")) {
				unlink($simgpth[$i]);
			}
			/*if(($bimg[$i] != "") && file_exists($bimgpth[$i])){
						unlink($bimgpth[$i]);
						}*/
		}
		$gmsg = "<font color='red'>Records deleted successfully</font>";
	} elseif ($delsts == 'n') {
		$gmsg = "<font color='red'>Record can't be deleted(child records exist)</font>";
	}
}
if (
	isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) != "")
	&& isset($_REQUEST['id']) && (trim($_REQUEST['id']) != "")
) {
	$sts = glb_func_chkvl($_REQUEST['sts']);
	$id = glb_func_chkvl($_REQUEST['id']);
	$updtsts = funcUpdtRecSts('pht_dtl', 'phtd_id', $id, 'phtd_sts', $sts);
	if ($updtsts == 'y') {
		$msg = "<font color=red>Record updated successfully</font>";
	} elseif ($updtsts == 'n') {
		$msg = "<font color=red>Record not updated</font>";
	}
}

if (isset($_REQUEST['did']) && (trim($_REQUEST['did']) != "")) {
	$did = glb_func_chkvl($_REQUEST['did']);
	$simg = glb_func_chkvl($_REQUEST['simg']);
	//$bimg   = glb_func_chkvl($_REQUEST['bimg']);
	$simgpth = $fldnm . $simg;
	//$bimgpth = $a_phtgalspath.$bimg;
	$delsts = funcDelRec($conn, 'pht_dtl', 'phtd_id', $did);
	if ($delsts == 'y') {
		if (($simg != "") && file_exists($simgpth)) {
			unlink($simgpth);
		}
		if (($bimg != "") && file_exists($bimgpth)) {
			unlink($bimgpth);
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
	$msg = "<font color=red>Dupilicate name Record not updated</font>";
}
$rowsprpg = 20; //maximum rows per page
include_once '../includes/inc_paging1.php'; //Includes pagination	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>
		<?php echo $pgtl; ?>
	</title>
	<?php include_once 'script.php'; ?>
	<script language="javascript">
		function addnew() {
			document.frmphtgal.action = "add_photogallery.php";
			document.frmphtgal.submit();
		}
		function chng() {
			var div1 = document.getElementById("div1");
			var div2 = document.getElementById("div2");
			if (document.frmphtgal.lstsrchby.value == 'p') {
				div1.style.display = "block";
				div2.style.display = "none";

			}
			else if (document.frmphtgal.lstsrchby.value == 'c') {
				div1.style.display = "none";
				div2.style.display = "block";
			}
		}
		function validate() {
			// if (document.frmphtgal.lstsrchby.value == "") {
			// 	alert("Please Select Search Criteria");
			// 	document.frmphtgal.lstsrchby.focus();
			// 	return false;
			// }
			if (document.frmphtgal.lstsrchby.value == "p") {
				if (document.frmphtgal.txtsrchval.value == "") {
					alert("Please Enter Key Word");
					document.frmphtgal.txtsrchval.focus();
					return false;
				}
			}
			if (document.frmphtgal.lstsrchby.value == "c") {
				if (document.frmphtgal.lstphtcat.value == "") {
					alert("Please Select Category");
					document.frmphtgal.lstphtcat.focus();
					return false;
				}
			}
			var optn = document.frmphtgal.lstsrchby.value;
			if (optn == 'p') {
				var val = document.frmphtgal.txtsrchval.value;
				if (document.frmphtgal.chkexact.checked == true) {
					document.frmphtgal.action = "view_all_photogallery.php?optn=p&val=" + val + "&chk=y";
					document.frmphtgal.submit();
				}
				else {
					document.frmphtgal.action = "view_all_photogallery.php?optn=p&val=" + val;
					document.frmphtgal.submit();
				}
			}
			else if (optn == 'c') {
				var val = document.frmphtgal.lstphtcat.value;
				document.frmphtgal.action = "view_all_photogallery.php?optn=c&val=" + val;
				document.frmphtgal.submit();
			}
			return true;
		}
		function onload() {
			//document.getElementById('txtsrchval').focus();
			<?php
			if (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 'p') {
				?>
				div1.style.display = "block";
				div2.style.display = "none";
				<?php
			} else if (isset($_POST['lstsrchby']) && $_POST['lstsrchby'] == 'c') {
				?>
					div1.style.display = "none";
					div2.style.display = "block";
					<?php
			}
			?>
		}
	</script>
	<script language="javascript" type="text/javascript" src="../includes/chkbxvalidate.js"></script>
</head>

<body onLoad="onload();">
<?php include_once $inc_adm_hdr; ?>
	
	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">View All Photo Gallery</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">View All Photo Gallery</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- Default box -->
		<div class="card">
			<!-- <?php if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) { ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert" id="delids" style="display:none">
					<strong>Deleted Successfully !</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php
			}
			?> -->
			<!-- <div class="alert alert-warning alert-dismissible fade show" role="alert" id="updid" style="display:none">
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
			</div> -->
			<div class="card-body p-0">
				<form method="POST" action="" name="frmphtgal" id="frmphtgal" onSubmit="return validate()">
					<input type="hidden" name="hidchkval" id="hidchkval">
					<input type="hidden" name="hidchksts" id="hidchksts">
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
														<option value="p" <?php if (isset($_REQUEST['lstsrchby']) && trim($_REQUEST['lstsrchby']) == 'p') {
															echo 'selected';
														} else if (isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'p') {
															echo 'selected';
														} ?>>Photo Name</option>
														<option value="c" <?php if (isset($_REQUEST['lstsrchby']) && trim($_REQUEST['lstsrchby']) == 'c') {
															echo 'selected';
														} else if (isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'c') {
															echo 'selected';
														} ?>>Category</option>
													</select>
												</td>
												<td width="40%">
													<div id="div1" <?php if (!isset($_REQUEST['optn']) || (trim($_REQUEST['optn']) == "p") || (trim($_REQUEST['optn']) == "")) {
														echo "style=\"display:block\"";
													} else {
														echo "style=\"display:none\"";
													} ?>>
														<input type="text" class="form-control" name="txtsrchval" value="<?php if (isset($_POST['txtsrchval']) && trim($_POST['txtsrchval']) != "") {
															echo $_POST['txtsrchval'];
														} else if (
															isset($_REQUEST['val']) && (trim($_REQUEST['val']) != "") &&
															isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "p")
														) {
															echo $_REQUEST['val'];
														}
														?>" id="txtsrchval">
														<strong>Exact</strong>
														<input type="checkbox" name="chkexact" value="1" <?php
														if (isset($_POST['chkexact']) && (trim($_POST['chkexact']) == 1)) {
															echo 'checked';
														} elseif (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
															echo 'checked';
														}
														?>>
													</div>
													<div id="div2" <?php if (isset($_REQUEST['optn']) && (trim($_REQUEST['optn']) == "c")) {
														echo "style=\"display:block\"";
													} else {
														echo "style=\"display:none\"";
													} ?>>
														<select name="lstphtcat" id="lstphtcat" class="form-control">
															<option value="">--Select--</option>
															<?php
															$sqryphtcat_mst = "SELECT phtcatm_id,phtcatm_name
											  from phtcat_mst
											  where phtcatm_sts='a'";
															//order by phtcatm_prty
															$stsphtcat_mst = mysqli_query($conn, $sqryphtcat_mst);
															while ($rowsphtcat_mst = mysqli_fetch_assoc($stsphtcat_mst)) {
																?>
																<option value="<?php echo $rowsphtcat_mst['phtcatm_id']; ?>" <?php if (isset($_POST['lstphtcat']) && trim($_POST['lstphtcat']) == $rowsphtcat_mst['phtcatm_id']) {
																		 echo 'selected';
																	 } else if (isset($_REQUEST['val']) && trim($_REQUEST['val']) == $rowsphtcat_mst['phtcatm_id']) {
																		 echo 'selected';
																	 } ?>><?php echo $rowsphtcat_mst['phtcatm_name']; ?></option>
																<?php
															}
															?>
														</select>
													</div>
												</td>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">

									&nbsp;&nbsp;&nbsp;
									<input type="submit" value="Search" class="btn btn-primary" name="btnsbmt"/>
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

											<input name="btnsts" id="btnsts" type="button" class="btn btn-xs btn-primary" value="Status"
												onClick="updatests('hidchksts','frmphtgal','chksts')">
										</div>
									</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btndel" id="btndel" type="button" class="btn btn-xs btn-primary" value="Delete"
												onClick="deleteall('hidchkval','frmphtgal','chkdlt');">
										</div>
									</td>
								</tr>
								<tr>
									<td width="5%" class="td_bg"><strong>SL.No.</strong></td>
									<td width="28%" class="td_bg"><strong>Name</strong></td>
									<td width="25%" class="td_bg"><strong>Category</strong></td>
									<td width="15%" class="td_bg"><strong>Type</strong></td>
									<td width="6%" align="center" class="td_bg"><strong>Rank</strong></td>
									<td width="20%" align="center" class="td_bg"><strong>Edit</strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes"
												onClick="Check(document.frmphtgal.chksts,'Check_ctr')"></strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_dctr" id="Check_dctr" value="yes"
												onClick="Check(document.frmphtgal.chkdlt,'Check_dctr')"></strong></td>
								</tr>




								<?php
								$sqryphtgal_dtl1 = "SELECT 
									 phtd_id,phtd_name,phtd_type,phtd_rank,phtd_sts,
									 phtcatm_id,phtcatm_name,phtd_phtcatm_id
				                  from 
							   		 pht_dtl
									inner join  
				phtcat_mst on phtcat_mst.phtcatm_id = pht_dtl.phtd_phtcatm_id";
								if (
									isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'p'
									&& isset($_REQUEST['val']) && trim($_REQUEST['val']) != ""
								) {
									$val = glb_func_chkvl($_REQUEST['val']);
									if (isset($_REQUEST['chk']) && trim($_REQUEST['chk']) == 'y') {
										$loc = "&optn=p&val=" . $val . "&chk=y";
										$sqryphtgal_dtl1 .= " and phtd_name='$val'";
									} elseif (!isset($_REQUEST['chk']) || trim($_REQUEST['chk']) != 'y') {
										$loc = "&optn=p&val=" . $val;
										$sqryphtgal_dtl1 .= " and phtd_name like '%$val%'";
									}
								} else if (
									isset($_REQUEST['optn']) && trim($_REQUEST['optn']) == 'c'
									&& isset($_REQUEST['val']) && trim($_REQUEST['val']) != ""
								) {
									$val = glb_func_chkvl($_REQUEST['val']);
									$loc = "&optn=c&val=" . $val;
									$sqryphtgal_dtl1 .= " and phtcatm_id = '$val'";
								}
							$sqryphtgal_dtl = $sqryphtgal_dtl1 . " group by phtd_name asc";
								$srsphtgal_dtl = mysqli_query($conn, $sqryphtgal_dtl) or die(mysqli_error($conn));
								$cnt = 0;
								while ($srowphtgal_dtl = mysqli_fetch_assoc($srsphtgal_dtl)) {
									
									$db_typ = $srowphtgal_dtl['phtd_type'];
									$cnt += 1;
									?>
									<tr <?php if ($cnt % 2 == 0) {
										echo "bgcolor='f9f8f8'";
									} else {
										echo "bgcolor='#F2F1F1'";
									} ?>>
										<td>
											<?php echo $cnt; ?>
										</td>

										<td>
											<a href="view_detail_photogallery.php?vw=<?php echo $srowphtgal_dtl['phtd_id']; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>"
												class="links"><?php echo $srowphtgal_dtl['phtd_name']; ?></a>
										</td>
										<td align="left">
											<?php echo $srowphtgal_dtl['phtcatm_name']; ?>
										</td>
										<td align="left"> <?php if ($db_typ == 'c') echo 'College'; ?>
												<?php if ($db_typ == 'd') echo 'Department'; ?>
											</td>

										<td align="center">
											<?php echo $srowphtgal_dtl['phtd_rank']; ?>
										</td>


										<td align="center">
											<a href="edit_photogallery.php?vw=<?php echo $srowphtgal_dtl['phtd_id']; ?>&pg=<?php echo $pgnum; ?>"
												class="orongelinks">Edit</a>
										</td>

										
										<td align="center">
											<input type="checkbox" name="chksts" id="chksts" value="<?php echo $srowphtgal_dtl['phtd_id']; ?>"
												<?php if ($srowphtgal_dtl['phtd_sts'] == 'a') {
													echo "checked";
												} ?>
												onClick="addchkval(<?php echo $srowphtgal_dtl['phtd_id']; ?>,'hidchksts','frmphtgal','chksts');">
										</td>
										<td align="center">
											<input type="checkbox" name="chkdlt" id="chkdlt" value="<?php echo $srowphtgal_dtl['phtd_id']; ?>">
										</td>
									</tr>
									
									<?php
								}
								?>
								<tr>
								<td colspan="<?php echo $clspn_val; ?>">&nbsp;</td>
								<td width="7%" align="right" valign="bottom">
									<div align="right">
										<input name="btnsts" id="btnsts" type="button" value="Status" 	onClick="updatests('hidchksts','frmphtgal','chksts')" class="btn btn-xs btn-primary">
									</div>
								</td>
								<td width="7%" align="right" valign="bottom">
									<div align="right">
										<input name="btndel" id="btndel" type="button" value="Delete" onClick="deleteall('hidchkval','frmphtgal','chkdlt');" class="btn btn-xs btn-primary">
									</div>
								</td>
							</tr>
							<?php
						
							$disppg = funcDispPag($conn,'links', $loc, $sqryphtgal_dtl1, $rowsprpg, $cntstart, $pgnum);
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
</html>