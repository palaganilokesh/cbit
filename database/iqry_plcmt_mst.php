<?php
include_once "../includes/inc_adm_session.php";    //checking for session
include_once "../includes/inc_connection.php";     //Making database Connection
include_once "../includes/inc_usr_functions.php";  //checking for session
include_once '../includes/inc_folder_path.php'; //Floder Path	
if (
    isset($_POST['btnplcmtbmt']) && ($_POST['btnplcmtbmt'] != "") &&
    isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
    isset($_POST['txtprior']) && ($_POST['txtprior'] != "")
) {

    $name     = glb_func_chkvl($_POST['txtname']);
    $compny    = addslashes(trim($_POST['txtcompny']));
    $prior    = glb_func_chkvl($_POST['txtprior']);
    $ofer      = glb_func_chkvl($_POST['txtofer']);
    $sts      = glb_func_chkvl($_POST['lststs']);
    date_default_timezone_set("Asia/kolkata");
    $dt       = date('Y-m-d h:i:s');
    $pkage      = glb_func_chkvl($_POST['txtpkg']);
    $percnt      = glb_func_chkvl($_POST['txtperc']);


    $sqryplcmt_mst = "SELECT plcmtm_name
					   from plcmt_mst
					   where plcmtm_name='$name'";
    $srsplcmt_mst = mysqli_query($conn, $sqryplcmt_mst);
    $rowsplcmt_mst         = mysqli_num_rows($srsplcmt_mst);
    if ($rowsplcmt_mst > 0) {
        $gmsg = "Duplicate  name. Record not saved";
    } else {
       

        $iqryplcmt_mst = "INSERT into plcmt_mst (plcmtm_name,plcmtm_compny,plcmtm_ofer,plcmtm_pkg, plcmtm_percnt,plcmtm_prty,plcmtm_sts,plcmtm_crtdon, plcmtm_crtdby)values( '$name','$compny','$ofer','$pkage','$percnt','$prior','$sts','$dt', '$ses_admin')";
       
        $rsplcmt_mst = mysqli_query($conn, $iqryplcmt_mst);
        if ($rsplcmt_mst == true) {
          
            $gmsg = "Record saved successfully";
        } else {
            $gmsg = "Record not saved";
        }
    }
}
