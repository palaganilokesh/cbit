<?php
error_reporting(0);
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once '../includes/inc_adm_session.php'; //checking for session
include_once '../includes/inc_connection.php'; //Making database Connection
include_once '../includes/inc_usr_functions.php'; //Use function for validation and more
include_once '../includes/inc_config.php';
include_once '../includes/inc_folder_path.php';
/***************************************************************/
//Programm 	  : edit_pagecontain.php
//Created By  :
//Created On  :
//Modified By :
//Modified On :
//Company 	  : Adroit
/************************************************************/
global $id, $pg, $cntstart, $loc, $rd_crntpgnm,$ses_deptid;
$rd_crntpgnm = "view_all_pagecontain.php";
$rd_vwpgnm   = "view_pagecontain_detail.php";
$rd_edtpgnm  = "edit_pagecontain.php";
$clspn_val   = "4";
/*****header link********/
$pagemncat = "Page Content";
$pagecat = "Page Contents";
$pagenm = "Page Contents";
/*****header link********/
if (
	isset($_POST['btnedtphcntn']) && (trim($_POST['btnedtphcntn']) != "") &&
	isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	isset($_POST['lstcat1']) && (trim($_POST['lstcat1']) != "") &&
	isset($_REQUEST['edtpgcntid']) && (trim($_REQUEST['edtpgcntid']) != "")
) {
	$arycatone     = glb_func_chkvl($_POST['lstcat1']);
	$chkdept     = explode('-', $arycatone);
	$rqst_lstdept     = glb_func_chkvl($_POST['lstdept']);

	//if((($chkdept[1]=='d') && ($rqst_lstdept !='')) || ($chkdept[1]=='g') || ($chkdept[1]=='n')){
	include_once "../includes/inc_fnct_fleupld.php"; // For uploading files
	include_once "../database/uqry_pgcnts_dtl.php";
	//}
}
if (
	isset($_REQUEST['edtpgcntid']) && trim($_REQUEST['edtpgcntid']) != "" &&
	isset($_REQUEST['pg']) && trim($_REQUEST['pg']) != "" &&
	isset($_REQUEST['cntstart']) && trim($_REQUEST['cntstart']) != ""
) {
	$id 	  = glb_func_chkvl($_REQUEST['edtpgcntid']);
	$pg 	  = glb_func_chkvl($_REQUEST['pg']);
	$cntstart = glb_func_chkvl($_REQUEST['cntstart']);
	$optn 	  = glb_func_chkvl($_REQUEST['optn']);
	$val 	  = glb_func_chkvl($_REQUEST['txtsrchval']);
	$lstctone = glb_func_chkvl($_REQUEST['lstcatone']);
	$lstcttwo = glb_func_chkvl($_REQUEST['lstcattwo']);
	$lstdpt   = glb_func_chkvl($_REQUEST['lstdept']);
	$chk	  = glb_func_chkvl($_REQUEST['chkexact']);
	if ($optn != "" && $val != "") {
		$loc = "&optn=" . $optn . "&txtsrchval=" . $val;
	}
	if ($chk == "y") {
		$loc .= "&chkexact=" . $chk;
	}
	if ($optn != "" && $lstctone != "") {
		$loc = "&optn=" . $optn . "&lstcatone=" . $lstctone;
	}
	if ($optn != "" && $lstcttwo != "") {
		$loc = "&optn=" . $optn . "&lstcattwo=" . $lstcttwo;
	}
	if ($optn != "" && $lstdpt != "") {
		$loc = "&optn=" . $optn . "&lstdept=" . $lstdpt;
	}
	$sqrypgcnts_dtl = "SELECT
							pgcntsd_id,pgcntsd_name,pgcntsd_desc,pgcntsd_lnk,pgcntsd_prodmnlnks_id,
							pgcntsd_prodcatm_id,pgcntsd_fle,pgcntsd_prodscatm_id,pgcntsd_typ,
							pgcntsd_sts,pgcntsd_prty,prodcatm_name,prodscatm_name,
							pgcntsd_seotitle,pgcntsd_seodesc,pgcntsd_seokywrd,pgcntsd_seohone,
							pgcntsd_seohtwo,pgcntsd_deptm_id,pgcntsd_dskimg,pgcntsd_tabimg,pgcntsd_mobimg
						 from
							vw_pgcnts_prodcat_prodscat_mst
						 where
							pgcntsd_id=$id";
		// echo $sqrypgcnts_dtl;
	$srspgcnts_dtl  = mysqli_query($conn, $sqrypgcnts_dtl);
	$cntrec_pgcnts = mysqli_num_rows($srspgcnts_dtl);
	if ($cntrec_pgcnts  > 0) {
		$rowspgcnts_dtl 	  = mysqli_fetch_assoc($srspgcnts_dtl);
		$db_pgscatid	  = $rowspgcnts_dtl['pgcntsd_prodscatm_id'];
	$db_mnlnkid		  = $rowspgcnts_dtl['pgcntsd_prodmnlnks_id'];
		$db_catname		  = $rowspgcnts_dtl['prodcatm_name'];
		$db_scatname	  = $rowspgcnts_dtl['prodscatm_name'];
		$db_pgcntname	  = $rowspgcnts_dtl['pgcntsd_name'];
		$db_pgcntdesc	  = stripslashes($rowspgcnts_dtl['pgcntsd_desc']);
		$db_pgcntlnk	  = $rowspgcnts_dtl['pgcntsd_lnk'];
		$db_pgcntfl		  = $rowspgcnts_dtl['pgcntsd_fle'];
		$db_pgcntseottl	  = trim($rowspgcnts_dtl['pgcntsd_seotitle']);
		$db_pgcntseodesc  = trim($rowspgcnts_dtl['pgcntsd_seodesc']);
		$db_pgcntseokywrd = trim($rowspgcnts_dtl['pgcntsd_seokywrd']);
		$db_pgcntseohone  = trim($rowspgcnts_dtl['pgcntsd_seohone']);
		$db_pgcntseohtwo  = trim($rowspgcnts_dtl['pgcntsd_seohtwo']);
		$db_pgcntprty	  = $rowspgcnts_dtl['pgcntsd_prty'];
		$db_pgcntsts	  = $rowspgcnts_dtl['pgcntsd_sts'];
		$db_pgcntsdype     = $rowspgcnts_dtl['pgcntsd_typ'];

	} else {
		header("Location:" . $rd_crntpgnm);
		exit();
	}
	if (
		isset($_REQUEST['imgid']) && (trim($_REQUEST['imgid']) != "") &&
		isset($_REQUEST['edtpgcntid']) && (trim($_REQUEST['edtpgcntid']) != "")
	) {
		$imgid      = glb_func_chkvl($_REQUEST['imgid']);
		$pgdtlid    = glb_func_chkvl($_REQUEST['edtpgcntid']);
		$pg         = glb_func_chkvl($_REQUEST['pg']);
		$cntstart   = glb_func_chkvl($_REQUEST['cntstart']);
		$sqrypgimgd_dtl = "select
								  pgimgd_img,pgimgd_fle
							 from
								  pgimg_dtl
							 where
								  pgimgd_pgcntsd_id='$pgdtlid'  and
								  pgimgd_id = '$imgid'";
		$srspgimgd_dtl     = mysqli_query($conn, $sqrypgimgd_dtl);
		$srowpgimgd_dtl    = mysqli_fetch_assoc($srspgimgd_dtl);
		$delfle[$i]      = glb_func_chkvl($srowpgimgd_dtl['pgimgd_fle']);
		$smlimg[$i]      = glb_func_chkvl($srowpgimgd_dtl['pgimgd_img']);
		$smlimgpth[$i]   = $a_phtgalspath . $smlimg[$i];
		$flepth[$i]   = $a_phtgalbpath . $delfle[$i];
		$delimgsts = funcDelAllRec($conn, 'pgimg_dtl', 'pgimgd_id', $imgid);
		if ($delimgsts == 'y') {
			if (($smlimg[$i] != "") && file_exists($smlimgpth[$i])) {
				unlink($smlimgpth[$i]);
			}
			if (($delfle[$i] != "") && file_exists($flepth[$i])) {
				unlink($flepth[$i]);
			}
		}
	}
	if (
		isset($_REQUEST['delid']) && (trim($_REQUEST['delid']) != "") &&
		isset($_REQUEST['edtpgcntid']) && (trim($_REQUEST['edtpgcntid']) != "")
	) {
		$delid      = glb_func_chkvl($_REQUEST['delid']);
		$pgdtlid    = glb_func_chkvl($_REQUEST['edtpgcntid']);
		$pg         = glb_func_chkvl($_REQUEST['pg']);
		$cntstart   = glb_func_chkvl($_REQUEST['cntstart']);
		$sqrypgqns_dtl = "SELECT pgcntqns_id from pgcntqnsm_dtl
							 where
							 pgcntqns_pgcntsd_id='$pgdtlid'  and
							 pgcntqns_id = '$delid'";
		$srspgqns_dtl     = mysqli_query($conn, $sqrypgqns_dtl);
		$srowpgqns_dtl    = mysqli_fetch_assoc($srspgqns_dtl);
		$delqnssts = funcDelAllRec($conn, '	pgcntqnsm_dtl', 'pgcntqns_id', $delid);
		if ($delqnssts == 'y') {
		}
	}
	if (
		isset($_REQUEST['vdoid']) && (trim($_REQUEST['vdoid']) != "") &&
		isset($_REQUEST['edtpgcntid']) && (trim($_REQUEST['edtpgcntid']) != "")
	) {
		$vdoid      = glb_func_chkvl($_REQUEST['vdoid']);
		$pgdtlid    = glb_func_chkvl($_REQUEST['edtpgcntid']);
		$pg         = glb_func_chkvl($_REQUEST['pg']);
		$cntstart   = glb_func_chkvl($_REQUEST['cntstart']);
		$sqrypgvdo_dtl = "SELECT pgvdod_id from 	pgvdo_dtl
						 where
						 pgvdod_pgcntsd_id='$pgdtlid'  and
						 pgvdod_id = '$vdoid'";
		$srspgvdo_dtl     = mysqli_query($conn, $sqrypgvdo_dtl);
		$srowpgvdo_dtl    = mysqli_fetch_assoc($srspgvdo_dtl);
		$delvdosts = funcDelAllRec($conn, 'pgvdo_dtl', 'pgvdod_id', $vdoid);
		if ($delvdosts == 'y') {
		}
	}
} else {
	header("Location:" . $rd_crntpgnm);
	exit();
}

// $rqst_stp      	= $rqst_arymdl[1];
// $rqst_stp_attn     = explode("::", $rqst_stp);
// $rqst_stp_chk      	= $rqst_arymdl[0];
// $rqst_stp_attn_chk     = explode("::", $rqst_stp_chk);
// if ($rqst_stp_attn_chk[0] == '2') {
// 	$rqst_stp      	= $rqst_arymdl[0];
// 	$rqst_stp_attn     = explode("::", $rqst_stp);
// }
// $sesvalary = explode(",", $_SESSION['sesmod']);
// if (!in_array(2, $sesvalary) || ($rqst_stp_attn[1] == '1')) {
// 	if ($ses_admtyp != 'a') {
// 		header("Location:main.php");
// 		exit();
// 	}
// }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title><?php echo $pgtl; ?></title>
	<script language="javascript" src="../includes/yav.js"></script>
	<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
	<script language="javascript" src="../includes/yav-config.js"></script>
	<script language="javascript" type="text/javascript">
		var rules = new Array();

		rules[0] = 'lstprodmcat:mainlinks Name|required|Select Mainlink name';
		rules[1] = 'lstcat1:Categoryone Name|required|Select Category name';
		rules[4] = 'txtname:Name|required|Enter name';
		rules[5] = 'txtprty:Rank|required|Enter Rank';
		rules[6] = 'txtprty:Rank|numeric|Enter Only Numbers';

		/*function chkDept(){
			var deptsts = (document.getElementById('lstdept').disabled);
			var catoneid = (document.getElementById('lstcat1').value);
			cat_ary 	= Array();
			cat_ary	 	= catoneid.split("-");
			if(cat_ary[1] =='d'){
				rules[3]='lstdept:Department Name|required|Select Department';
				document.getElementById('lstdept').disabled=false;
			}
			else{
				document.getElementById('lstdept').disabled=true;
				document.getElementById('lstdept').value="";
				document.getElementById("errorsDiv_lstdept").innerHTML = "";
			}
			return false;
		}*/
	</script>
	<?php
	include_once('script.php');
	include_once "../includes/inc_fnct_ajax_validation.php"; //Includes ajax validations
	?>
	<script language="javascript">
		function setfocus() {
			document.getElementById('txtname').focus();
		}
	</script>
	<script language="javascript" type="text/javascript">
		function funcChkDupName() {
			debugger
			<?php /*?>var pgcntid= <?php echo $id ;?>;
		var pagcntnname;
		pagcntnname = document.getElementById('txtname').value;
		catid = document.getElementById('lstcatone').value;
		if(pagcntnname != ""){
			var url = "chkvalidname.php?pagcntnname="+name+"&catid="+catid+"&pgcntid="+id;
			xmlHttp	= GetXmlHttpObject(funcpgcnthnstatChngd);
			xmlHttp.open("GET", url , true);
			xmlHttp.send(null);
		}<?php */ ?>
			var pagcntnname, pgcntid, catname;
			pgcntid = <?php echo $id; ?>;

			mnlnks = document.getElementById('lstprodmcat').value;
			catname = document.getElementById('lstcat1').value;
			scatname = document.getElementById('lstcat2').value;
			pagcntnname = document.getElementById('txtname').value;
			deptidval = "";
			if (document.getElementById('lstdept').disabled == false) {
				deptidval = document.getElementById('lstdept').value;
			}
			if ((pagcntnname != "") && (pgcntid != "") && (catname != "")) {
				var url = "chkduplicate.php?pagcntnname=" + pagcntnname +"&lstprodmcat="+ mnlnks + "&pgcntid=" + pgcntid + "&catname=" + catname + "&scatname=" + scatname + "&deptid=" + deptidval;
				xmlHttp = GetXmlHttpObject(funcpgcnthnstatChngd);
				xmlHttp.open("GET", url, true);
				xmlHttp.send(null);
			} else {
				document.getElementById('errorsDiv_txtname').innerHTML = "";
			}
		}

		function funcpgcnthnstatChngd() {
			if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
				var temp = xmlHttp.responseText;
				document.getElementById("errorsDiv_txtname").innerHTML = temp;
				if (temp != 0) {
					//alert(temp);
					document.getElementById('txtname').focus();
				}
			}
		}

		function rmvimg(imgid) {
			var img_id;
			img_id = imgid;
			if (img_id != '') {
				var r = window.confirm("Do You Want to Remove Image");
				if (r == true) {
					x = "You pressed OK!";
				} else {
					return false;
				}
			}
			document.frmedtpgcntn.action = "<?php echo $rd_edtpgnm; ?>?edtpgcntid=<?php echo $id; ?>&imgid=" + img_id + "&pg=<?php echo $pg; ?>&cntstart=<?php echo $cntstart . $loc; ?>"
			document.frmedtpgcntn.submit();
		}

		function rmvqns(del_id) {
			var delid;
			delid = del_id;
			if (delid != '') {
				var z = window.confirm("Do You Want to Remove Questions");
				if (z == true) {
					x = "You pressed OK!";
				} else {
					return false;
				}
			}
			document.frmedtpgcntn.action = "<?php echo $rd_edtpgnm; ?>?edtpgcntid=<?php echo $id; ?>&delid=" + delid + "&pg=<?php echo $pg; ?>&cntstart=<?php echo $cntstart . $loc; ?>"
			document.frmedtpgcntn.submit();
		}

		function rmvvdo(vdo_id) {
			var vdoid;
			vdoid = vdo_id;
			if (vdoid != '') {
				var n = window.confirm("Do You Want to Remove Video");
				if (n == true) {
					n = "You pressed OK!";
				} else {
					return false;
				}
			}
			document.frmedtpgcntn.action = "<?php echo $rd_edtpgnm; ?>?edtpgcntid=<?php echo $id; ?>&vdoid=" + vdoid + "&pg=<?php echo $pg; ?>&cntstart=<?php echo $cntstart . $loc; ?>"
			document.frmedtpgcntn.submit();
		}

		function funcRmvOptn(prmtrCntrlnm) {
			if (prmtrCntrlnm != '') {
				var lstCntrlNm, optnLngth;
				lstCntrlNm = prmtrCntrlnm;
				optnLngth = document.getElementById(lstCntrlNm).options.length;
				for (incrmnt = optnLngth - 1; incrmnt > 0; incrmnt--) {
					document.getElementById(lstCntrlNm).options.remove(incrmnt);
				}
			}
		}

		function funcAddOptn(prmtrCntrlnm, prmtrOptn) {
			tempary = Array();
			tempary = prmtrOptn.split(",");
			cntrlary = 0;
			var id = "";
			var name = "";
			var selstr = "";
			var optn = "";
			for (var inc = 0; inc < (tempary.length); inc++) {
				cntryary = tempary[inc].split(":");
				id = cntryary[0];
				name = cntryary[1];
				//optn 	 	= document.createElement("OPTION");
				//optn.value 	= id;
				//optn.text 	= name;
				//var newopt	= new Option(name,id);
				hdnprodscatid = document.getElementById('hdnprodscatid').value;
				var newopt = new Option(name, id);
				if (id == hdnprodscatid) {
					newopt.selected = "selected";
				}
				document.getElementById(prmtrCntrlnm).options[inc + 1] = newopt;
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
				$("#lstcat1").html(data);
			}
		});
	}
	function funcDspScat() {
		var lstcatone = $("#lstcat1").val();
		var mcatid = $("#lstprodmcat").val();

		$.ajax({
			type: "POST",
			url: "../includes/inc_getStsk.php",
			data: 'lstcatone=' + lstcatone+'&mcatid='+mcatid,
			success: function(data) {
				// alert(data)
				$("#lstcat2").html(data);
			}
		});
	}

		// function funcDspScat() {
		// 	var catid;
		// 	catid = document.getElementById('lstcat1').value;
		// 	if (catid != "") {
		// 		var url = "../includes/inc_getScat.php?selprodcatid=" + catid;
		// 		xmlHttp = GetXmlHttpObject(funscatval);
		// 		xmlHttp.open("GET", url, true);
		// 		xmlHttp.send(null);
		// 	} else {
		// 		funcRmvOptn('lstcat2');
		// 	}
		// }

		// function funscatval() {
		// 	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		// 		funcRmvOptn('lstcat2');
		// 		var temp = xmlHttp.responseText;
		// 		if (temp != "") {
		// 			funcAddOptn('lstcat2', temp);
		// 		}
		// 	}
		// }
	</script>
</head>

<body>
	<?php
	include_once('../includes/inc_adm_header.php');
	// include_once ('../includes/inc_adm_leftlinks.php');
	?>
	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">Edit Page Content</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Edit Page Content</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<form name="frmedtpgcntn" id="frmedtpgcntn" method="post" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" onSubmit="return performCheck('frmedtpgcntn', rules, 'inline');" enctype="multipart/form-data">

			<input type="hidden" name="edtpgcntid" id="edtpgcntid" value="<?php echo $id; ?>">
			<input type="hidden" name="pg" id="pg" value="<?php echo $pg; ?>">
			<input type="hidden" name="cntstart" id="cntstart" value="<?php echo $cntstart; ?>">
			<input type="hidden" name="optn" id="optn" value="<?php echo $optn; ?>">
			<input type="hidden" name="txtsrchval" id="txtsrchval" value="<?php echo $val; ?>">
			<input type="hidden" name="lstcatone" id="lstcatone" value="<?php echo $lstctone; ?>">
			<input type="hidden" name="lstcattwo" id="lstcattwo" value="<?php echo $lstcttwo; ?>">
			<input type="hidden" name="hdnlstdept" id="hdnlstdept" value="<?php echo $lstdpt; ?>">
			<input type="hidden" name="hdnprodscatid" id="hdnprodscatid" value="<?php echo $db_pgscatid; ?>">
			<input type="hidden" name="hdnevntnm" id="hdnevntnm" value="<?php echo $db_pgcntfl ?>">
			<input type="hidden" name="hdndskgimg" id="hdndskgimg" value="<?php echo $rowspgcnts_dtl['pgcntsd_dskimg']; ?>">
			<input type="hidden" name="hdntabgimg" id="hdntabgimg" value="<?php echo $rowspgcnts_dtl['pgcntsd_tabimg']; ?>">
			<input type="hidden" name="hdnmobgimg" id="hdnmobgimg" value="<?php echo $rowspgcnts_dtl['pgcntsd_mobimg']; ?>">
			<input type="hidden" name="lstchkdept" id="lstchkdept">
			<input type="hidden" name="hdnprodscatid" id="hdnprodscatid" value="<?php echo $rowspgcnts_dtl['pgcntsd_prodcatm_id']; ?>">
			<input type="hidden" name="hdnprodfnscatid" id="hdnprodfnscatid" value="<?php echo $rowspgcnts_dtl['pgcntsd_prodscatm_id']; ?>">
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
								$sqryprodmncat_mst = "SELECT 	prodmnlnksm_id,prodmnlnksm_name	from prodmnlnks_mst 	where	 prodmnlnksm_sts = 'a' ";
								if($ses_admtyp=='d'){
									$sqryprodmncat_mst .= " and prodmnlnksm_name='Departments' ";
								}
								$sqryprodmncat_mst .= " order by prodmnlnksm_name";
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
											<option value="<?php echo $mncatid; ?>" <?php if ($db_mnlnkid	 == $mncatid) echo 'selected';  ?>><?php echo $mncatname; ?></option>
									<?php
										}
									}
									?>
								</select>
								<span id="errorsDiv_lstprodmcat"></span>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row mb-2 mt-2">
							<div class="col-sm-3">
								<label>Category *</label>
							</div>
							<div class="col-sm-9">
								<select name="lstcat1" id="lstcat1" class="form-control" onchange="funcDspScat(),chkDept();">
								<option value="<?php echo $rowspgcnts_dtl['pgcntsd_prodcatm_id'] ?>"><?php echo $db_catname	; ?></option>

								</select>
								<span id="errorsDiv_lstcat1"></span>
							</div>
						</div>
					</div>
						<!-- <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Category</label>
								</div>
								<div class="col-sm-9">
									<select name="lstcat1" id="lstcat1" onchange="funcDspScat(),chkDept();" class="form-control">
										<option value="">--Category--</option>
										<?php
										$sqrycatone_mst = "select prodcatm_id,prodcatm_name,prodcatm_typ
													from prodcat_mst where prodcatm_sts='a'";
										if ($ses_admtyp == 'u') {
											$sqrycatone_mst .= " and prodcatm_typ='d'";
										}
										$sqrycatone_mst .= " order by prodcatm_name";
										$srscatone_mst = mysqli_query($conn, $sqrycatone_mst) or die(mysqli_error($conn));
										while ($rowscatone_mst = mysqli_fetch_assoc($srscatone_mst)) {
											$dbprodcat_typ 	= $rowscatone_mst['prodcatm_typ'];
										?>
											<option value="<?php echo $rowscatone_mst['prodcatm_id'] ?>-<?php echo $dbprodcat_typ; ?>" <?php if (isset($_POST['lstcat1']) && (trim($_POST['lstcat1']) != "")) {
																																													echo 'selected';
																																				} elseif ($rowscatone_mst['prodcatm_id'] ==  $rowspgcnts_dtl['pgcntsd_prodcatm_id']) {
																																			echo 'selected';
																																						}
																												?>> <?php echo $rowscatone_mst['prodcatm_name'] ?></option>
										<?php
										}
										?>
									</select>
									<span id="errorsDiv_lstcat1"></span>
								</div>
							</div>
						</div> -->
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Subcategory</label>
								</div>
								<div class="col-sm-9">
									<select name="lstcat2" id="lstcat2" class="form-control">
										<?php
										echo $scatids = $rowspgcnts_dtl['pgcntsd_prodscatm_id'];
										$sqryscatone_mst = "select prodscatm_id,prodscatm_name	from
									vw_prodcat_prodscat_mst where prodscatm_id='$scatids'";
										$srsscatone_mst = mysqli_query($conn, $sqryscatone_mst) or die(mysqli_error($conn));
										while ($rowsscatone_mst = mysqli_fetch_assoc($srsscatone_mst)) {
										?>
											<option value="<?php echo $rowsscatone_mst['prodscatm_id'] ?>" <?php
													if ($rowsscatone_mst['prodscatm_id'] ==  $rowspgcnts_dtl['pgcntsd_prodscatm_id']) {
																		echo 'selected';
																	}
															?>> <?php echo $rowsscatone_mst['prodscatm_name'] ?></option>
										<?php
										}
										?>
									</select>
									<span id="errorsDiv_lstcat2"></span>
								</div>
							</div>
						</div>
						<input type="hidden" name='lstdept' id='lstdept'>
						<?php /*?><tr bgcolor="#FFFFFF">
                       <td bgcolor="#f1f6fd"> <strong>Department</strong> </td>
					   <td bgcolor="#f1f6fd"><strong>:</strong></td>
                       <td bgcolor="#f1f6fd">
					   <select name="lstdept" id="lstdept" style="width:240px" >
                              <option value="">--Department--</option>
                              <?php
								  $sqrydept_mst = "select
														deptm_id,deptm_name
													from
														dept_mst
													where
														deptm_sts='a'";
									if($ses_admtyp =='u'){
										$sqrydept_dtl ="select
															deptd_deptm_id
														from
															lgn_mst
															inner join dept_dtl on lgnm_id  = deptd_lgnm_id
															inner join dept_mst on deptm_id   = deptd_deptm_id
														where
															deptd_lgnm_id ='$ses_adminid'";
										$srrsdept_dtl = mysqli_query($conn,$sqrydept_dtl);
										$cntrec_deptdtl = mysqli_num_rows($srrsdept_dtl);
										if($cntrec_deptdtl > 0){
											$srodept_drl = mysqli_fetch_assoc($srrsdept_dtl);
											$deptid = $srodept_drl['deptd_deptm_id'];
											$sqrydept_mst .=" and deptm_id = $deptid";
										}
									}
									$sqrydept_mst .=" order by deptm_name";
								 $srsdept_mst= mysqli_query($conn,$sqrydept_mst) or die(mysqli_error());
								 while($rowsdept_mst = mysqli_fetch_assoc($srsdept_mst)){
					   			 $slctd="";
								 if($rowsdept_mst['deptm_id'] ==  $rowspgcnts_dtl['pgcntsd_deptm_id']){
										 $slctd="selected";
								}
								?>
        						 <option value="<?php echo $rowsdept_mst['deptm_id']; ?>" <?php echo $slctd;  ?>><?php echo $rowsdept_mst['deptm_name']; ?></option>
								<?php
								 }
								 ?>
					</select>
				  </td>
                   <td bgcolor="#f1f6fd" style="color:#FF0000"><div id="errorsDiv_lstdept"></div></td>
                </tr><?php */ ?>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Name *</label>
								</div>
								<div class="col-sm-9">
									<input name="txtname" type="text" id="txtname" size="560" onBlur="funcChkDupName()" class="form-control" value="<?php echo $db_pgcntname; ?>">
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
									<textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"><?php echo $db_pgcntdesc; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Link</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtlnk" id="txtlnk" size="45" maxlength="250" class="form-control" value="<?php echo $db_pgcntlnk; ?>">
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
								$dskimgnm   = $rowspgcnts_dtl['pgcntsd_dskimg'];
								$dskimgpath = $a_pgcnt_bnrfldnm . $dskimgnm;
								if (($dskimgnm != "") && file_exists($dskimgpath)) {
									echo "<img src='$dskimgpath' width='80pixel' height='80pixel'><br><input type='checkbox' name='chkbximg1' id='chkbximg1' value='$dskimgpath'>Remove Iamge";
								} else {
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
								$tabimgnm   = $rowspgcnts_dtl['pgcntsd_tabimg'];
								$tabimgpath = $a_pgcnt_bnrfldnm . $tabimgnm;
								if (($tabimgnm != "") && file_exists($tabimgpath)) {
									echo "<img src='$tabimgpath' width='80pixel' height='80pixel'><br><input type='checkbox' name='chkbximg2' id='chkbximg2' value='$tabimgpath'>Remove Iamge";
								} else {
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
								$mobimgnm   = $rowspgcnts_dtl['pgcntsd_mobimg'];
								$mobimgpath = $a_pgcnt_bnrfldnm . $mobimgnm;
								if (($mobimgnm != "") && file_exists($mobimgpath)) {
									echo "<img src='$mobimgpath' width='80pixel' height='80pixel'><br><input type='checkbox' name='chkbximg3' id='chkbximg3' value='$mobimgpath'>Remove Iamge";
								} else {
									echo "Image not available";
								}
								?>
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
										<input name="evntfle" type="file" class="form-control" id="evntfle">
									</div>
									<?php
									$evntflnm 	= $db_pgcntfl;
									$evntflpath 	= $gevnt_fldnm . $id . "-" . $evntflnm;
									if (($evntflnm != "") && file_exists($evntflpath)) {
										echo "$evntflnm<br><input type='checkbox' name='chkbxfle' id='chkbxfle' value='$evntflnm'>
									Remove File";
									} else {
										echo "File not available";
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
									<select name="lsttyp" id="lsttyp" class="form-control">
										<option value="1" <?php if ($db_pgcntsdype == '1') echo 'selected'; ?>>Page Content</option>
										<option value="2" <?php if ($db_pgcntsdype == '2') echo 'selected'; ?>>Photo Gallery</option>
										<option value="3" <?php if ($db_pgcntsdype == '3') echo 'selected'; ?>>Video Gallery</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO Title</label>
								</div>
								<div class="col-sm-9">
									<input name="txtseotitle" type="text" id="txtseotitle" size="560" class="form-control" value="<?php echo $db_pgcntseottl; ?>">
									<span id="errorsDiv_txtseotitle"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label> SEO Description</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseodesc" cols="60" rows="3" id="txtseodesc" class="form-control"><?php echo $db_pgcntseodesc; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label> SEO Keyword</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseokywrd" cols="60" rows="3" id="txtseokywrd" class="form-control"><?php echo $db_pgcntseokywrd; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label> SEO H1</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseohone" cols="60" rows="3" id="txtseohone" class="form-control"><?php echo $db_pgcntseohone; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label> SEO H2</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseohtwo" cols="60" rows="3" id="txtseohtwo" class="form-control"><?php echo $db_pgcntseohtwo; ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Rank *</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="txtprty" id="txtprty" class="form-control" size="4" maxlength="3" value="<?php echo $db_pgcntprty; ?>">
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
										<option value="a" <?php if ($db_pgcntsts == 'a') echo 'selected'; ?>>Active</option>
										<option value="i" <?php if ($db_pgcntsts == 'i') echo 'selected'; ?>>Inactive</option>
									</select>
								</div>
							</div>
						</div>

						<div class="table-responsive">
						<div class="col-sm-3">
									<label>Images:</label>
								</div>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
									<td width="5%" align="center"><strong>SL.No.</strong></td>
									<td width="15%" align="center"><strong>Name</strong></td>
									<!-- <td width="15%" align="center"><strong>Designation</strong></td> -->
									<td width="20%" align="center"><strong>Image</strong></td>
									<!-- <td width="20%" align="center"><strong>File</strong></td> -->
									<td width="10%" align="center"><strong>Rank</strong></td>
									<td width="10%" align="center"><strong>Status</strong></td>
									<td width="10%" align="center"><strong>Remove</strong></td>
								</tr>
							</table>
						</div>

						<?php
						$sqryimg_dtl = "select pgimgd_id,pgimgd_name,pgimgd_desig,pgimgd_pgcntsd_id,pgimgd_img,pgimgd_fle,	pgimgd_prty,pgimgd_sts
							 from  pgimg_dtl where pgimgd_pgcntsd_id ='$id'  order by  pgimgd_id";
						$srsimg_dtl	= mysqli_query($conn, $sqryimg_dtl);
						$cntpgimg_dtl  = mysqli_num_rows($srsimg_dtl);
						$nfiles = "";
						if ($cntpgimg_dtl > 0) {
						?>
							<?php
							while ($rowspgimgd_mdtl = mysqli_fetch_assoc($srsimg_dtl)) {
								$pgimgdid 	  = $rowspgimgd_mdtl['pgimgd_id'];
								$db_pgimgnm   = $rowspgimgd_mdtl['pgimgd_name'];
								// $arytitle     = explode("-", $db_pgimgnm);
								$db_pgimgimg  = $rowspgimgd_mdtl['pgimgd_img'];
								$db_pgimgprty = $rowspgimgd_mdtl['pgimgd_prty'];
								$db_pgimgsts  = $rowspgimgd_mdtl['pgimgd_sts'];
								$db_pgimgdesig  = $rowspgimgd_mdtl['pgimgd_desig'];
								$imgnm = $db_pgimgimg;
								$imgpath = $a_phtgalspath . $imgnm;
								$nfiles += 1;
								$clrnm = "";
								if ($cnt % 2 == 0) {
									$clrnm = "bgcolor='#f1f6fd'";
								} else {
									$clrnm = "bgcolor='#f1f6fd'";
								}
							?>

								<div class="table-responsive">
									<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
										<table width="100%" border="0" cellspacing="3" cellpadding="3">
											<tr bgcolor="#FFFFFF">
												<td colspan="7" align="center" bgcolor="#f1f6fd">
													<input type="hidden" name="hdnpgdid<?php echo $nfiles ?>" class="form-control" value="<?php echo $pgimgdid; ?>">
												</td>
											<tr>
												<td width='5%'>
													<?php echo $nfiles; ?>
												</td>
												<td width='15%' align='center'>
													<input type="text" name="txtphtname1<?php echo $nfiles ?>" id="txtphtname1<?php echo $nfiles ?>" value='<?php echo $db_pgimgnm ?>' class="form-control" size="10">
												</td>
												<!-- <td width='15%' align='center'>
													<input type="text" name="txtphtdesig<?php echo $nfiles ?>" id="txtphtdesig<?php echo $nfiles ?>" value='<?php echo  $db_pgimgdesig; ?>' class="form-control" size="10">
												</td> -->
												<td align="right" width='15%'><input type="file" name="flesmlimg<?php echo $nfiles ?>" class="form-control" id="flesmlimg">
												</td>
												<td align='center' width='5%'>
													<?php
													if (($imgnm != "") && file_exists($imgpath)) {
														echo "<img src='$imgpath' width='30pixel' height='30pixel'>";
													} else {
														echo "No Image";
													}
													?>
													<span id="errorsDiv_flesmlimg1"></span>
												</td>
												<!-- <td align='center' width='15%'><input type="file" name="facfle<?php echo $nfiles ?>" class="form-control" id="facfle">
												</td> -->
												<!-- <td align='center' width='5%'>
													<?php
													$flnm 	  = $rowspgimgd_mdtl['pgimgd_fle'];
													$flepath = $a_phtgalbpath . $flnm;
													if (($flnm != "")) {
														echo "<a href='$flepath'  target='_blank' >View</a>";
													} else {
														echo "No file";
													}
													?>
													<span id="errorsDiv_facfle1"></span>
												</td> -->
												<td width='10%' align='center'>
													<input type="text" name="txtphtprior<?php echo $nfiles ?>" id="txtphtprior1" class="form-control" value="<?php echo $db_pgimgprty; ?>" size="4" maxlength="3"><span id="errorsDiv_txtphtprior1"></span>
												</td>
												<td align='center' width='10%'>
													<select name="lstphtsts<?php echo $nfiles ?>" id="lstphtsts<?php echo $nfiles ?>" class="form-control">
														<option value="a" <?php if ($db_pgimgsts == 'a') echo 'selected'; ?>>Active</option>
														<option value="i" <?php if ($db_pgimgsts == 'i') echo 'selected'; ?>>Inactive</option>
													</select>
												</td>
												<td width='10%'><input type="button" name="btnrmv" value="REMOVE" onClick="rmvimg('<?php echo $pgimgdid; ?>')"></td>
											</tr>
										</table>
									</table>
							<?php
							}
						} else {
							echo "<tr bgcolor='#FFFFFF'><td colspan='6' align='center' bgcolor='#f1f6fd'>No Records Found.</td></tr>";
						}
							?>
							<div id="myDiv">
								<table width="100%" cellspacing='2' cellpadding='3'>
									<tr>
										<td align="center">
											<input type="hidden" name="hdntotcntrl" id="hdntotcntrl" value="<?php echo $nfiles; ?>">
											<input name="btnadd" type="button" onClick="expand()" value="Add Another Image" class="btn btn-primary mb-3">
										</td>
									</tr>
								</table>
							</div>
								</div>

								<!-- Start Video Session -->
								<div class="table-responsive">
								<div class="col-sm-3">
									<label>Videos:</label>
								</div>
									<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
										<tr bgcolor="#FFFFFF">
											<td width="5%" align="center"><strong>SL.No.</strong></td>
											<td width="30%" align="center"><strong>Name</strong></td>
											<td width="30%" align="center"><strong>Video</strong></td>
											<td width="10%" align="center"><strong>Rank</strong></td>
											<td width="10%" align="center"><strong>Status</strong></td>
											<td width="10%" align="center"><strong>Remove</strong></td>
										</tr>
									</table>
								</div>
								<?php
								$sqryvdo_dtl = "select pgvdod_id,pgvdod_name,pgvdod_pgcntsd_id,pgvdod_vdo,pgvdod_prty,pgvdod_sts
							 from  pgvdo_dtl where  pgvdod_pgcntsd_id ='$id'  order by pgvdod_id";
								$srsvdo_dtl	= mysqli_query($conn, $sqryvdo_dtl);
								$cntpgvdo_dtl  = mysqli_num_rows($srsvdo_dtl);
								$nfiles_vdo = "";
								if ($cntpgvdo_dtl > 0) {
								?>
									<?php
									while ($rowspgvdod_mdtl = mysqli_fetch_assoc($srsvdo_dtl)) {
										$pgvdodid = $rowspgvdod_mdtl['pgvdod_id'];
										$vdonm = $rowspgvdod_mdtl['pgvdod_vdo'];
										//$vdopath = $a_phtgalspath.$vdonm;
										$nfiles_vdo += 1;
										$clrnm = "";
										if ($cnt % 2 == 0) {
											$clrnm = "bgcolor='#f1f6fd'";
										} else {
											$clrnm = "bgcolor='#f1f6fd'";
										}
									?>
										<div class="table-responsive">
											<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
												<table width="100%" border="0" cellspacing="3" cellpadding="3">
													<tr bgcolor="#FFFFFF">
														<td colspan="7" align="center" bgcolor="#f1f6fd">
															<input type="hidden" name="hdnpgvdoid<?php echo $nfiles_vdo ?>" class="form-control" value="<?php echo $pgvdodid; ?>">
															<input type="hidden" name="hdnpgdvdo<?php echo $nfiles_vdo ?>" class="form-control" value="<?php echo $vdonm; ?>">
													<tr>
														<td width='5%'>
															<?php echo $nfiles_vdo; ?>
														</td>
														<td width='30%' align='center'>

															<input type="text" name="txtvdoname1<?php echo $nfiles_vdo ?>" id="txtvdoname1<?php echo $nfiles_vdo ?>" value='<?php echo $rowspgvdod_mdtl['pgvdod_name'] ?>' class="form-control" size="10">
														</td>
														<td align="right" width='30%'>
															<textarea name="txtvdo<?php echo $nfiles_vdo ?>" cols="30" rows="3" class="form-control" id="txtvdo<?php echo $nfiles_vdo ?>"><?php echo $vdonm ?></textarea>
														</td>
														<td width='10%' align='center'>
															<input type="text" name="txtvdoprior<?php echo $nfiles_vdo ?>" id="txtvdoprior1" class="form-control" value="<?php echo $rowspgvdod_mdtl['pgvdod_prty']; ?>" size="4" maxlength="3"><span id="errorsDiv_txtvdoprior1"></span>
														</td>
														<td valign="middle" width='10%'>
															<select name="lstvdosts<?php echo $nfiles_vdo ?>" class="form-control" id="lstvdosts<?php echo $nfiles_vdo ?>">
																<option value="a" <?php if ($rowspgvdod_mdtl['pgvdod_sts'] == 'a') echo 'selected'; ?>>Active</option>
																<option value="i" <?php if ($rowspgvdod_mdtl['pgvdod_sts'] == 'i') echo 'selected'; ?>>Inactive</option>
															</select>
														</td>
														<td width='10%'><input type="button" name="btnrmv" value="REMOVE" onClick="rmvvdo('<?php echo $pgvdodid; ?>')"></td>
													</tr>
												</table>
											</table>
									<?php
									}
								} else {
									echo "<tr bgcolor='#FFFFFF'><td colspan='10' align='center' bgcolor='#f1f6fd'>No Records Found.</td></tr>";
								}
									?>
									<div id="myDivVdo">
										<table width="100%" cellspacing='2' cellpadding='3'>
											<tr>
												<td align="center">
													<input type="hidden" name="hdntotcntrlvdo" id="hdntotcntrlvdo" value="<?php echo $nfiles_vdo; ?>">
													<input name="btnadd" type="button" onClick="expandVdo()" value="Add Another Video" class="btn btn-primary mb-3">
												</td>
											</tr>
										</table>
									</div>
										</div>
										<!-- Start questions Session -->
										<div class="table-responsive">
										<div class="col-sm-3">
									<label>Questions:</label>
								</div>
											<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
												<tr bgcolor="#FFFFFF">
													<td width="10%" align="center"><strong>SL.No.</strong></td>
													<td width="35%" align="center"><strong>Name</strong></td>
													<td width="35%" align="center"><strong>Description</strong></td>
													<td width="10%" align="center"><strong>Rank</strong></td>
													<td width="10%" align="center"><strong>Status</strong></td>
													<td width="10%" align="center"><strong>Remove</strong></td>
												</tr>
											</table>
										</div>
										<?php
										$sqns = "SELECT pgcntqns_id,pgcntqns_name,pgcntqns_pgcntsd_id,pgcntqns_vdo,
						 pgcntqns_prty,pgcntqns_sts from  pgcntqnsm_dtl where pgcntqns_pgcntsd_id='$id' and pgcntqns_name!='' order by pgcntqns_id";
										$srsns = mysqli_query($conn, $sqns);
										$cntqns = mysqli_num_rows($srsns);
										$nfiles_qns = "";
										if ($cntqns > 0) {
										?>
											<?php while ($rowsns = mysqli_fetch_array($srsns)) {
												$nfiles_qns++;
												$pgcntqns_id = $rowsns['pgcntqns_id'];
												$pgcntqns_name = $rowsns['pgcntqns_name'];
												$pgcntqns_pgcntsd_id = $rowsns['pgcntqns_pgcntsd_id'];
												$pgcntqns_vdo = $rowsns['pgcntqns_vdo'];
												$pgcntqns_prty = $rowsns['pgcntqns_prty'];
												$pgcntqns_sts = $rowsns['pgcntqns_sts'];
											?>
												<div class="table-responsive">
													<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
														<table width="100%" border="0" cellspacing="3" cellpadding="3">
															<tr bgcolor="#FFFFFF">
																<td colspan="7" align="center" bgcolor="#f1f6fd">
																<input type="hidden" name="hdnpgqnsid<?php echo $nfiles_qns ?>" class="form-control"
													value="<?php echo $pgcntqns_id; ?>">
												<input type="hidden" name="hdnpgdname<?php echo $nfiles_qns ?>" class="form-control"
													value="<?php echo $pgcntqns_name; ?>">



															<tr>
																<td width='5%'>
																	<?php echo $nfiles_qns; ?>
																</td>
																<td width='35%' align='center'>
																	<input type="text" name="txtqnsnm1<?php echo $nfiles_qns ?>" id="txtqnsnm1<?php echo $nfiles_qns ?>" value='<?php echo $pgcntqns_name ?>' class="form-control" size="50">
																</td>
																<td width="35%" align="center">
																	<textarea name="txtansdesc<?php echo $nfiles_qns ?>" cols="35" rows="3" id="txtansdesc<?php echo $nfiles_qns ?>" class="form-control"><?php echo $pgcntqns_vdo ?></textarea><br>
																</td>
																<td width="10%" align="center">
																	<input type="text" name="txtqnsprty<?php echo $nfiles_qns; ?>" id="txtqnsprty<?php echo $nfiles_qns ?>" value="<?php echo $pgcntqns_prty; ?>" class="form-control" size="15"><br>
																</td>
																<td width="10%" align="center">
																	<select name="lstqnssts<?php echo $nfiles_qns; ?>" id="lstqnssts<?php echo $nfiles_qns; ?>" class="form-control">
																		<option value="a" <?php if ($pgcntqns_sts == 'a')
																												echo 'selected'; ?>>Active</option>
																		<option value="i" <?php if ($pgcntqns_sts == 'i')
																												echo 'selected'; ?>>Inactive</option>
																	</select>
																</td>
																<td width='10%'><input type="button" name="btnrmv" value="REMOVE" onClick="rmvqns('<?php echo $pgcntqns_id; ?>')"></td>
															</tr>
															</td>
															</tr>
														</table>
													</table>
											<?php
											}
										} else {
											echo "<tr bgcolor='#FFFFFF'><td colspan='6' align='center' bgcolor='#f1f6fd'>No Records Found.</td></tr>";
										}
											?>
											<div id="myDivQns">
												<table width="100%" cellspacing='2' cellpadding='3'>
													<tr>
														<td align="center">
															<input type="hidden" name="hdntotcntrlqns" id="hdntotcntrlqns" value="<?php echo $nfiles_qns; ?>">
															<input name="btnadd" type="button" onClick="expandQns()" value="Add Another Question" class="btn btn-primary mb-3">
														</td>
													</tr>
												</table>

												<p class="text-center">
													<input type="Submit" class="btn btn-primary btn-cst" name="btnedtphcntn" id="btnedtphcntn" value="Submit">
													&nbsp;&nbsp;&nbsp;
													<input type="reset" class="btn btn-primary btn-cst" name="btnecatrst" value="Clear" id="btnecatrst">
													&nbsp;&nbsp;&nbsp;
													<input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_vwpgnm; ?>?edtpgcntid=<?php echo $id; ?>&pg=<?php echo $pg . "&cntstart=" . $cntstart . $loc; ?>'">
												</p>
											</div>
												</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</section>
	<?php include_once "../includes/inc_adm_footer.php"; ?>
	<script language="javascript" type="text/javascript">
		CKEDITOR.replace('txtdesc');
	</script>
	<script language="javascript" type="text/javascript">
		/********************Multiple Image Upload********************************/
		var nfiles = "<?php echo $nfiles; ?>";

		function expand() {
			nfiles++;
			var htmlTxt = '<?php
											echo "<table width=100%  border=0 cellspacing=1 cellpadding=1 >";
											echo "<tr>";
											echo "<td align=left width=5%>";
											echo "<span class=buylinks> ' + nfiles + '</span></td>";
											echo "<td  width=15% >";
											echo "<input type=text name=txtphtname1' + nfiles + ' id=txtphtname1' + nfiles + ' class=form-control ></td>";
											// echo "<td  width=15% >";
											// echo "<input type=text name=txtphtdesig' + nfiles + ' id=txtphtdesig' + nfiles + ' class=form-control ></td>";
											echo "<td align=left width=20% colspan=2>";
											echo "<input type=file name=flesmlimg' + nfiles + ' id=flesmlimg' + nfiles + ' class=form-control><br>";
											// echo "<td align=left width=20% colspan=2>";
											// echo "<input type=file name=facfle' + nfiles + ' id=facfle' + nfiles + ' class=form-control><br>";
											echo "<td align=center width=10%>";
											echo "<input type=text name=txtphtprior' + nfiles + ' id=txtphtprior' + nfiles + ' class=form-control size=4 maxlength=3>";
											echo "</td>";
											echo "<td  width=10% align=right colspan=2>";
											echo "<select name=lstphtsts' + nfiles + ' id=lstphtsts' + nfiles + ' class=form-control>";
											echo "<option value=a>Active</option>";
											echo "<option value=i>Inactive</option>";
											echo "</select>";
											echo "</td></tr></table><br>";
											?>';
			var Cntnt = document.getElementById("myDiv");
			if (document.createRange) { //all browsers, except IE before version 9
				var rangeObj = document.createRange();
				Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
				document.frmedtpgcntn.hdntotcntrl.value = nfiles;
				if (rangeObj.createContextualFragment) { // all browsers, except IE
					//var documentFragment = rangeObj.createContextualFragment (htmlTxt);
					//Cntnt.insertBefore (documentFragment, Cntnt.firstChild);	//Mozilla
				} else { //Internet Explorer from version 9
					Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
				}
			} else { //Internet Explorer before version 9
				Cntnt.insertAdjacentHTML("BeforeBegin", htmlTxt);
			}
			document.frmedtpgcntn.hdntotcntrl.value = nfiles;
		}
		var nfiles_vdo = "<?php echo $nfiles_vdo; ?>";

		function expandVdo() {
			nfiles_vdo++;
			if (nfiles_vdo <= 20) {
				var htmlTxt = '<?php
												echo "<table width=100%  border=0 cellspacing=1 cellpadding=1 >";
												echo "<tr>";
												echo "<td align=left width=5%>";
												echo "<span class=buylinks> ' + nfiles_vdo + '</span></td>";
												echo "<td  width=30% >";
												echo "<input type=text align=left name=txtvdoname1' + nfiles_vdo + ' id=txtvdoname1' + nfiles_vdo + ' class=form-control size=10><br>";
												echo "<td align=center width=30% >";
												echo "<textarea name=txtvdo' + nfiles_vdo + ' id=txtvdo' + nfiles_vdo + 'class=form-control cols=60 rows=3></textarea><br>";
												echo "<td align=center width=10%>";
												echo "<input type=text name=txtvdoprior' + nfiles_vdo + ' id=txtvdoprior' + nfiles_vdo + ' class=form-control size=4 maxlength=3>";
												echo "</td>";
												echo "<td  width=10% align=left colspan=2>";
												echo "<select name=lstvdosts' + nfiles_vdo + ' id=lstvdosts' + nfiles_vdo + ' class=form-control>";
												echo "<option value=a>Active</option>";
												echo "<option value=i>Inactive</option>";
												echo "</select>";
												echo "</td></tr></table><br>";
												?>';
				var Cntnt = document.getElementById("myDivVdo");
				if (document.createRange) { //all browsers, except IE before version 9
					var rangeObj = document.createRange();
					Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
					document.frmedtpgcntn.hdntotcntrlvdo.value = nfiles_vdo;
					if (rangeObj.createContextualFragment) { // all browsers, except IE
						//var documentFragment = rangeObj.createContextualFragment (htmlTxt);
						//Cntnt.insertBefore (documentFragment, Cntnt.firstChild);	//Mozilla
					} else { //Internet Explorer from version 9
						Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
					}
				} else { //Internet Explorer before version 9
					Cntnt.insertAdjacentHTML("BeforeBegin", htmlTxt);
				}
				document.frmedtpgcntn.hdntotcntrlvdo.value = nfiles_vdo;
			} else {
				alert("Maximum 20 Video's Only");
				return false;
			}
		}
		/*----Questions and answers Start Hear-*/
		var nfiles_qns = "<?php echo $nfiles_qns; ?>";

		function expandQns() {
			nfiles_qns++;
			if (nfiles_qns <= 20) {
				var htmlTxt = '<?php
												echo "<table border=\'0\' cellpadding=\'1\' cellspacing=\'1\' width=\'100%\'>";
												echo "<tr>";
												echo "<td align=\'center\' width=\'5%\'> ' + nfiles_qns + '</td>";
												echo "<td align=\'left\' width=\'35%\'>";
												echo "<input type=text name=txtqnsnm1' + nfiles_qns + ' id=txtqnsnm1' + nfiles_qns + ' class=form-control size=\'50\'>";
												echo "</td>";
												echo "<td align=\'left\' width=\'35%\'>";
												echo "<textarea name=txtansdesc' + nfiles_qns + ' id=txtansdesc' + nfiles_qns + ' cols=35 rows=3 class=form-control></textarea><br>";
												echo "</td>";
												echo "<td align=\'left\' width=\'10%\'>";
												echo "<input type=\'text\' name=txtqnsprty' + nfiles_qns + ' id=txtqnsprty' + nfiles_qns + ' class=form-control size=5 maxlength=3>";
												echo "</td>";
												echo "<td align=center width=\'10%\'>";
												echo "<select name=lstqnssts' + nfiles_qns + ' id=lstqnssts' + nfiles_qns + ' class=form-control>";
												echo "<option value=a>Active</option>";
												echo "<option value=i>Inactive</option>";
												echo "</select>";
												echo "</td></tr></table>";
												?>';
				var Cntnt = document.getElementById("myDivQns");
				if (document.createRange) { //all browsers, except IE before version 9
					var rangeObj = document.createRange();
					Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
					document.frmedtpgcntn.hdntotcntrlqns.value = nfiles_qns;
					if (rangeObj.createContextualFragment) { // all browsers, except IE
						//var documentFragment = rangeObj.createContextualFragment (htmlTxt);
						//Cntnt.insertBefore (documentFragment, Cntnt.firstChild);	//Mozilla
					} else { //Internet Explorer from version 9
						Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
					}
				} else { //Internet Explorer before version 9
					Cntnt.insertAdjacentHTML("BeforeBegin", htmlTxt);
				}
				// document.getElementById('hdntotcntrlqns').value = nfiles_qns;
				document.frmedtpgcntn.hdntotcntrlqns.value = nfiles_qns;
			} else {
				alert("Maximum 20 Questions's Only");
				return false;
			}
		}
	</script>