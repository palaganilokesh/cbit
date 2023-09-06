<?php
error_reporting(0);
include_once "../includes/inc_nocache.php"; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_connection.php"; //Making database Connection
include_once '../includes/inc_config.php';
include_once '../includes/inc_usr_functions.php'; //Use function for validation and more 
include_once "../includes/inc_folder_path.php";
/***************************************************************/
//Programm 	  : edit_event.php
//Company 	  : Adroit
/************************************************************/
global $id, $pg, $cntstart, $val;

$rd_crntpgnm = "view_all_events.php";
$rd_edtpgnm = "edit_event.php";
$clspn_val = "4";
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Events";
$pagenm = "Events";
/*****header link********/
if (
	isset($_REQUEST['edit']) && $_REQUEST['edit'] != ""
	&& isset($_REQUEST['pg']) && $_REQUEST['pg'] != ""
	&& isset($_REQUEST['countstart']) && $_REQUEST['countstart'] != ""
) {
	$id = glb_func_chkvl($_REQUEST['edit']);
	$pg = glb_func_chkvl($_REQUEST['pg']);
	$cntstart = glb_func_chkvl($_REQUEST['countstart']);
} else if (
	isset($_REQUEST['hdnevntid']) && $_REQUEST['hdnevntid'] != ""
	&& isset($_REQUEST['hdnpage']) && $_REQUEST['hdnpage'] != ""
	&& isset($_REQUEST['hdncnt']) && $_REQUEST['hdncnt'] != ""
) {
	$id = glb_func_chkvl($_REQUEST['hdnevntid']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$cntstart = glb_func_chkvl($_REQUEST['hdncnt']);
}
if (isset($_REQUEST['edit']) && $_REQUEST['edit'] != "") {
	$val    = glb_func_chkvl($_REQUEST['val']);
	$opt 	= glb_func_chkvl($_REQUEST['optn']);
	$ck 	= glb_func_chkvl($_REQUEST['chk']);
}
$sqryevnt_mst = "SELECT 
						evntm_name,evntm_id,evntm_desc,evntm_city,evntm_dstrctm_id,
						evntm_venue,date_format(evntm_strtdt,'%d-%m-%Y') as evntm_strtdt,
						evtnm_strttm,date_format(evntm_enddt,'%d-%m-%Y') as evntm_enddt,
						evntm_endtm,evntm_btch,evntm_fle,evntm_prty,
						evntm_sts,evntm_lnk,evntm_lsttyp,evntm_typ,evntm_dept
				    from 
						evnt_mst
	                where 
						evntm_id=$id";
$srsevnt_mst  = mysqli_query($conn, $sqryevnt_mst);
$rowsevnt_mst = mysqli_fetch_assoc($srsevnt_mst);
$evn_typ = $rowsevnt_mst['evntm_typ'];
if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) {
	$msg = "<font color=red>Record updated successfully</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "n")) {
	$msg = "<font color=red>Record not updated</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "d")) {
	$msg = "<font color=red>Duplicate Recored Name Exists & Record Not updated</font>";
}


if (isset($_REQUEST['imgid']) && (trim($_REQUEST['imgid']) != "")) {

	$imgid      = glb_func_chkvl($_REQUEST['imgid']);
	$pg         = glb_func_chkvl($_REQUEST['pg']);
	$countstart = glb_func_chkvl($_REQUEST['countstart']);

	$sqryevntd_dtl = "SELECT 
								   evntm_fle
								from 
								   evnt_mst
								where
									evntm_id = '$imgid'";
	$srsevntd_dtl     	= mysqli_query($conn, $sqryevntd_dtl);
	$srowevntd_dtl    	= mysqli_fetch_assoc($srsevntd_dtl);
	$smlimg      		= glb_func_chkvl($srowevntd_dtl['evntm_fle']);
	$smlimgpth   		= $gevnt_fldnm . $smlimg;
	$uqryevnt_mst 		= "update 
										evnt_mst set
									evntm_fle =''
									where evntm_id ='$imgid'";
	$ursevnt_mst  = mysqli_query($conn, $uqryevnt_mst) or die(mysqli_error($conn));
	if ($ursevnt_mst == 'y') {
		if (($smlimg != "") && file_exists($smlimgpth)) {
			unlink($smlimgpth);
		}
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="yav-style.css" type="text/css" rel="stylesheet">
	<title><?php echo $pgtl; ?></title>
	<script language="javascript" src="../includes/yav.js"></script>
	<script language="javascript" src="../includes/yav-config.js"></script>
	<script language='javascript' src="searchpopcalendar.js"></script>
	<script language="javascript" type="text/javascript">
		var rules = new Array();
		rules[0] = 'txtname:Event Name|required|Enter name';
		rules[1] = 'txtprior:Priority|required|Enter Priority';
		rules[2] = 'txtprior:Priority|numeric|Enter Only Numbers';
		rules[3] = 'txtcity:City|required|Enter City';
		rules[4] = 'txtstdate:Start Date|required|Enter Start Date';
		rules[5] = 'txtnvets:Vets|required|Enter No. of Seats';
	</script>
	<?php
	include_once "../includes/inc_fnct_ajax_validation.php"; //Includes ajax validations				
	?>
	<script language="JavaScript" type="text/javascript" src="wysiwyg.js"></script>

	<script language="javascript">
		function setfocus() {
			document.getElementById('txtname').focus();
		}
		<?php /*?>function rmvimg(imgid){
			var img_id;
			img_id = imgid;
			if(img_id !=''){
				var r=window.confirm("Do You Want to Remove Image");
				if (r==true){						
					 x="You pressed OK!";
				  }
				else
				  {
					  return false;
				  }	
        	}
			document.frmedtevnt.action="view_event.php?edit=+"<?php echo $id;?>"&imgid=<?php echo $id;?>&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$loc;?>" 
			document.frmedtevnt.submit();
			document.frmedtevnt.action="view_event.php?edit=<?php echo $imgid;?>&imgid="+img_id+"&pg=<?php echo $pg;?>&countstart=				<?php echo $countstart.$loc;?>" 
			document.frmedtevnt.submit();	
	}<?php */ ?>
	</script>
	<?php
	include_once('script.php');
	?>
</head>

<body>
	<?php
	include_once '../includes/inc_adm_header.php';
	include_once '../includes/inc_adm_leftlinks.php'; ?>

	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">View Event / News</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">View Event / News</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>



		<form name="frmedtevnt" id="frmedtevnt" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="" enctype="multipart/form-data">
			<input type="hidden" name="hdnevntid" value="<?php echo $id; ?>">
			<input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
			<input type="hidden" name="hdncnt" value="<?php echo $cntstart ?>">
			<input type="hidden" name="hdnval" value="<?php echo $val; ?>">
			<input type="hidden" name="hdnopt" value="<?php echo $opt; ?>">
			<input type="hidden" name="hdnchk" value="<?php echo $ck; ?>">
			<!--<input type="hidden" name="hdnsimg" value="">-->
			<input type="hidden" name="hdnevntnm" id="hdnevntnm" value="<?php echo $rowsevnt_mst['evntm_fle'] ?>">
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
								<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Name</label>
								<div class="col-sm-8">
									<?php echo $rowsevnt_mst['evntm_name']; ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Description</label>
								<div class="col-sm-8">
									<?php echo stripslashes($rowsevnt_mst['evntm_desc']); ?>
								</div>
							</div>
							<div class="form-group row">
								<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Link </label>
								<div class="col-sm-8">
									<?php echo $rowsevnt_mst['evntm_lnk']; ?>

								</div>
							</div>
							<?php
							if ($rowsevnt_mst['evntm_dept'] != '0') {
							?>

								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Department </label>
									<div class="col-sm-8">
										<?php
										$dep_id = $rowsevnt_mst['evntm_dept'];
										$qry = "SELECT prodcatm_name,prodcatm_id	
                              From prodcat_mst where prodcatm_id='$dep_id'";
										$res = mysqli_query($conn, $qry);
										$values = mysqli_fetch_assoc($res);
										$dep_nm = $values['prodcatm_name'];
										?>
										<?php echo $dep_nm; ?>

									</div>
								</div>
							<?php
							} ?>
							<?php if ($evn_typ == 'e') {
							?>
								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">City</label>
									<div class="col-sm-8">
										<?php echo $rowsevnt_mst['evntm_city']; ?>
									</div>
								</div>
							<?php
							}
							?>
							<div class="form-group row">
								<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Type</label>
								<div class="col-sm-8">
									<?php $typ = $rowsevnt_mst['evntm_typ'];
									if ($typ == 'n') {
										echo "News";
									} else {
										echo "Events";
									}
									?>
								</div>
							</div>

							<?php if ($evn_typ == 'e') {
							?>
								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Venue</label>
									<div class="col-sm-8">
										<?php echo $rowsevnt_mst['evntm_venue']; ?>
									</div>
								</div>
							<?php
							}
							?>
							<div class="form-group row">
								<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Start Date </label>
								<div class="col-sm-8">
									<?php echo $rowsevnt_mst['evntm_strtdt']; ?>
								</div>
							</div>







							<!---<tr bgcolor="#FFFFFF">
				<td bgcolor="#E7F3F7"><strong>Type</strong></td>
				<td bgcolor="#E7F3F7"><strong>:</strong></td>
				<td bgcolor="#E7F3F7">				
					<?php
					// $sqrydstrct_mst = "select 
					// 				ctym_id,ctym_name
					// 			from 
					// 				cty_mst";
					// $srsdstrct_mst=mysqli_query($conn,$sqrydstrct_mst);
					// while($rowsdstrct_mst=mysqli_fetch_assoc($srsdstrct_mst)){
					// 	if($rowsdstrct_mst['ctym_id'] == $rowsevnt_mst['evntm_dstrctm_id']){ 
					// 		echo ($rowsdstrct_mst['ctym_name']);
					// 	}
					// }
					?>
				</td>
			</tr>-->
							<?php if ($evn_typ == 'e') {
							?>
								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Start Time </label>
									<div class="col-sm-8">
										<?php
										$sttm			= $rowsevnt_mst['evtnm_strttm'];
										$sttmarr 		= explode(":", $sttm);
										$sthrs          = $sttmarr[0];
										$stminarr		= explode(" ", $sttmarr[1]);
										$stmin			= $stminarr[0];
										$stmina			= $stminarr[1];
										for ($i = 1; $i <= 12; $i++) {
											if ($sthrs == $i) {
												if ($i < 10) {
													$i = '0' . $i;
												}
												echo $i;
											}
										}
										for ($j = 5; $j <= 60; $j = $j + 5) {
											if ($stmin == $j) {
												if ($j < 10) {
													$j = '0' . $j;
												}
												echo ":";
												echo $j;
											}
										}
										if ($stmina == "AM")
											echo " AM";
										if ($stmina == "PM")
											echo " PM";
										?>


									</div>
								</div>

								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">End Date </label>
									<div class="col-sm-8">
										<?php
										if ($rowsevnt_mst['evntm_enddt'] > 0) {
											echo $rowsevnt_mst['evntm_enddt'];
										} else {
											echo "";
										}
										?>
									</div>
								</div>
								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">End Time </label>
									<div class="col-sm-8">
										<?php
										$edtm			= $rowsevnt_mst['evntm_endtm'];
										$edtmarr 		= explode(":", $edtm);
										$edhrs          = $edtmarr[0];
										$edminarr		= explode(" ", $edtmarr[1]);
										$edmin			= $edminarr[0];
										$edmina			= $edminarr[1];

										for ($k = 1; $k <= 12; $k++) {
											if ($edhrs == $k) {
												if ($k < 10) {
													$k = '0' . $k;
												}
												echo $k;
											}
										}
										for ($l = 5; $l <= 60; $l = $l + 5) {
											if ($edmin == $l) {
												if ($l < 10) {
													$l = '0' . $l;
												}
												echo ":";
												echo $l;
											}
										}
										if ($edmina == "AM")
											echo " AM";
										if ($edmina == "PM")
											echo " PM";
										?>
									</div>
								</div>
								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">No. of Seats </label>
									<div class="col-sm-8">
										<?php echo $rowsevnt_mst['evntm_btch']; ?>

									</div>
								</div>
								<div class="form-group row">
									<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Files</label>
									<div class="col-sm-8">
										<?php
										$evntflnm 	 = $rowsevnt_mst['evntm_fle'];
										$evntflpath  = $gevnt_fldnm . $id . "-" . $evntflnm;
										if (($evntflnm != "") && file_exists($evntflpath)) {
											echo $evntflnm;
										} else {
											echo "Files not available";
										}
										?>

									</div>
								</div>
							<?php
							}
							?>
							<div class="form-group row">
								<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Priority </label>
								<div class="col-sm-8">
									<?php echo $rowsevnt_mst['evntm_prty']; ?>

								</div>
							</div>
							<div class="form-group row">
								<label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status </label>
								<div class="col-sm-8">
									<?php if ($rowsevnt_mst['evntm_sts'] == 'a') echo 'Active'; ?>
									<?php if ($rowsevnt_mst['evntm_sts'] == 'i') echo 'Inactive'; ?>

								</div>
							</div>


							<tr bgcolor="#FFFFFF">
								<td colspan="4">
									<table width="100%" border="0" cellspacing="1" cellpadding="3">
										<tr>
											<td width="5%" bgcolor="#f1f6fd"><strong>SL.No.</strong></td>
											<td width="40%" bgcolor="#f1f6fd"><strong>Name</strong></td>
											<td width="20%" bgcolor="#f1f6fd" align='center'><strong>Image</strong></td>
											<td width="20%" bgcolor="#f1f6fd"><strong>Rank</strong></td>
											<td width="20%" bgcolor="#f1f6fd"><strong>Status</strong></td>
										</tr>
										<?php
										$sqryimg_dtl = "SELECT 
								  evntimgd_name,evntimgd_img,evntimgd_prty,
								  if(evntimgd_sts = 'a', 'Active','Inactive') as evntimgd_sts
							 from 
								  evntimg_dtl
							 where 
								  evntimgd_evntm_id ='$id' 
							 order by 
								  evntimgd_id";
										$srsimg_dtl	= mysqli_query($conn, $sqryimg_dtl);
										$cntevntimg_dtl  = mysqli_num_rows($srsimg_dtl);
										$cnt = $offset;
										if ($cntevntimg_dtl > 0) {
											while ($rowevntimg_dtl	  = mysqli_fetch_assoc($srsimg_dtl)) {
												$db_evntimgnm   = $rowevntimg_dtl['evntimgd_name'];
												$arytitle     = explode("-", $db_evntimgnm);
												$db_evntimgimg  = $rowevntimg_dtl['evntimgd_img'];
												$db_evntimgprty = $rowevntimg_dtl['evntimgd_prty'];
												$db_evntimgsts  = $rowevntimg_dtl['evntimgd_sts'];

												$cnt += 1;
												$clrnm = "";
												if ($cnt % 2 == 0) {
													$clrnm = "bgcolor='#f1f6fd'";
												} else {
													$clrnm = "bgcolor='#f1f6fd'";
												}
										?>
												<tr>
													<td bgcolor="#f1f6fd"><?php echo $cnt; ?></td>
													<td bgcolor="#f1f6fd"><?php echo $arytitle[1]; ?></td>
													<td bgcolor="#f1f6fd" align='center'>
														<?php
														$imgnm   = $db_evntimgimg;
														$imgpath = $imgevnt_fldnm . $imgnm;
														if (($imgnm != "") && file_exists($imgpath)) {
															echo "<img src='$imgpath' width='80pixel' height='80pixel'>";
														} else {
															echo "Image not available";
														}
														?>
													</td>
													<td bgcolor="#f1f6fd"><?php echo $db_evntimgprty; ?></td>
													<td bgcolor="#f1f6fd"><?php echo $db_evntimgsts; ?></td>
												</tr>
										<?php
											}
										} else {
											echo "<tr bgcolor='#FFFFFF'>
							<td colspan='5' bgcolor='#f1f6fd' align='center'>Image not available</td>
						</tr>";
										}
										?>
									</table>
								</td>

							</tr>




							<p class="text-center">
								<input type="button" class="btn btn-primary btn-cst" name="btnedtevnt" id="btnedtevnt" value="Edit" onclick="location.href='edit_event.php?edit=<?php echo $rowsevnt_mst['evntm_id']; ?>&pg=<?php echo $pg . "&countstart=" . $cntstart; ?>&val=<?php echo $val; ?>&optn=<?php echo $opt; ?>&chk=<?php echo $ck; ?>'">
								&nbsp;&nbsp;&nbsp;
								<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='view_all_events.php?pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart; ?>&optn=<?php echo $opt; ?>&val=<?php echo $val; ?>&chk=<?php echo $ck; ?>'">
							</p>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>


	<?php include_once "../includes/inc_adm_footer.php"; ?>
</body>

</html>