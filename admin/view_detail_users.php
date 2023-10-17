<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_detail_banner.php
Purpose : For Viewing Banner Details
Created By : Lokesh palagani
Created On :	27-07-2023
Modified By :
Modified On :
Purpose :
Company : Adroit
************************************************************/
global $id,$pg,$countstart;
$rd_crntpgnm = "view_all_users.php";
$rd_edtpgnm = "edit_users.php";
$clspn_val = "4";
/*****header link********/
$pagemncat = "Users";
$pagecat = "Users";
$pagenm = "Users";
/*****header link********/
if($ses_admtyp=='wm' || $ses_admtyp=='d'){
  ?>
		<script language="javascript">
			location.href = "../admin/index.php";
		</script>
	<?php
		exit();
}
if(isset($_REQUEST['vw']) && (trim($_REQUEST['vw'])!="") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg'])!="") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart'])!=""))
{
	$id = glb_func_chkvl($_REQUEST['vw']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
	$srchval = glb_func_chkvl($_REQUEST['val']);
}
$sqrylgn_mst = "SELECT lgnm_uid, lgnm_typ, if(lgnm_sts = 'a', 'Active','Inactive') as lgnm_sts,lgnm_dept_id
	from lgn_mst where lgnm_id = $id";
$srslgn_mst = mysqli_query($conn,$sqrylgn_mst);
$rowslgn_mst = mysqli_fetch_assoc($srslgn_mst);
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
		document.frmedtuser.action="<?php echo $rd_edtpgnm;?>?vw=<?php echo $id;?>&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$loc;?>";
		document.frmedtuser.submit();
	}
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View Users</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">View Users</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtuser" id="frmedtuser" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onSubmit="return performCheck('frmedtuser', rules, 'inline');">
		<input type="hidden" name="hdnbnrid" value="<?php echo $id;?>">
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
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Name</label>
							<div class="col-sm-8">
								<?php echo $rowslgn_mst['lgnm_uid'];?>
							</div>
						</div>

						<?php if($rowslgn_mst['lgnm_typ']=='d'){
							?>
							<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Department</label>
							<div class="col-sm-8">
								<?php
								$dept_id=$rowslgn_mst['lgnm_dept_id'];
								$dept="SELECT prodcatm_name,prodcatm_id from prodcat_mst where prodcatm_id='$dept_id'";
								$res=mysqli_query($conn,$dept);
								$result=mysqli_fetch_assoc($res);
								echo $result['prodcatm_name'];

								 ?>
							</div>
						</div>
							<?php
						}?>

						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Display Type</label>
							<div class="col-sm-8">
						<?php if($rowslgn_mst['lgnm_typ']=='wm') echo 'Website Management';?>
								<?php if($rowslgn_mst['lgnm_typ']=='d') echo 'Department';?>


							</div>
						</div>


						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status</label>
							<div class="col-sm-8">
								<?php echo $rowslgn_mst['lgnm_sts'];?>
							</div>
						</div>
						<p class="text-center">
							<input type="Submit" class="btn btn-primary btn-cst" name="frmedtuser" id="frmedtuser" value="Edit"
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