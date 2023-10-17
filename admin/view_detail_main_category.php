<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
include_once '../includes/inc_adm_dept_session.php'; //department sessions
/***************************************************************
Programm : view_detail_main_category.php
Purpose : For Viewing Main Category Details
Created By : Bharath
Created On : 30/10/2013
Modified By :
Modified On :
Purpose :
Company : Adroit
 ************************************************************/
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Product Group";
$pagenm = "main category";
/*****header link********/
global $id, $pg, $cntstart, $msg, $loc, $rd_crntpgnm, $rd_edtpgnm, $clspn_val;
global $id, $pg, $countstart;
$rd_crntpgnm = "view_main_category.php";
$rd_edtpgnm = "edit_main_category.php";
$clspn_val = "4";
if (isset($_REQUEST['vw']) && (trim($_REQUEST['vw']) != "") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg']) != "") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart']) != "")) {
	$id = glb_func_chkvl($_REQUEST['vw']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
	$srchval = glb_func_chkvl($_REQUEST['val']);
	$chk = glb_func_chkvl($_REQUEST['chk']);
}
// $sqryprodmncat_mst="SELECT prodmn_catm_id, prodmn_catm_name, prodmn_catm_desc, prodmn_catm_smlimg, prodmn_catm_bnrimg, prodmn_catm_seotitle, prodmn_catm_seodesc, prodmn_catm_seokywrd, prodmn_catm_seohonetitle, prodmn_catm_seohonedesc, prodmn_catm_seohtwotitle, prodmn_catm_seohtwodesc, prodmn_catm_sts, prodmn_catm_prty, prodmn_catm_hmprty FROM prodmcat_mst WHERE prodmn_catm_id = $id";
// $srsprodmncat_mst = mysqli_query($conn,$sqryprodmncat_mst);
// $rowsprodmncat_mst = mysqli_fetch_assoc($srsprodmncat_mst);

$sqryprodcat_mst = "SELECT
			prodmnlnksm_name,prodmnlnksm_desc,prodmnlnksm_seotitle,prodmnlnksm_seodesc,
			prodmnlnksm_seohone,prodmnlnksm_seohtwo,prodmnlnksm_seokywrd,prodmnlnksm_prty,
			if(prodmnlnksm_sts = 'a', 'Active','Inactive') as prodmnlnksm_sts,
			prodmnlnksm_typ,prodmnlnksm_dsplytyp,prodmnlnksm_dskimg,prodmnlnksm_tabimg,prodmnlnksm_mobimg
		from
			prodmnlnks_mst
						  where
							prodmnlnksm_id=$id";
$srsprodcat_mst  = mysqli_query($conn, $sqryprodcat_mst);
$cntrecprodcat_mst = mysqli_num_rows($srsprodcat_mst);
if ($cntrecprodcat_mst  > 0) {
	$rowsprodcat_mst = mysqli_fetch_assoc($srsprodcat_mst);
	$db_catname		 = $rowsprodcat_mst['prodmnlnksm_name'];
	$db_catdesc		 = stripslashes($rowsprodcat_mst['prodmnlnksm_desc']);
	$db_cattyp		 = $rowsprodcat_mst['prodmnlnksm_typ'];
	$db_dsplytyp     = $rowsprodcat_mst['prodmnlnksm_dsplytyp'];
	$db_catseottl	 = $rowsprodcat_mst['prodmnlnksm_seotitle'];
	$db_catseodesc	 = $rowsprodcat_mst['prodmnlnksm_seodesc'];
	$db_catseokywrd	 = $rowsprodcat_mst['prodmnlnksm_seokywrd'];
	$db_catseohone	 = $rowsprodcat_mst['prodmnlnksm_seohone'];
	$db_catseohtwo	 = $rowsprodcat_mst['prodmnlnksm_seohtwo'];
	$db_catprty		 = $rowsprodcat_mst['prodmnlnksm_prty'];
	$db_catsts		 = $rowsprodcat_mst['prodmnlnksm_sts'];
}
$loc = "&val=$srchval";
if ($chk != '') {
	$loc .= "&chk=y";
}
if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) {
	$msg = "<font color=red>Record updated successfully</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "n")) {
	$msg = "<font color=red>Record not updated</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "d")) {
	$msg = "<font color=red>Duplicate Recored Name Exists & Record Not updated</font>";
}

?>
<script language="javascript">
	function update1() //for update download details
	{
		document.frmedtprodmnlnks.action = "<?php echo $rd_edtpgnm; ?>?vw=<?php echo $id; ?>&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
		document.frmedtprodmnlnks.submit();
	}
</script>
<?php
include_once $inc_adm_hdr;
include_once $inc_adm_lftlnk;
?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View Main Link Details</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">View Main Link Details</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtprodmnlnks" id="frmedtprodmnlnks" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return performCheck('frmedtprodmnlnks', rules, 'inline');">
		<input type="hidden" name="edtpdctid" value="<?php echo $id; ?>">
		<input type="hidden" name="pg" value="<?php echo $pg; ?>">
		<input type="hidden" name="cntstart" value="<?php echo $countstart ?>">
		<input type="hidden" name="chkexact" id="chkexact" value="<?php echo $chk; ?>">
		<input type="hidden" name="txtsrchval" id="txtsrchval" value="<?php echo $val; ?>">
		<?php
		if ($msg != '') {
			echo "<center><tr bgcolor='#FFFFFF'>
				<td colspan='4' bgcolor='#F3F3F3' align='center'><strong>$msg</strong></td>
			</tr></center>";
		}
		?>
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Name </label>
							<div class="col-sm-8">
								<?php echo $db_catname; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Description</label>
							<div class="col-sm-8">
								<?php echo $db_catdesc; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Header Desktop Image</label>
							<div class="col-sm-8">
								<?php
								$dskimgnm   = $rowsprodcat_mst['prodmnlnksm_dskimg'];
								$dskimgpath = $a_mnlnks_bnrfldnm . $dskimgnm;
								if (($dskimgnm != "") && file_exists($dskimgpath)) {
									echo "<img src='$dskimgpath' width='80pixel' height='80pixel'>";
								} else {
									echo "N.A.";
								}
								?>

							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Header Tablet Image</label>
							<div class="col-sm-8">
								<?php
								$tabimgnm   = $rowsprodcat_mst['prodmnlnksm_tabimg'];
								$tabimgpath = $a_mnlnks_bnrfldnm . $tabimgnm;
								if (($tabimgnm != "") && file_exists($tabimgpath)) {
									echo "<img src='$tabimgpath' width='80pixel' height='80pixel'>";
								} else {
									echo "N.A.";
								}
								?>

							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Header Mobile Image</label>
							<div class="col-sm-8">
								<?php
								$mobimgnm   = $rowsprodcat_mst['prodmnlnksm_mobimg'];
								$mobimgpath = $a_mnlnks_bnrfldnm . $mobimgnm;
								if (($mobimgnm != "") && file_exists($mobimgpath)) {
									echo "<img src='$mobimgpath' width='80pixel' height='80pixel'>";
								} else {
									echo "N.A.";
								}
								?>

							</div>
						</div>

						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Type </label>
							<div class="col-sm-8">
								<?php echo  funcDispcattyp($db_cattyp); ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Menu Display Type </label>
							<div class="col-sm-8">
								<?php echo  funcDsplyTyp($db_dsplytyp); ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Title </label>
							<div class="col-sm-8">
								<?php echo $db_catseottl; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label"> SEO Description </label>
							<div class="col-sm-8">
								<?php echo $db_catseodesc; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label"> SEO Keyword</label>
							<div class="col-sm-8">
								<?php echo $db_catseokywrd; ?>
							</div>
						</div>

						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H1 </label>
							<div class="col-sm-8">
								<?php echo $db_catseohone; ?>
							</div>
						</div>
						<!-- <div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H1 Description </label>
							<div class="col-sm-8">
								<?php echo $db_catseohone; ?>
							</div>
						</div> -->
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H2 </label>
							<div class="col-sm-8">
								<?php echo $db_catseohtwo; ?>
							</div>
						</div>
						<!-- <div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H2 Description </label>
							<div class="col-sm-8">
								<?php echo $rowsprodmncat_mst['prodmn_catm_seohtwodesc']; ?>
							</div>
						</div> -->
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Rank</label>
							<div class="col-sm-8">
								<?php echo $db_catprty; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status </label>
							<div class="col-sm-8">
								<?php echo $db_catsts; ?>
							</div>
						</div>
						<p class="text-center">
							<input type="Submit" class="btn btn-primary btn-cst" name="frmedtprodmnlnks" id="frmedtprodmnlnks" value="Edit" onclick="update1()">
							&nbsp;&nbsp;&nbsp;
							<!-- <input type="reset" class="btn btn-primary btn-cst" name="btnprodcatreset" value="Clear" id="btnprodcatreset">
						 &nbsp;&nbsp;&nbsp; -->
							<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_crntpgnm; ?>?<?php echo $loc; ?>'">
						</p>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>