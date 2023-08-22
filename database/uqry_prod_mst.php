<?php

include_once '../includes/inc_nocache.php'; // Clearing the cache information
include_once '../includes/inc_adm_session.php'; //checking for session
if (
    isset($_POST['btnedtprod']) && (trim($_POST['btnedtprod']) != "") &&
    isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
    isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")
) {
    $name           = glb_func_chkvl($_POST['txtname']);
    $desc           = addslashes($_POST['txtdesc']);
    $id           = glb_func_chkvl($_POST['hdnprodid']);
    //$url	  	  = glb_func_chkvl($_POST['lsturl']);
    //$img	 	  = glb_func_chkvl($_FILES['fleimg']);
    $sts           = glb_func_chkvl($_POST['lststs']);
    $prty         = glb_func_chkvl($_POST['txtprior']);
    $dt             = date('Y-m-d h:i:s');
    $pg           = glb_func_chkvl($_REQUEST['pg']);
    $countstart   = glb_func_chkvl($_REQUEST['countstart']);
    $val          = glb_func_chkvl($_REQUEST['hdnval']);
    $optn         = glb_func_chkvl($_REQUEST['hdnoptn']);
    $chk             = glb_func_chkvl($_REQUEST['hdnchk']);
    $rows         = "";
    $sqryprod_mst = "select prodm_name
		               from prod_mst
					   where prodm_name='$name'
					   and prodm_id !=$id";

    $srsprod_mst  = mysqli_query($conn, $sqryprod_mst);
    $rows         = mysqli_num_rows($srsprod_mst);
    if ($rows > 0) {
?>
        <script>
            location.href = "product.php?sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart; ?>&val=<?php echo $val; ?>&optn=<?php echo $optn; ?>&chk=<?php echo $chk; ?>";
        </script>
        <?php
    } else {
        $uqryprod_mst = "update prod_mst set 
				               prodm_name='$name',
							   prodm_desc='$desc',  
							   prodm_prty='$prty',
							   prodm_sts='$sts',
							   prodm_mdfdon='$dt',
							   prodm_mdfdby='$cur_sesadmin'
							   where prodm_id='$id'";

        $ursprod_mst = mysqli_query($conn, $uqryprod_mst) or die(mysqli_error());
        if ($ursprod_mst == true) {

        ?>
            <script>
                location.href = "<?php echo $rd_vwpgnm; ?>?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart; ?>&val=<?php echo $val; ?>&optn=<?php echo $optn; ?>&chk=<?php echo $chk; ?>";
            </script>
        <?php
        } else {
        ?>
            <script>
                location.href = "view_product_dtl.php?sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart; ?>&val=<?php echo $val; ?>&optn=<?php echo $optn; ?>&chk=<?php echo $chk; ?>";
            </script>
<?php
        }
    }
}
?>