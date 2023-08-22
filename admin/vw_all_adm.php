<?php
include_once '../includes/inc_config.php'; //Making paging validation 
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session 
include_once $inc_pgng_fnctns; //Making paging validation 
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_all_banner.php
Purpose : For Viewing Home page banners
Created By : Bharath
Created On : 05-01-2022
Modified By : 
Modified On :
Company : Adroit
 ************************************************************/
global $msg, $loc, $rowsprpg, $dispmsg, $disppg;
$clspn_val = "5";
$rd_adpgnm = "add_recruiters.php";
$rd_edtpgnm = "edit_recruiters.php";
$rd_crntpgnm = "vw_all_adm.php";
$rd_vwpgnm = "view_detail_recruiters.php";
$loc = "";
/*****header link********/
$pagemncat = "Setup";
$pagecat = "Admission";
$pagenm = "Admission";
/*****header link********/
if (isset($_POST['hdnchksts']) && (trim($_POST['hdnchksts']) != "") || isset($_POST['hdnallval']) && (trim($_POST['hdnallval']) != "")) {
    $dchkval = substr($_POST['hdnchksts'], 1);
    $id = glb_func_chkvl($dchkval);
    $chkallval = glb_func_chkvl($_POST['hdnallval']);
    $updtsts = funcUpdtAllRecSts('brnd_mst', 'brndm_id', $id, 'brndm_sts', $chkallval);
    if ($updtsts == 'y') {
        $msg = "<font color=red>Record updated successfully</font>";
    } elseif ($updtsts == 'n') {
        $msg = "<font color=red>Record not updated</font>";
    }
}
if (($_POST['hdnchkval'] != "") && isset($_REQUEST['hdnchkval'])) {
    $dchkval = substr($_POST['hdnchkval'], 1);
    $did = glb_func_chkvl($dchkval);
    $del = explode(',', $did);
    $count = sizeof($del);
    $smlimg = array();
    $smlimgpth = array();
    for ($i = 0; $i < $count; $i++) {
        $sqryprodimgd_dtl = "select 
			                       brndm_img,brndm_zmimg
							    from 
					               brnd_mst
					            where
					                brndm_id=$del[$i]";
        $srsprodimgd_dtl = mysqli_query($conn, $sqryprodimgd_dtl);
        $cntrecprodimgd_dtl = mysqli_num_rows($srsprodimgd_dtl);
        while ($srowprodimgd_dtl = mysqli_fetch_assoc($srsprodimgd_dtl)) {
            $smlimg[$i] = glb_func_chkvl($srowprodimgd_dtl['brndm_img']);
            $smlimgpth[$i] = $gbrnd_upldpth . $smlimg[$i];
            for ($j = 0; $j < $cntrecprodimgd_dtl; $j++) {
                if (($smlimg[$i] != "") && file_exists($smlimgpth[$i])) {
                    unlink($smlimgpth[$i]);
                }
            }
        }
    }
    $delsts = funcDelAllRec('brnd_mst', 'brndm_id', $did);
    if ($delsts == 'y') {
        $msg = "<font color=red>Record deleted successfully</font>";
    } elseif ($delsts == 'n') {
        $msg = "<font color=red>Record can't be deleted(child records exist)</font>";
    }
}
if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) {
    $msg = "<font color=red>Record updated successfully</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "n")) {
    $msg = "<font color=red>Record not updated</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "d")) {
    $msg = "<font color=red>Duplicate Recored Name Exists & Record Not updated</font>";
}
$rowsprpg = 20; //maximum rows per page
include_once '../includes/inc_paging1.php'; //Includes pagination
$sqrybrnd_mst1 = "select brndm_id,brndm_name,brndm_img,brndm_sts,brndm_prty 
from
								   brnd_mst";
if (isset($_REQUEST['txtname']) && (trim($_REQUEST['txtname']) != "")) {
    $txtname = glb_func_chkvl($_REQUEST['txtname']);
    $loc .= "&txtname=" . $txtname;
    if (isset($_REQUEST['chk']) && (trim($_REQUEST['chk']) == 'y')) {
        $sqrybrnd_mst1 .= " where brndm_name ='$txtname'";
    } else {
        $sqrybrnd_mst1 .= " where brndm_name like '%$txtname%'";
    }
}
$sqrybrnd_mst1 = $sqrybrnd_mst1;
$sqrybrnd_mst = $sqrybrnd_mst1 . " order by brndm_name limit $offset, $rowsprpg";
//echo $sqrybrnd_mst; exit;
$srsbrnd_mst = mysqli_query($conn, $sqrybrnd_mst);
$cnt_recs = mysqli_num_rows($srsbrnd_mst);
include_once 'script.php';
?>
<script language="javascript">
    function addnew() {
        document.frmbnrmst.action = "<?php echo $rd_adpgnm; ?>";
        document.frmbnrmst.submit();
    }

    function srch() {
        //alert("");
        var urlval = "";
        if ((document.frmbnrmst.txtname.value == "")) {
            alert("Select Search Criteria");
            document.frmbnrmst.txtname.focus();
            return false;
        }
        var txtname = document.frmbnrmst.txtname.value;
        if (txtname != '') {
            if (urlval == "") {
                urlval += "txtname=" + txtname;
            } else {
                urlval += "&txtname=" + txtname;
            }
        }
        if (document.frmbnrmst.chkexact.checked == true) {
            document.frmbnrmst.action = "<?php echo $rd_crntpgnm; ?>?" + urlval + "&chk=y";
            document.frmbnrmst.submit();
        } else {
            document.frmbnrmst.action = "<?php echo $rd_crntpgnm; ?>?" + urlval;
            document.frmbnrmst.submit();
        }
        return true;
    }
</script>
<script language="javascript" type="text/javascript" src="../includes/chkbxvalidate.js"></script>
<link href="docstyle.css" rel="stylesheet" type="text/css">

<body>
    <?php include_once $inc_adm_hdr; ?>
    <section class="content">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">View Admission</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Admission</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Default box -->
        <div class="card">
            <?php if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) { ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="delids" style="display:none">
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
                <form method="post" action="<?php $_SERVER['SCRIPT_FILENAME']; ?>" name="frmbnrmst" id="frmbnrmst">
                    <input type="hidden" name="hdnchkval" id="hdnchkval">
                    <input type="hidden" name="hdnchksts" id="hdnchksts">
                    <input type="hidden" name="hdnallval" id="hdnallval">
                    <div class="col-md-12">
                        <div class="row justify-content-left align-items-center mt-3">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="col-10">
                                                <input type="text" name="txtname" placeholder="Search by name" id="txtname" class="form-control" value="<?php if (isset($_REQUEST['txtname']) && $_REQUEST['txtname'] != "") {
                                                                                                                                                            echo $_REQUEST['txtname'];
                                                                                                                                                        } ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">Exact
                                    <input type="checkbox" name="chkexact" value="1" <?php if (isset($_POST['chkexact']) && ($_POST['chkexact'] == 1)) {
                                                                                            echo 'checked';
                                                                                        } elseif (isset($_REQUEST['chk']) && ($_REQUEST['chk'] == 'y')) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="submit" value="Search" class="btn btn-primary" name="btnsbmt" onClick="srch();">
                                    <a href="<?php echo $rd_crntpgnm; ?>" class="btn btn-primary">Refresh</a>
                                    <button type="submit" class="btn btn-primary" onClick="addnew();">+ Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table width="100%" border="0" cellpadding="3" cellspacing="1" class="table table-striped projects">
                                <tr>
                                    <td colspan="<?php echo $clspn_val; ?>" align='center'><?php echo $msg;  ?></td>
                                    <!-- 
                                    <td width="7%" align="right" valign="bottom">
                                        <div align="right">

                                            <input name="btnsts" id="btnsts" type="button" class="btn btn-xs btn-primary" value="Status" onClick="updatests('hdnchksts','frmbnrmst','chksts')">
                                        </div>
                                    </td> -->
                                    <td width="7%" align="right" valign="bottom">
                                        <div align="right">
                                            <input name="btndel" id="btndel" type="button" class="btn btn-xs btn-primary" value="Delete" onClick="deleteall('hdnchkval','frmbnrmst','chkdlt');">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%" class="td_bg"><strong>SL.No.</strong></td>
                                    <td width="28%" class="td_bg"><strong>Name</strong></td>
                                    <td width="28%" class="td_bg"><strong>Phone Number</strong></td>
                                    <td width="15%" class="td_bg"><strong>Email Id</strong></td>
                                    <td width="15%" class="td_bg"><strong>Course</strong></td>
                                    <!-- <td width="15%" class="td_bg"><strong>Link</strong></td> -->
                                    <!-- <td width="6%" align="center" class="td_bg"><strong>Rank</strong></td> -->
                                    <!-- <td width="7%" align="center" class="td_bg"><strong>Edit</strong></td> -->
                                    <td width="7%" class="td_bg" align="center"><strong>
                                            <input type="checkbox" name="Check_ctr" id="Check_ctr" value="yes" onClick="Check(document.frmbnrmst.chksts,'Check_ctr','hdnallval')"></strong></td>
                                    <!-- <td width="7%" class="td_bg" align="center"><strong>
                                            <input type="checkbox" name="Check_dctr" id="Check_dctr" value="yes" onClick="Check(document.frmbnrmst.chkdlt,'Check_dctr')"></strong></td> -->
                                </tr>
                                <?php
                                $cnt = $offset;
                                if ($cnt_recs > 0) {
                                    while ($srowbrnd_mst = mysqli_fetch_assoc($srsbrnd_mst)) {
                                        $pgval_srch = $pgnum . $loc;
                                        $db_subid = $srowbrnd_mst['brndm_id'];
                                        $db_subname = $srowbrnd_mst['brndm_name'];
                                        $db_sublink = $srowbrnd_mst['brndm_lnk'];
                                        $db_prty = $srowbrnd_mst['brndm_prty'];
                                        $db_sts  = $srowbrnd_mst['brndm_sts'];
                                        $db_typ  = $srowbrnd_mst['brndm_typ'];
                                        $db_szchrt = $srowbrnd_mst['brndm_img'];
                                        $cnt += 1;
                                ?>
                                        <tr <?php if ($cnt % 2 == 0) {
                                                echo "";
                                            } else {
                                                echo "";
                                            } ?>>
                                            <td><?php echo $cnt; ?></td>
                                            <!-- <td><?php echo $db_subid; ?></td> -->
                                            <td>
                                                <a href="<?php echo $rd_vwpgnm; ?>?vw=<?php echo $db_subid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="links"><?php echo $db_subname; ?></a>
                                            </td>
                                            <td align="left">
                                                <?php
                                                $imgnm = $db_szchrt;
                                                $imgpath = $gbrnd_upldpth . $imgnm;
                                                if (($imgnm != "") && file_exists($imgpath)) {
                                                    echo "<img src='$imgpath' width='50pixel' height='50pixel'>";
                                                } else {
                                                    echo "NA";
                                                }
                                                ?>
                                            </td>
                                            <td align="center"><?php echo "hello" ?></td>
                                            <!-- <td align="center"><?php echo $db_prty; ?></td> -->
                                            <td align="center">
                                                <!-- <a href="<?php echo $rd_edtpgnm; ?>?edit=<?php echo $db_subid; ?>&pg=<?php echo $pgnum; ?>&countstart=<?php echo $cntstart . $loc; ?>" class="orongelinks">Edit</a> -->
                                            </td>
                                            <!-- <td align="center">
                                                <input type="checkbox" name="chksts" id="chksts" value="<?php echo $db_subid; ?>" <?php if ($db_sts == 'a') {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> onClick="addchkval(<?php echo $db_subid; ?>,'hdnchksts','frmbnrmst','chksts');">
                                            </td> -->
                                            <td align="center">
                                                <input type="checkbox" name="chkdlt" id="chkdlt" value="<?php echo $db_subid; ?>">
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    $msg = "<font color=red>No Records In Database</font>";
                                }
                                ?>
                                <tr>
                                    <td colspan="<?php echo $clspn_val; ?>">&nbsp;</td>
                                    <!-- <td width="7%" align="right" valign="bottom">
                                        <div align="right">
                                            <input name="btnsts" id="btnsts" type="button" value="Status" onClick="updatests('hdnchksts','frmbnrmst','chksts')" class="btn btn-xs btn-primary">
                                        </div>
                                    </td> -->
                                    <td width="7%" align="right" valign="bottom">
                                        <div align="right">
                                            <input name="btndel" id="btndel" type="button" value="Delete" onClick="deleteall('hdnchkval','frmbnrmst','chkdlt');" class="btn btn-xs btn-primary">
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                $disppg = funcDispPag($conn, 'links', $loc, $sqrybrnd_mst1, $rowsprpg, $cntstart, $pgnum);
                                $colspanval = $clspn_val + 2;
                                if ($disppg != "") {
                                    $disppg = "<br><tr><td colspan='$colspanval' align='center' >$disppg</td></tr>";
                                    echo $disppg;
                                }
                                if ($msg != "") {
                                    $dispmsg = "<tr><td colspan='$colspanval' align='center' >$msg</td></tr>";
                                    echo $dispmsg;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</body>
<?php include_once "../includes/inc_adm_footer.php"; ?>