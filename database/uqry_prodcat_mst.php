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
	$hdndskimg	= glb_func_chkvl($_POST['hdndskimg']);
	$hdntabimg	= glb_func_chkvl($_POST['hdntabimg']);
	$hdnmobimg	= glb_func_chkvl($_POST['hdnmobimg']);
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
if (isset($_FILES['fledskimg']['tmp_name']) && ($_FILES['fledskimg']['tmp_name'] != "")) {
  $dskimgval = funcUpldImg('fledskimg', 'dskimg');
  if ($dskimgval != "") {
    $dskimgary = explode(":", $dskimgval, 2);
    $dskdest = $dskimgary[0];
    $dsksource = $dskimgary[1];
  }
   $uqryprodcat_mst .= ", prodcatm_dskimg = '$dskdest'";
}
if (isset($_FILES['fletabimg']['tmp_name']) && ($_FILES['fletabimg']['tmp_name'] != "")) {
	$tabimgval = funcUpldImg('fletabimg', 'tabimg');
	if ($tabimgval != "") {
		$tabimgary = explode(":", $tabimgval, 2);
		$tabdest = $tabimgary[0];
		$tabsource = $tabimgary[1];
	}
	$uqryprodcat_mst .= ", prodcatm_tabimg = '$tabdest'";
}
if (isset($_FILES['flemobimg']['tmp_name']) && ($_FILES['flemobimg']['tmp_name'] != "")) {
  $mobimgval = funcUpldImg('flemobimg', 'mobimg');
  if ($mobimgval != "") {
    $mobimgary = explode(":", $mobimgval, 2);
    $mobdest = $mobimgary[0];
    $mobsource = $mobimgary[1];
  }
  $uqryprodcat_mst .= ", prodcatm_mobimg = '$mobdest'";
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

		if (isset($_POST['chkbximg1']) && ($_POST['chkbximg1'] != "")) {
			$deldskimgnm   = glb_func_chkvl($_POST['chkbximg1']);
			$deldskimgpth  = $a_cat_bnrfldnm . $deldskimgnm;
			if (isset($deldskimgnm) && file_exists($deldskimgpth)) {
				unlink($deldskimgpth);
				$uqryprodcat_mst .= ",prodcatm_dskimg=''";
			}
		}
		if (isset($_POST['chkbximg2']) && ($_POST['chkbximg2'] != "")) {
			$deltabimgnm   = glb_func_chkvl($_POST['chkbximg2']);
			$deltabimgpth  = $a_cat_bnrfldnm . $deltabimgnm;
			if (isset($deltabimgnm) && file_exists($deltabimgpth)) {
				unlink($deltabimgpth);
				$uqryprodcat_mst .= ",prodcatm_tabimg=''";
			}
		}
		if (isset($_POST['chkbximg3']) && ($_POST['chkbximg3'] != "")) {
			$delmobimgnm   = glb_func_chkvl($_POST['chkbximg3']);
			$delmobimgpth  = $a_cat_bnrfldnm . $delmobimgnm;
			if (isset($delmobimgnm) && file_exists($delmobimgpth)) {
				unlink($delmobimgpth);
				$uqryprodcat_mst .= ",prodcatm_mobimg=''";
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
		$simg1='flesmlimg'.$i;


		 //*------------------------------------Update small image----------------------------*/


				 $simgval1 = funcUpldImg($simg1,'simg1');
			 if($simgval1 != ""){
				 $simgary1 = explode(":",$simgval1,2);
				 $sdest1 		= $simgary1[0];
				 $ssource1 	= $simgary1[1];
			 }

		if($pgdtlid != ''){
			$sqrypg_dtl = "SELECT
			catm_img
		 from
		 catimg_dtl
		 where
		 catm_name ='$qnsname' and
		 catm_id !='$pgdtlid' and
		 catm_cat_id ='$id'";
$srpgimgd_dtl 	= mysqli_query($conn,$sqrypg_dtl);
$cntrec_pgimg = mysqli_num_rows($srpgimgd_dtl);
if($cntrec_pgimg < 1){
	//echo "text";
		$srowpgimgd_dtl  = mysqli_fetch_assoc($srpgimgd_dtl);
		$dbsmlimg 		= $srowpgimgd_dtl['pgimgcatm_imgd_img'];

		$smlimgpth      = $a_cat_imgfldnm.$dbsmlimg;
		if(($dbsmlimg != '') && file_exists($smlimgpth)){
			unlink($smlimgpth);
		}

		$uqrypgimgd_dtl ="UPDATE catimg_dtl set
								catm_name = '$qnsname'";
	if(isset($_FILES[$simg1]['tmp_name']) && ($_FILES[$simg1]['tmp_name']!="")){
		$uqrypgimgd_dtl .=" ,catm_img = '$sdest1'";
	}

	$uqrypgimgd_dtl .=" ,catm_sts = '$sts',
	catm_prty = '$prty',
	catm_mdfdon= '$cur_dt',
	catm_mdfdby = '$ses_admin'
							where
							catm_cat_id = '$id' and
							catm_id='$pgdtlid'";

		$srpgimgd_dtl = mysqli_query($conn,$uqrypgimgd_dtl) or die (mysqli_error($conn));
	}

		}
		else{
			$sqrypg_dtl = "SELECT
				catm_img
		 from
		 catimg_dtl
		 where
		 catm_name ='$qnsname' and
		 catm_id !='$pgdtlid' and
		 catm_cat_id ='$id'";
$srpgimgd_dtl 	= mysqli_query($conn,$sqrypg_dtl) or die (mysqli_error($conn));
$cntrec_pgimg = mysqli_num_rows($srpgimgd_dtl);
if($cntrec_pgimg < 1){
$iqrypg_dtl ="INSERT into catimg_dtl(
	catm_name,catm_img,catm_sts,catm_prty,
	catm_cat_id,catm_typ,catm_crtdon,catm_crtdby)values(
				 '$qnsname','$sdest1','$sts','$prty',
				 '$id','1','$cur_dt','$ses_admin')";
$srpgimgd_dtl = mysqli_query($conn,$iqrypg_dtl) or die (mysqli_error($conn));
}
		}
		if($srpgimgd_dtl){
			if(($ssource1!='none') && ($ssource1!='') && ($sdest1 != "")){
				move_uploaded_file($ssource1,$a_cat_imgfldnm.$sdest1);
			}

		}
	}//End of For Loop
 }

		$ursprodmncat_mst = mysqli_query($conn, $uqryprodcat_mst);
		if ($ursprodmncat_mst == true) {
			if (($dsksource != 'none') && ($dsksource != '') && ($dskdest != "")) {
				$dskimgpth      = $a_cat_bnrfldnm . $hdndskimg;
				if (($hdndskimg != '') && file_exists($dskimgpth)) {
					unlink($dskimgpth);
				}
				move_uploaded_file($dsksource, $a_cat_bnrfldnm . $dskdest);
			}
			if (($tabsource != 'none') && ($tabsource != '') && ($tabdest != "")) {
				$tabimgpth      = $a_cat_bnrfldnm . $hdntabimg;
				if (($hdntabimg != '') && file_exists($tabimgpth)) {
					unlink($tabimgpth);
				}
				move_uploaded_file($tabsource, $a_cat_bnrfldnm . $tabdest);
			}
			if (($mobsource != 'none') && ($mobsource != '') && ($mobdest != "")) {
				$mobimgpth      = $a_cat_bnrfldnm . $hdnmobimg;
				if (($hdnmobimg != '') && file_exists($mobimgpth)) {
					unlink($mobimgpth);
				}
				move_uploaded_file($mobsource, $a_cat_bnrfldnm . $mobdest);
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