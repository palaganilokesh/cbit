<?php
include_once '../includes/inc_config.php';
include_once $inc_nocache;        //Clearing the cache information
include_once $adm_session;    //checking for session
include_once $inc_cnctn;     //Making database Connection
include_once $inc_usr_fnctn;  //checking for session 
include_once $inc_fldr_pth; //Floder Path		
if (
    isset($_POST['btnanewssbmt']) && (trim($_POST['btnanewssbmt']) != "") &&
    isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
    isset($_POST['txtlnk']) && (trim($_POST['txtlnk']) != "") &&
    isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")
) {
    $name         = glb_func_chkvl($_POST['txtname']);
    $desc         = addslashes(trim($_POST['txtdesc']));
    $bnrdesc      = addslashes(trim($_POST['txtbnrdesc']));
    $prty         = glb_func_chkvl($_POST['txtprty']);
    $sts          = glb_func_chkvl($_POST['lststs']);
    $typval        = glb_func_chkvl($_POST['lsttyp']);
    $std_testmnlDt            = glb_func_chkvl(trim($_POST['txtnwsdt']));
    $std_testmnllnk           = glb_func_chkvl(trim($_POST['txtlnk']));

    $std_testmnlDt           = date('Y-m-d', strtotime($std_testmnlDt));

    $curdt    = date('Y-m-d h:i:s');

    $sqrynews_dtl = "select 
							std_testmnlm_name
					   from 
					   		std_testmnl_mst
					   where 
					   		std_testmnlm_name='$name'";
    $srsnews_dtl = mysqli_query($conn, $sqrynews_dtl) or die(mysqli_error());
    $cnt_rec     = mysqli_num_rows($srsnews_dtl);
    if ($cnt_rec < 1) {
        $fle_dwnld     = 'fledwnld';
        if (isset($_FILES[$fle_dwnld]['tmp_name']) && ($_FILES[$fle_dwnld]['tmp_name'] != "")) {
            $upld_flenm  = '';
            $dwnldfleval = funcUpldFle($fle_dwnld, $upld_flenm);
            if ($dwnldfleval != "") {
                $dwnldfleval = explode(":", $dwnldfleval, 2);
                $fdest           = $dwnldfleval[0];
                $fsource     = $dwnldfleval[1];
            }
        }
        if (isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")) {
            $bimgval = funcUpldImg('flebnrimg', 'bimg');
            if ($bimgval != "") {
                $bimgary    = explode(":", $bimgval, 2);
                $bdest         = $bimgary[0];
                $bsource     = $bimgary[1];
            }
        }

        $iqrynews_dtl = "insert into std_testmnl_mst(
		   				   std_testmnlm_name,std_testmnlm_desc,std_testmnlm_dwnfl,std_testmnlm_img,std_testmnlm_prty,
						   std_testmnlm_typ,std_testmnlm_lnk,std_testmnlm_dt,std_testmnlm_sts,std_testmnlm_crtdon,
						   std_testmnlm_crtdby)values(						   
						   '$name','$desc','$fdest','$bdest','$prty',
						   '$typval','$std_testmnllnk','$std_testmnlDt','$sts','$curdt',
						   '$ses_admin')";

        $irsnews_dtl = mysqli_query($conn, $iqrynews_dtl) or die(mysqli_error());
        if ($irsnews_dtl == true) {
            $prodid    = mysqli_insert_id($conn);
            if (($bsource != 'none') && ($bsource != '') && ($bdest != "")) {
                move_uploaded_file($bsource, $a_cat_std_testmnlfldnm . $bdest);
            }
            if (($fsource != 'none') && ($fsource != '') && ($fdest != "")) {
                $fdest = $prodid . "-" . $fdest;
                move_uploaded_file($fsource, $dwnfl_upldpth . $fdest);
            }
            $gmsg = "Record saved successfully";
        } else {
            $gmsg = "Record not saved";
        }
    } else {
        $gmsg = "Duplicate name. Record not saved";
    }
}
