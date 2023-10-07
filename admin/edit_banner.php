<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/**********************************************************
Programm : edit_banner.php
Purpose : For Editing Banner
Created By : Bharath
Created On : 05-01-2022
Modified By :
Modified On :
Purpose :
Company : Adroit
************************************************************/
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Banner";
$pagenm = "Banner";
/*****header link********/
global $id,$pg,$countstart;
$rd_vwpgnm = "view_detail_banner.php";
$rd_crntpgnm = "view_all_banner.php";
$clspn_val = "4";
if(isset($_POST['btnebnrsbmt']) && (trim($_POST['btnebnrsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	include_once "../includes/inc_fnct_fleupld.php"; // For uploading files
	include_once "../database/uqry_bnr_mst.php";
}
if(isset($_REQUEST['edit']) && (trim($_REQUEST['edit'])!="") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg'])!="") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart'])!=""))
{
	$id = glb_func_chkvl($_REQUEST['edit']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);
}
elseif(isset($_REQUEST['hdnbnrid']) && (trim($_REQUEST['hdnbnrid'])!="") && isset($_REQUEST['hdnpage']) && (trim($_REQUEST['hdnpage'])!="") && isset($_REQUEST['hdncnt']) && (trim($_REQUEST['hdncnt'])!=""))
{
	$id = glb_func_chkvl($_REQUEST['hdnbnrid']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
}
 $sqrybnr_mst = "SELECT bnrm_name, bnrm_desc, bnrm_sts,bnrm_text, bnrm_prty, bnrm_lnk,bnrm_btn_name, dskm_imgnm, tabm_imgnm, mobm_imgnm from bnr_mst where bnrm_id = $id";
$srsbnr_mst = mysqli_query($conn,$sqrybnr_mst);
$cntrec = mysqli_num_rows($srsbnr_mst);
if($cntrec > 0)
{
	$rowsbnr_mst = mysqli_fetch_assoc($srsbnr_mst);
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
  rules[1]='txtname:Name|alphaspace|Name only characters and numbers';
  rules[2]='txtprior:Priority|required|Enter Rank';
//   rules[2]='bnrm_btn_name:Priority|required|Enter Button Name';

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
			var url = "chkduplicate.php?bnrname="+name+"&bnrid="+id;
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
					<h1 class="m-0 text-dark">Edit Banner</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Banner</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtbnrid" id="frmedtbnrid" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onSubmit="return performCheck('frmedtbnrid', rules, 'inline');" enctype="multipart/form-data">
		<input type="hidden" name="hdnbnrid" value="<?php echo $id;?>">
		<input type="hidden" name="hdnpage" value="<?php echo $pg;?>">
		<input type="hidden" name="hdncnt" value="<?php echo $countstart?>">
		<input type="hidden" name="hdnloc" value="<?php echo $loc?>">
		<input type="hidden" name="hdndskimg" id="hdndskimg" value="<?php echo $rowsbnr_mst['dskm_imgnm'];?>">
		<input type="hidden" name="hdntabimg" id="hdntabimg" value="<?php echo $rowsbnr_mst['tabm_imgnm'];?>">
		<input type="hidden" name="hdnmobimg" id="hdnmobimg" value="<?php echo $rowsbnr_mst['mobm_imgnm'];?>">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center align-items-center">
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Title *</label>
							</div>
							<div class="col-sm-9">
								<input name="txtname" type="text" id="txtname" size="560" maxlength="" onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsbnr_mst['bnrm_name']; ?>">
								<span id="errorsDiv_txtname"></span>
							</div>
						</div>
					</div>
					<!-- <div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Button Name *</label>
							</div>
							<div class="col-sm-9">
								<input name="txtbtnname" type="text" id="txtbtnname" size="260" maxlength="" onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsbnr_mst['bnrm_btn_name']; ?>">
								<span id="errorsDiv_txtbtnname"></span>
							</div>
						</div>
					</div> -->
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Description</label>
							</div>
							<div class="col-sm-9">
								<textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"><?php echo $rowsbnr_mst['bnrm_desc']; ?></textarea>
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
								$dskimgnm = $rowsbnr_mst['dskm_imgnm'];
								$dskimgpath  = $gbnr_fldnm.$dskimgnm;
								if(($dskimgnm !="") && file_exists($dskimgpath))
								{
									echo "<img src='$dskimgpath' width='50pixel' height='50pixel'>";
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
								<label>Header Tablet Image</label>
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input name="fletabimg" type="file" class="form-control" id="fletabimg">
								</div>
								<?php
								$tabimgnm = $rowsbnr_mst['tabm_imgnm'];
								$tabimgpath  = $gbnr_fldnm.$tabimgnm;
								if(($tabimgnm !="") && file_exists($tabimgpath))
								{
									echo "<img src='$tabimgpath' width='50pixel' height='50pixel'>";
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
								<label>Header Mobile Image</label>
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input name="flemobimg" type="file" class="form-control" id="flemobimg">
								</div>
								<?php
								$mobimgnm = $rowsbnr_mst['mobm_imgnm'];
								$mobimgpath  = $gbnr_fldnm.$mobimgnm;
								if(($mobimgnm !="") && file_exists($mobimgpath))
								{
									echo "<img src='$mobimgpath' width='50pixel' height='50pixel'>";
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
								<input type="text" name="txtlnk" id="txtlnk" size="45" maxlength="250" class="form-control" value="<?php echo $rowsbnr_mst['bnrm_lnk']; ?>">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>TextAlign</label>
							</div>
							<div class="col-sm-9">
								<select name="txtalin" id="txtalin" class="form-control">
									<option value="L"<?php if($rowsbnr_mst['bnrm_text']=='L') echo 'selected';?>>Left</option>
									<option value="R"<?php if($rowsbnr_mst['bnrm_text']=='R') echo 'selected';?>>Right</option>
									<option value="C"<?php if($rowsbnr_mst['bnrm_text']=='C') echo 'selected';?>>Center</option>
								</select>

							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Rank *</label>
							</div>
							<div class="col-sm-9">
								<input type="text" name="txtprior" id="txtprior" class="form-control" size="4" maxlength="3" value="<?php echo $rowsbnr_mst['bnrm_prty']; ?>">
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
									<option value="a"<?php if($rowsbnr_mst['bnrm_sts']=='a') echo 'selected';?>>Active</option>
									<option value="i"<?php if($rowsbnr_mst['bnrm_sts']=='i') echo 'selected';?>>Inactive</option>
								</select>

							</div>
						</div>
					</div>
					<p class="text-center">
						<input type="Submit" class="btn btn-primary" name="btnebnrsbmt" id="btnebnrsbmt" value="Submit">
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