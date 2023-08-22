<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/**********************************************************
Programm : edit_alumni.php 
Purpose : For Editing alumni
Created By : Bharath
Created On : 05-01-2022
Modified By : 
Modified On : 
Purpose : 
Company : Adroit
************************************************************/ 
/*****header link********/
$pagemncat = "Setup";
$pagecat = "alumni";
$pagenm = "alumni";
/*****header link********/
global $id,$pg,$countstart;
$rd_vwpgnm = "view_detail_alumni.php";
$rd_crntpgnm = "view_all_alumni.php";
$clspn_val = "4";
if(isset($_POST['btnealumnisbmt']) && (trim($_POST['btnealumnisbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	include_once "../includes/inc_fnct_fleupld.php"; // For uploading files 
	include_once "../database/uqry_alumni_mst.php";
}
if(isset($_REQUEST['edit']) && (trim($_REQUEST['edit'])!="") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg'])!="") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart'])!=""))
{
	$id = glb_func_chkvl($_REQUEST['edit']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
}
elseif(isset($_REQUEST['hdnalumniid']) && (trim($_REQUEST['hdnalumniid'])!="") && isset($_REQUEST['hdnpage']) && (trim($_REQUEST['hdnpage'])!="") && isset($_REQUEST['hdncnt']) && (trim($_REQUEST['hdncnt'])!=""))
{
	$id = glb_func_chkvl($_REQUEST['hdnalumniid']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
}
$sqryalumni_mst = "SELECT alumnim_name, alumnim_desc, alumnim_sts, alumnim_prty, alumnim_lnk,alumnim_imgnm, alumnim_batch,alumnim_job from alumni_mst where alumnim_id = $id";
$srsalumni_mst = mysqli_query($conn,$sqryalumni_mst);
$cntrec = mysqli_num_rows($srsalumni_mst);
if($cntrec > 0)
{
	$rowsalumni_mst = mysqli_fetch_assoc($srsalumni_mst);
}
else
{ ?>
	<script>location.href = "<?php echo $rd_crntpgnm; ?>";</script>
	<?php
	exit();
}
?>
<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
	var rules=new Array();
	rules[0]='txtname:Name|required|Enter Name';
//   rules[1]='txtname:Name|alphaspace|Name only characters and numbers';
  rules[2]='txtprior:Priority|required|Enter Rank';
  rules[3]='txtbatch:Priority|required|Enter Batch and Department';
  rules[4]='txtjob:job|required|Enter Job Name';
//   rules[2]='alumnim_btn_name:Priority|required|Enter Button Name';
  
  function setfocus()
  {
  	document.getElementById('txtname').focus();
  }
</script>
<?php 
include_once ('script.php');
include_once ('../includes/inc_fnct_ajax_validation.php');	
?>
<script language="javascript" type="text/javascript">
	function funcChkDupName()
	{
		var name = document.getElementById('txtname').value;
		id = <?php echo $id;?>;
		if(name != "")
		{
			var url = "chkduplicate.php?alumniname="+name+"&alumniid="+id;
			xmlHttp	= GetXmlHttpObject(stateChanged);
			xmlHttp.open("GET", url , true);
			xmlHttp.send(null);
		}
		else
		{
			document.getElementById('errorsDiv_txtname').innerHTML = "";
		}
	}
	function stateChanged()
	{
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			var temp=xmlHttp.responseText;
			// alert(temp);
			document.getElementById("errorsDiv_txtname").innerHTML = temp;
			if(temp!=0)
			{
				document.getElementById('txtname').focus();
			}
		}
	}
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit alumni</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit alumni</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtalumniid" id="frmedtalumniid" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onSubmit="return performCheck('frmedtalumniid', rules, 'inline');" enctype="multipart/form-data">
		<input type="hidden" name="hdnalumniid" value="<?php echo $id;?>">
		<input type="hidden" name="hdnpage" value="<?php echo $pg;?>">
		<input type="hidden" name="hdncnt" value="<?php echo $countstart?>">
		<input type="hidden" name="hdnloc" value="<?php echo $loc?>">
		<input type="hidden" name="hdnalumniimg" id="hdnalumniimg" value="<?php echo $rowsalumni_mst['alumnim_imgnm'];?>">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center align-items-center">
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Name *</label>
							</div>
							<div class="col-sm-9">
								<input name="txtname" type="text" id="txtname" size="560"  onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsalumni_mst['alumnim_name']; ?>">
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
								<textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"><?php echo $rowsalumni_mst['alumnim_desc']; ?></textarea>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Image</label>
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input name="flealumniimg" type="file" class="form-control" id="flealumniimg">
								</div>
								<?php
								$alumniimgnm = $rowsalumni_mst['alumnim_imgnm'];
								$alumniimgpath  = $galumni_fldnm.$alumniimgnm;
								if(($alumniimgnm !="") && file_exists($alumniimgpath))
								{
									echo "<img src='$alumniimgpath' width='50pixel' height='50pixel'>";
								}
								else
								{
									echo "Image not available";
								}
								?>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Link</label>
							</div>
							<div class="col-sm-9"> 
								<input type="text" name="txtlnk" id="txtlnk" size="45" maxlength="250" class="form-control" value="<?php echo $rowsalumni_mst['alumnim_lnk']; ?>">
							</div>
						</div>
					</div>
                    <div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Batch</label>
							</div>
							<div class="col-sm-9"> 
								<input type="text" name="txtbatch" id="txtbatch" size="45"  placeholder="BE 2005, Civil" maxlength="250" class="form-control" value="<?php echo $rowsalumni_mst['alumnim_batch']; ?>">
                                <span id="errorsDiv_txtbatch"></span>
							</div>
						</div>
					</div>
                    <div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Job</label>
							</div>
							<div class="col-sm-9"> 
								<input type="text" name="txtjob" id="txtjob" size="45" maxlength="250" placeholder="Actor,Software.." class="form-control" value="<?php echo $rowsalumni_mst['alumnim_job']; ?>">
                                <span id="errorsDiv_txtjob"></span>
							</div>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Rank *</label>
							</div>
							<div class="col-sm-9"> 
								<input type="text" name="txtprior" id="txtprior" class="form-control" size="4" maxlength="3" value="<?php echo $rowsalumni_mst['alumnim_prty']; ?>">
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
									<option value="a"<?php if($rowsalumni_mst['alumnim_sts']=='a') echo 'selected';?>>Active</option>
									<option value="i"<?php if($rowsalumni_mst['alumnim_sts']=='i') echo 'selected';?>>Inactive</option>
								</select>
								
							</div>
						</div>
					</div>
					<p class="text-center">
						<input type="Submit" class="btn btn-primary" name="btnealumnisbmt" id="btnealumnisbmt" value="Submit">
						&nbsp;&nbsp;&nbsp;
						<input type="reset" class="btn btn-primary" name="btnbrndreset" value="Clear" id="btnbrndreset">
						&nbsp;&nbsp;&nbsp;
						<input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm ;?>'">
					</p>
				</div>
			</div>
		</div>
 	</form>
</section>
<?php include_once "../includes/inc_adm_footer.php";?>
<script language="javascript" type="text/javascript">
	CKEDITOR.replace('txtdesc');
</script>