<?php
error_reporting(0);
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************/
//Programm 	  : add_pagecontain.php
//Package 	  :
//Purpose 	  : For adding Page
//Created By  :
//Created On  :
//Modified By :
//Modified On :
//Company 	  : Adroit
/************************************************************/
/*****header link********/
$pagemncat = "Page Content";
$pagecat = "Page Contents";
$pagenm = "Page Contents";
/*****header link********/
global $gmsg,$ses_deptid;

if (
	isset($_POST['btnaddpgcnt']) && (trim($_POST['btnaddpgcnt']) != "") &&
	isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	isset($_POST['lstcatone']) && (trim($_POST['lstcatone']) != "") &&
	isset($_POST['lstcattwo']) && (trim($_POST['lstcattwo']) != "") &&
	isset($_POST['lstprodmcat']) && (trim($_POST['lstprodmcat']) != "") &&
	isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")
) {
	$arycatone     = glb_func_chkvl($_POST['lstcatone']);
	$chkdept     = explode('-', $arycatone);
	$rqst_lstdept     = glb_func_chkvl($_POST['lstdept']);
	//if((($chkdept[1]=='d') && ($rqst_lstdept !='')) || ($chkdept[1]=='g') || ($chkdept[1]=='n')){
	include_once '../includes/inc_fnct_fleupld.php'; // For uploading files
	include_once '../database/iqry_pgcnts_dtl.php';
	//}
}
$rd_crntpgnm = "view_all_pagecontain.php";
$clspn_val   = "4";

$rqst_stp      	= $rqst_arymdl[1];
$rqst_stp_attn     = explode("::", $rqst_stp);
$rqst_stp_chk      	= $rqst_arymdl[0];
$rqst_stp_attn_chk     = explode("::", $rqst_stp_chk);
if ($rqst_stp_attn_chk[0] == '2') {
	$rqst_stp      	= $rqst_arymdl[0];
	$rqst_stp_attn     = explode("::", $rqst_stp);
}
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
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">

	<title><?php echo $pgtl; ?></title>
	<?php
	include_once('script.php');
	include_once '../includes/inc_fnct_ajax_validation.php'; //Includes ajax validations
	?>
	<script language="javaScript" type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">

	<script language="javascript" type="text/javascript">
		var rules = new Array();
		rules[1] = 'lstcatone:Categoryone Name|required|Select Category';
		rules[3] = 'txtname:Name|required|Enter name';
		rules[4] = 'txtprty:Rank|required|Enter Rank';
		rules[5] = 'txtprty:Rank|numeric|Enter Only Numbers';
		rules[6] = 'lstprodmcat:Categoryone Name|required|Select Main Links';
		rules[7] = 'lstcattwo:Sub Categoryone Name|required|Select Sub Category';
		/*function chkDept(){
			var deptsts = (document.getElementById('lstdept').disabled);
			var catoneid = (document.getElementById('lstcatone').value);
			cat_ary 	= Array();
			cat_ary	 	= catoneid.split("-");
			if(cat_ary[1] =='d'){
				document.getElementById('lstdept').disabled=false;
				rules[3]='lstdept:Department Name|required|Select Department';
			}
			else{
				document.getElementById('lstdept').disabled=true;
				document.getElementById('lstdept').value="";
				document.getElementById("errorsDiv_lstdept").innerHTML = "";
			}
			return false;
		}*/
	</script>
	<script>
		function get_cat()
  {
  	var mncatval = $("#lstprodmcat").val();
  	$.ajax({
  		type: "POST",
  		url: "../includes/inc_getStsk.php",
  		data:'mncatval='+mncatval,
  		success: function(data){
  			// alert(data)
  			$("#lstcatone").html(data);
  		}
  	});
  }
	function get_scat()
  {
		// debugger
  	var lstcatone = $("#lstcatone").val();
		var mcatid = $("#lstprodmcat").val();
  	$.ajax({
  		type: "POST",
  		url: "../includes/inc_getStsk.php",
  		data:'lstcatone='+lstcatone +'&mcatid='+mcatid,
  		success: function(data){
  			// alert(data)
  			$("#lstcattwo").html(data);
  		}
  	});
  }

		function funscatval() {
			if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
				funcRmvOptn('lstcattwo');
				var temp = trim(xmlHttp.responseText);
				// alert(temp);
				if (temp != "") {
					funcAddOptn('lstcattwo', temp);
				}
			}
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
				optn = document.createElement("OPTION");
				optn.value = id;
				optn.text = name;
				var newopt = new Option(name, id);
				document.getElementById(prmtrCntrlnm).options[inc + 1] = newopt;
			}
		}

		/********************Multiple Image Upload********************************/

		var nfiles = 1;

		function expand() {
			nfiles++;
			var htmlTxt = '<?php
											echo "<table border=\'0\' cellpadding=\'1\' cellspacing=\'1\' width=\'100%\'>";
											echo "<tr>";
											echo "<td align=\'center\' width=\'5%\'> ' + nfiles + '</td>";
											echo "<td align=\'left\' width=\'15%\'>";
											echo "<input type=text name=txtphtname' + nfiles + ' id=txtphtname' + nfiles + ' class=form-control size=\'10\'>";
											echo "</td>";
											// echo "<td align=\'left\' width=\'15%\'>";
											// echo "<input type=text name=txtphtdesig' + nfiles + ' id=txtphtdesig' + nfiles + ' class=form-control size=\'10\'>";
											// echo "</td>";

											echo "<td align=\'left\' width=\'20%\'>";
											echo "<input type=file name=flesimg' + nfiles + ' id=flesimg' + nfiles + ' class=form-control><br>";
											echo "</td>";
											// echo "<td align=\'left\' width=\'20%\'>";
											// echo "<input type=file name=facfle' + nfiles + ' id=facfle' + nfiles + ' class=form-control><br>";
											// echo "</td>";

											echo "<td align=\'left\' width=\'10%\'>";
											echo "<input type=\'text\' name=txtphtprior' + nfiles + ' id=txtphtprior' + nfiles + ' class=form-control size=5 maxlength=3>";
											echo "</td>";

											echo "<td align=center width=\'10%\'>";
											echo "<select name=lstphtsts' + nfiles + ' id=lstphtsts' + nfiles + ' class=form-control>";
											echo "<option value=a>Active</option>";
											echo "<option value=i>Inactive</option>";
											echo "</select>";
											echo "</td></tr></table>";
											?>';

			var Cntnt = document.getElementById("myDiv");

			if (document.createRange) { //all browsers, except IE before version 9

				var rangeObj = document.createRange();
				Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
				document.frmpgcntn.hdntotcntrl.value = nfiles;
				if (rangeObj.createContextualFragment) { // all browsers, except IE
					//var documentFragment = rangeObj.createContextualFragment (htmlTxt);
					//Cntnt.insertBefore (documentFragment, Cntnt.firstChild);	//Mozilla

				} else { //Internet Explorer from version 9
					Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
				}
			} else { //Internet Explorer before version 9
				Cntnt.insertAdjacentHTML("BeforeBegin", htmlTxt);
			}
			document.getElementById('hdntotcntrl').value = nfiles;
			//document.frmpgcntn.hdntotcntrl.value = nfiles;
		}

		function setfocus() {
			document.getElementById('txtname').focus();
		}

		function funcChkDupName() {
			var pagcntnname, catname;
			catname = document.getElementById('lstcatone').value;
			scatname = document.getElementById('lstcattwo').value;
			pagcntnname = document.getElementById('txtname').value;
			deptidval = "";
			if (document.getElementById('lstdept').disabled == false) {
				deptidval = document.getElementById('lstdept').value;
			}
			if (pagcntnname != "" && catname != "") {
				var url = "chkduplicate.php?pagcntnname=" + pagcntnname + "&catname=" + catname + "&scatname=" + scatname + "&deptid=" + deptidval;
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
					document.getElementById('txtname').focus();
				}
			}
		}
		/*----Video Start Hear-*/
		var nfiles_vdo = 1;

		function expandVdo() {
			nfiles_vdo++;
			if (nfiles_vdo <= 20) {
				var htmlTxt = '<?php
												echo "<table border=\'0\' cellpadding=\'1\' cellspacing=\'1\' width=\'100%\'>";
												echo "<tr>";
												echo "<td align=\'center\' width=\'10%\'> ' + nfiles_vdo + '</td>";
												echo "<td align=\'center\' width=\'35%\'>";
												echo "<input type=text name=txtvdoname' + nfiles_vdo + ' id=txtvdoname' + nfiles_vdo + ' class=form-control size=\'25\'>";
												echo "</td>";

												echo "<td align=\'center\' width=\'35%\'>";
												echo "<textarea name=txtvdo' + nfiles_vdo + ' id=txtvdo' + nfiles_vdo + ' cols=35 rows=3 class=form-control></textarea><br>";
												echo "</td>";



												echo "<td align=\'center\' width=\'10%\'>";
												echo "<input type=\'text\' name=txtvdoprior' + nfiles_vdo + ' id=txtvdoprior' + nfiles_vdo + ' class=form-control size=5 maxlength=3>";
												echo "</td>";

												echo "<td align=center width=\'10%\'>";
												echo "<select name=lstvdosts' + nfiles_vdo + ' id=lstvdosts' + nfiles_vdo + ' class=form-control>";
												echo "<option value=a>Active</option>";
												echo "<option value=i>Inactive</option>";
												echo "</select>";
												echo "</td></tr></table>";
												?>';
				var Cntnt = document.getElementById("myDivVdo");

				if (document.createRange) { //all browsers, except IE before version 9
					var rangeObj = document.createRange();
					Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
					document.frmpgcntn.hdntotcntrlvdo.value = nfiles_vdo;
					if (rangeObj.createContextualFragment) { // all browsers, except IE
						//var documentFragment = rangeObj.createContextualFragment (htmlTxt);
						//Cntnt.insertBefore (documentFragment, Cntnt.firstChild);	//Mozilla

					} else { //Internet Explorer from version 9
						Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
					}
				} else { //Internet Explorer before version 9
					Cntnt.insertAdjacentHTML("BeforeBegin", htmlTxt);
				}
				document.getElementById('hdntotcntrlvdo').value = nfiles_vdo;
				document.frmpgcntn.hdntotcntrlvdo.value = nfiles_vdo;
			} else {
				alert("Maximum 20 Video's Only");
				return false;
			}
		}

		/*----Questions and answers Start Hear-*/

		var nfiles_qns = 1;

function expandQns() {
    nfiles_qns++;
    if (nfiles_qns <= 20) {
        var htmlTxt = '<?php
                                        echo "<table border=\'0\' cellpadding=\'1\' cellspacing=\'1\' width=\'100%\'>";
                                        echo "<tr>";
                                        echo "<td align=\'center\' width=\'10%\'> ' + nfiles_qns + '</td>";
                                        echo "<td align=\'left\' width=\'35%\'>";
                                        echo "<input type=text name=txtqnsnm' + nfiles_qns + ' id=txtqnsnm' + nfiles_qns + ' class=form-control size=\'25\'>";
                                        echo "</td>";

                                        echo "<td align=\'left\' width=\'35%\'>";
                                        echo "<textarea name=txtansdesc' + nfiles_qns + ' id=txtansdesc' + nfiles_qns + ' cols=35 rows=3 class=form-control></textarea><br>";
                                        echo "</td>";

                                        /*echo "<td align=center width=35%>";
                echo "<input type=file name=flebimg' + nfiles_qns + ' id=flebimg' + nfiles_qns + ' class=select><br>";
                echo "</td>";*/


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
            document.frmpgcntn.hdntotcntrlQns.value = nfiles_qns;
            if (rangeObj.createContextualFragment) { // all browsers, except IE
                //var documentFragment = rangeObj.createContextualFragment (htmlTxt);
                //Cntnt.insertBefore (documentFragment, Cntnt.firstChild);	//Mozilla

            } else { //Internet Explorer from version 9
                Cntnt.insertAdjacentHTML('BeforeBegin', htmlTxt);
            }
        } else { //Internet Explorer before version 9
            Cntnt.insertAdjacentHTML("BeforeBegin", htmlTxt);
        }
        document.getElementById('hdntotcntrlQns').value = nfiles_qns;
        document.frmpgcntn.hdntotcntrlQns.value = nfiles_qns;
    } else {
        alert("Maximum 20 Questions's Only");
        return false;
    }
}


	</script>
</head>

<body onLoad="setfocus();">
	<?php
	include_once('../includes/inc_adm_header.php');

	?>

	<section class="content">
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0 text-dark">Add Pagecontent</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Add Pagecontent</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>

		<div class="card-body p-0">
			<form name="frmpgcntn" id="frmpgcntn" method="post" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" enctype="multipart/form-data" onSubmit="return performCheck('frmpgcntn', rules, 'inline');">

				<input type="hidden" name="lstchkdept" id="lstchkdept">
				<div class="col-md-12">
					<div class="row justify-content-center align-items-center">
						<?php
						if ($gmsg != "") {
							echo "<tr bgcolor='#f1f6fd'>
							<td align='center' valign='middle' bgcolor='#f1f6fd' colspan='$clspn_val' >
								<font face='Arial' size='2' color = 'red'>
									$gmsg
								</font>
							</td>
			  			</tr>";
						}
						?>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Main Link </label>
								</div>
								<div class="col-sm-9">
									<?php
									$sqryprodmncat_mst = "SELECT	prodmnlnksm_id,prodmnlnksm_name from	prodmnlnks_mst
							  		 where prodmnlnksm_sts = 'a'";
	if($ses_admtyp=='d'){
		$sqryprodmncat_mst .= " and prodmnlnksm_name='Departments' ";
	}
										 $sqryprodmncat_mst .= "	order by	prodmnlnksm_name";
									$rsprodmncat_mst = mysqli_query($conn,$sqryprodmncat_mst);
									$cnt_prodmncat = mysqli_num_rows($rsprodmncat_mst);
									?>
									<select name="lstprodmcat" id="lstprodmcat" class="form-control" onchange="get_cat();">
										<option value="">--Select Main Link--</option>
										<?php
										if($cnt_prodmncat > 0)
										{
											while($rowsprodmncat_mst=mysqli_fetch_assoc($rsprodmncat_mst))
											{
												$mncatid = $rowsprodmncat_mst['prodmnlnksm_id'];
												$mncatname = $rowsprodmncat_mst['prodmnlnksm_name'];
												?>
												<option value="<?php echo $mncatid;?>"><?php echo $mncatname;?></option>
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
									<label>Category </label>
								</div>
								<div class="col-sm-9">
									<select name="lstcatone" id="lstcatone" class="form-control" onChange=" get_scat(),chkDept();">
										<option value="">Select </option>
									</select>
									<span id="errorsDiv_lstcatone"></span>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Sub Category </label>
								</div>
								<div class="col-sm-9">
									<select name="lstcattwo" id="lstcattwo" class="form-control" >
										<option value="">Select </option>
									</select>
									<span id="errorsDiv_lstcattwo"></span>
								</div>
							</div>
						</div>

						<!-- <div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Category</label>
								</div>
								<div class="col-sm-9">
									<select name="lstcatone" id="lstcatone" class="form-control" onChange="funcDspScat(),chkDept();">
										<option value="">--Select--</option>
										<?php
										$sqryprodcat_mst = "SELECT
                                      prodcatm_id,prodcatm_name,prodcatm_typ
                                  from
                                      prodcat_mst
                                  where
                                      prodcatm_sts='a'";
										if ($ses_admtyp == 'u') {
											$sqryprodcat_mst .= " and prodcatm_typ='d'";
										}
										$sqryprodcat_mst .= " order by prodcatm_name";
										$srsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
										while ($rowsprodcat_mst = mysqli_fetch_assoc($srsprodcat_mst)) {
											$dbprodcat_typ 	= $rowsprodcat_mst['prodcatm_typ'];
											$dbprodcat_id 	= $rowsprodcat_mst['prodcatm_id'];
											$dbprodcat_name = $rowsprodcat_mst['prodcatm_name'];
											echo "<option value='$dbprodcat_id-$dbprodcat_typ'>$dbprodcat_name</option>";
										}
										?>
									</select>
									<span id="errorsDiv_lstcatone"></span>

								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Subcategory</label>
								</div>
								<div class="col-sm-9">
									<select name="lstcattwo" id="lstcattwo" class="form-control" onChange="funcChkDupName()">
										<option value="">--Select--</option>
									</select>
									<span id="errorsDiv_lstcattwo"></span>
								</div>
							</div>
						</div> -->
						<input type="hidden" name='lstdept' id='lstdept'>

						<?php /*?><tr bgcolor="#f1f6fd">
				<td width="18%" align="left" valign="top" bgcolor="#f1f6fd"><strong>Department</strong></td>
				<td width="2%" align="left" valign="center" bgcolor="#f1f6fd"><strong>:</strong></td>
				<td width="40%" align="left" valign="top" bgcolor="#f1f6fd">
				<select name="lstdept" id="lstdept" style="width:150px" >
				  <option value="">--Select--</option>
				 <?php
					$sqrydept_mst="select
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
					$srsdept_mst=mysqli_query($conn,$sqrydept_mst);
					while($rowsdept_mst=mysqli_fetch_assoc($srsdept_mst)){
					?>
						<option value="<?php echo $rowsdept_mst['deptm_id'];?>"><?php echo $rowsdept_mst['deptm_name'];?></option>
						<?php
					 }
					 ?>
					 </select>
				</td>
				<td width="40%" align="left" valign="middle" bgcolor="#f1f6fd" style="color:#FF0000">
					<div id="errorsDiv_lstdept"></div>
				</td>
          </tr><?php */ ?>

						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Name *</label>
								</div>
								<div class="col-sm-9">
									<input name="txtname" type="text" id="txtname" size="45" maxlength="250" class="form-control" >
									<!-- onBlur="funcChkDupName()" -->
									<span id="errorsDiv_txtname"></span>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>Description </label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtdesc" id="txtdesc" cols="60" rows="3" class="form-control"></textarea>
									<span id="errorsDiv_txtdesc"></span>
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
										<input name="txtlnk" type="text" class="form-control" id="txtlnk" maxlength="50">
										<span id="errorsDiv_txtlnk"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
            <div class="row mb-2 mt-2">
              <div class="col-sm-3">
                <label>Header Desktop Image</label>
              </div>
              <div class="col-sm-9">
                <input type="file" name="fledskimg" id="fledskimg" class="form-control">
                <span id="errorsDiv_fledskimg"></span>
              </div>
            </div>
          </div>

					<div class="col-md-12">
            <div class="row mb-2 mt-2">
              <div class="col-sm-3">
                <label>Header Tablet Image</label>
              </div>
              <div class="col-sm-9">
                <input type="file" name="fletabimg" id="fletabimg" class="form-control">
                <span id="errorsDiv_fletabimg"></span>
              </div>
            </div>
          </div>

					<div class="col-md-12">
            <div class="row mb-2 mt-2">
              <div class="col-sm-3">
                <label>Header Mobile Image</label>
              </div>
              <div class="col-sm-9">
                <input type="file" name="flemobimg" id="flemobimg" class="form-control">
                <span id="errorsDiv_flemobimg"></span>
              </div>
            </div>
          </div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>File</label>
								</div>
								<div class="col-sm-9">
									<input type="file" name="evntfle" id="evntfle" class="form-control">
									<span id="errorsDiv_evntfle"></span>
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
										<option value="1" selected>Page Content</option>
										<option value="2">Photo Gallery</option>
										<option value="3">Video Gallery</option>
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
									<input type="text" name="txtseotitle" id="txtseotitle" size="45" maxlength="250" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO Description</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseodesc" rows="3" cols="60" id="txtseodesc" class="form-control"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO Keyword</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseokywrd" rows="3" cols="60" id="txtseokywrd" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO H1 Description</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseohone" rows="3" cols="60" id="txtseohone" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="row mb-2 mt-2">
								<div class="col-sm-3">
									<label>SEO H2 Description</label>
								</div>
								<div class="col-sm-9">
									<textarea name="txtseohtwo" rows="3" cols="60" id="txtseohtwo" class="form-control"></textarea>
								</div>
							</div>
						</div>
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


						<!-- End of Name Desc and cat selection -->

						<div class="table-responsive">
						<div class="col-sm-3">
									<label>Images: </label>
								</div>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
									<td width="5%" align="center"><strong>SL.No.</strong></td>
									<td width="15%" align="left"><strong>Name</strong></td>
									<!-- <td width="15%" align="left"><strong>Designation</strong></td> -->
									<td width="20%" align="left"><strong>Image</strong></td>
									<!-- <td width="20%" align="left"><strong>File</strong></td> -->
									<td width="10%" align="left"><strong>Rank</strong></td>
									<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>

						<div class="table-responsive">
									<table width="100%"  border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered" >
										<table width="100%" border="0" cellspacing="3" cellpadding="3">
											<tr bgcolor="#FFFFFF">
											<td width="5%" align="center">1</td>
												<td width="15%"  align="center">
													<input type="text" name="txtphtname1" id="txtphtname1" placeholder="Name" class="form-control" size="15"><br>
													<span id="errorsDiv_txtphtname1" style="color:#FF0000"></span>
												</td>
												<!-- <td width="15%"  align="center">
													<input type="text" name="txtphtdesig1" id="txtphtdesig1" class="form-control" size="15"><br>
													<span id="errorsDiv_txtphtdesig1" style="color:#FF0000"></span>
												</td> -->
												<td width="20%"  align="center">
													<input type="file" name="flesimg1" id="flesimg1" class="form-control" size="15"><br>
													<span id="errorsDiv_flesimg1" style="color:#FF0000"></span>
												</td>
												<!-- <td width="20%"  align="center">
													<input type="file" name="facfle1" id="facfle1" class="form-control" size="15"><br>
													<span id="errorsDiv_facfle1" style="color:#FF0000"></span>
												</td> -->
												<td width="10%"  align="center">
													<input type="text" name="txtphtprior1" id="txtphtprior1" class="form-control" size="15"><br>
													<span id="errorsDiv_txtphtprior1" style="color:#FF0000"></span>
												</td>
												<td width="10%" align="center" >
													<select name="lstphtsts1" id="lstphtsts1" class="form-control">
														<option value="a" selected>Active</option>
														<option value="i">Inactive</option>
													</select>
												</td>
											</tr>
										</table>
									</table>
									<div id="myDiv">
										<table width="100%" cellspacing='2' cellpadding='3'>
											<tr>
												<td align="center">
													<input name="btnadd" type="button" onClick="expand()" value="Add Another Image" class="btn btn-primary mb-3">
												</td>
											</tr>
										</table>
									</div>
								</div>

				 <!-- Start Video Session -->

						<div class="table-responsive">
						<div class="col-sm-3">
									<label>Videos: </label>
								</div>
							<table width="100%" border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered">
								<tr bgcolor="#FFFFFF">
								<td width="10%" align="center"><strong>SL.No.</strong></td>
										<td width="35%" align="center"><strong>Name</strong></td>
										<td width="35%" align="center"><strong>Video</strong></td>
										<td width="10%" align="center"><strong>Rank</strong></td>
										<td width="10%" align="center"><strong>Status</strong></td>
								</tr>
							</table>
						</div>
						<div class="table-responsive">
									<table width="100%"  border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered" >
										<table width="100%" border="0" cellspacing="3" cellpadding="3">
											<tr bgcolor="#FFFFFF">
											<td width="10%" align="center">1</td>
												<td width="35%"  align="center">
													<input type="text" name="txtvdoname1" id="txtvdoname1" placeholder="Name" class="form-control" size="15"><br>
													<span id="errorsDiv_txtvdoname1" style="color:#FF0000"></span>
												</td>
												<td width="35%"  align="center">
												<textarea name="txtvdo1" cols="35" rows="3" id="txtvdo1" class="form-control"></textarea><br>
													<span id="errorsDiv_txtvdo1" style="color:#FF0000"></span>
												</td>

												<td width="10%"  align="center">
													<input type="text" name="txtvdoprior1" id="txtvdoprior1" class="form-control" size="15"><br>
													<span id="errorsDiv_txtvdoprior1" style="color:#FF0000"></span>
												</td>
												<td width="10%" align="center" >
													<select name="lstvdosts1" id="lstvdosts1" class="form-control">
														<option value="a" selected>Active</option>
														<option value="i">Inactive</option>
													</select>
												</td>
											</tr>
										</table>
									</table>
									<div id="myDivVdo">
										<table width="100%" cellspacing='2' cellpadding='3'>
											<tr>
												<td align="center">
													<input name="btnadd" type="button" onClick="expandVdo()" value="Add Another Video" class="btn btn-primary mb-3">
												</td>
											</tr>
										</table>
									</div>
								</div>
									<!-- end Video Session -->

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
								</tr>
							</table>
						</div>
						<div class="table-responsive">
									<table width="100%"  border="0" cellspacing="1" cellpadding="1" class="table table-striped table-bordered" >
										<table width="100%" border="0" cellspacing="3" cellpadding="3">
											<tr bgcolor="#FFFFFF">
											<td width="10%" align="center">1</td>
												<td width="35%"  align="center">
													<input type="text" name="txtqnsnm1" id="txtqnsnm1" placeholder="Name" class="form-control" size="15"><br>
													<span id="errorsDiv_txtqnsnm1" style="color:#FF0000"></span>
												</td>
												<td width="35%"  align="center">
												<textarea name="txtansdesc1" cols="35" rows="3" id="txtansdesc1" class="form-control"></textarea><br>
													<span id="errorsDiv_txtansdesc1" style="color:#FF0000"></span>
												</td>

												<td width="10%"  align="center">
													<input type="text" name="txtqnsprty1" id="txtqnsprty1" class="form-control" size="15"><br>
													<span id="errorsDiv_txtqnsprty1" style="color:#FF0000"></span>
												</td>
												<td width="10%" align="center" >
													<select name="lstqnssts1" id="lstqnssts1" class="form-control">
														<option value="a" selected>Active</option>
														<option value="i">Inactive</option>
													</select>
												</td>
											</tr>
										</table>
									</table>
									<div id="myDivQns">
										<table width="100%" cellspacing='2' cellpadding='3'>
											<tr>
												<td align="center">
													<input name="btnadd" type="button" onClick="expandQns()" value="Add Another Question" class="btn btn-primary mb-3">
												</td>
											</tr>
										</table>
									</div>
								</div>
									<!-- end questions Session -->
									<input type="hidden" name="hdntotcntrlQns" value="1">
								<input type="hidden" name="hdntotcntrlvdo" value="1">
								<input type="hidden" name="hdntotcntrl" value="1">


								<p class="text-center">
							<input type="Submit" class="btn btn-primary" name="btnaddpgcnt" id="btnaddpgcnt" value="Submit">
							&nbsp;&nbsp;&nbsp;
							<input type="reset" class="btn btn-primary" name="btnreset" value="Clear" id="btnreset">
							&nbsp;&nbsp;&nbsp;
							<input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
						</p>

			</form>
		</div>

	</section>

	<?php include_once "../includes/inc_adm_footer.php"; ?>
</body>

</html>




<script language="javascript" type="text/javascript">
	//CKEDITOR.replace('txtdesc');
	CKEDITOR.replace('txtdesc', {
		'filebrowserImageUploadUrl': 'js/plugins/imgupload/imgupload.php'
	});
</script>