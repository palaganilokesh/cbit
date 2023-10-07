<?php
error_reporting(0);
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***********************************************************
Programm : edit_main_category.php
Package :
Purpose : For Edit Main Category
Created By : Bharath
Created On : 20-01-2022
Modified By :
Modified On : btneprodmnlnkssbmtedtpdctid
Purpose :
Company : Adroit
 ************************************************************/
//global $id,$pg,$$countstart;
global $id, $pg, $countstart, $loc, $rd_crntpgnm;
$rd_vwpgnm = "view_detail_main_category.php";
$rd_crntpgnm = "view_main_category.php";
$clspn_val = "4";
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Product Group";
$pagenm = "main category";
/*****header link********/
if (
	isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	isset($_POST['edtpdctid']) && (trim($_POST['edtpdctid']) != "") &&
	isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")
) {
	include_once "../includes/inc_fnct_fleupld.php";
	include_once "../database/uqry_mnlnks_mst.php";
}

if (
	isset($_REQUEST['edtpdctid']) && trim($_REQUEST['edtpdctid']) != "" &&
	isset($_REQUEST['pg']) && trim($_REQUEST['pg']) != "" &&
	isset($_REQUEST['countstart']) && trim($_REQUEST['countstart']) != ""
) {
	//echo "haiddfhjfhf";exit;

	// 	$id = glb_func_chkvl($_REQUEST['edit']);
	// 	$pg = glb_func_chkvl($_REQUEST['pg']);
	// 	$$countstart = glb_func_chkvl($_REQUEST['$countstart']);
	// 	$srchval = glb_func_chkvl($_REQUEST['val']);
	// }
	// elseif(isset($_REQUEST['edtpdctid']) && (trim($_REQUEST['edtpdctid'])!="") && isset($_REQUEST['hdnpage']) && (trim($_REQUEST['hdnpage'])!="") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart'])!=""))
	// {
	// $id = glb_func_chkvl($_REQUEST['edtpdctid']);
	// $pg = glb_func_chkvl($_REQUEST['hdnpage']);
	// $$countstart = glb_func_chkvl($_REQUEST['countstart']);
	$srchval = glb_func_chkvl($_REQUEST['val']);
	//$chk = glb_func_chkvl($_REQUEST['chk']);
	$id = glb_func_chkvl($_REQUEST['edtpdctid']);
	$pg         = glb_func_chkvl($_REQUEST['pg']);
	$countstart	= glb_func_chkvl($_REQUEST['countstart']);
	//echo "here".$countstart;exit;
	$optn 		= glb_func_chkvl($_REQUEST['optn']);
	$val  		= glb_func_chkvl($_REQUEST['txtsrchval']);
	$vltyp 		= glb_func_chkvl($_REQUEST['lsttyp']);
	$ctdstyp	= glb_func_chkvl($_REQUEST['lstdstyp']);
	$chk  		= glb_func_chkvl($_REQUEST['chkexact']);

	// if($optn != "" && $val != ""){
	// $loc = "&optn=".$optn."&txtsrchval=".$val;
	// if($chk == "y"){
	// 	$loc .= "&chkexact=".$chk;
	// }
	// }
	// if($optn != "" && $vltyp != ""){
	// 	$loc = "&optn=".$optn."&lsttyp=".$vltyp;
	// }
	// if($optn != "" && $ctdstyp != ""){
	// 	$loc = "&optn=".$optn."&lstdstyp=".$ctdstyp;
	// }

	// $sqryprodmncat_mst="SELECT prodmn_catm_id, prodmn_catm_name, prodmn_catm_desc, prodmn_catm_smlimg, prodmn_catm_bnrimg, prodmn_catm_seotitle, prodmn_catm_seodesc, prodmn_catm_seokywrd, prodmn_catm_seohonetitle, prodmn_catm_seohonedesc, prodmn_catm_seohtwotitle, prodmn_catm_seohtwodesc, prodmn_catm_sts, prodmn_catm_prty, prodmn_catm_hmprty FROM prodmcat_mst WHERE prodmn_catm_id = $id";
	// $srsprodmncat_mst  = mysqli_query($conn,$sqryprodmncat_mst);
	// $rowsprodmncat_mst = mysqli_fetch_assoc($srsprodmncat_mst);
	$sqryprodcat_mst = "select
								prodmnlnksm_name,prodmnlnksm_desc,prodmnlnksm_seotitle,prodmnlnksm_seodesc,
								prodmnlnksm_seohone,prodmnlnksm_seohtwo,prodmnlnksm_seokywrd,prodmnlnksm_prty,
								prodmnlnksm_sts,
								prodmnlnksm_typ,prodmnlnksm_dsplytyp,prodmnlnksm_dskimg,prodmnlnksm_tabimg,prodmnlnksm_mobimg
							from
								prodmnlnks_mst
							where
								prodmnlnksm_id='$id'";
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
	} else {
		header("Location:" . $rd_vwpgnm);
		exit();
	}
}
// else{
// 		header("location:".$rd_vwpgnm);
// 		exit();
// 	}


?>




<script language="javaScript" type="text/javascript" src="js/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
	var rules = new Array();
	rules[0] = 'txtname:Name|required|Enter Main Link Name';
	rules[1] = 'txtprty:Priority|required|Enter Rank';
	rules[2] = 'txtprty:Priority|numeric|Enter Only Numbers';

	function setfocus() {
		document.getElementById('txtname').focus();
	}
</script>
<?php
include_once('script.php');
include_once('../includes/inc_fnct_ajax_validation.php');
?>
<script language="javascript" type="text/javascript">
	function funcChkDupName() {
		var name;
		name = document.getElementById('txtname').value;
		id = <?php echo $id; ?>;
		if ((name != "") && (id != "")) {
			var url = "chkduplicate.php?prodmnlnksname=" + name + "&prodmncatid=" + id;
			xmlHttp = GetXmlHttpObject(stateChanged);
			xmlHttp.open("GET", url, true);
			xmlHttp.send(null);
		} else {
			document.getElementById('errorsDiv_txtname').innerHTML = "";
		}
	}

	function stateChanged() {
		if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
			var temp = xmlHttp.responseText;

			document.getElementById("errorsDiv_txtname").innerHTML = temp;
			if (temp != 0) {
				document.getElementById('txtname').focus();
			}
		}
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
					<h1 class="m-0 text-dark">Edit Main Link <Link:mf></Link:mf>
					</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Main Link</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtprodmnlnks" id="frmedtprodmnlnks" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onSubmit="return performCheck('frmedtprodmnlnks', rules, 'inline');">
		<input type="hidden" name="edtpdctid" value="<?php echo $id; ?>">
		<input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
		<input type="hidden" name="hdnval" value="<?php echo $srchval; ?>">
		<input type="hidden" name="hdnchk" value="<?php echo $chk; ?>">
		<input type="hidden" name="hdnloc" value="<?php echo $loc ?>">
		<input type="hidden" name="hdncnt" value="<?php echo $countstart ?>">
		<!-- <input type="hidden" name="hdnsmlimg" value="<?php echo $rowsprodmncat_mst['prodmn_catm_smlimg']; ?>">
		<input type="hidden" name="hdnbnrimg" value="<?php echo $rowsprodmncat_mst['prodmn_catm_bnrimg']; ?>"> -->
		<input type="hidden" name="hdndskimg" value="<?php echo $rowsprodmncat_mst['prodmnlnksm_dskimg']; ?>">
		<input type="hidden" name="hdntabimg" value="<?php echo $rowsprodmncat_mst['prodmnlnksm_tabimg']; ?>">
		<input type="hidden" name="hdnmobimg" value="<?php echo $rowsprodmncat_mst['prodmnlnksm_mobimg']; ?>">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Name *</label>
							</div>
							<div class="col-sm-9">
								<input name="txtname" type="text" id="txtname" size="560" onBlur="funcChkDupName()" class="form-control" value="<?php echo $db_catname; ?>">
								<span id="errorsDiv_txtname"></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Description</label>
							</div>
							<div class="col-sm-9">
								<textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"><?php echo stripslashes($db_catdesc); ?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
					<div class="row mb-2 mt-2">
						<div class="col-sm-3">
							<label>Header Desktop Image</label>
						</div>
						<div class="col-sm-9">
							<div class="custom-file">
								<input name="fledskimg" type="file" class="form-control" id="fledskimg">
							</div>
							<?php
							$dskimgnm   = $rowsprodcat_mst['prodmnlnksm_dskimg'];
							$dskimgpath = $a_mnlnks_bnrfldnm . $dskimgnm;
							if (($dskimgnm != "") && file_exists($dskimgpath)) {
								echo "<img src='$dskimgpath' width='80pixel' height='80pixel'><br><input type='checkbox' name='chkbximg1' id='chkbximg1' value='$dskimgpath'>Remove Image";
							} else {
								echo "N.A.";
							}
							?>
						</div>
					</div>
					</div>
					<div class="col-md-12">
					<div class="row mb-2 mt-2">
						<div class="col-sm-3">
							<label>Header Tablet Image</label>
						</div>
						<div class="col-sm-9">
							<div class="custom-file">
								<input name="fletabimg" type="file" class="form-control" id="fletabimg">
							</div>
							<?php
							$tabimgnm   = $rowsprodcat_mst['prodmnlnksm_tabimg'];
							$tabimgpath = $a_mnlnks_bnrfldnm . $tabimgnm;
							if (($tabimgnm != "") && file_exists($tabimgpath)) {
								echo "<img src='$tabimgpath' width='80pixel' height='80pixel'><br><input type='checkbox' name='chkbximg2' id='chkbximg2' value='$tabimgpath'>Remove Image";
							} else {
								echo "N.A.";
							}
							?>
						</div>
					</div>
					</div>
					<div class="col-md-12">
					<div class="row mb-2 mt-2">
						<div class="col-sm-3">
							<label>Header Mobile Image</label>
						</div>
						<div class="col-sm-9">
							<div class="custom-file">
								<input name="flemobimg" type="file" class="form-control" id="flemobimg">
							</div>
							<?php
							$mobimgnm   = $rowsprodcat_mst['prodmnlnksm_mobimg'];
							$mobimgpath = $a_mnlnks_bnrfldnm . $mobimgnm;
							if (($mobimgnm != "") && file_exists($mobimgpath)) {
								echo "<img src='$mobimgpath' width='80pixel' height='80pixel'><br><input type='checkbox' name='chkbximg3' id='chkbximg3' value='$mobimgpath'>Remove Image";
							} else {
								echo "N.A.";
							}
							?>
						</div>
					</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Type</label>
							</div>
							<div class="col-sm-9">
								<select name="lstcattyp" id="lstcattyp" class="form-control">
									<option value="g" <?php if ($db_cattyp == 'g') echo 'selected'; ?>>General</option>
									<option value="d" <?php if ($db_cattyp == 'd') echo 'selected'; ?>>Department</option>
									<option value="m" <?php if ($db_cattyp == 'm') echo 'selected'; ?>>Important Links</option>
									<option value="f" <?php if ($db_cattyp == 'f') echo 'selected'; ?>>Footer Menu</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Menu Display Type</label>
							</div>
							<div class="col-sm-9">
								<select name="lstdsplytyp" id="lstdsplytyp" class="form-control">
									<option value="1" <?php if ($db_dsplytyp == '1') echo 'selected'; ?>>General</option>
									<option value="2" <?php if ($db_dsplytyp == '2') echo 'selected'; ?>>Mega Menu</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO Title</label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtseotitle" id="txtseotitle" size="45" maxlength="250" class="form-control" value="<?php echo $db_catseottl; ?>">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO Description</label>
							</div>
							<div class="col-sm-9">
								<textarea name="txtseodesc" rows="3" cols="60" id="txtseodesc" class="form-control"><?php echo stripslashes($db_catseodesc); ?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO Keyword</label>
							</div>
							<div class="col-sm-9">
								<textarea name="txtseokywrd" rows="3" cols="60" id="txtseokywrd" class="form-control"><?php echo stripslashes($db_catseokywrd); ?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO H1 </label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtseoh1" id="txtseoh1" size="45" maxlength="250" class="form-control" value="<?php echo $db_catseohone; ?>">
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO H2 </label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtseoh2" id="txtseoh2" size="45" maxlength="250" class="form-control" value="<?php echo $db_catseohtwo; ?>">
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Rank *</label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtprty" id="txtprty" class="form-control" size="4" maxlength="3" value="<?php echo $db_catprty; ?>">
								<span id="errorsDiv_txtprty"></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Status</label>
							</div>
							<div class="col-sm-9">
								<select name="lststs" id="lststs" class="form-control">
									<option value="a" <?php if ($db_catsts == 'a') echo 'selected'; ?>>Active</option>
									<option value="i" <?php if ($db_catsts == 'i') echo 'selected'; ?>>Inactive</option>
								</select>
							</div>
						</div>
					</div>
					<p class="text-center">
						<input type="Submit" class="btn btn-primary btn-cst" name="btneprodmnlnkssbmt" id="btneprodmnlnkssbmt" value="Submit">
						&nbsp;&nbsp;&nbsp;
						<input type="reset" class="btn btn-primary btn-cst" name="btnprodcatreset" value="Clear" id="btnprodcatreset">
						&nbsp;&nbsp;&nbsp;
						<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_vwpgnm; ?>?vw=<?php echo $id; ?>&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>'">


					</p>
				</div>
			</div>
		</div>
	</form>
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>
<script language="javascript" type="text/javascript">
	CKEDITOR.replace('txtdesc');
</script>