<?php

include_once "../includes/inc_adm_session.php";    //checking for session
include_once "../includes/inc_connection.php";     //Making database Connection
include_once "../includes/inc_usr_functions.php";  //checking for session
include_once '../includes/inc_folder_path.php'; //Floder Path

if (
    isset($_POST['btnedtplctm']) && ($_POST['btnedtplctm'] != "") &&
    isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
    isset($_POST['hdnplcmtid']) && ($_POST['hdnplcmtid'] != "") &&
    isset($_POST['txtprior']) && ($_POST['txtprior'] != "")
) {
    $id                 = glb_func_chkvl(trim($_POST['hdnplcmtid']));
		$name     = glb_func_chkvl($_POST['txtname']);
    $compny    = addslashes(trim($_POST['txtcompny']));
    $prior    = glb_func_chkvl($_POST['txtprior']);
    $ofer      = glb_func_chkvl($_POST['txtofer']);
    $sts      = glb_func_chkvl($_POST['lststs']);
   
    $pkage      = glb_func_chkvl($_POST['txtpkg']);
    $percnt      = glb_func_chkvl($_POST['txtperc']);
    $sts                = glb_func_chkvl($_POST['lststs']);
    $loc                = addslashes(trim($_POST['hdnloc']));
		date_default_timezone_set("Asia/kolkata");
    $dt       = date('Y-m-d h:i:s');
       $val                = $_REQUEST['val'];
     $pg                 = $_REQUEST['pg'];
    $countstart     = $_REQUEST['countstart'];

    $sqryplcmt_mst  = "SELECT plcmtm_name from plcmt_mst where plcmtm_name='$name' and plcmtm_id!=$id";
		$srsplcmt_mst = mysqli_query($conn, $sqryplcmt_mst);
    $rowsplcmt_mst         = mysqli_num_rows($srsplcmt_mst);
    if ($rowsplcmt_mst > 0) {
?>
        <script>
            location.href = "view_all_placement_highlights.php?sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
        </script>
        <?php
    } else {
       
        $uqryplcmt_mst = "UPDATE plcmt_mst set 
							   plcmtm_name='$name',
							   plcmtm_compny='$compny',
							   plcmtm_sts='$sts',
								 plcmtm_ofer='$ofer',
							   plcmtm_prty=$prior,
							   plcmtm_pkg='$pkage',
								 plcmtm_percnt='$percnt',
							   plcmtm_mdfdon='$dt',
							   plcmtm_mdfdby='$ses_admin' 
                where  plcmtm_id=$id ";
        $ursplcmt_mst = mysqli_query($conn, $uqryplcmt_mst) or die(mysqli_error($conn));

        if ($ursplcmt_mst == true) {
        ?>
            <script>
                location.href = "<?php echo $rd_vwpgnm; ?>?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
            </script>
        <?php
        } else {
        ?>
            <script>
                location.href = "view_detail_placement.php?sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
            </script>
<?php
        }
    }
}
?>