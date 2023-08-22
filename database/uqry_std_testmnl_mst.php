<?php
include_once '../includes/inc_config.php';
include_once $inc_nocache;        //Clearing the cache information
include_once $adm_session;    //checking for session
include_once $inc_cnctn;     //Making database Connection
include_once $inc_usr_fnctn;  //checking for session 
include_once $inc_fldr_pth; //Floder Path		
if (
    isset($_POST['btnestdtestmnlsbmt']) && (trim($_POST['btnestdtestmnlsbmt']) != "") &&
    isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
    isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "") &&
    isset($_POST['edtnw']) && (trim($_POST['edtnw']) != "")
) {
    $id         = glb_func_chkvl($_POST['edtnw']);
    $name      = glb_func_chkvl($_POST['txtname']);
    $desc        = addslashes(trim($_POST['txtdesc']));
    $prty         = glb_func_chkvl($_POST['txtprior']);
    $sts          = glb_func_chkvl($_POST['lststs']);
    $typval    = glb_func_chkvl($_POST['lsttyp']);
    $std_testmnllnk           = glb_func_chkvl(trim($_POST['txtlnk']));
    $hdndwnfle = $id . "-" . glb_func_chkvl($_POST['hdndwnfle']);
    $curdt     = date('Y-m-d h:i:s');
    $pg           = glb_func_chkvl($_REQUEST['pg']);
    $cntstart  = glb_func_chkvl($_REQUEST['countstart']);
    $val          = glb_func_chkvl($_REQUEST['txtsrchval']);
    $std_testmnlDt     = glb_func_chkvl(trim($_POST['txtstd_testmnldt']));
    $hdnbgimg    = glb_func_chkvl($_POST['hdnbgimg']);
    $std_testmnlDt           = date('Y-m-d', strtotime($std_testmnlDt));

    if (isset($_REQUEST['chkexact']) && $_REQUEST['chkexact'] == 'y') {
        $chk = "&chkexact=y";
    }
    if ($val != '') {
        $srchval .= "&txtsrchval=" . $val . $chk;
    }
    $sqrystd_testmnl_dtl = "select 
							std_testmnlm_name
					   	from 
					   		std_testmnl_mst
					   	where 
					   		std_testmnlm_name='$name' and
							std_testmnlm_id!='$id'";
    $srsstd_testmnl_dtl = mysqli_query($conn, $sqrystd_testmnl_dtl);
    $cnt_rows   = mysqli_num_rows($srsstd_testmnl_dtl);
    if ($cnt_rows > 0) {
?>
        <script>
            location.href = "<?php echo $rd_vwpgnm; ?>?edtnw=<?php echo $id; ?>&sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $srchval; ?>";
        </script>
        <?php
    } else {
        $uqrystd_testmnl_mst = "update std_testmnl_mst set 
							std_testmnlm_name='$name',								   
						    std_testmnlm_desc='$desc',							
						    std_testmnlm_sts='$sts',
							std_testmnlm_typ='$typval',
							std_testmnlm_dt='$std_testmnlDt',
							std_testmnlm_lnk='$std_testmnllnk',
						    std_testmnlm_prty='$prty',
						    std_testmnlm_mdfdon='$curdt',
						    std_testmnlm_mdfdby='$ses_admin'";
        $fsource = "";
        $fdest   = "";
        $fle_down = 'fledwnld';
        /*			if(isset($_FILES[$fle_down]['tmp_name']) && ($_FILES[$fle_down]['tmp_name']!="")){
				$dwnldfleval = funcUpldFle($fle_down,'fle');						
				if($dwnldfleval != ""){
					$dwnldfleval = explode(":",$dwnldfleval,2);
					$fdest 		= $dwnldfleval[0];					
					$fsource 	= $dwnldfleval[1];							
				}
				$uqrystd_testmnl_mst .= ",std_testmnlm_dwnfl='$fdest'";
			}	*/
        if (isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")) {
            $bimgval = funcUpldImg('flebnrimg', 'news');
            if ($bimgval != "") {
                $bimgary    = explode(":", $bimgval, 2);
                $bdest         = $bimgary[0];
                $bsource     = $bimgary[1];
            }
            $uqrystd_testmnl_mst .= ",std_testmnlm_img='$bdest'";
        }
        $uqrystd_testmnl_mst .= " where std_testmnlm_id ='$id'";
        //echo $uqrystd_testmnl_mst;exit;
        $ursstd_testmnl_mst = mysqli_query($conn, $uqrystd_testmnl_mst);
        if ($ursstd_testmnl_mst == true) {
            if (($bsource != 'none') && ($bsource != '') && ($bdest != "")) {
                $bgimgpth      = $a_cat_std_testmnlfldnm . $hdnbgimg;
                if (($hdnbgimg != '') && file_exists($bgimgpth)) {
                    unlink($bgimgpth);
                }
                move_uploaded_file($bsource, $a_cat_std_testmnlfldnm . $bdest);
            }
            /*if(($fsource!='none') && ($fsource!='') && ($fdest!= "")){ 
					$flepth      = $dwnfl_upldpth.$hdndwnfle;	
					if(($hdndwnfle != '') && file_exists($flepth)){							   
					unlink($flepth);
					}
				   move_uploaded_file($fsource,$dwnfl_upldpth.$id."-".$fdest);
				}*/
        ?>
            <script>
                location.href = "<?php echo $rd_vwpgnm; ?>?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $srchval; ?>";
            </script>
        <?php
        } else {
        ?>
            <script>
                location.href = "<?php echo $rd_vwpgnm; ?>?edtnw=<?php echo $id; ?>&sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart . $srchval; ?>";
            </script>
<?php
        }
    }
}
?>