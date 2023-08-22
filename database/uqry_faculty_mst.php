<?php
// echo "<pre>";
// var_dump($_POST);
// echo "</pre>";
// exit;
error_reporting(0);
include_once '../includes/inc_config.php';       //Making paging validation	
include_once $inc_nocache;        //Clearing the cache information
include_once $adm_session;    //checking for session
include_once $inc_cnctn;     //Making database Connection
include_once $inc_usr_fnctn;  //checking for session	
include_once $inc_fldr_pth; //Floder Path	
global $a_phtgalspath1;
if (
	isset($_POST['btnedtpht']) && (trim($_POST['btnedtpht']) != "") &&

	isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "") &&
	isset($_POST['vw']) && (trim($_POST['vw']) != "")/**/
) {



	$id  	    = glb_func_chkvl($_POST['vw']);
	// echo "here".$catid  	    = glb_func_chkvl($_REQUEST[$cat_id]); 	exit;	
	$catid       = glb_func_chkvl($_POST['hdnlstphcat']);
	$prty       = glb_func_chkvl($_POST['txtprty']);
	// $name       = glb_func_chkvl($_POST['txtname']);
	// $desc       = addslashes(trim($_POST['txtdesc']));
	$rank       = glb_func_chkvl($_POST['txtprty']);
	$sts        = glb_func_chkvl($_POST['lststs1']);
	$cntcntrl   = glb_func_chkvl($_POST['hdntotcntrl']);
	$curdt      = date('Y-m-d h:i:s');
	$pg       	= glb_func_chkvl($_REQUEST['pg']);
	$cntstart   = glb_func_chkvl($_REQUEST['countstart']);
	$val      	= glb_func_chkvl($_REQUEST['txtsrchval']);
	// $sqryphtcat_mst="select
	// 					 faculty_dtl_id,phtm_name
	//               	 from 
	// 			  		 pht_mst
	// 			  	 where 
	// 			 		 	phtm_phtd_id='$id'";
	// $srsphtcat_mst = mysqli_query($conn,$sqryphtcat_mst);
	// $rows          = mysqli_num_rows($srsphtcat_mst);

	// if($rows > 0){
	// 
?>
	<!-- <script>location.href="view_detail_faculty.php?vw=<?php echo $id; ?>&sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart; ?><?php echo $srchval; ?>";</script> -->
	<?php
	// }
	// else{
	$uqryphtcat_mst = "UPDATE  faculty_mst set 			  
			 faculty_rank='$rank',
			 faculty_sts='$sts',
			 faculty_mdfdon='$curdt',
							  faculty_mdfdby='$ses_admin'";
	$uqryphtcat_mst .= "  where  faculty_id=$id";
	// echo $uqryphtcat_mst;exit;
	$ursphtcat_mst = mysqli_query($conn, $uqryphtcat_mst);
	if ($uqryphtcat_mst == true) {
		if ($id != "" && $cntcntrl != "") {
			for ($i = 1; $i <= $cntcntrl; $i++) {

				$cntrlid  = glb_func_chkvl("hdnproddid" . $i); //fac-img-id
				$pgdtlid  = glb_func_chkvl($_POST[$cntrlid]);
				$cntbgimg	= glb_func_chkvl("hdnbgimg" . $i); //fac-dtl-id
				$db_hdnimg  = glb_func_chkvl($_POST[$cntbgimg]);
				$cntfle	= glb_func_chkvl("hdnfle" . $i); //fac-dtl-id
				$db_hdnfle  = glb_func_chkvl($_POST[$cntfle]);
				$phtname   = glb_func_chkvl("txtphtname" . $i);
				$validname  = glb_func_chkvl($_POST[$phtname]);
				$fac_desg   = glb_func_chkvl("txtdesg" . $i);
				$validdesg  = glb_func_chkvl($_POST[$fac_desg]);
				$fac_desc   = glb_func_chkvl("txtdesc" . $i);
				$fac_desc1  = glb_func_chkvl($_POST[$fac_desc]);

				$prty   = glb_func_chkvl("txtphtprior" . $i);
				$prty   = glb_func_chkvl($_POST[$prty]);
				$phtsts  = "lstphtsts" . $i;
				$psts     = $_POST[$phtsts];
				if ($prty == "") {
					$prty 	= $i;
				}
				$factyp  = "factyp" . $i;
				$fac_typ = $_POST[$factyp];

				$bimg = 'flebgimg' . $i;
				if (isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name'] != "") || $db_hdnimg != '') {
					$bimgval = funcUpldImg($bimg, 'bimg' . $i);
					if ($bimgval != "") {
						$bimgary    = explode(":", $bimgval, 2);
						$bdest 		= $bimgary[0];
						$bsource 	= $bimgary[1];
					}
				}
				$fle = 'facltyfle' . $i;
				if (isset($_FILES[$fle]['tmp_name']) && ($_FILES[$fle]['tmp_name'] != "") || $db_hdnimg != '') {
					$bimgval1 = funcUpldFle($fle, 'fle' . $i);
					if ($bimgval1 != "") {
						$bimgary1   = explode(":", $bimgval1, 2);
						$bdest1 		= $bimgary1[0];
						$bsource1 	= $bimgary1[1];
					}
				}
				if ($pgdtlid != '') {
					$uqryphtimgd_dtl = "UPDATE faculty_dtl set
											  faculty_simgnm='$validname',
												faculty_desgn=' $validdesg',
												faculty_typ='$fac_typ',
												faculty_desc='$fac_desc1',
											  faculty_prty='$prty',
											  faculty_dtl_sts='$psts',	
											  faculty_mdfdon='$curdt',
											  faculty_mdfdby='$ses_admin'";
					if (($bsource != 'none') && ($bsource != '') && ($bdest != "")) {
						if (isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name'] != "")) {
							$bgimgpth      = $a_phtgalfaculty . $db_hdnimg;
							if (($db_hdnimg != '')) {
								unlink($bgimgpth);
							}
							$uqryphtimgd_dtl .= ",faculty_simg='$bdest'";
						}
						move_uploaded_file($bsource, $a_phtgalfaculty . $bdest);
					}

					if (($bsource1 != 'none') && ($bsource1 != '') && ($bdest1 != "")) {
						if (isset($_FILES[$fle]['tmp_name']) && ($_FILES[$fle]['tmp_name'] != "")) {
							$bgflepth      = $a_phtgalfaculty . $db_hdnfle;
							if (($db_hdnfle != '')) {
								unlink($bgflepth);
							}
							$uqryphtimgd_dtl .= ",faculty_file='$bdest1'";
							// echo $uqryphtimgd_dtl;exit;
						}
						move_uploaded_file($bsource1, $a_phtgalfaculty . $bdest1);
					}


					$uqryphtimgd_dtl .= " where 
												faculty_mst_id = '$id' 
												  and 
												  faculty_dtl_id='$pgdtlid'";

					//  echo $uqryphtimgd_dtl;exit; 		  


					//echo $uqryphtimgd_dtl;exit; 		


					$srphtimgd_dtl1 = mysqli_query($conn, $uqryphtimgd_dtl);
				} else {
					$iqryprod_dtl = "INSERT into faculty_dtl(
										faculty_simgnm,faculty_desgn,faculty_typ,faculty_desc,faculty_simg,faculty_file,faculty_dtl_sts,faculty_prty,
										faculty_dtl_dept_id,faculty_mst_id,faculty_crtdon,faculty_crtdby)
										values(
										'$validname','$validdesg','$fac_typ','$fac_desc1','$bdest','$bdest1','$psts','$prty',
										'$catid','$id' ,'$curdt','$ses_admin')";
					$srphtimgd_dtl = mysqli_query($conn, $iqryprod_dtl) or die(mysqli_error($conn));
					if ($srphtimgd_dtl) {
						if (($bsource != 'none') && ($bsource != '') && ($bdest != "")) {
							move_uploaded_file($bsource, $a_phtgalfaculty . $bdest);
						}
						if (($bsource1 != 'none') && ($bsource1 != '') && ($bdest1 != "")) {
							move_uploaded_file($bsource1, $a_phtgalfaculty . $bdest1);
						}
					}
				}
			}
		}
	?>
		<script>
			location.href = "view_detail_faculty.php?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart; ?><?php echo $srchval; ?>";
		</script>
	<?php
	} else {
	?>
		<script>
			location.href = "view_detail_faculty.php?vw=<?php echo $id; ?>&sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $cntstart; ?><?php echo $srchval; ?>";
		</script>
<?php
	}
}
// }
?>