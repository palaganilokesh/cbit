<?php

include_once "../includes/inc_adm_session.php";    //checking for session
include_once "../includes/inc_connection.php";     //Making database Connection
include_once "../includes/inc_usr_functions.php";  //checking for session
include_once '../includes/inc_folder_path.php'; //Floder Path

if (
    isset($_POST['btnedtbrnd']) && ($_POST['btnedtbrnd'] != "") &&
    isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
    isset($_POST['hdnbrndid']) && ($_POST['hdnbrndid'] != "") &&
    isset($_POST['txtprior']) && ($_POST['txtprior'] != "")
) {
    $id                 = glb_func_chkvl(trim($_POST['hdnbrndid']));
    $name           = glb_func_chkvl($_POST['txtname']);
    $desc           = addslashes(trim($_POST['txtdesc']));
    $simgnm        = glb_func_chkvl($_POST['hdnsimgnm']);
    // $zimgnm        = glb_func_chkvl($_POST['hdnzmimgnm']);
    $prior              = glb_func_chkvl($_POST['txtprior']);
    $sts                = glb_func_chkvl($_POST['lststs']);
    $loc                = addslashes(trim($_POST['hdnloc']));
    $typval                = glb_func_chkvl($_POST['lsttyp']);
    $lnkval                = glb_func_chkvl($_POST['txtlnk']);

    // $seotitle   = glb_func_chkvl($_POST['txtseotitle']);
    // $seodesc    = glb_func_chkvl($_POST['txtseodesc']);
    // $seokywrd   = glb_func_chkvl($_POST['txtseokywrd']);
    // $seoh1ttl      = glb_func_chkvl($_POST['txtseoh1ttl']);
    // $seoh1desc    = glb_func_chkvl($_POST['txtseoh1desc']);
    // $seoh2ttl     = glb_func_chkvl($_POST['txtseoh2ttl']);
    // $seoh2desc     = glb_func_chkvl($_POST['txtseoh2desc']);

    $val                = $_REQUEST['val'];
    $dt                 = date('Y-m-d h:i:s');
    $pg                 = $_REQUEST['pg'];
    $countstart     = $_REQUEST['countstart'];

    /*if(isset($_REQUEST['chk']) && $_REQUEST['chk']=='y')
		{
		  $ck="&chk=y";
		}
		if($val != "")
		{
			$srchval= "&val=".$val.$ck;
		}*/

    $sqrybrnd_mst = "select brndm_name
					   from brnd_mst
					   where brndm_name='$name' and
					   brndm_id!=$id";

    $srsbrnd_mst = mysqli_query($conn, $sqrybrnd_mst);
    $rowsbrnd_mst = mysqli_num_rows($srsbrnd_mst);

    if ($rowsbrnd_mst > 0) {
?>
        <script>
            location.href = "view_all_recruiters.php?sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
        </script>
        <?php
    } else {
        /*
			
							   brndm_seotitle='$seotitle',
							   brndm_seodesc='$seodesc',
							   brndm_seokywrd='$seokywrd',
							   brndm_seohonetitle='$seoh1ttl',
							   brndm_seohonedesc='$seoh1desc',	
							   brndm_seohtwotitle='$seoh2ttl',
							   brndm_seohtwodesc='$seoh2desc',
		*/
        $uqrybrnd_mst = "update brnd_mst set 
							   brndm_name='$name',
							   brndm_desc='$desc',
							   brndm_sts='$sts',
							    brndm_typ='$typval',
							   brndm_prty=$prior,
							   brndm_lnk='$lnkval',
							   brndm_mdfdon='$dt',
							   brndm_mdfdby='$sesadmin' ";

        /*------------------------------------Update small image----------------------------*/

        if (isset($_FILES['flesmlimg']['tmp_name']) && ($_FILES['flesmlimg']['tmp_name'] != "")) {
            $simgval = funcUpldImg('flesmlimg', 'brndimg');
            if ($simgval != "") {
                $simgary    = explode(":", $simgval, 2);
                $sdest         = $simgary[0];
                $ssource     = $simgary[1];
            }
            if (($ssource != 'none') && ($ssource != '') && ($sdest != "")) {
                $simgpth      = $gbrnd_upldpth . $simgnm;

                if (($simgnm != '') && file_exists($simgpth)) {
                    unlink($simgpth);
                }
                move_uploaded_file($ssource, $gbrnd_upldpth . $sdest);
                $uqrybrnd_mst .= ",brndm_img='$sdest'";
            }
        }

        $uqrybrnd_mst .= "  where brndm_id=$id";
        $ursbrnd_mst = mysqli_query($conn, $uqrybrnd_mst) or die(mysqli_error());

        if ($ursbrnd_mst == true) {
        ?>
            <script>
                location.href = "<?php echo $rd_vwpgnm; ?>?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
            </script>
        <?php
        } else {
        ?>
            <script>
                location.href = "view_detail_recruiters.php?sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
            </script>
<?php
        }
    }
}
?>