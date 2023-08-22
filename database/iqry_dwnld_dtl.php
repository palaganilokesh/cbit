<?php
//echo "hi";exit;
include_once '../includes/inc_nocache.php';      //Clearing the cache information
include_once '../includes/inc_adm_session.php';  //checking for session
include_once '../includes/inc_usr_functions.php'; //Making database Connection
include_once '../includes/inc_folder_path.php';

if (isset($_POST['btnadddwnlds']) && (trim($_POST['btnadddwnlds']) != "")) {
    //isset($_POST['txtname']) && (trim($_POST['txtname'])!= "") && 	
    //isset($_POST['lstprdctcat']) && (trim($_POST['lstprdctcat'])!= "")&& 	
    // isset($_FILES['fledwnld']) && (trim($_FILES['fledwnld'])!= ""))
    //{

    $prod_id        = glb_func_chkvl($_POST['lstprdctcat']);
    $dt                = date("Y-m-d h:i:s"); //date 
    $user             = $_SESSION['sesadmin']; //session of user			   
    $name           = glb_func_chkvl($_POST['txtname']);
    $desc           = glb_func_chkvl($_POST['txtdesc']);
    $prior          = glb_func_chkvl($_POST['txtprior']);
    $sts            = glb_func_chkvl($_POST['lststs']);
    $sqrydwnld_dtl = "select dwnld_name
			                 from   dwnld_dtl
						     where dwnld_name='$name'
						     and dwnld_prodm_id=$prod_id";
    $srsdwnld_dtl = mysqli_query($conn, $sqrydwnld_dtl);
    $cntrec        = mysqli_num_rows($srsdwnld_dtl);
    if ($cntrec < 1) {

        //**********************IMAGE UPLOADING START*******************************//
        if (isset($_FILES['fledwnld']['tmp_name']) && ($_FILES['fledwnld']['tmp_name'] != "")) {
            $dwnldfleval = funcUpldImg('fledwnld', 'fle');
            if ($dwnldfleval != "") {
                $dwnldfleval = explode(":", $dwnldfleval, 2);
                $dest          = $dwnldfleval[0];
                $source      = $dwnldfleval[1];
            }
        }
        /***************Big Image Upload End ********************/
        $iqrydwnld_dtl = "insert into dwnld_dtl(
						                  dwnld_name,dwnld_desc,dwnld_prodm_id,dwnld_flenm,
										  dwnld_sts,dwnld_prty,dwnld_crtdon,dwnld_crtdby)
										  values('$name','$desc','$prod_id','$dest', 
										  '$sts','$prior','$dt','$user')";
        $rsdwnld_dtl   = mysqli_query($conn, $iqrydwnld_dtl);


        //}//If Image Name is Set
        if ($rsdwnld_dtl == true) {
            $pgimgd_pgcntsd_id     = mysqli_insert_id();
            if (($source != 'none') && ($source != '') && ($dest != "")) {
                $dest = $pgimgd_pgcntsd_id . $dest;
                move_uploaded_file($source, $dwnlds_fldnm . $dest);
            }

            $gmsg = 'Record Saved Successfully ';
        } else {
            $gmsg = 'Record Not Saved(Try Again)';
        }
    } else {
        $gmsg = 'Duplicate Record(Record Not Saved)';
    } //Not A Duplicate Record Check


}
