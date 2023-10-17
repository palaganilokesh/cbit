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
Created By : Lokesh palagani
Created On :
Modified By :
Modified On :
Purpose :
Company : Adroit
************************************************************/
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
global $id,$pg,$countstart;
$rd_vwpgnm = "view_detail_users.php";
$rd_crntpgnm = "view_all_users.php";
$clspn_val = "4";
if(isset($_POST['btnedtuser']) && (trim($_POST['btnedtuser']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != ""))
{
	include_once "../includes/inc_fnct_fleupld.php"; // For uploading files
	include_once "../database/uqry_lgn_mst.php";
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

echo $sqrybnr_mst = "SELECT lgnm_uid, lgnm_typ, if(lgnm_sts = 'a', 'Active','Inactive') as lgnm_sts,lgnm_dept_id from lgn_mst where lgnm_id =$id";
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
	rules[0]='txtname:Name|required|Enter User Name';
  rules[1]='txtname:Name|alphaspace|Name only characters and numbers';
  // rules[2]='txtprior:Priority|required|Enter Rank';
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
					<h1 class="m-0 text-dark">Edit Users</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Edit Users</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<form name="frmedtphcat" id="frmedtphcat" method="post" action="<?php $_SERVER['PHP_SELF'];?>" onSubmit="return performCheck('frmedtphcat', rules, 'inline');" enctype="multipart/form-data">
		<input type="hidden" name="hdnbnrid" value="<?php echo $id;?>">
		<input type="hidden" name="hdnpage" value="<?php echo $pg;?>">
		<input type="hidden" name="hdncnt" value="<?php echo $countstart?>">
		<input type="hidden" name="hdnloc" value="<?php echo $loc?>">
		<input type="hidden" name="txttyp" value="<?php echo $rowsbnr_mst['lgnm_typ'];?>">
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center align-items-center">
                <div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Type</label>
							</div>
							<div class="col-sm-9">
								<select name="txttyp" id="txttyp" class="form-control" disabled >
                                <!-- onchange="disptype()" -->
									<option value="c"<?php if($rowsbnr_mst['lgnm_typ']=='wm') echo 'selected';?>>Website Management</option>
									<option value="d"<?php if($rowsbnr_mst['lgnm_typ']=='d') echo 'selected';?>>Department</option>

								</select>

							</div>
						</div>
					</div>
                    <?php if($rowsbnr_mst['lgnm_typ']=='d'){
                        ?>
  <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Department *</label>
								</div>
								<div class="col-sm-9">


									<select name="lstprodcat" id="lstprodcat" class="form-control" disabled>
                                        <option value="">--Select Department--</option>
                                        <?php
                                        $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='UG' order by prodcatm_name";
                                        $rsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
                                        $cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
										if( $cnt_prodcat > 0)
										{   ?>
                                            <option disabled>-- UG --</option>
                                            <?php
                                            while($rowsprodcat_mst=mysqli_fetch_assoc($rsprodcat_mst))
											{
												$catid = $rowsprodcat_mst['prodcatm_id'];
												$catname = $rowsprodcat_mst['prodcatm_name'];
												?>
                                                <option value="<?php echo $catid;?>"<?php if($rowsbnr_mst['lgnm_dept_id']==$catid) echo 'selected';?>><?php echo $catname;?></option>

												<?php
											}
										}
                                        $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='PG' order by prodcatm_name";
                                        $rsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
                                        $cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
										if( $cnt_prodcat > 0)
										{   ?>
                                            <option disabled>-- PG --</option>
                                            <?php	while($rowsprodcat_mst=mysqli_fetch_assoc($rsprodcat_mst))
											{
												$catid = $rowsprodcat_mst['prodcatm_id'];
												$catname = $rowsprodcat_mst['prodcatm_name'];
												?>
                                                 <option value="<?php echo $catid;?>"<?php if($rowsbnr_mst['lgnm_dept_id']==$catid) echo 'selected';?>><?php echo $catname;?></option>
												<!-- <option value="<?php echo $catid;?>"><?php echo $catname;?></option> -->
												<?php
											}
										}
										?>
									</select>
									<span id="errorsDiv_lstprodcat"></span>
								</div>
							</div>
						</div>
                        <?php
                    }?>

					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>User Name *</label>
							</div>
							<div class="col-sm-9">
								<input name="txtname" type="text" id="txtname" size="45" maxlength="40" onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsbnr_mst['lgnm_uid']; ?>">
								<span id="errorsDiv_txtname"></span>
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
									<option value="a"<?php if($rowsbnr_mst['lgnm_sts']=='a') echo 'selected';?>>Active</option>
									<option value="i"<?php if($rowsbnr_mst['lgnm_sts']=='i') echo 'selected';?>>Inactive</option>
								</select>

							</div>
						</div>
					</div>
					<p class="text-center">
						<input type="Submit" class="btn btn-primary" name="btnedtuser" id="btnedtuser" value="Submit">
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