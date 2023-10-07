<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth;
global $ses_admin;
	if(isset($_POST['btneprodmnlnkssbmt']) && (trim($_POST['btneprodmnlnkssbmt']) != "") &&
	   isset($_POST['txtname'])  &&  (trim($_POST['txtname']) != "") &&
	   isset($_POST['edtpdctid']) && (trim($_POST['edtpdctid']) != "") &&
	   isset($_POST['txtprty']) && (trim($_POST['txtprty']) != ""))
	  {

		$id 	  	= glb_func_chkvl($_POST['edtpdctid']);
		$name     	= glb_func_chkvl($_POST['txtname']);
		$prior    	= glb_func_chkvl($_POST['txtprty']);
		$desc     	= addslashes(trim($_POST['txtdesc']));
		$hdndskimg	= glb_func_chkvl($_POST['hdndskimg']);
		$hdntabimg	= glb_func_chkvl($_POST['hdntabimg']);
		$hdnmobimg	= glb_func_chkvl($_POST['hdnmobimg']);
		$cattyp    	= glb_func_chkvl($_POST['lstcattyp']);
		$disptyp  	= glb_func_chkvl($_POST['lstdsplytyp']);
		$title    	= glb_func_chkvl($_POST['txtseotitle']);
		$seodesc  	= glb_func_chkvl($_POST['txtseodesc']);
		$key      	= glb_func_chkvl($_POST['txtseokywrd']);
		$seoh1 	  	= glb_func_chkvl($_POST['txtseoh1']);
		$seoh2 	  	= glb_func_chkvl($_POST['txtseoh2']);
	    $pg			= glb_func_chkvl($_REQUEST['pg']);

		$sts      	= glb_func_chkvl($_POST['lststs']);
		$optn 		= glb_func_chkvl($_REQUEST['optn']);
		$val        = glb_func_chkvl($_REQUEST['txtsrchval']);
		$vltyp 		= glb_func_chkvl($_REQUEST['lsttyp']);
		$ctdstyp	= glb_func_chkvl($_REQUEST['lstdstyp']);
		$chk 		= glb_func_chkvl($_REQUEST['chkexact']);
		$curdt      = date('Y-m-d h:i:s');
		$cntstart   = glb_func_chkvl($_POST['hdncnt']);

		$rd_vwpgnm   = "view_detail_main_category.php";

		if(isset($_REQUEST['chkexact']) && $_REQUEST['chkexact']=='y'){
		  $chk="&chkexact=y";
		}
		if($optn != "" && $val != ""){
			$srchval= "&txtsrchval=".$val.$chk;
		}
		if($optn != "" && $vltyp != ""){
			$srchval = "&optn=".$optn."&lsttyp=".$vltyp;
		}
		if($optn != "" && $ctdstyp != ""){
			$srchval = "&optn=".$optn."&lstdstyp=".$ctdstyp;
		}
		$sqryprodcat_mst="select
								prodmnlnksm_name
		                  from
						  		prodmnlnks_mst
					      where
						  		prodmnlnksm_name='$name' and
						   		prodmnlnksm_id != $id";
		$srsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
		$rows_cnt       = mysqli_num_rows($srsprodcat_mst);
		if($rows_cnt > 0){
		?>
		    <script type="text/javascript">
			location.href="<?php echo $rd_vwpgnm;?>?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
		<?php
		}
		else{
			 $uqryprodcat_mst= "update prodmnlnks_mst set
								prodmnlnksm_name='$name',
								prodmnlnksm_sts='$sts',
								prodmnlnksm_desc='$desc',
								prodmnlnksm_typ='$cattyp',
								prodmnlnksm_dsplytyp='$disptyp',
								prodmnlnksm_seotitle='$title',
								prodmnlnksm_seodesc='$seodesc',
								prodmnlnksm_seokywrd='$key',
								prodmnlnksm_seohone='$seoh1',
								prodmnlnksm_seohtwo='$seoh2',
								prodmnlnksm_prty ='$prior',
								prodmnlnksm_mdfdon ='$curdt',
								prodmnlnksm_mdfdby='$ses_admin'";
								if(isset($_FILES['fledskimg']['tmp_name']) && ($_FILES['fledskimg']['tmp_name'] != "")){
									$dskimgval = funcUpldImg('fledskimg','dskimg');
									if($dskimgval != ""){
										$dskimgary    = explode(":",$dskimgval,2);
										$dskdest 		= $dskimgary[0];
										$dsksource 	= $dskimgary[1];
									}
										$uqryprodcat_mst .= ",prodmnlnksm_dskimg='$dskdest'";
								}
								else{
									if(isset($_POST['chkbximg1']) && ($_POST['chkbximg1'] != "")){
										$deldskimgnm   = glb_func_chkvl($_POST['chkbximg1']);
										$deldskimgpth  = $a_mnlnks_bnrfldnm.$deldskimgnm;
										if(isset($deldskimgnm) && file_exists($deldskimgpth)){
											unlink($deldskimgpth);
											$uqryprodcat_mst .= ",prodmnlnksm_dskimg=''";
										}
									}
								}
								if(isset($_FILES['fletabimg']['tmp_name']) && ($_FILES['fletabimg']['tmp_name'] != "")){
									$tabimgval = funcUpldImg('fletabimg','bimg');
									if($tabimgval != ""){
										$tabimgary    = explode(":",$tabimgval,2);
										$tabdest 		= $tabimgary[0];
										$tabsource 	= $tabimgary[1];
									}
										$uqryprodcat_mst .= ",prodmnlnksm_tabimg='$tabdest'";
								}
								else{
									if(isset($_POST['chkbximg2']) && ($_POST['chkbximg2'] != "")){
										$deltabimgnm   = glb_func_chkvl($_POST['chkbximg2']);
										$deltabimgpth  = $a_mnlnks_bnrfldnm.$deltabimgnm;
										if(isset($deltabimgnm) && file_exists($deltabimgpth)){
											unlink($deltabimgpth);
											$uqryprodcat_mst .= ",prodmnlnksm_tabimg=''";
										}
									}
								}
								if(isset($_FILES['flemobimg']['tmp_name']) && ($_FILES['flemobimg']['tmp_name'] != "")){
									$mobimgval = funcUpldImg('flemobimg','bimg');
									if($mobimgval != ""){
										$mobimgary    = explode(":",$mobimgval,2);
										$mobdest 		= $mobimgary[0];
										$mobsource 	= $mobimgary[1];
									}
										$uqryprodcat_mst .= ",prodmnlnksm_mobimg='$mobdest'";
								}
								else{
									if(isset($_POST['chkbximg3']) && ($_POST['chkbximg3'] != "")){
										$delmobimgnm   = glb_func_chkvl($_POST['chkbximg3']);
										$delmobimgpth  = $a_mnlnks_bnrfldnm.$delmobimgnm;
										if(isset($delmobimgnm) && file_exists($delmobimgpth)){
											unlink($delmobimgpth);
											$uqryprodcat_mst .= ",prodmnlnksm_mobimg=''";
										}
									}
								}
			$uqryprodcat_mst .= "where prodmnlnksm_id=$id";
			$ursprodmncat_mst = mysqli_query($conn,$uqryprodcat_mst);
			if($ursprodmncat_mst==true){
				if(($dsksource!='none') && ($dsksource!='') && ($dskdest != "")){
					$dskimgpth      = $a_mnlnks_bnrfldnm.$hdndskimg;
					if(($hdndskimg != '') && file_exists($dskimgpth)){
						unlink($dskimgpth);
					}
					move_uploaded_file($dsksource,$a_mnlnks_bnrfldnm.$dskdest);
				}
				if(($tabsource!='none') && ($tabsource!='') && ($tabdest != "")){
					$tabimgpth      = $a_mnlnks_bnrfldnm.$hdntabimg;
					if(($hdntabimg != '') && file_exists($tabimgpth)){
						unlink($tabimgpth);
					}
					move_uploaded_file($tabsource,$a_mnlnks_bnrfldnm.$tabdest);
				}
				if(($mobsource!='none') && ($mobsource!='') && ($mobdest != "")){
					$mobimgpth      = $a_mnlnks_bnrfldnm.$hdnmobimg;
					if(($hdnmobimg != '') && file_exists($mobimgpth)){
						unlink($mobimgpth);
					}
					move_uploaded_file($mobsource,$a_mnlnks_bnrfldnm.$mobdest);
				}
			?>
			  <script type="text/javascript">
				location.href="<?php echo $rd_vwpgnm;?>?vw=<?php echo $id;?>&pg=<?php echo $pg;?>&sts=y&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
			<?php
			}
			else{
			?>
			  <script type="text/javascript">
			  location.href="<?php echo $rd_vwpgnm;?>?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
		<?php
			}
		}
	}
	?>