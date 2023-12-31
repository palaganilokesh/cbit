<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_detail_product_subcategory.php
Purpose : For Viewing sub category Details
Created By : Bharath
Created On :	21-01-2022
Modified By :
Modified On :
Purpose :
Company : Adroit
************************************************************/
global $id,$pg,$countstart;
$rd_crntpgnm = "view_product_subcategory.php";
$rd_edtpgnm = "edit_product_subcategory.php";
$clspn_val = "4";
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Product Group";
$pagenm = "Subcategory";
/*****header link********/
if(isset($_REQUEST['vw']) && (trim($_REQUEST['vw'])!="") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg'])!="") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart'])!=""))
{
	$id = glb_func_chkvl($_REQUEST['vw']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
	$srchval = glb_func_chkvl($_REQUEST['val']);
}
$sqryprodscat_mst="select
prodscatm_id,prodscatm_name,prodscatm_desc,prodscatm_prodcatm_id,
prodscatm_prodmnlnksm_id,prodcatm_prty,
if(prodscatm_sts = 'a', 'Active','Inactive') as prodscatm_sts,prodscatm_prty,
prodscatm_seotitle,prodscatm_seodesc,prodscatm_seokywrd,prodscatm_seohone,
prodscatm_seohtwo,prodcatm_name,prodscatm_typ,
prodscatm_dskimg,prodscatm_tabimg,prodscatm_mobimg,prodmnlnksm_name,prodscatm_dpthead,prodscatm_dptname,
 prodscatm_dpttitle
from
 prodscat_mst inner join prodcat_mst on prodcatm_id = prodscatm_prodcatm_id
inner join prodmnlnks_mst on prodmnlnksm_id = prodscatm_prodmnlnksm_id
where
prodscatm_id=$id";
$srsprodscat_mst  = mysqli_query($conn,$sqryprodscat_mst);
$rowsprodscat_mst = mysqli_fetch_assoc($srsprodscat_mst);

$db_scattype	 = $rowsprodscat_mst['prodscatm_typ'];//type
$loc= "&val=$srchval";
if(isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y"))
{
	$msg = "<font color=red>Record updated successfully</font>";
}
elseif(isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "n"))
{
	$msg = "<font color=red>Record not updated</font>";
}
elseif(isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "d"))
{
	$msg = "<font color=red>Duplicate Recored Name Exists & Record Not updated</font>";
}
?>
<script language="javascript">
	function update1() //for update download details
	{
		document.frmedtprodscatid.action="<?php echo $rd_edtpgnm;?>?vw=<?php echo $id;?>&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$loc;?>";
		document.frmedtprodscatid.submit();
	}
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View Sub Category</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">View Sub Category</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtprodscatid" id="frmedtprodscatid" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onSubmit="return performCheck('frmedtprodscatid', rules, 'inline');">
		<input type="hidden" name="hdnprodscatid" value="<?php echo $id;?>">
		<input type="hidden" name="hdnpage" value="<?php echo $pg;?>">
		<input type="hidden" name="hdncnt" value="<?php echo $countstart?>">
		<?php
		if($msg !='')
		{
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
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Main Links</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodmnlnksm_name'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Category</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodcatm_name'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Name</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_name'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Description</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_desc'];?>
							</div>
						</div>

							<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Desktop Image</label>
							<div class="col-sm-8">
								<?php
								$scatdskimgnm = $rowsprodscat_mst['prodscatm_dskimg'];
								$scatdskimgpath = $a_scat_bnrfldnm.$scatdskimgnm;
								if(($scatdskimgnm !="") && file_exists($scatdskimgpath))
								{
									echo "<img src='$scatdskimgpath' width='50pixel' height='50pixel'>";
								}
								else
								{
									echo "Image not available";
								}
								?>
							</div>
							</div>
							<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Tablet Image</label>
							<div class="col-sm-8">
								<?php
								$scattabimgnm = $rowsprodscat_mst['prodscatm_tabimg'];
								$scattabimgpath = $a_scat_bnrfldnm.$scattabimgnm;
								if(($scattabimgnm !="") && file_exists($scattabimgpath))
								{
									echo "<img src='$scattabimgpath' width='50pixel' height='50pixel'>";
								}
								else
								{
									echo "Image not available";
								}
								?>
							</div>
							</div>
							<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Mobile Image</label>
							<div class="col-sm-8">
								<?php
								$scatmobimgnm = $rowsprodscat_mst['prodscatm_mobimg'];
								$scatmobimgpath = $a_scat_bnrfldnm.$scatmobimgnm;
								if(($scatmobimgnm !="") && file_exists($scatmobimgpath))
								{
									echo "<img src='$scatmobimgpath' width='50pixel' height='50pixel'>";
								}
								else
								{
									echo "Image not available";
								}
								?>
							</div>
							</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Type</label>
							<div class="col-sm-8">
								<?php echo funcDsplyCattwoTyp($db_scattype);?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Department  Title</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_dpttitle'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Head of the Department Name</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_dpthead'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Title</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_seotitle'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Description</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_seodesc'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO Keyword</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_seokywrd'];?>
							</div>
						</div>

						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H1</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_seohone'];?>
							</div>
						</div>

						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">SEO H2 </label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_seohtwo'];?>
							</div>
						</div>

						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Rank</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_prty'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status</label>
							<div class="col-sm-8">
								<?php echo $rowsprodscat_mst['prodscatm_sts'];?>
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
						 pgqnsd_prty,pgqnsd_sts from pgqns_dtl where pgqnsd_pgcntsd_id='$id' and pgqnsd_name!='' order by pgqnsd_id";
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

										<td width="35%" align="center"><?php echo $rowsns['pgqnsd_name']; ?></td>
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
							<input type="Submit" class="btn btn-primary btn-cst" name="frmedtprodscatid" id="frmedtprodscatid" value="Edit"
							onclick="update1();">
							&nbsp;&nbsp;&nbsp;
							<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_crntpgnm;?>?<?php echo $loc;?>'">
						</p>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
<?php include_once "../includes/inc_adm_footer.php";?>