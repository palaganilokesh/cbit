<?php
error_reporting(0);
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth;
global $ses_admin;
if (isset($_POST['btneprodcatsbmt']) && (trim($_POST['btneprodcatsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")) {
	//echo "here";exit;


	$prodcat  	= glb_func_chkvl($_POST['lstcat']);
	$id = glb_func_chkvl($_POST['hdnprodcatid']);
	$name = glb_func_chkvl($_POST['txtname']);
	$prior = glb_func_chkvl($_POST['txtprty']);
	//$hmprior = glb_func_chkvl($_POST['txthmprior']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$admtyp    	= glb_func_chkvl($_POST['admtype']);//admissions type ug/pg
	$title = glb_func_chkvl($_POST['txtseotitle']);
	$seodesc = glb_func_chkvl($_POST['txtseodesc']);
	$kywrd = glb_func_chkvl($_POST['txtseokywrd']);
	$seoh1 = glb_func_chkvl($_POST['txtseoh1']);
	$seoh2 = glb_func_chkvl($_POST['txtseoh2']);
	//$seoh1_desc = glb_func_chkvl($_POST['txtseoh1desc']);
	//$seoh2_desc = glb_func_chkvl($_POST['txtseoh2desc']);
	$cattyp    	= glb_func_chkvl($_POST['lstcattyp']);
	$disptyp  	= glb_func_chkvl($_POST['lstdsplytyp']);
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$hdnsmlimg = glb_func_chkvl($_POST['hdnsmlimg']);
	$hdnbnrimg	= glb_func_chkvl($_POST['hdnbgimg']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$srchval = glb_func_chkvl($_REQUEST['hdnval']);
	$chk = glb_func_chkvl($_REQUEST['hdnchk']);
	$cur_dt = date('Y-m-d h:i:s');
	$loc = "&val=$srchval";
	if ($chk != '') {
		$loc .= "&chk=y";
	}
	$sqryprodcat_mst = "SELECT prodcatm_name  from prodcat_mst where prodcatm_name='$name' and prodcatm_prodmnlnksm_id = '$prodcat' and prodcatm_id='$id'";
	$srsprodcat_mst = mysqli_query($conn, $sqryprodcat_mst);
	$rows_cnt = mysqli_num_rows($srsprodcat_mst);
	if ($rows_cnt > 1) { ?>
		<script type="text/javascript">
			location.href = "view_detail_product_category.php?vw=<?php echo $id; ?>&sts=d&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
		</script>
		<?php
	} else {
		$uqryprodcat_mst = "UPDATE prodcat_mst set 
		prodcatm_name='$name', 
		prodcatm_prodmnlnksm_id ='$prodcat',
		prodcatm_sts='$sts', 
		prodcatm_desc='$desc',
		prodcatm_typ='$cattyp',
		prodcatm_admtyp='$admtyp',
		prodcatm_dsplytyp='$disptyp',
		prodcatm_seotitle='$title', 
		prodcatm_seodesc='$seodesc', 
		prodcatm_seokywrd='$kywrd', 
		prodcatm_seohone='$seoh1', 
		
		prodcatm_seohtwo='$seoh2',
		
		prodcatm_prty ='$prior', 
		prodcatm_mdfdon ='$cur_dt',
		prodcatm_mdfdby='$ses_admin'";
		if (isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")) {
			$bimgval = funcUpldImg('flebnrimg', 'bimg');
			//$bimgval = funcUpldImg('flebnrimg','catimg');
			if ($bimgval != "") {
				$bimgary = explode(":", $bimgval, 2);
				$bdest = $bimgary[0];
				$bsource = $bimgary[1];
			}
			$uqryprodcat_mst .= ", prodcatm_bnrimg = '$bdest'";
		}
		if (isset($_FILES['icnimg']['tmp_name']) && ($_FILES['icnimg']['tmp_name'] != "")) {
			$simgval = funcUpldImg('icnimg', 'simg');
			if ($simgval != "") {
				$simgary    = explode(":", $simgval, 2);
				$sdest 		= $simgary[0];
				$ssource 	= $simgary[1];
			}
			$uqryprodcat_mst .= ",prodcatm_icn='$sdest'";
		}
		if (isset($_POST['chkbximg']) && ($_POST['chkbximg'] != "")) {
			$delimgnm   = glb_func_chkvl($_POST['chkbximg']);
			$delimgpth  = $a_cat_bnrfldnm . $delimgnm;
			if (isset($delimgnm) && file_exists($delimgpth)) {
				unlink($delimgpth);
				$uqryprodcat_mst .= ",prodcatm_bnrimg=''";
			}
		}
		if (isset($_POST['chkbxicn']) && ($_POST['chkbxicn'] != "")) {
			$delimgnm   = glb_func_chkvl($_POST['chkbxicn']);
			$delimgpth  = $a_cat_icnfldnm . $delimgnm;
			if (isset($delimgnm) && file_exists($delimgpth)) {
				unlink($delimgpth);
				$uqryprodcat_mst .= ",prodcatm_icn=''";
			}
		}
		$uqryprodcat_mst .= " where prodcatm_id = $id";
/*********************************Change*********************************/
 $cntcntrlqns = glb_func_chkvl($_POST['hdntotcntrlqns']);
if($id!="" && $cntcntrlqns !="" ){
	for($i=1;$i<=$cntcntrlqns;$i++){
		$cntrlid  = glb_func_chkvl("hdnpgqnsid".$i);
		$pgdtlid  = glb_func_chkvl($_POST[$cntrlid]);
		$qnsname   = glb_func_chkvl("txtqnsnm1".$i);
		
		$validname  = glb_func_chkvl($_POST[$qnsname]);
		$qnsname    =  glb_func_chkvl($_POST[$qnsname]);
		if($validname ==""){
			$qnsname    = $qnsname;
		}
		$prty   = glb_func_chkvl("txtqnsprty".$i);
		$prty   = glb_func_chkvl($_POST[$prty]);
		$qnssts  = "lstqnssts".$i;
		$sts     = $_POST[$qnssts];		
		if($prty ==""){
			$prty 	= $id;
		}
		$ansdesc    = glb_func_chkvl("txtansdesc".$i);
		//$qnsname    = glb_func_chkvl($_POST[$qnsname]);
		$qnsansdesc  = glb_func_chkvl($_POST[$ansdesc]);
		if($pgdtlid != ''){	
						
	
				$uqrypgvdod_dtl = "UPDATE  pgqns_dtl set
				pgqnsd_name = '$qnsname', 
				pgqnsd_vdo = '$qnsansdesc',
				pgqnsd_sts = '$sts',
				pgqnsd_prty = '$prty',											  	  
				pgqnsd_mdfdon= '$cur_dt',
				pgqnsd_mdfdby = '$ses_admin'
									where 
									pgqnsd_pgcntsd_id = '$id' and 
									pgqnsd_id='$pgdtlid'";	 	
				$srpgvdod_dtl = mysqli_query($conn,$uqrypgvdod_dtl);							
			//}												
		}	
		else{
			
			 $sqrypg_dtl ="SELECT 
			pgqnsd_name
							from
							pgqns_dtl
							where 
							pgqnsd_name ='$qnsname' and 
							pgqnsd_pgcntsd_id ='$id'"; 
			$srpgvdod_dtl1 	= mysqli_query($conn,$sqrypg_dtl);		
			$cntrec_pgvdo = mysqli_num_rows($srpgvdod_dtl1);
			if($cntrec_pgvdo < 1){
				$iqrypg_dtl ="INSERT into pgqns_dtl(
					pgqnsd_name,pgqnsd_vdo,pgqnsd_sts,pgqnsd_prty,
					pgqnsd_pgcntsd_id,pgqnsd_typ,pgqnsd_crtdon,pgqnsd_crtdby)values(
								 '$qnsname','$qnsansdesc','$sts','$prty',
								 '$id','1','$cur_dt','$ses_admin')";  
				$srpgvdod_dtl2 = mysqli_query($conn,$iqrypg_dtl);
			}
		}																		
	}//End of For Loop	
 }

		$ursprodmncat_mst = mysqli_query($conn, $uqryprodcat_mst);
		if ($ursprodmncat_mst == true) {
			if (($bsource != 'none') && ($bsource != '') && ($bdest != "")) {
				$bgimgpth      = $a_cat_bnrfldnm . $hdnbgimg;
				if (($hdnbgimg != '') && file_exists($bgimgpth)) {
					unlink($bgimgpth);
				}
				move_uploaded_file($bsource, $a_cat_bnrfldnm . $bdest);
			}
			if (($ssource != 'none') && ($ssource != '') && ($sdest != "")) {
				$smlimgpth      = $a_cat_icnfldnm . $hdnsmlimg;
				if (($hdnsmlimg != '') && file_exists($smlimgpth)) {
					unlink($smlimgpth);
				}
				move_uploaded_file($ssource, $a_cat_icnfldnm . $sdest);
			}
		?>
			<script type="text/javascript">
				location.href = "view_detail_product_category.php?vw=<?php echo $id; ?>&sts=y&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
			</script>
		<?php
		}
		 else { 
			?>
			<script type="text/javascript">
				location.href = "view_detail_product_category.php?vw=<?php echo $id; ?>&sts=n&pg=<?php echo $pg; ?>&countstart=<?php echo $countstart . $loc; ?>";
			</script>
<?php
		}
	}
}
?>