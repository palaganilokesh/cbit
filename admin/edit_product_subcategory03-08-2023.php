<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/**********************************************************
Programm : edit_product_subcategory.php 
Purpose : For Editing sub category
Created By : Bharath
Created On : 20-01-2022
Modified By : 
Modified On : 
Purpose : 
Company : Adroit
 ************************************************************/
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Product Group";
$pagenm = "Subcategory";
/*****header link********/
global $id, $pg, $countstart;
$rd_vwpgnm = "view_detail_product_subcategory.php";
$rd_crntpgnm = "view_product_subcategory.php";
$clspn_val = "4";
if (isset($_POST['btneprodscatsbmt']) && (trim($_POST['btneprodscatsbmt']) != "") && isset($_POST['lstprodcat']) && (trim($_POST['lstprodcat']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['hdnprodscatid']) && (trim($_POST['hdnprodscatid']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")) {
	include_once "../includes/inc_fnct_fleupld.php"; // For uploading files
	include_once "../database/uqry_prodsubcat_mst.php";
}
if (isset($_REQUEST['edit']) && (trim($_REQUEST['edit']) != "") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg']) != "") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart']) != "")) {
	$id = glb_func_chkvl($_REQUEST['edit']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
} elseif (isset($_REQUEST['hdnprodscatid']) && (trim($_REQUEST['hdnprodscatid']) != "") && isset($_REQUEST['hdnpage']) && (trim($_REQUEST['hdnpage']) != "") && isset($_REQUEST['hdncnt']) && (trim($_REQUEST['hdncnt']) != "")) {
	$id = glb_func_chkvl($_REQUEST['hdnprodscatid']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
}
$sqryprodscat_mst = "select 
prodscatm_name,prodscatm_sts,prodscatm_desc,prodscatm_prty,
prodscatm_prodcatm_id,prodscatm_seotitle,prodscatm_seodesc,prodscatm_seokywrd,
prodscatm_seohone,prodscatm_seohtwo,prodcatm_name,prodscatm_prodmnlnksm_id,
prodscatm_typ,prodscatm_bnrimg,prodmnlnksm_name,prodscatm_dpthead,prodscatm_dptname,
prodscatm_dpttitle
from 
prodscat_mst 
inner join   prodcat_mst on prodcatm_id = prodscatm_prodcatm_id
inner join   prodmnlnks_mst on prodmnlnksm_id =prodscatm_prodmnlnksm_id
where 
prodscatm_id=$id";
$srsprodscat_mst = mysqli_query($conn, $sqryprodscat_mst);
$cntrec = mysqli_num_rows($srsprodscat_mst);
if ($cntrec > 0) {
	$rowsprodscat_mst = mysqli_fetch_assoc($srsprodscat_mst);
} else { ?>
	<script>
		location.href = "<?php echo $rd_crntpgnm; ?>";
	</script>
<?php
	exit();
}
?>
<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
	var rules = new Array();
	rules[0] = 'txtname:Name|required|Enter Name';
	rules[1] = 'lstprodmcat:Main Category|required|Select Main Category';
	rules[2] = 'lstprodcat:Category|required|Select Category';
	rules[3] = 'txtprior:Priority|required|Enter Rank';
	rules[4] = 'txtprior:Priority|numeric|Enter Only Numbers';

	function setfocus() {
		document.getElementById('lstprodmcat').focus();
	}
</script>
<?php
include_once('script.php');
include_once('../includes/inc_fnct_ajax_validation.php');
?>
<script language="javascript" type="text/javascript">
	function funcChkDupName() {
		debugger;
		var name = document.getElementById('txtname').value;
		var prodmncatid = document.getElementById('lstprodmcat').value;
		var prodcatid = document.getElementById('lstprodcat').value;
		id = <?php echo $id; ?>;
		if (prodmncatid != "" && prodcatid != "" && name != "" && id != "") {
			var url = "chkduplicate.php?prodscatname=" + name + "&prodmncatid=" + prodmncatid + "&prodcatid=" + prodcatid + "&subcatid=" + id;
			xmlHttp = GetXmlHttpObject(stateChanged);
			xmlHttp.open("GET", url, true);
			xmlHttp.send(null);
		} else {
			document.getElementById('errorsDiv_lstprodmcat').innerHTML = "";
			document.getElementById('errorsDiv_lstprodcat').innerHTML = "";
			document.getElementById('errorsDiv_txtname').innerHTML = "";
		}
	}

	function stateChanged() {
		if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
			var temp = xmlHttp.responseText;
			//alert(temp);
			document.getElementById("errorsDiv_txtname").innerHTML = temp;
			if (temp != 0) {
				document.getElementById('txtname').focus();
			}
		}
	}

	function get_cat() {
		var mncatval = $("#lstprodmcat").val();
		$.ajax({
			type: "POST",
			url: "../includes/inc_getStsk.php",
			data: 'mncatval=' + mncatval,
			success: function(data) {
				// alert(data)
				$("#lstprodcat").html(data);
			}
		});
	}
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Sub Category</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Sub Category</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtscat" id="frmedtscat" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return performCheck('frmedtscat', rules, 'inline');" enctype="multipart/form-data">
		<input type="hidden" name="hdnprodscatid" value="<?php echo $id; ?>">
		<input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
		<input type="hidden" name="hdncnt" value="<?php echo $countstart ?>">
		<input type="hidden" name="hdnloc" value="<?php echo $loc ?>">
		<input type="hidden" name="hdnscatimg" id="hdnscatimg" value="<?php echo $rowsvehbrnd_mst['prodscatm_szchrtimg']; ?>">
		<input type="hidden" name="hdnscatbnrimg" id="hdnscatbnrimg" value="<?php echo $rowsvehbrnd_mst['prodscatm_bnrimg']; ?>">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center align-items-center">
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Main Link *</label>
							</div>
							<div class="col-sm-9">
								<?php
								$sqryprodmncat_mst = "select 
								prodmnlnksm_id,prodmnlnksm_name						
								from 
								prodmnlnks_mst 
								where	 
								prodmnlnksm_sts = 'a'
								order by
							   prodmnlnksm_name";
								$rsprodmncat_mst = mysqli_query($conn, $sqryprodmncat_mst);
								$cnt_prodmncat = mysqli_num_rows($rsprodmncat_mst);
								?>
								<select name="lstprodmcat" id="lstprodmcat" class="form-control" onchange="get_cat();">
									<option value="">--Select Main Link--</option>
									<?php
									if ($cnt_prodmncat > 0) {
										while ($rowsprodmncat_mst = mysqli_fetch_assoc($rsprodmncat_mst)) {
											$mncatid = $rowsprodmncat_mst['prodmnlnksm_id'];
											$mncatname = $rowsprodmncat_mst['prodmnlnksm_name'];
									?>
											<option value="<?php echo $mncatid; ?>" <?php if ($rowsprodscat_mst['prodscatm_prodmnlnksm_id'] == $mncatid) echo 'selected';  ?>><?php echo $mncatname; ?></option>
									<?php
										}
									}
									?>
								</select>
								<span id="errorsDiv_lstprodcat"></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Category *</label>
							</div>
							<div class="col-sm-9">
								<select name="lstprodcat" id="lstprodcat" class="form-control">
									<option value="<?php echo $rowsprodscat_mst['prodscatm_prodcatm_id']; ?>"><?php echo $rowsprodscat_mst['prodcatm_name']; ?></option>
								</select>
								<span id="errorsDiv_lstprodcat"></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Name *</label>
							</div>
							<div class="col-sm-9">
								<input name="txtname" type="text" id="txtname" size="45" maxlength="40" onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsprodscat_mst['prodscatm_name']; ?>">
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
								<textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"><?php echo stripslashes($rowsprodscat_mst['prodscatm_desc']); ?></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Banner Image</label>
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input name="flescatimg" type="file" class="form-control" id="flescatimg">
								</div>
								<?php
								$scatbnrimgnm = $rowsprodscat_mst['prodscatm_bnrimg'];
								$scatbnrimgpath = $a_scat_bnrfldnm . $scatbnrimgnm;
								if (($scatbnrimgnm != "") && file_exists($scatbnrimgpath)) {
									echo "<img src='$scatbnrimgpath' width='60pixel' height='60pixel'><br><input type='checkbox' name='chkbximg' id='chkbximg' value='$scatbnrimgpath'>Remove Image";
									// echo "<img src='$scatbnrimgpath' width='50pixel' height='50pixel'>";
								} else {
									echo "N.A";
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
								<?php $db_scattype	 = $rowsprodscat_mst['prodscatm_typ']; ?>
								<select name="lsttyp" id="lsttyp" class="form-control">

									<option value="1" <?php if ($db_scattype == '1') echo 'selected'; ?>>Page Content</option>
									<option value="2" <?php if ($db_scattype == '2') echo 'selected'; ?>>Photo Gallery</option>
									<option value="3" <?php if ($db_scattype == '3') echo 'selected'; ?>>Video Gallery</option>
									<option value="4" <?php if ($db_scattype == '4') echo 'selected'; ?>>Link</option>

								</select>

							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Department Title</label>
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input name="txtdpttitle" type="text" id="txtdpttitle" class="form-control" value="<?php echo $rowsprodscat_mst['prodscatm_dpttitle']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Head of the Department Name </label>
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input name="txtdpthednm" type="text" id="txtdpthednm" class="form-control" value="<?php echo $rowsprodscat_mst['prodscatm_dpthead']; ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label> Department Name (branch)</label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtdptnm" id="txtdptnm" size="45" maxlength="250" class="form-control" value="<?php echo $rowsprodscat_mst['prodscatm_dptname']; ?>">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO Title</label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtseotitle" id="txtseotitle" size="45" maxlength="250" class="form-control" value="<?php echo $rowsprodscat_mst['prodscatm_seotitle']; ?>">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO Description</label>
							</div>
							<div class="col-sm-9">
								<textarea name="txtseodesc" rows="3" cols="60" id="txtseodesc" class="form-control"><?php echo stripslashes($rowsprodscat_mst['prodscatm_seodesc']); ?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO Keyword</label>
							</div>
							<div class="col-sm-9">
								<textarea name="txtkywrd" rows="3" cols="60" id="txtkywrd" class="form-control"><?php echo stripslashes($rowsprodscat_mst['prodscatm_seokywrd']); ?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO H1 </label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtseoh1" id="txtseoh1" size="45" maxlength="250" class="form-control" value="<?php echo $rowsprodscat_mst['prodscatm_seohone']; ?>">
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>SEO H2 </label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtseoh2" id="txtseoh2" size="45" maxlength="250" class="form-control" value="<?php echo $rowsprodscat_mst['prodscatm_seohtwo']; ?>">
							</div>
						</div>
					</div>

					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Rank *</label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtprior" id="txtprior" class="form-control" size="4" maxlength="3" value="<?php echo $rowsprodscat_mst['prodscatm_prty']; ?>">
								<span id="errorsDiv_txtprior"></span>
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
									<option value="a" <?php if ($rowsprodscat_mst['prodscatm_sts'] == 'a') echo 'selected'; ?>>Active</option>
									<option value="i" <?php if ($rowsprodscat_mst['prodscatm_sts'] == 'i') echo 'selected'; ?>>Inactive</option>
								</select>

							</div>
						</div>
					</div>
					<p class="text-center">
						<input type="Submit" class="btn btn-primary" name="btneprodscatsbmt" id="btneprodscatsbmt" value="Submit">
						&nbsp;&nbsp;&nbsp;
						<input type="reset" class="btn btn-primary" name="btnprodscatreset" value="Clear" id="btnprodscatreset">
						&nbsp;&nbsp;&nbsp;
						<input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
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