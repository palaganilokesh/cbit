<?php
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once '../includes/inc_adm_session.php'; //checking for session
include_once '../includes/inc_usr_functions.php'; //Use function for validation and more	


if (
    isset($_POST['btnedtabtus']) && (trim($_POST['btnedtabtus']) != "") &&
    isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
    isset($_POST['hdnabtusid']) && (trim($_POST['hdnabtusid']) != "") &&
    isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")
) {

    $id         = glb_func_chkvl($_POST['hdnabtusid']);
    $name       = glb_func_chkvl($_POST['txtname']);
    $lnk           = glb_func_chkvl($_POST['txtlnk']);
    $prior      = glb_func_chkvl($_POST['txtprior']);
    $desc       = addslashes(trim($_POST['txtdesc']));
    $sts        = glb_func_chkvl($_POST['lststs']);
    $curdt      = date('Y-m-d h:i:s');
    $himg         = glb_func_chkvl($_POST['hdnsmlimg']);
    $pg         = glb_func_chkvl($_REQUEST['hdnpage']);
    $cntstart    = glb_func_chkvl($_REQUEST['hdncnt']);
    $loc                = addslashes(trim($_POST['hdnloc']));

    /*  if(isset($_REQUEST['chk']) && trim($_REQUEST['chk'])=='y'){
		  $chk="&chk=y";
		}
		if($val != ""){
			 $srchval= "&val=".$val.$chk;
		}*/

    $sqryabtus_mst = "select 
								abtusm_name
							from 
								abtus_mst
							where 
								abtusm_id != $id and
								abtusm_name='$name'";
    $srsabtus_mst = mysqli_query($conn, $sqryabtus_mst);
    $cntabtusm    = mysqli_num_rows($srsabtus_mst);
    if ($cntabtusm < 1) {
        $uqryabtus_mst = "update abtus_mst set 
								  abtusm_name='$name',
								  abtusm_desc='$desc',
								  abtusm_lnk='$lnk',
								  abtusm_prty='$prior',
								  abtusm_sts='$sts',
								  abtusm_mdfdon='$curdt',
								  abtusm_mdfdby='$sesadmin'";
        if (isset($_FILES['flesmlimg']['tmp_name']) && ($_FILES['flesmlimg']['tmp_name'] != "")) {
            $simgval = funcUpldImg('flesmlimg', 'simg');
            if ($simgval != "") {
                $simgary    = explode(":", $simgval, 2);
                $sdest         = $simgary[0];
                $ssource     = $simgary[1];
            }
            $uqryabtus_mst .= ",abtusm_imgnm='$sdest'";
        }
        $uqryabtus_mst .= " where 
								  abtusm_id='$id'";
        $ursabtus_mst = mysqli_query($conn, $uqryabtus_mst);
        if ($ursabtus_mst == true) {
            if (($ssource != 'none') && ($ssource != '') && ($sdest != "")) {
                $smlimgpth      = $gabtus_fldnm . $himg;
                if (($himg != '') && file_exists($smlimgpth)) {
                    unlink($smlimgpth);
                }
                move_uploaded_file($ssource, $gabtus_fldnm . $sdest);
            }
?>
            <script>
                location.href = "view_abtus_detail.php?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $loc;; ?>";
            </script>
        <?php
        } else {
        ?>
            <script>
                location.href = "view_abtus_detail.php?edit=<?php echo $id; ?>&sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $loc; ?>";
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            location.href = "view_abtus_detail.php?edit=<?php echo $id; ?>&sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $loc; ?>";
        </script>
<?php
    }
}
?>