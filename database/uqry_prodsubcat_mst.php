<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
global $ses_admin;
if(isset($_POST['btneprodscatsbmt']) && (trim($_POST['btneprodscatsbmt']) != "") && isset($_POST['lstprodcat']) && (trim($_POST['lstprodcat']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['hdnprodscatid']) && (trim($_POST['hdnprodscatid']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$id = glb_func_chkvl($_POST['hdnprodscatid']);//id
	$prodmncat = glb_func_chkvl($_POST['lstprodmcat']);//main link
	$prodcat = glb_func_chkvl($_POST['lstprodcat']);//catageroy
	$name = glb_func_chkvl($_POST['txtname']);//name
	$prior = glb_func_chkvl($_POST['txtprior']);//rank
	$prodcattyp  = glb_func_chkvl($_POST['lsttyp']);//list type
	$desc = addslashes(trim($_POST['txtdesc']));//description
	$seotitle = glb_func_chkvl($_POST['txtseotitle']);//seo title
	$seodesc = glb_func_chkvl($_POST['txtseodesc']);//seo desc
	$seokeyword = glb_func_chkvl($_POST['txtkywrd']);//seo keywords
	$seoh1 = glb_func_chkvl($_POST['txtseoh1']);//seo h1
	$seoh2= glb_func_chkvl($_POST['txtseoh2']);//seo h2
	$dtptitle = glb_func_chkvl($_POST['txtdpttitle']);//dept title
	$dtphead = glb_func_chkvl($_POST['txtdpthednm']);//dept head
	$dtpname  = glb_func_chkvl($_POST['txtdptnm']);//dept name
	$pg = glb_func_chkvl($_REQUEST['hdnpage']);
	$countstart = glb_func_chkvl($_REQUEST['hdncnt']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$hdnscatimg	= glb_func_chkvl($_REQUEST['hdnscatimg']);
	$hdndskimg	= glb_func_chkvl($_REQUEST['hdnscatdskimg']);
	$hdntabimg	= glb_func_chkvl($_REQUEST['hdnscattabimg']);
	$hdnmobimg	= glb_func_chkvl($_REQUEST['hdnscatmobimg']);
	$srchval = addslashes(trim($_POST['hdnloc']));
	$curdt = date('Y-m-d h:i:s');

	$sqryprodscat_mst = "SELECT prodscatm_name from prodscat_mst where prodscatm_name='$name' and prodscatm_prodmnlnksm_id='$prodmncat' and prodscatm_prodcatm_id='$prodcat' and prodscatm_id != $id";
	$srsprodscat_mst = mysqli_query($conn,$sqryprodscat_mst);
	$cntscatm = mysqli_num_rows($srsprodscat_mst);
	if($cntscatm < 1)
			{
				$uqryprodscat_mst ="update prodscat_mst set
				prodscatm_name='$name',
				prodscatm_desc='$desc',
				prodscatm_typ = '$prodcattyp',
				prodscatm_dpttitle ='$dtptitle',
				prodscatm_dpthead='$dtphead',
				prodscatm_dptname='$dtpname',
				prodscatm_seotitle='$seotitle',
				prodscatm_seodesc = '$seodesc',
				prodscatm_seokywrd = '$seokeyword',
				prodscatm_seohone = '$seoh1',
				prodscatm_seohtwo = '$seoh2',
				prodscatm_sts='$sts',
				prodscatm_prty ='$prior',
				prodscatm_prodcatm_id='$prodcat',
				prodscatm_prodmnlnksm_id = $prodmncat,
				prodscatm_mdfdon ='$curdt',
				prodscatm_mdfdby='$ses_admin'	";

				if(isset($_FILES['flescatdskimg']['tmp_name']) && ($_FILES['flescatdskimg']['tmp_name']!=""))
				{

					$dskimgval = funcUpldImg('flescatdskimg','dskimg');
					if($dskimgval != "")
					{

						$dskimgary = explode(":",$dskimgval,2);
						$dskdest = $dskimgary[0];
						$dsksource = $dskimgary[1];
					}
					$uqryprodscat_mst .= ", prodscatm_dskimg='$dskdest'";
				}
				if(isset($_POST['chkbximg1']) && ($_POST['chkbximg1'] != "")){
					$deldskimgnm   = glb_func_chkvl($_POST['chkbximg1']);
					$deldskimgpth  = $a_scat_bnrfldnm.$deldskimgnm;
					if(isset($deldskimgnm) && file_exists($deldskimgpth)){
						unlink($deldskimgpth);
						$uqryprodscat_mst .= ",prodscatm_dskimg=''";
					}
				}
				if(isset($_FILES['flescattabimg']['tmp_name']) && ($_FILES['flescattabimg']['tmp_name']!=""))
				{
					$tabimgval = funcUpldImg('flescattabimg','tabimg');
					if($tabimgval != "")
					{
						$tabimgary = explode(":",$tabimgval,2);
						$tabdest = $tabimgary[0];
						$tabsource = $tabimgary[1];
					}
					$uqryprodscat_mst .= ", prodscatm_tabimg='$tabdest'";
				}
				if(isset($_POST['chkbximg2']) && ($_POST['chkbximg2'] != "")){
					$deltabimgnm   = glb_func_chkvl($_POST['chkbximg2']);
					$deltabimgpth  = $a_scat_bnrfldnm.$deltabimgnm;
					if(isset($deltabimgnm) && file_exists($deltabimgpth)){
						unlink($deltabimgpth);
						$uqryprodscat_mst .= ",prodscatm_tabimg=''";
					}
				}
				if(isset($_FILES['flescatmobimg']['tmp_name']) && ($_FILES['flescatmobimg']['tmp_name']!=""))
				{
					$mobimgval = funcUpldImg('flescatmobimg','mobimg');
					if($mobimgval != "")
					{
						$mobimgary = explode(":",$mobimgval,2);
						$mobdest = $mobimgary[0];
						$mobsource = $mobimgary[1];
					}
					$uqryprodscat_mst .= ", prodscatm_mobimg='$mobdest'";
				}
				if(isset($_POST['chkbximg3']) && ($_POST['chkbximg3'] != "")){
					$delmobimgnm   = glb_func_chkvl($_POST['chkbximg3']);
					$delmobimgpth  = $a_scat_bnrfldnm.$delmobimgnm;
					if(isset($delmobimgnm) && file_exists($delmobimgpth)){
						unlink($delmobimgpth);
						$uqryprodscat_mst .= ",prodscatm_mobimg=''";
					}
				}

		$uqryprodscat_mst .= " where prodscatm_id='$id'";
		/*********************************Change*********************************/
		// questions and answers start
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
				pgqnsd_mdfdon= '$curdt',
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
								 '$id','1','$curdt','$ses_admin')";
				$srpgvdod_dtl2 = mysqli_query($conn,$iqrypg_dtl);
			}
		}
	}//End of For Loop
 }

		$ursprodscat_mst = mysqli_query($conn,$uqryprodscat_mst);
		if($ursprodscat_mst==true)
		{
			if(($dsksource!='none') && ($dsksource!='') && ($dskdest != ""))
			{
				$dskimgpth = $a_scat_bnrfldnm.$hdndskimg;
				if(($hdndskimg != '') && file_exists($dskimgpth))
				{
					unlink($dskimgpth);
				}
				move_uploaded_file($dsksource,$a_scat_bnrfldnm.$dskdest);
			}
			if(($tabsource!='none') && ($tabsource!='') && ($tabdest != ""))
			{
				$tabimgpth = $a_scat_bnrfldnm.$hdntabimg;
				if(($hdntabimg != '') && file_exists($tabimgpth))
				{
					unlink($tabimgpth);
				}
				move_uploaded_file($tabsource,$a_scat_bnrfldnm.$tabdest);
			}
			if(($mobsource!='none') && ($mobsource!='') && ($mobdest != ""))
			{
				$mobimgpth = $a_scat_bnrfldnm.$hdnmobimg;
				if(($hdnmobimg != '') && file_exists($mobimgpth))
				{
					unlink($mobimgpth);
				}
				move_uploaded_file($mobsource,$a_scat_bnrfldnm.$mobdest);
			}

			?>
			<script>location.href="view_detail_product_subcategory.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
		else
		{ ?>
			<script>location.href="view_detail_product_subcategory.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $countstart.$srchval;?>";</script>
			<?php
		}
	}
	else
	{ ?>
		<script>location.href="view_detail_product_subcategory.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $countstart;?>";</script>
		<?php
	}
}
?>