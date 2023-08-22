<?php
include_once '../includes/inc_config.php'; //Making paging validation	
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_detail_product_category.php	
Purpose : For Viewing Category Details
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
$pagenm = "Category";
/*****header link********/
global $id, $pg, $countstart;
$rd_crntpgnm = "view_product_category.php";
$rd_edtpgnm = "edit_product_category.php";
$clspn_val = "4";
if (isset($_REQUEST['vw']) && (trim($_REQUEST['vw']) != "") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg']) != "") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart']) != "")) {
	$id = glb_func_chkvl($_REQUEST['vw']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
	$srchval = glb_func_chkvl($_REQUEST['val']);
	$chk = glb_func_chkvl($_REQUEST['chk']);
}

$sqryprodcat_mst = "SELECT prodcatm_id,
prodcatm_name,prodcatm_desc,prodcatm_seotitle,prodcatm_seodesc,
prodcatm_seohone,prodcatm_seohtwo,prodcatm_seokywrd,prodcatm_prty, 
if(prodcatm_sts = 'a', 'Active','Inactive') as prodcatm_sts,
prodcatm_typ,prodcatm_dsplytyp,prodcatm_bnrimg,prodcatm_prodmnlnksm_id,
prodmnlnksm_name,prodcatm_icn,prodcatm_admtyp
from 
prodcat_mst
inner join 	prodmnlnks_mst
on		prodmnlnks_mst.prodmnlnksm_id=prodcat_mst.prodcatm_prodmnlnksm_id
where 
prodcatm_id=$id";
$srsprodcat_mst  = mysqli_query($conn, $sqryprodcat_mst);
$cntrecprodcat_mst = mysqli_num_rows($srsprodcat_mst);
if ($cntrecprodcat_mst  > 0) {
	$rowsprodcat_mst = mysqli_fetch_assoc($srsprodcat_mst);
	$db_mnlnksnm		 = $rowsprodcat_mst['prodmnlnksm_name'];
	$db_catname		 = $rowsprodcat_mst['prodcatm_name'];
	$db_catid	 = $rowsprodcat_mst['prodcatm_id'];
	$db_catdesc		 = stripslashes($rowsprodcat_mst['prodcatm_desc']);
	$db_cattyp		 = $rowsprodcat_mst['prodcatm_typ'];
	$db_dsplytyp     = $rowsprodcat_mst['prodcatm_dsplytyp'];
	$db_catseottl	 = $rowsprodcat_mst['prodcatm_seotitle'];
	$db_catseodesc	 = $rowsprodcat_mst['prodcatm_seodesc'];
	$db_catseokywrd	 = $rowsprodcat_mst['prodcatm_seokywrd'];
	$db_catseohone	 = $rowsprodcat_mst['prodcatm_seohone'];
	$db_catseohtwo	 = $rowsprodcat_mst['prodcatm_seohtwo'];
	$db_catprty		 = $rowsprodcat_mst['prodcatm_prty'];
	$db_catsts		 = $rowsprodcat_mst['prodcatm_sts'];
	$db_typ		 = $rowsprodcat_mst['prodcatm_admtyp'];
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
		document.frmedtprodcat.action = "<?php echo $rd_edtpgnm; ?>?vw=<?php echo $id; ?>&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
		document.frmedtprodcat.submit();
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
					<h1 class="m-0 text-dark">View Category</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">View Category</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtprodcat" id="frmedtprodcat" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return performCheck('frmedtprodcat', rules, 'inline');">
		<input type="hidden" name="hdnprodcatid" value="<?php echo $id; ?>">
		<input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
		<input type="hidden" name="hdncnt" value="<?php echo $countstart ?>">
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
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Main Link </label>
							<div class="col-sm-8">
								<?php echo $db_mnlnksnm; ?>
							</div>
						</div>
						<?php if($db_mnlnksnm=='Admissions'||$db_mnlnksnm=='Departments'){
							?>
<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Type </label>
							<div class="col-sm-8">
								<?php echo $db_typ; ?>
							</div>
						</div>
							<?php
						}?>
						
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Category Name </label>
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
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Baner Image</label>
							<div class="col-sm-8">
								<?php
								$imgnm   = $rowsprodcat_mst['prodcatm_bnrimg'];
								$imgpath = $a_cat_bnrfldnm . $imgnm;
								if (($imgnm != "") && file_exists($imgpath)) {
									echo "<img src='$imgpath' width='80pixel' height='80pixel'>";
								} else {
									echo "N.A.";
								}
								?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label"> Icon</label>
							<div class="col-sm-8">
								<?php
								$imgnm   = $rowsprodcat_mst['prodcatm_icn'];
								$imgpath = $a_cat_icnfldnm . $imgnm;
								if (($imgnm != "") && file_exists($imgpath)) {
									echo "<img src='$imgpath' width='80pixel' height='80pixel'>";
								} else {
									echo "N.A.";
								}
								?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Type </label>
							<div class="col-sm-8">
								<?php echo funcDispcattyp($db_cattyp); ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Display Type </label>
							<div class="col-sm-8">
								<?php echo funcDsplyTyp($db_dsplytyp);; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Title </label>
							<div class="col-sm-8">
								<?php echo $db_catseottl; ?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label"> SEO Description</label>
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

						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H2 </label>
							<div class="col-sm-8">
								<?php echo $db_catseohtwo; ?>
							</div>
						</div>

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
						<div class="table-responsive">
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="10%" align="center"><strong>SL.No.</strong></td>
										<td width="35%" align="center"><strong>Name</strong></td>
										<td width="35%" align="center"><strong>Description</strong></td>
										<td width="10%" align="center"><strong>Rank</strong></td>
										<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>
						<?php
						$sqns="SELECT pgqnsd_id,pgqnsd_name,pgqnsd_pgcntsd_id,pgqnsd_vdo,
						 pgqnsd_prty,pgqnsd_sts from pgqns_dtl where pgqnsd_pgcntsd_id='$db_catid' and pgqnsd_name!='' order by pgqnsd_id";
						$srsns = mysqli_query($conn, $sqns);
						$cntqns=mysqli_num_rows($srsns);
						if ($cntqns > 0) {
							
					
						$nfiles = "";
						while ($rowsns = mysqli_fetch_assoc($srsns)) {
							$nfiles+=1;
							?>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="10%" align="center"><?php echo $nfiles ?></td>
								<?php $arytitle = explode("-",$rowsns['pgqnsd_name']);?>
										<td width="35%" align="center"><?php echo $arytitle[1]; ?></td>
										<td width="35%" align="center"><?php echo $rowsns['pgqnsd_vdo']; ?></td>
										
										<td width="10%" align="center"><?php echo $rowsns['pgqnsd_prty']; ?></td>
										<td width="10%" align="center"><?php echo $rowsns['pgqnsd_sts']; ?></td>
								</tr>
							</table>
							<?php
						}
					}
					else{
						?>
						<td width="10%"  align="center"><?php echo "No Record Found"; ?></td>
						
				<?php	}
						?>
						<p class="text-center">
							<input type="Submit" class="btn btn-primary btn-cst" name="frmedtprodcat" id="frmedtprodcat" value="Edit" onclick="update1()">
							&nbsp;&nbsp;&nbsp;
							<input type="reset" class="btn btn-primary btn-cst" name="btnprodcatreset" value="Clear" id="btnprodcatreset">
							&nbsp;&nbsp;&nbsp;
							<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_crntpgnm; ?>?<?php echo $loc; ?>'">
						</p>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>