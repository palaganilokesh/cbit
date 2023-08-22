<?php
include_once '../includes/inc_config.php'; //Making paging validation	
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session	
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth; //Making paging validation
/***************************************************************
Programm : view_detail_product_subcategory.php	
Purpose : For Viewing placements Details
Created By : Lokesh palagani
Created On :	21-01-2022
Modified By : 
Modified On :
Purpose : 
Company : Adroit
 ************************************************************/
global $id, $pg, $countstart;
$rd_crntpgnm = "view_all_placement_highlights.php";
$rd_edtpgnm = "edit_placement.php";
$clspn_val = "4";
/*****header link********/
$pagemncat = "Placements";
$pagecat = "Placement Higilights";
$pagenm = "Placement Higilights";
/*****header link********/
if (isset($_REQUEST['vw']) && (trim($_REQUEST['vw']) != "") && isset($_REQUEST['pg']) && (trim($_REQUEST['pg']) != "") && isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart']) != "")) {
    $id = glb_func_chkvl($_REQUEST['vw']);
    $pg = glb_func_chkvl($_REQUEST['pg']);
    $countstart = glb_func_chkvl($_REQUEST['countstart']);
    $srchval = glb_func_chkvl($_REQUEST['val']);
}
 $sqryprodscat_mst = "SELECT plcmtm_id,plcmtm_name,plcmtm_img,plcmtm_sts,plcmtm_prty,plcmtm_compny,plcmtm_ofer,plcmtm_pkg, plcmtm_percnt
from plcmt_mst where plcmtm_id=$id";
$srsprodscat_mst  = mysqli_query($conn, $sqryprodscat_mst);
$rowsprodscat_mst = mysqli_fetch_assoc($srsprodscat_mst);

// $db_scattype     = $rowsprodscat_mst['prodscatm_typ']; //type
$loc = "&val=$srchval";
if (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "y")) {
    $msg = "<font color=red>Record updated successfully</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "n")) {
    $msg = "<font color=red>Record not updated</font>";
} elseif (isset($_REQUEST['sts']) && (trim($_REQUEST['sts']) == "d")) {
    $msg = "<font color=red>Duplicate Recored Name Exists & Record Not updated</font>";
}
?>
<script language="javascript">
    function update1() //for update download details
    {
        document.frmedtplcmt.action = "<?php echo $rd_edtpgnm; ?>?edit=<?php echo $id; ?>&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
        document.frmedtplcmt.submit();
    }
</script>
<?php include_once $inc_adm_hdr; ?>
<section class="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">View Placement Highlights</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">View Placement Highlights</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <form name="frmedtplcmt" id="frmedtplcmt" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" onSubmit="return performCheck('frmedtplcmt', rules, 'inline');">
        <input type="hidden" name="hdnprodscatid" value="<?php echo $id; ?>">
        <input type="hidden" name="hdnpage" value="<?php echo $pg; ?>">
        <input type="hidden" name="hdncnt" value="<?php echo $countstart ?>">
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
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Placement Year </label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['plcmtm_name']; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Companies </label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['plcmtm_compny']; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Placement Offers</label>
                            <div class="col-sm-8">
                            <?php echo $rowsprodscat_mst['plcmtm_ofer']; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Highest Package</label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['plcmtm_pkg']; ?> L
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Of Placements </label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['plcmtm_percnt']; ?> %
                            </div>
                        </div>
                            <!-- 
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Logo</label>
                            <div class="col-sm-8">
                                <?php
                                $imgnm = $rowsprodscat_mst['plcmtm_img'];
                                $imgpath = $gplcmt_upldpth . $imgnm;
                                if (($imgnm != "") && file_exists($imgpath)) {
                                    echo "<img src='$imgpath' width='80pixel' height='80pixel'><br>";
                                } else {
                                    echo "Image not available";
                                }
                                ?>
                            </div>
                        </div> -->
                       
                   

                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Rank</label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['plcmtm_prty']; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtname" class="col-sm-2 col-md-2 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <?php echo $rowsprodscat_mst['plcmtm_sts']; ?>
                            </div>
                        </div>
                        <p class="text-center">
                            <input type="Submit" class="btn btn-primary btn-cst" name="btnedtplcmt" id="btnedtplcmt" value="Edit" onclick="update1();">
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" name="btnBack" value="Back" class="btn btn-primary btn-cst" onclick="location.href='<?php echo $rd_crntpgnm; ?>?<?php echo $loc; ?>'">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<?php include_once "../includes/inc_adm_footer.php"; ?>