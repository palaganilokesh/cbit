<?php

include_once '../includes/inc_config.php';
include_once $inc_nocache;        //Clearing the cache information
include_once $adm_session;    //checking for session
include_once $inc_cnctn;     //Making database Connection
include_once $inc_usr_fnctn;  //checking for session 
include_once $inc_fldr_pth; //Floder Path	
if (
    isset($_POST['btnenewssbmt']) && (trim($_POST['btnenewssbmt']) != "") &&
    isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
    isset($_POST['txtnwsdt']) && (trim($_POST['txtnwsdt']) != "") &&
    isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")
) {

    $id         = glb_func_chkvl($_POST['hdnbrndid']);
    $name      = glb_func_chkvl($_POST['txtname']);
    $desc        = addslashes(trim($_POST['txtdesc']));
    $prty         = glb_func_chkvl($_POST['txtprior']);
    $sts          = glb_func_chkvl($_POST['lststs']);
    $typval    = glb_func_chkvl($_POST['lsttyp']);
    $dept_id    = glb_func_chkvl($_POST['lstprodcat']);
    
    $nwslnk           = glb_func_chkvl(trim($_POST['txtlnk']));
    $hdndwnfle = glb_func_chkvl($_POST['hdndwnfle']);//file
    $curdt     = date('Y-m-d h:i:s');
    $pg           = glb_func_chkvl($_REQUEST['pg']);
    $cntstart  = glb_func_chkvl($_REQUEST['countstart']);
    $val          = glb_func_chkvl($_REQUEST['txtsrchval']);
    $nwsDt     = glb_func_chkvl(trim($_POST['txtnwsdt']));
    $hdnbgimg    = glb_func_chkvl($_POST['hdnbgimg']);//image
    $nwsDt           = date('Y-m-d', strtotime($nwsDt));

    if (isset($_REQUEST['chkexact']) && $_REQUEST['chkexact'] == 'y') {
        $chk = "&chkexact=y";
    }
    if ($val != '') {
        $srchval .= "&txtsrchval=" . $val . $chk;
    }
    $sqrynws_dtl = "select 
							nwsm_name
					   	from 
					   		nws_mst
					   	where 
					   		nwsm_name='$name' and
							nwsm_id!='$id'";
    $srsnws_dtl = mysqli_query($conn, $sqrynws_dtl);
    $cnt_rows   = mysqli_num_rows($srsnws_dtl);
    if ($cnt_rows > 0) {
?>
        <script>
            location.href = "<?php echo $rd_vwpgnm; ?>?vw=<?php echo $id; ?>&sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $srchval; ?>";
        </script>
        <?php
    } else {
        $uqrynws_mst = "update nws_mst set 
							nwsm_name='$name',								   
						    nwsm_desc='$desc',							
						    nwsm_sts='$sts',
							nwsm_typ='$typval',
                            nwsm_dept='$dept_id',
							nwsm_dt='$nwsDt',
							nwsm_lnk='$nwslnk',
						    nwsm_prty='$prty',
						    nwsm_mdfdon='$curdt',
						    nwsm_mdfdby='$ses_admin'";
        $fsource = "";
        $fdest   = "";
        $fle_down = 'fledwnld';

        			if(isset($_FILES[$fle_down]['tmp_name']) && ($_FILES[$fle_down]['tmp_name']!="")){
				$dwnldfleval = funcUpldFle($fle_down,'fle');						
				if($dwnldfleval != ""){
					$dwnldfleval = explode(":",$dwnldfleval,2);
					$fdest 		= $dwnldfleval[0];					
					$fsource 	= $dwnldfleval[1];							
				}
				$uqrynws_mst .= ",nwsm_dwnfl='$fdest'";
			}	
        if (isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")) {
            $bimgval = funcUpldImg('flebnrimg', 'news');
            if ($bimgval != "") {
                $bimgary    = explode(":", $bimgval, 2);
                $bdest         = $bimgary[0];
                $bsource     = $bimgary[1];
            }
            $uqrynws_mst .= ",nwsm_img='$bdest'";
        }
        $uqrynws_mst .= " where nwsm_id ='$id'";
        // echo $uqrynws_mst;
        // exit;
        $ursnws_mst = mysqli_query($conn, $uqrynws_mst);
        if ($ursnws_mst == true) {

            if (($bsource != 'none') && ($bsource != '') && ($bdest != "")) {
                $bgimgpth      = $a_cat_nwsfldnm . $hdnbgimg;
                if (($hdnbgimg != '') && file_exists($bgimgpth)) {
                    unlink($bgimgpth);
                }
                move_uploaded_file($bsource, $a_cat_nwsfldnm . $bdest);
            }
            if(($fsource!='none') && ($fsource!='') && ($fdest!= "")){ 
					$flepth      = $a_dwnfl_upldpth.$hdndwnfle;	
					if(($hdndwnfle != '') && file_exists($flepth)){							   
					unlink($flepth);
					}
				   move_uploaded_file($fsource,$a_dwnfl_upldpth.$fdest);
				}

        ?>

            <script type="text/javascript">
                location.href = "<?php echo $rd_vwpgnm; ?>?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart; ?>";
            </script>

        <?php
        } else {
        ?>
            <script>
                location.href = "<?php echo $rd_vwpgnm; ?>?edit=<?php echo $id; ?>&sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $srchval; ?>";
            </script>
<?php
        }
    }
}
?>