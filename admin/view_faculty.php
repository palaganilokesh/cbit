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
//Programm 	  : faculty.php	
//Package 	  : ICAI
//Purpose 	  : For Viewing New faculty 
//Created By  : Lokesh Palagani
//Created On  :	
//Modified By : 
//Modified On : 
//Company 	  : Adroit
/************************************************************/
global $msg, $loc, $rowsprpg, $dispmsg, $disppg, $a_phtgalfaculty;
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Faculty";
$pagenm = "Faculty";
/*****header link********/
$clspn_val = "4";
$rd_adpgnm = "add_faculty.php";
$rd_edtpgnm = "edit_faculty.php";
$rd_crntpgnm = "view_faculty.php";
$rd_vwpgnm = "view_detail_faculty.php";
$loc = "";
if (($_POST['hidchksts'] != "") && isset($_REQUEST['hidchksts'])) {
	$dchkval = substr($_POST['hidchksts'], 1);
	$id = glb_func_chkvl($dchkval);
	$updtsts = funcUpdtAllRecSts('faculty_mst', 'faculty_id', $id, 'faculty_sts');
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
	$delsts = funcDelAllRec($conn, 'faculty_mst', 'faculty_id', $did);
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
	$delsts = funcDelRec('pht_dtl', 'phtd_id',$did);
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
			document.frmfaclty.action = "add_faculty.php";
			document.frmfaclty.submit();
		}

		function validate() {
		
					if (document.frmfaclty.lstfaculty.value == "") {
					alert("Please Select Department");
					document.frmfaclty.lstfaculty.focus();
					return false;
				}
			return true;
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
						<h1 class="m-0 text-dark">View All Faculty</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">View All Faculty</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- Default box -->
		<div class="card">
		
			<div class="card-body p-0">
				<form method="POST" action="" name="frmfaclty" id="frmfaclty" >
				<!-- onSubmit="return validate()" -->
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
											<select name="lstfaculty" id="lstfaculty" class="form-control">
															<option value="">--Select--</option>
															<?php
															$sqryfaculty_mst = "SELECT faculty_id,faculty_name,faculty_dept_id,prodcatm_id,prodcatm_name
											  from faculty_mst
												inner join  prodcat_mst on prodcatm_id= faculty_dept_id
											  where faculty_sts='a'";
															//order by faculty_prty
															$stsfaculty_mst = mysqli_query($conn, $sqryfaculty_mst);
															while ($rowsfaculty_mst = mysqli_fetch_assoc($stsfaculty_mst)) {
																?>

																<option value="<?php echo $rowsfaculty_mst['faculty_dept_id']; ?>" <?php if (isset($_POST['lstfaculty']) && trim($_POST['lstfaculty']) == $rowsfaculty_mst['faculty_dept_id']) {
																		 echo 'selected';
																	 } ?>><?php echo $rowsfaculty_mst['prodcatm_name']; ?></option>
																<?php
															}
															?>
														</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">

									&nbsp;&nbsp;&nbsp;
									<input type="submit" value="Search" class="btn btn-primary" name="btnsbmt" onClick="validate()";/>
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
												onClick="updatests('hidchksts','frmfaclty','chksts')">
										</div>
									</td>
									<td width="7%" align="right" valign="bottom">
										<div align="right">
											<input name="btndel" id="btndel" type="button" class="btn btn-xs btn-primary" value="Delete"
												onClick="deleteall('hidchkval','frmfaclty','chkdlt');">
										</div>
									</td>
								</tr>
								<tr>
									<td width="5%" class="td_bg"><strong>SL.No.</strong></td>
									<td width="28%" class="td_bg"><strong>Department Name</strong></td>
								
									<td width="6%" align="center" class="td_bg"><strong>Rank</strong></td>
									<td width="20%" align="center" class="td_bg"><strong>Edit</strong></td>
									<td width="7%" class="td_bg" align="center"><strong>

											<input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes"
												onClick="Check(document.frmfaclty.chksts,'Check_ctr')"></strong></td>
									<td width="7%" class="td_bg" align="center"><strong>
											<input type="checkbox" name="Check_dctr" id="Check_dctr" value="yes"
												onClick="Check(document.frmfaclty.chkdlt,'Check_dctr')"></strong></td>
								</tr>




								<?php
								$sqryphtgal_dtl1 = "SELECT faculty_id,faculty_dept_id,faculty_sts,faculty_mst_id,faculty_dtl_dept_id,faculty_dtl_sts,faculty_rank,prodcatm_id,prodcatm_name
								  from 
							   	faculty_mst
									inner join  faculty_dtl on faculty_mst_id=faculty_id
									inner join  prodcat_mst on prodcatm_id= faculty_dept_id";

if (isset($_REQUEST['lstfaculty']) && (trim($_REQUEST['lstfaculty']) != "")) {
	$lstfaculty = glb_func_chkvl($_REQUEST['lstfaculty']);
	$loc .= "&lstfaculty=" . $lstfaculty;
	if (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
		$sqryphtgal_dtl1 .= " and faculty_dept_id = '$lstfaculty'";
	} else {
		$sqryphtgal_dtl1 .= " and faculty_dept_id like '%$lstfaculty%'";
	}
}

							$sqryphtgal_dtl = $sqryphtgal_dtl1 . " group by faculty_mst_id asc";
							// echo $sqryphtgal_dtl;
								$srsphtgal_dtl = mysqli_query($conn, $sqryphtgal_dtl) or die(mysqli_error($conn));
								$cnt = 0;
								while ($srowphtgal_dtl = mysqli_fetch_assoc($srsphtgal_dtl)) {
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
											<a href="view_detail_faculty.php?vw=<?php echo $srowphtgal_dtl['faculty_id']; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>"
												class="links"><?php echo $srowphtgal_dtl['prodcatm_name']; ?></a>
										</td>
									
										<td align="center">
											<?php echo $srowphtgal_dtl['faculty_rank']; ?>
										</td>


										<td align="center">
											<a href="edit_faculty.php?vw=<?php echo $srowphtgal_dtl['faculty_id']; ?>&pg=<?php echo $pgnum; ?>"
												class="orongelinks">Edit</a>
										</td>

										
										<td align="center">
											<input type="checkbox" name="chksts" id="chksts" value="<?php echo $srowphtgal_dtl['faculty_id']; ?>"
												<?php if ($srowphtgal_dtl['faculty_sts'] == 'a') {
													echo "checked";
												} ?>
												onClick="addchkval(<?php echo $srowphtgal_dtl['faculty_id']; ?>,'hidchksts','frmfaclty','chksts');">
										</td>
										<td align="center">
											<input type="checkbox" name="chkdlt" id="chkdlt" value="<?php echo $srowphtgal_dtl['faculty_id']; ?>">
										</td>
									</tr>
									
									<?php
								}
								?>
								<tr>
								<td colspan="<?php echo $clspn_val; ?>">&nbsp;</td>
								<td width="7%" align="right" valign="bottom">
									<div align="right">
										<input name="btnsts" id="btnsts" type="button" value="Status" 	onClick="updatests('hidchksts','frmfaclty','chksts')" class="btn btn-xs btn-primary">
									</div>
								</td>
								<td width="7%" align="right" valign="bottom">
									<div align="right">
										<input name="btndel" id="btndel" type="button" value="Delete" onClick="deleteall('hidchkval','frmfaclty','chkdlt');" class="btn btn-xs btn-primary">
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