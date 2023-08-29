<?php
include_once '../includes/inc_config.php'; //Making paging validation	
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_detail_gnrlenqry.php	
Purpose : For Viewing gnrlenqry Details
Created By : Bharath
Created On :	27-12-2021
Modified By : 
Modified On :
Purpose : 
Company : Adroit
************************************************************/
global $id,$pg,$countstart;
$rd_crntpgnm = "view_all_genral_enq.php";
// $rd_edtpgnm = "edit_gnrlenqry.php";
$clspn_val = "4";
/*****header link********/
$pagemncat = "Enquiry";
$pagecat = "enquiry";
$pagenm = "enquiry";
/*****header link********/
if(isset($_REQUEST['vw']) && (trim($_REQUEST['vw'])!="") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg'])!="") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart'])!=""))
{
	$id = glb_func_chkvl($_REQUEST['vw']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
	$srchval = glb_func_chkvl($_REQUEST['val']);
}
$sqrygnrlenqry_mst = "SELECT gnrlenqrym_name, gnrlenqrym_msg, gnrlenqrym_sub,gnrlenqrym_emailid,gnrlenqrym_phno,gnrlenqrym_crtdon
	from gnrlenqry_mst where gnrlenqrym_id = $id";
$srsgnrlenqry_mst = mysqli_query($conn,$sqrygnrlenqry_mst);
$rowsgnrlenqry_mst = mysqli_fetch_assoc($srsgnrlenqry_mst);
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

<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">View General Enquiry Form</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">View General Enquiry Form</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtgnrlenqryid" id="frmedtgnrlenqryid" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onSubmit="return performCheck('frmedtgnrlenqryid', rules, 'inline');">
		<input type="hidden" name="hdngnrlenqryid" value="<?php echo $id;?>">
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
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Nmae</label>
							<div class="col-sm-8">
								<?php echo $rowsgnrlenqry_mst['gnrlenqrym_name'];?>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Email</label>
							<div class="col-sm-8">
								<?php echo $rowsgnrlenqry_mst['gnrlenqrym_emailid'];?>
							</div>
						</div>
                        <div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Date&Time</label>
							<div class="col-sm-8">
								<?php echo $rowsgnrlenqry_mst['gnrlenqrym_crtdon'];?>
							</div>
						</div>
						<div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Subject</label>
							<div class="col-sm-8">
								<?php echo $rowsgnrlenqry_mst['gnrlenqrym_sub'];?>
							</div>
						</div>
                        <div class="form-group row">
							<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Message</label>
							<div class="col-sm-8">
								<?php echo $rowsgnrlenqry_mst['gnrlenqrym_msg'];?>
							</div>
						</div>
                        
						<p class="text-center">
							
							<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_crntpgnm;?>?<?php echo $loc;?>'">
						</p>
					</div>
				</div>
			</div>
		</div>
	</form> 
</section>
<?php include_once "../includes/inc_adm_footer.php";?>