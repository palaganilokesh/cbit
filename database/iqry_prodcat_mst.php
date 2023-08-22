<?php
include_once  "../includes/inc_nocache.php"; // Clearing the cache information
include_once "../includes/inc_adm_session.php"; //checking for session
include_once "../includes/inc_usr_functions.php"; //Use function for validation and more
//checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth;
global $ses_admin;
if (
	isset($_POST['btnprodcatsbmt']) && (trim($_POST['btnprodcatsbmt']) != "") &&
	isset($_POST['lstprodcat']) && (trim($_POST['lstprodcat']) != "") &&
	isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")
) {

	$prodcat      = glb_func_chkvl($_POST['lstprodcat']);
	$name     	= glb_func_chkvl($_POST['txtname']);
	$desc     	= addslashes(trim($_POST['txtdesc']));
	$prior    	= glb_func_chkvl($_POST['txtprty']);
	$cattyp    	= glb_func_chkvl($_POST['lstcattyp']);
	$admtyp    	= glb_func_chkvl($_POST['admtype']);//admissions type ug/pg
	$disptyp    = glb_func_chkvl($_POST['lstdsplytyp']);
	$seotitle   = glb_func_chkvl($_POST['txtseotitle']);
	$seodesc  	= glb_func_chkvl($_POST['txtseodesc']);
	$seokywrd   = glb_func_chkvl($_POST['txtseokywrd']);
	$seoh1 		= glb_func_chkvl($_POST['txtseoh1']);
	$seoh2 		= glb_func_chkvl($_POST['txtseoh2']);
	$sts      	= $_POST['lststs'];
	$dt       	= date('Y-m-d h:i:s');

	$sqryprodcat_mst = "SELECT 
								prodcatm_name,prodcatm_prodmnlnksm_id,prodcatm_admtyp
					      	from 
						    	prodcat_mst
					      	where 
						  		 prodcatm_name ='$name'
								 and
								  prodcatm_prodmnlnksm_id ='$prodcat' and prodcatm_admtyp='$admtyp'";
	$srsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
	$cntrec_cat     = mysqli_num_rows($srsprodcat_mst);
	if ($cntrec_cat < 1) {
		if (isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")) {
			$bimgval = funcUpldImg('flebnrimg', 'bimg');
			if ($bimgval != "") {
				$bimgary    = explode(":", $bimgval, 2);
				$bdest 		= $bimgary[0];
				$bsource 	= $bimgary[1];
			}
		}
		if (isset($_FILES['icnimg']['tmp_name']) && ($_FILES['icnimg']['tmp_name'] != "")) {
			$simgval = funcUpldImg('icnimg', 'simg');
			if ($simgval != "") {
				$simgary    = explode(":", $simgval, 2);
				$sdest 		= $simgary[0];
				$ssource 	= $simgary[1];
			}
		}
		$iqryprodcat_mst = "INSERT into prodcat_mst(
						      prodcatm_prodmnlnksm_id,prodcatm_name,prodcatm_desc,prodcatm_bnrimg,
							  prodcatm_icn,prodcatm_typ,prodcatm_admtyp,
							  prodcatm_seotitle,prodcatm_dsplytyp,prodcatm_seodesc,prodcatm_seokywrd,
							  prodcatm_seohone,prodcatm_seohtwo,prodcatm_sts,prodcatm_prty,
							  prodcatm_crtdon,prodcatm_crtdby)values(							  
						      '$prodcat','$name','$desc','$bdest','$sdest','$cattyp','$admtyp',
							  '$seotitle','$disptyp','$seodesc','$seokywrd',
							  '$seoh1','$seoh2','$sts',$prior,
							  '$dt','$ses_admin')";

		$irsprodcat_mst = mysqli_query($conn, $iqryprodcat_mst);
		if ($irsprodcat_mst == true) {
			$pgimgd_pgcntsd_id     = mysqli_insert_id($conn);
			if (($bsource != 'none') && ($bsource != '') && ($bdest != "")) {
				move_uploaded_file($bsource, $a_cat_bnrfldnm . $bdest);
			}
			if (($ssource != 'none') && ($ssource != '') && ($sdest != "")) {
				move_uploaded_file($ssource, $a_cat_icnfldnm . $sdest);
			}
			$gmsg = "Record saved successfully";
		} 
//Questtions and answers upload start
$cntcntrlqns   =  glb_func_chkvl($_POST['hdntotcntrlQns']); 
if($pgimgd_pgcntsd_id !="" && $cntcntrlqns !="")
{
	for($i=1;$i<= $cntcntrlqns;$i++){
		$prior1      = glb_func_chkvl("txtqnsprty".$i);
		$prior2      = glb_func_chkvl($_POST[$prior1]);
		$qnsname    = glb_func_chkvl("txtqnsnm".$i);
	
		$validname1  = glb_func_chkvl($_POST[$qnsname]);
		$qnsname    =  $i."-".glb_func_chkvl($_POST[$qnsname]);
		//$qnsname    =  glb_func_chkvl($_POST[$qnsname]);
		if($validname1 ==""){
			$qnsname    =  $i."-".$name;
			// $qnsname    =  $name;
		}
		$qnssts     = "lstqnssts".$i;
		$sts1   	= $_POST[$qnssts];
		if($prior2 ==""){
			$prior2 	= $pgimgd_pgcntsd_id;
		}
		
		
		$qnsans   = glb_func_chkvl("txtansdesc".$i);
		$curdt             	=  	date('Y-m-d h:i:s');
		//$vdoname    = glb_func_chkvl($_POST[$vdoname]);
		$qnsansnm  = glb_func_chkvl($_POST[$qnsans]);
		$sqrypgqns_dtl="SELECT  pgqnsd_name	from pgqns_dtl	where pgqnsd_name='$qnsname' and	pgqnsd_pgcntsd_id ='$pgimgd_pgcntsd_id'"; 
		$srspgqns_dtl = mysqli_query($conn,$sqrypgqns_dtl);
	 $cntpgqns_dtl       = mysqli_num_rows($srspgqns_dtl);
		if($cntpgqns_dtl < 1){
			if($qnsansnm !=""){
				$iqrypgqns_dtl ="INSERT into pgqns_dtl(
								 pgqnsd_name,pgqnsd_pgcntsd_id,pgqnsd_vdo,pgqnsd_typ,
								 pgqnsd_prty,pgqnsd_sts,pgqnsd_crtdon,pgqnsd_crtdby)values(
								 '$qnsname','$pgimgd_pgcntsd_id','$qnsansnm','1',
								 '$prior2','$sts1','$curdt','$ses_admin')";								     
				$rspgqns_dtl1   = mysqli_query($conn,$iqrypgqns_dtl);
				if($rspgqns_dtl1 == true){								
					$gmsg = "Record saved successfully";		
				}
			}
		}						
	}
}
//Questtions and answers upload end

		else {
			$gmsg = "Record not saved";
		}
	} else {
		$gmsg = "Duplicate name. Record not saved";
	}
}
