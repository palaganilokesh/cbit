<?php

include_once  "../includes/inc_nocache.php"; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_usr_functions.php";
if (
    isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
    isset($_POST['txtprior']) && (trim($_POST['txtprior']) != "")
) {
    $name     = glb_func_chkvl($_POST['txtname']);
    $desc      = addslashes($_POST['txtdesc']);
    //$url	  =	glb_func_chkvl($_POST['lsturl']);
    //$img	  =	glb_func_chkvl($_FILES['fleimg']);
    $sts      = glb_func_chkvl($_POST['lststs']);
    $prty     = glb_func_chkvl($_POST['txtprior']);
    $dt       = date('Y-m-d h:i:s');
    $rows      = "";
    $sqryprod_mst = "select prodm_name
					   from prod_mst
					   where prodm_name ='$name'";
    $srsprod_mst = mysqli_query($conn, $sqryprod_mst);
    $rows        = mysqli_num_rows($srsprod_mst);
    if ($rows == 0) {
        $iqryprod_mst = "insert into prod_mst(
			 					 prodm_name,prodm_desc,
								 prodm_sts,prodm_prty,prodm_crtdon,prodm_crtdby) values(
								 '$name','$desc','$sts','$prty','$dt','$cur_sesadmin')";
        $irprod_mst = mysqli_query($conn, $iqryprod_mst) or die(mysqli_error());

        if ($irprod_mst == true) {
            $gmsg = "Record saved successfully";
        } else {
            $gmsg = "Record not saved";
        }
    } else {
        $gmsg = "Duplicate Product name. Record not saved";
    }
}
