<?php

include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_connection.php"; //Making database Connection
include_once "../includes/inc_usr_functions.php"; //checking for session
include_once '../includes/inc_config.php';       //Making paging validation
include_once '../includes/inc_folder_path.php'; //Floder Path	
/***************************************************************/
//Programm 	  		: edit_brand.php	
//Purpose 	  			: Updating new brand
//Created By  		: Lokesh palagani
//Created On  		:	07-06-223
//Modified By 		: 
//Modified On   	: 
//Company 	  		: Adroit
/************************************************************/
global $id, $pg, $countstart, $fldnm;
$fldnm = $gbrnd_upldpth;
$rd_crntpgnm = "view_all_placement_highlights.php";
$rd_vwpgnm = "view_detail_placement.php";
/*****header link********/
$pagemncat = "Placements";
$pagecat = "Placement Higilights";
$pagenm = "Placement Higilights";
/*****header link********/
if (
    isset($_POST['btnedtplctm']) && ($_POST['btnedtplctm'] != "") &&
    isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
    isset($_POST['hdnplcmtid']) && ($_POST['hdnplcmtid'] != "") &&
    isset($_POST['txtprior']) && ($_POST['txtprior'] != "")
) {
    include_once "../includes/inc_fnct_fleupld.php"; // For uploading files		
    include_once "../database/uqry_plcmt_mst.php";
}
if (
    isset($_REQUEST['edit']) && $_REQUEST['edit'] != "" &&
    isset($_REQUEST['pg']) && $_REQUEST['pg'] != "" &&
    isset($_REQUEST['countstart']) && $_REQUEST['countstart'] != ""
) {
    $id         = $_REQUEST['edit'];
    $pg         = $_REQUEST['pg'];
    $countstart = $_REQUEST['countstart'];
} else if (
    isset($_REQUEST['hdnplcmtid']) && $_REQUEST['hdnplcmtid'] != "" &&
    isset($_REQUEST['hdnpage']) && $_REQUEST['hdnpage'] != "" &&
    isset($_REQUEST['hdncnt']) && $_REQUEST['hdncnt'] != ""
) {
    $id         = $_REQUEST['hdnplcmtid'];
    $pg         = $_REQUEST['hdnpage'];
    $countstart = $_REQUEST['hdncnt'];
}
$sqrybrnd_mst = "SELECT plcmtm_id,plcmtm_name,plcmtm_img,plcmtm_sts,plcmtm_prty,plcmtm_compny,plcmtm_ofer,plcmtm_pkg, plcmtm_percnt from plcmt_mst where plcmtm_id=$id";
$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
$cntbrnd_mst  = mysqli_num_rows($srsbrnd_mst);
if ($cntbrnd_mst > 0) {
    $rowsbrnd_mst = mysqli_fetch_assoc($srsbrnd_mst);
} else {
    header('Location: view_all_placement_highlights.php');
    exit;
}

?>
<script language="javaScript" type="text/javascript" src="js/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
    var rules = new Array();
		rules[0] = 'txtname:Name|required|Enter Placement Year';
	// rules[1]='txtname:Name|alphaspace|Name only characters and numbers';
	rules[1] = 'txtprior:Priority|required|Enter Rank';
	rules[2] = 'txtprior:Priority|numeric|Enter Only Numbers';
	rules[3] = 'txtcompny:company|required|Enter How Many Comapnies In Placement ';
	rules[4] = 'txtcompny:company|numeric|Enter Only Numbers';
	rules[5] = 'txtofer:Offer|required|Enter How Many Students Placed In Placement';
	rules[6] = 'txtofer:Offer|numeric|Enter Only Numbers';
	rules[7] = 'txtpkg:Package|required|Enter Highest Package';
	rules[8] = 'txtperc:percentage|required|Enter Percentage of Placement';
    function setfocus() {
        document.getElementById('txtname').focus();
    }
</script>
<?php
include_once('script.php');
include_once('../includes/inc_fnct_ajax_validation.php');
?>
<script language="javascript" type="text/javascript">
    function funcChkDupName() {
        var name;
        name = document.getElementById('txtname').value;
      
        id = <?php echo $id; ?>;
        if (name != "" && id != "") {
            var url = "chkduplicate.php?plcmtname=" + name + "&plcmtm_id=" +id;
            xmlHttp = GetXmlHttpObject(stateChanged);
            xmlHttp.open("GET", url, true);
            xmlHttp.send(null);
        } else {
            document.getElementById('errorsDiv_txtname').innerHTML = "";
        }
    }

    function stateChanged() {
        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
            var temp = xmlHttp.responseText;
            document.getElementById("errorsDiv_txtname").innerHTML = temp;
            if (temp != 0) {
                document.getElementById('txtname').focus();
            }
        }
    }
</script>
<?php
include_once $inc_adm_hdr;
include_once $inc_adm_lftlnk;
?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Placement Highlights</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Placement Highlights</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <form name="frmedtplcmt" id="frmedtplcmt" method="post" action="<?php $_SERVER['PHP_SELF']; ?>"  onSubmit="return performCheck('frmedtplcmt', rules, 'inline');">
        <input type="hidden" name="hdnplcmtid" value="<?php echo $id; ?>">
        <input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
        <input type="hidden" name="hdnval" value="<?php echo $srchval; ?>">
        <input type="hidden" name="hdnchk" value="<?php echo $chk; ?>">
        <input type="hidden" name="hdncnt" value="<?php echo $countstart ?>">
      
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Placement Year  *</label>
                            </div>
                            <div class="col-sm-9">
                                <input name="txtname" type="text" id="txtname" size="45" maxlength="40" onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsbrnd_mst['plcmtm_name']; ?>">
                                <span id="errorsDiv_txtname"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
														<label>Companies *</label>
                            </div>
                            <div class="col-sm-9">
														<input name="txtcompny" type="text" id="txtcompny" size="45" maxlength="40" class="form-control" value="<?php echo $rowsbrnd_mst['plcmtm_compny']; ?>">
                            </div>
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
														<label>Placement Offers *</label>
                            </div>
                            <div class="col-sm-9">
														<input name="txtofer" type="text" id="txtofer" size="45" maxlength="40" class="form-control" value="<?php echo $rowsbrnd_mst['plcmtm_ofer']; ?>"> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
														<label>Highest Package *</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtpkg" id="txtpkg" class="form-control" size="4" value="<?php echo $rowsbrnd_mst['plcmtm_pkg']; ?>">
                                <span id="errorsDiv_txtlnk"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
														<label>Of Placements *</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtperc" id="txtperc" class="form-control" size="4" value="<?php echo $rowsbrnd_mst['plcmtm_percnt']; ?>">
                                <span id="errorsDiv_txtlnk"></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Rank *</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtprior" id="txtprior" class="form-control" size="4" maxlength="3" value="<?php echo $rowsbrnd_mst['plcmtm_prty']; ?>">
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
                                    <option value="a" <?php if ($rowsbrnd_mst['plcmtm_sts'] == 'a') echo 'selected'; ?>>Active</option>
                                    <option value="i" <?php if ($rowsbrnd_mst['plcmtm_sts'] == 'i') echo 'selected'; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="text-center">
                        <input type="Submit" class="btn btn-primary btn-cst" name="btnedtplctm" id="btnedtplctm" value="Submit">
                        &nbsp;&nbsp;&nbsp;
                        <input type="reset" class="btn btn-primary btn-cst" name="btneprodcatrst" value="Clear" id="btneprodcatrst">
                        &nbsp;&nbsp;&nbsp;
                        <input type="button" name="btnBack" value="Back" class="btn btn-primary" onClick="location.href='<?php echo $rd_crntpgnm; ?>'">
                    </p>
                </div>
            </div>
        </div>
    </form>
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>
<script language="javascript" type="text/javascript">
    CKEDITOR.replace('txtdesc');
</script>