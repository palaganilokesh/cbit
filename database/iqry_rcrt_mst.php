<?php

include_once "../includes/inc_adm_session.php";    //checking for session
include_once "../includes/inc_connection.php";     //Making database Connection
include_once "../includes/inc_usr_functions.php";  //checking for session
include_once '../includes/inc_folder_path.php'; //Floder Path	
if (
    isset($_POST['btnbnrsbmt']) && ($_POST['btnbnrsbmt'] != "") &&
    isset($_POST['txtname']) && ($_POST['txtname'] != "") &&
    isset($_POST['txtprior']) && ($_POST['txtprior'] != "")
) {

    $name     = glb_func_chkvl($_POST['txtname']);
    $desc     = addslashes(trim($_POST['txtdesc']));
    $prior    = glb_func_chkvl($_POST['txtprior']);
    $sts      = glb_func_chkvl($_POST['lststs']);
    $dt       = date('Y-m-d h:i:s');
    $typval      = glb_func_chkvl($_POST['lsttyp']);
    $lnkval      = glb_func_chkvl($_POST['txtlnk']);

    /*$seotitle  =  glb_func_chkvl($_POST['txtseotitle']);
		$seodesc   =  glb_func_chkvl($_POST['txtseodesc']);
		$seokywrd  =  glb_func_chkvl($_POST['txtseokywrd']);
		$seoh1ttl  =  glb_func_chkvl($_POST['txtseoh1ttl']);
		$seoh1desc =  glb_func_chkvl($_POST['txtseoh1desc']);
		$seoh2ttl  =  glb_func_chkvl($_POST['txtseoh2ttl']); 
		$seoh2desc =  glb_func_chkvl($_POST['txtseoh2desc']);*/

    $sqrybrnd_mst = "select brndm_name
					   from brnd_mst
					   where brndm_name='$name'";
    $srsbrnd_mst = mysqli_query($conn, $sqrybrnd_mst);
    $rowsbrnd_mst         = mysqli_num_rows($srsbrnd_mst);
    if ($rowsbrnd_mst > 0) {
        $gmsg = "Duplicate  name. Record not saved";
    } else {
        //**********************IMAGE UPLOADING START*******************************//

        /*------------------------------------Update Brand image----------------------------*/
        if (isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")) {
            $simgval = funcUpldImg('flebnrimg', 'brndimg');
            if ($simgval != "") {
                $simgary    = explode(":", $simgval, 2);
                $sdest         = $simgary[0];
                $ssource     = $simgary[1];
            }
        }
        /*-----------------------------------------------------------------------------------*/

        /*------------------------------------Update Zoom image------------------------------*/
        /*if(isset($_FILES['flezmimg']['tmp_name']) && ($_FILES['flezmimg']['tmp_name']!=""))
			{
				$zmimgval = funcUpldImg('flezmimg','zmimg');
				if($zmimgval != "")
				{
					$zimgary    = explode(":",$zmimgval,2);
				    $zdest 		= $zimgary[0];					
					$zsource 	= $zimgary[1];	
				}		
			}	*/
        /*-----------------------------------------------------------------------------------*/

        $iqrybrnd_mst = "insert into brnd_mst
						  (brndm_name,brndm_desc,brndm_img,brndm_sts,
						   brndm_typ,brndm_prty,brndm_lnk,brndm_crtdon,
						   brndm_crtdby)values(
						   '$name','$desc','$sdest','$sts',
						   '$typval','$prior','$lnkval','$dt',
						   '$sesadmin')";
        /*$iqrybrnd_mst="insert into brnd_mst
						  (brndm_name,brndm_desc,brndm_img,brndm_zmimg,
						   brndm_seotitle,brndm_seodesc,brndm_seokywrd,brndm_seohonetitle,
						   brndm_seohonedesc, brndm_seohtwotitle,brndm_seohtwodesc,brndm_sts,
						   brndm_prty,brndm_crtdon,brndm_crtdby)values(
						   '$name','$desc','$sdest','$zdest',
						   '$seotitle','$seodesc','$seokywrd','$seoh1ttl',
							'$seoh1desc','$seoh2ttl','$seoh2desc','$sts',
						   '$prior','$dt','$sesadmin')";*/
        $rsbrnd_mst = mysqli_query($conn, $iqrybrnd_mst);
        if ($rsbrnd_mst == true) {
            if (($ssource != 'none') && ($ssource != '') && ($sdest != "")) {
                move_uploaded_file($ssource, $gbrnd_upldpth . $sdest);
            }
            /*if(($zsource!='none') && ($zsource!='') && ($zdest != ""))
				{ 
					move_uploaded_file($zsource,$gbrnd_upldpth.$zdest);
				}		*/
            $gmsg = "Record saved successfully";
        } else {
            $gmsg = "Record not saved";
        }
    }
}
