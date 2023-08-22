<?php
include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session	
if (
    isset($_POST['btnedtdwnlds']) && (trim($_POST['btnedtdwnlds']) != "") &&
    // isset($_POST['txtname']) && (trim($_POST['txtname'])!= "") && 	
    // isset($_POST['lstprdctcat']) && (trim($_POST['lstprdctcat'])!= "")&& 	
    // isset($_POST['hdnfle']) && (trim($_POST['hdnfle']) != "") &&
    isset($_POST['hdnbrndid']) && (trim($_POST['hdnbrndid']) != "")
)

//isset($_FILES['fledwnld']) && (trim($_FILES['fledwnld'])!= ""))
{
    $id           = glb_func_chkvl($_POST['hdnbrndid']);
    $name         = glb_func_chkvl($_POST['txtname']);
    $desc         = glb_func_chkvl($_POST['txtdesc']);
    $prod_id    = glb_func_chkvl($_POST['lstprdctcat']);
    $prior       = glb_func_chkvl($_POST['txtprior']);
    $hdnfle     = glb_func_chkvl($_POST['hdnfle']);
    $desc         = glb_func_chkvl($_POST['txtdesc']);
    $sts          = glb_func_chkvl($_POST['lststs']);
    $dt         = date('Y-m-d h:i:s');
    $emp         = $_SESSION['admin'];
    $pg         = glb_func_chkvl($_REQUEST['pg']);
    $countstart = glb_func_chkvl($_REQUEST['countstart']);
    $val        = glb_func_chkvl($_REQUEST['val']);
    $optn       = glb_func_chkvl($_REQUEST['optn']);

    if (isset($_REQUEST['chk']) && trim($_REQUEST['chk']) == 'y') {
        $ck = "&chk=y";
    }
    if (($val != "") && ($optn != "")) {
        $srchval = "&optn=" . $optn . "&val=" . $val . $ck;
    }
    $sqrydwnld_dtl = "select dwnld_name
			            from   dwnld_dtl
						where  dwnld_name='$name' and
						dwnld_prodm_id=$prod_id   and 
						dwnld_id!=$id";
    $srsdwnld_dtl = mysqli_query($conn, $sqrydwnld_dtl);
    $rowsdwnld_dtl         = mysqli_num_rows($srsdwnld_dtl);
    if ($rowsdwnld_dtl < 1) {
        $uqrydwnld_dtl = "update dwnld_dtl set 
				          dwnld_name='$name',
						  dwnld_desc='$desc',
						  dwnld_prodm_id='$prod_id',
						  dwnld_sts='$sts',
						  dwnld_prty='$prior',
						  dwnld_mdfdon='$dt',
						  dwnld_mdfdby='$emp'";


        /*------------------------------------Update File----------------------------*/
        // if (isset($_FILES['fledwnld']['tmp_name']) && ($_FILES['fledwnld']['tmp_name'] != "")) {
        //     $dwnldfleval = funcUpldImg('fledwnld', 'fledwn');
        //     if ($dwnldfleval != "") {
        //         $dwnldfleval = explode(":", $dwnldfleval, 2);
        //         $dest         = $dwnldfleval[0];
        //         $evntsource     = $dwnldfleval[1];
        //     }
        //     if (($evntsource != 'none') && ($evntsource != '') && ($dest != "")) {
        //         $evntflpath      = $dwnlds_fldnm . $hdnfle;
        //         if (($hdnfle != '') && file_exists($evntflpath)) {
        //             unlink($evntflpath);
        //         }
        //         move_uploaded_file($evntsource, $dwnlds_fldnm . $id . "-" . $dest);
        //         $uqrydwnld_dtl .= ",dwnld_flenm='$dest'";
        //     }
        // }
        if (isset($_FILES['fledwnld']['tmp_name']) && ($_FILES['fledwnld']['tmp_name'] != "")) {
            $simgval = funcUpldImg('fledwnld', 'fledwn');
            if ($simgval != "") {
                $simgary    = explode(":", $simgval, 2);
                $dest         = $simgary[0];
                $source     = $simgary[1];
            }
            if (($source != 'none') && ($source != '') && ($dest != "")) {
                $simgpth      = $dwnlds_fldnm . $simgnm;

                if (($simgnm != '') && file_exists($simgpth)) {
                    unlink($simgpth);
                }
                move_uploaded_file($source, $dwnlds_fldnm . $dest);
                $uqrydwnld_dtl .= ",dwnld_flenm='$dest'";
            }
        }
        $uqrydwnld_dtl .= " where dwnld_id=$id";


        // echo  $uqrydwnld_dtl;
        // exit;
        $ursdwnld_dtl = mysqli_query($conn, $uqrydwnld_dtl);

        if ($ursdwnld_dtl == true) {
?>
            <script>
                location.href = "view_download_details.php?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart ?>";
            </script>

        <?php
        } else {
        ?>
            <script>
                location.href = "view_downloads.php?sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $srchval; ?>";
            </script>
        <?php
        }
        ?>

    <?php
    } else {
    ?>
        <script>
            location.href = "view_downloads.php?sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $srchval; ?>";
        </script>
<?php
    }
}
?>