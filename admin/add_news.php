<?php
error_reporting(0);
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
include_once 'searchpopcalendar.php';
/***********************************************************
Programm : add_main_category.php
Package :
Purpose : For add main category
Created By : Bharath
Created On :	20-01-2022
Modified By :
Modified On :
Purpose :
Company : Adroit
 ************************************************************/
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Updates / Notifications";
$pagenm = "Updates / Notifications";
/*****header link********/

global $gmsg;
if (isset($_POST['btnanewssbmt']) && (trim($_POST['btnanewssbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")) {
	include_once "../includes/inc_fnct_fleupld.php";
	include_once "../database/iqry_news_dtl.php";
}
$rd_crntpgnm = "view_all_news.php";
$clspn_val = "4";
?>
<!-- <script language="javaScript" type="text/javascript" src="js/ckeditor.js"></script> -->
<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
	var rules = new Array();
	rules[0] = 'txtname:Name|required|Enter Updates / Notifications Name';
	rules[1] = 'txtprty:txtprty|required|Enter Rank';
	rules[2] = 'txtprty:txtprty|numeric|Enter Only Numbers';
	rules[3] = 'lstacyr:Academic year|required|Select Academic Year';
	// rules[2] = 'flebnrimg:txtprty|numeric|Upload Image';
	function setfocus() {
		document.getElementById('txtname').focus();
	}
</script>
<?php
include_once('script.php');
include_once('../includes/inc_fnct_ajax_validation.php');
?>
<script language="javascript">
	function setfocus() {
		document.getElementById('txtname').focus();
	}

	function funcChkDupName() {
		var name, txtnwsdt;
		name = document.getElementById('txtname').value;
		evntstrtdt = document.getElementById('txtnwsdt').value;
		if (name != "") {
			var url = "chkduplicate.php?evntname=" + name + "&evntstrtdt=" + evntstrtdt;
			xmlHttp = GetXmlHttpObject(stateChanged);
			xmlHttp.open("GET", url, true);
			xmlHttp.send(null);
		} else {
			document.getElementById('errorsDiv_txtnwsdt').value = "";
		}
	}

	function stateChanged() {
		if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
			var temp = xmlHttp.responseText;
			document.getElementById("errorsDiv_txtnwsdt").innerHTML = temp;
			if (temp != 0) {
				document.getElementById('txtnwsdt').focus();
			}
		}
	}
	function disptype() {

        var div1 = document.getElementById("div1");
        if (document.frmanews.lsttyp.value == '5') {
            div1.style.display = "block";

        }
        else if (document.frmanews.lsttyp.value == '2') {
            div1.style.display = "none";

        }
		else if (document.frmanews.lsttyp.value == '4') {
            div1.style.display = "none";

        }
    }
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Updates / Notifications</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Add Updates / Notifications</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- Default box -->
	<div class="card">
		<?php
		if ($gmsg != "") {
			echo "<center><div class='col-12'>
			<font face='Arial' size='2' color = 'red'>$gmsg</font>
			</div></center>";
		}
		if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert" id="delids">
				<strong>Deleted Successfully !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php
		}
		?>
		<div class="alert alert-warning alert-dismissible fade show" role="alert" id="updid" style="display:none">
			<strong>Updated Successfully !</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="alert alert-info alert-dismissible fade show" role="alert" id="sucid" style="display:none">
			<strong>Added Successfully !</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="card-body p-0">
			<form name="frmanews" id="frmanews" method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return performCheck('frmanews', rules, 'inline');" enctype="multipart/form-data">
				<div class="col-md-12">
					<div class="row justify-content-center align-items-center">
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Name*</label>
								</div>
								<div class="col-sm-9">
									<input name="txtname" type="text" id="txtname" size="560" onBlur="funcChkDupName()" class="form-control">
									<span id="errorsDiv_txtname"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Academic Year </label>
								</div>
								<div class="col-sm-9">

									<select name="lstacyr" id="lstacyr" class="form-control">
										<option value="">--Select Academic Year--</option>
										<?php
										$sqryay_mst = "SELECT prodm_id,prodm_name from prod_mst where prodm_sts='a'  order by prodm_prty asc";
										$rsproday_mst = mysqli_query($conn, $sqryay_mst);
										$cnt_proday = mysqli_num_rows($rsproday_mst);
										if ($cnt_proday > 0) {
											while ($rowsprodacyr_mst = mysqli_fetch_assoc($rsproday_mst)) {
												$ayid = $rowsprodacyr_mst['prodm_id'];
												$aynm = $rowsprodacyr_mst['prodm_name'];
										?>
												<option value="<?php echo $aynm; ?>"><?php echo $aynm; ?></option>
										<?php
											}
										}

										?>
									</select>
									<span id="errorsDiv_lstacyr"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Start Date</label>
								</div>
								<div class="col-sm-9">
									<input name="txtnwsdt" type="text" id="txtnwsdt" size="45" maxlength="40" onBlur="funcChkDupName()" class="form-control">
									<span id="errorsDiv_txtnwsdt"></span>
									<script language='javascript'>
										if (!document.layers) {
											document.write("<img src='images/calendar.gif' onclick='popUpCalendar(this,frmanews.txtnwsdt, \"yyyy-mm-dd\")'  style='font-size:11px' style='cursor:pointer'>")
										}
									</script>
								</div>
							</div>

						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Description</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"></textarea>
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
										<input name="flebnrimg" type="file" class="form-control" id="flebnrimg" >
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Link</label>
								</div>
								<div class="col-sm-9">
									<div class="custom-file">
										<input name="txtlnk" type="text" class="form-control" id="txtlnk">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>File</label>
								</div>
								<div class="col-sm-9">
									<div class="custom-file">
										<input name="fledwnld" type="file" class="form-control" id="fledwnld" >
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Type</label>
								</div>
								<div class="col-sm-9">
									<select name="lsttyp" id="lsttyp" class="form-control" onchange="disptype()">
										<!-- <option value="1" selected>Results Updates</option> -->
										<option value="2">College Notifications</option>
										<!-- <option value="3">University Notifications</option> -->
										<option value="4">Announcements</option>
										<option value="5">Department Notifications</option>
									</select>
								</div>
							</div>
						</div>
						<div id="div1" class="col-md-12" style="display: none;">
                        <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Department *</label>
								</div>
								<div class="col-sm-9">

									<select name="lstprodcat" id="lstprodcat" class="form-control">
                                        <option value="">--Select Department--</option>
                                        <?php
                                        $sqryprodcat_mst = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='UG' order by prodcatm_name";
                                        $rsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
                                        $cnt_prodcat = mysqli_num_rows($rsprodcat_mst);
										if( $cnt_prodcat > 0)
										{   ?>
                                            <option disabled>-- UG --</option>
                                            <?php			while($rowsprodcat_mst=mysqli_fetch_assoc($rsprodcat_mst))
											{
												$catid = $rowsprodcat_mst['prodcatm_id'];
												$catname = $rowsprodcat_mst['prodcatm_name'];
												?>
												<option value="<?php echo $catid;?>"><?php echo $catname;?></option>
												<?php
											}
										}
                $sqryprodcat_mst1 = "SELECT prodcatm_id,prodcatm_name from prodcat_mst where prodcatm_typ='d' and prodcatm_admtyp='PG' order by prodcatm_name";
                                        $rsprodcat_mst1 = mysqli_query($conn,$sqryprodcat_mst1);
                                        $cnt_prodcat1 = mysqli_num_rows($rsprodcat_mst1);
										if( $cnt_prodcat1 > 0)
										{   ?>
                                            <option disabled>-- PG --</option>
                                            <?php	while($rowsprodcat_mst1=mysqli_fetch_assoc($rsprodcat_mst1))
											{
												$catid = $rowsprodcat_mst1['prodcatm_id'];
												$catname = $rowsprodcat_mst1['prodcatm_name'];
												?>
												<option value="<?php echo $catid;?>"><?php echo $catname;?></option>
												<?php
											}
										}
										?>
									</select>
									<span id="errorsDiv_lstprodcat"></span>
								</div>
							</div>
						</div>

								</div>
						<!-- <div class="col-md-12">
                            <div class="row mb-2 mt-2">
                                <div class="col-sm-3">
                                    <label>Display Type</label>
                                </div>
                                <div class="col-sm-9">
                                    <select name="lstdsplytyp" id="lstdsplytyp" class="form-control">
                                        <option value="1">General</option>
                                        <option value="2">Tabular</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
						<!-- <div class="col-md-12">
                            <div class="row mb-2 mt-2">
                                <div class="col-sm-3">
                                    <label>SEO Title</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="txtseotitle" id="txtseotitle" size="45" maxlength="250" class="form-control">
                                </div>
                            </div>
                        </div> -->
						<!-- <div class="col-md-12">
                            <div class="row mb-2 mt-2">
                                <div class="col-sm-3">
                                    <label>SEO Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="txtseodesc" rows="3" cols="60" id="txtseodesc" class="form-control"></textarea>
                                </div>
                            </div>
                        </div> -->
						<!-- <div class="col-md-12">
                            <div class="row mb-2 mt-2">
                                <div class="col-sm-3">
                                    <label>SEO Keyword</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="txtseokywrd" rows="3" cols="60" id="txtseokywrd" class="form-control"></textarea>
                                </div>
                            </div>
                        </div> -->

						<!-- <div class="col-md-12">
                            <div class="row mb-2 mt-2">
                                <div class="col-sm-3">
                                    <label>SEO H1 Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="txtseoh1" rows="3" cols="60" id="txtseoh1" class="form-control"></textarea>
                                </div>
                            </div>
                        </div> -->

						<!-- <div class="col-md-12">
                            <div class="row mb-2 mt-2">
                                <div class="col-sm-3">
                                    <label>SEO H2 Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <textarea name="txtseoh2" rows="3" cols="60" id="txtseoh2" class="form-control"></textarea>
                                </div>
                            </div>
                        </div> -->
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Rank *</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtprty" id="txtprty" class="form-control" size="4" maxlength="3">
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
										<option value="a" selected>Active</option>
										<option value="i">Inactive</option>
									</select>
								</div>
							</div>
						</div>
						<p class="text-center">
							<input type="Submit" class="btn btn-primary" name="btnanewssbmt" id="btnanewssbmt" value="Submit">
							&nbsp;&nbsp;&nbsp;
							<input type="reset" class="btn btn-primary" name="btnprodmn_catreset" value="Clear" id="btnprodmn_catreset">
							&nbsp;&nbsp;&nbsp;
							<input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
						</p>
					</div>
				</div>
			</form>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>
<script language="javascript" type="text/javascript">
	CKEDITOR.replace('txtdesc');
</script>