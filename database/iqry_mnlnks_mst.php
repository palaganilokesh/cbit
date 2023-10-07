<?php
    include_once  "../includes/inc_nocache.php"; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_usr_functions.php";//Use function for validation and more
	global $ses_admin;
	if(isset($_POST['btnprodmnlnkssbmt']) && (trim($_POST['btnprodmnlnkssbmt']) != "") &&
	   isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	   isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")){

		$name     	= glb_func_chkvl($_POST['txtname']);
		$desc     	= addslashes(trim($_POST['txtdesc']));
		$prior    	= glb_func_chkvl($_POST['txtprty']);
		$cattyp    	= glb_func_chkvl($_POST['lstcattyp']);
		$disptyp    = glb_func_chkvl($_POST['lstdsplytyp']);
		$seotitle   = glb_func_chkvl($_POST['txtseotitle']);
		$seodesc  	= glb_func_chkvl($_POST['txtseodesc']);
		$seokywrd   = glb_func_chkvl($_POST['txtseokywrd']);
		$seoh1 		= glb_func_chkvl($_POST['txtseoh1']);
		$seoh2 		= glb_func_chkvl($_POST['txtseoh2']);
		$sts      	= $_POST['lststs'];
		$dt       	= date('Y-m-d h:i:s');

		$sqryprodcat_mst = "select
								prodmnlnksm_name
					      	from
						    	prodmnlnks_mst
					      	where
						  		 prodmnlnksm_name ='$name'";
		$srsprodcat_mst = mysqli_query($conn,$sqryprodcat_mst);
		$cntrec_cat     = mysqli_num_rows($srsprodcat_mst);
		if($cntrec_cat < 1){
			if(isset($_FILES['fledskimg']['tmp_name']) && ($_FILES['fledskimg']['tmp_name'] != "")){
				$dskimgval = funcUpldImg('fledskimg','bimg');
				if($dskimgval != ""){
					$dskimgary    = explode(":",$dskimgval,2);
					$dskdest 		= $dskimgary[0];
					$dsksource 	= $dskimgary[1];
				}
			}
			if(isset($_FILES['fletabimg']['tmp_name']) && ($_FILES['fletabimg']['tmp_name'] != "")){
				$tabimgval = funcUpldImg('fletabimg','bimg');
				if($tabimgval != ""){
					$tabimgary    = explode(":",$tabimgval,2);
					$tabdest 		= $tabimgary[0];
					$tabsource 	= $tabimgary[1];
				}
			}
			if(isset($_FILES['flemobimg']['tmp_name']) && ($_FILES['flemobimg']['tmp_name'] != "")){
				$mobimgval = funcUpldImg('flemobimg','bimg');
				if($mobimgval != ""){
					$mobimgary    = explode(":",$mobimgval,2);
					$mobdest 		= $mobimgary[0];
					$mobsource 	= $mobimgary[1];
				}
			}
			$iqryprodcat_mst="insert into prodmnlnks_mst(
						      prodmnlnksm_name,prodmnlnksm_desc,prodmnlnksm_dskimg,prodmnlnksm_tabimg,prodmnlnksm_mobimg,prodmnlnksm_typ,
							  prodmnlnksm_seotitle,prodmnlnksm_dsplytyp,prodmnlnksm_seodesc,
							  prodmnlnksm_seokywrd,
							  prodmnlnksm_seohone,prodmnlnksm_seohtwo,prodmnlnksm_sts,prodmnlnksm_prty,
							  prodmnlnksm_crtdon,prodmnlnksm_crtdby)values(
						      '$name','$desc','$dskdest','$tabdest','$mobdest','$cattyp',
							  '$seotitle','$disptyp','$seodesc','$seokywrd',
							  '$seoh1','$seoh2','$sts','$prior',
							  '$dt','$ses_admin')";
							  // echo 	$iqryprodcat_mst;exit;
			$irsprodcat_mst= mysqli_query($conn,$iqryprodcat_mst);
			if($irsprodcat_mst==true){
				if(($dsksource!='none') && ($dsksource!='') && ($dskdest != "")){
					echo move_uploaded_file($dsksource,$a_mnlnks_bnrfldnm.$dskdest);
				}
				if(($tabsource!='none') && ($tabsource!='') && ($tabdest != "")){
					echo move_uploaded_file($tabsource,$a_mnlnks_bnrfldnm.$tabdest);
				}
				if(($mobsource!='none') && ($mobsource!='') && ($mobdest != "")){
					echo move_uploaded_file($mobsource,$a_mnlnks_bnrfldnm.$mobdest);
				}
				$gmsg = "Record saved successfully";
			}
			else{
				$gmsg = "Record not saved";
			}
		}
		else{
			$gmsg = "Duplicate name. Record not saved";
		}
	}
?>