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
//Created By  		: Mallikarjuna
//Created On  		:	16/04/2013
//Modified By 		: Aradhana
//Modified On   	: 07-06-2014
//Company 	  		: Adroit
/************************************************************/
global $id, $pg, $countstart, $fldnm;
$fldnm = $gbrnd_upldpth;
$rd_crntpgnm = "view_downloads.php";
$rd_vwpgnm = "view_detail_recruiters.php";
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Downloads";
$pagenm = "Downloads";
/*****header link********/
if (
    isset($_POST['btnedtdwnlds']) && ($_POST['btnedtdwnlds'] != "") &&
    isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
    isset($_POST['lstprdctcat']) && (trim($_POST['lstprdctcat']) != "") &&
    isset($_POST['hdnbrndid']) && ($_POST['hdnbrndid'] != "") &&
    isset($_POST['txtprior']) && ($_POST['txtprior'] != "")
) {

    include_once "../includes/inc_fnct_fleupld.php"; // For uploading files		
    include_once "../database/uqry_dwnld_dtl.php";
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
    isset($_REQUEST['hdnbrndid']) && $_REQUEST['hdnbrndid'] != "" &&
    isset($_REQUEST['hdnpage']) && $_REQUEST['hdnpage'] != "" &&
    isset($_REQUEST['hdncnt']) && $_REQUEST['hdncnt'] != ""
) {
    $id         = $_REQUEST['hdnbrndid'];
    $pg         = $_REQUEST['hdnpage'];
    $countstart = $_REQUEST['hdncnt'];
}
$sqrybrnd_mst = "select dwnld_name,dwnld_id,dwnld_desc,
dwnld_prty,dwnld_sts,dwnld_prodm_id,
dwnld_flenm
from dwnld_dtl
where dwnld_id=$id";
$srsbrnd_mst  = mysqli_query($conn, $sqrybrnd_mst);
$cntbrnd_mst  = mysqli_num_rows($srsbrnd_mst);
if ($cntbrnd_mst > 0) {
    $rowsbrnd_mst = mysqli_fetch_assoc($srsbrnd_mst);
} else {
    header('Location: view_downloads.php');
    exit;
}
// $val = glb_func_chkvl($_REQUEST['val']);
// $optn = glb_func_chkvl($_REQUEST['optn']);
// $chk = glb_func_chkvl($_REQUEST['chk']);
// $loc = "&optn=" . $optn . "&val=" . $val;
// if ($chk != "") {
//     $loc = "&optn=" . $optn . "&val=" . $val . "&chk=" . $chk . "";
// }


// $rqst_stp          = $rqst_arymdl[0];
// $rqst_stp_attn  = explode("::", $rqst_stp);
// $sesvalary = explode(",", $_SESSION['sesmod']);
// if (!in_array(1, $sesvalary) || ($rqst_stp_attn[1] == '1') || ($rqst_stp_attn[1] == '2')) {
//     if ($ses_admtyp != 'a') {
//         header("Location:main.php");
//         exit();
//     }
// }
?>
<script language="javaScript" type="text/javascript" src="js/ckeditor.js"></script>
<script language="javascript" src="../includes/yav.js"></script>
<script language="javascript" src="../includes/yav-config.js"></script>
<link rel="stylesheet" type="text/css" href="../includes/yav-style1.css">
<script language="javascript" type="text/javascript">
    var rules = new Array();
    rules[0] = 'lstprdctcat:Product Name|required|Select Product name';
    rules[1] = 'txtname:Name|required|Enter Name';
    rules[2] = 'txtprior:Priority|required|Enter Rank';
    rules[3] = 'txtprior:Priority|numeric|Enter Only Numbers';

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
        var prodmcatid = document.getElementById('lstprdctcat').value;
        id = <?php echo $id; ?>;
        if (name != "" && prodmcatid != "" && id != "") {
            var url = "chkduplicate.php?prodcatname=" + name + "&prodmcatid=" + prodmcatid + "&prodcatid=" + id;
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
                    <h1 class="m-0 text-dark">Edit Downloads</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Downloads</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <form name="frmedtbrnd" id="frmedtbrnd" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" onSubmit="return performCheck('frmedtbrnd', rules, 'inline');">
        <input type="hidden" name="hdnbrndid" value="<?php echo $id; ?>">
        <input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
        <input type="hidden" name="hdnval" value="<?php echo $srchval; ?>">
        <input type="hidden" name="hdnchk" value="<?php echo $chk; ?>">
        <input type="hidden" name="hdncnt" value="<?php echo $countstart ?>">
        <input type="hidden" name="hdnbgimg" id="hdnbgimg" value="<?php echo $rowsprodcat_mst['prodcatm_bnrimg']; ?>">
        <input type="hidden" name="hdnsmlimg" id="hdnsmlimg" value="<?php echo $rowsprodscat_mst['prodcatm_icn']; ?>">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Product Name</label>
                            </div>
                            <div class="col-sm-9">

                                <?php
                                $sqryprod_mst = "select prodm_id,prodm_name
									   from prod_mst
									   where prodm_sts='a'
									   order by prodm_prty";
                                $srsprod_mst = mysqli_query($conn, $sqryprod_mst) or die(mysqli_error());

                                $cnt_prodmncat = mysqli_num_rows($srsprod_mst);
                                ?>
                                <select name="lstprdctcat" id="lstprdctcat" class="form-control">
                                    <option value="">--Select--</option>
                                    <?php
                                    if ($cnt_prodmncat > 0) {
                                        while ($rowsprodmncat_mst = mysqli_fetch_assoc($srsprod_mst)) {
                                            $mncatid = $rowsprodmncat_mst['prodm_id'];
                                            $mncatname = $rowsprodmncat_mst['prodm_name'];
                                    ?>
                                            <option value="<?php echo $mncatid; ?>" <?php if ($rowsbrnd_mst['dwnld_prodm_id'] == $mncatid) echo 'selected';  ?>><?php echo $mncatname; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span id="errorsDiv_lstprdctcat"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Name *</label>
                            </div>
                            <div class="col-sm-9">
                                <input name="txtname" type="text" id="txtname" size="45" maxlength="40" onBlur="funcChkDupName()" class="form-control" value="<?php echo $rowsbrnd_mst['dwnld_name']; ?>">
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
                                <textarea name="txtdesc" cols="60" rows="3" id="txtdesc" class="form-control"><?php echo $rowsbrnd_mst['dwnld_desc']; ?></textarea>
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
                                    <input name="fledwnld" type="file" class="form-control" id="fledwnld">
                                </div>
                                <?php
                                $imgnm = $rowsbrnd_mst['dwnld_flenm'];
                                $imgpath = $dwnlds_fldnm . $imgnm;
                                if (($imgnm != "") && file_exists($imgpath)) {
                                    echo "<img src='$imgpath' width='80pixel' height='80pixel'><br><input type='checkbox' name='chkbximg' id='chkbximg' value='$imgpath'>Remove Image";
                                } else {
                                    echo "N.A.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>


                    <!-- 
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Link</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtlnk" id="txtlnk" class="form-control" size="4" value="<?php echo $rowsbrnd_mst['brndm_lnk']; ?>">
                                <span id="errorsDiv_txtlnk"></span>
                            </div>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Display Type</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="lstdsplytyp" id="lstdsplytyp" class="form-control">

                                    <option value="1" <?php if ($db_dsplytyp == '1') echo 'selected'; ?>>General</option>
                                    <option value="2" <?php if ($db_dsplytyp == '2') echo 'selected'; ?>>Tabular</option>
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
                                <input type="text" name="txtseotitle" id="txtseotitle" size="45" maxlength="250" class="form-control" value="<?php echo $db_catseottl; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>SEO Description</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="txtseodesc" rows="3" cols="60" id="txtseodesc" class="form-control"><?php echo $db_catseodesc; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>SEO Keyword</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="txtseokywrd" rows="3" cols="60" id="txtseokywrd" class="form-control"><?php echo $db_catseokywrd; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>SEO H1 </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtseoh1" id="txtseoh1" size="45" maxlength="250" class="form-control" value="<?php echo $db_catseohone; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>SEO H2 </label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtseoh2" id="txtseoh2" size="45" maxlength="250" class="form-control" value="<?php echo $db_catseohtwo; ?>">
                            </div>
                        </div>
                    </div> -->

                    <div class="col-md-12">
                        <div class="row mb-2 mt-2">
                            <div class="col-sm-3">
                                <label>Priority*</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="txtprior" id="txtprior" class="form-control" size="4" maxlength="3" value="<?php echo $rowsbrnd_mst['dwnld_prty']; ?>">
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
                                    <option value="a" <?php if ($rowsbrnd_mst['dwnld_sts'] == 'a') echo 'selected'; ?>>Active</option>
                                    <option value="i" <?php if ($rowsbrnd_mst['dwnld_sts'] == 'i') echo 'selected'; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p class="text-center">
                        <input type="Submit" class="btn btn-primary btn-cst" name="btnedtdwnlds" id="btnedtdwnlds" value="Submit">
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