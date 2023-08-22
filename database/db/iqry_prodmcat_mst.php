<?php
include_once '../includes/inc_config.php'; //Making paging validation
include_once $inc_nocache; //Clearing the cache information
include_once $adm_session; //checking for session
include_once $inc_cnctn; //Making database Connection
include_once $inc_usr_fnctn; //checking for session
include_once $inc_pgng_fnctns; //Making paging validation
include_once $inc_fldr_pth;
if(isset($_POST['btnprodmn_catsbmt']) && (trim($_POST['btnprodmn_catsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
	$name = glb_func_chkvl($_POST['txtname']);
	$desc = addslashes(trim($_POST['txtdesc']));
	$prior = glb_func_chkvl($_POST['txtprior']);
	$hmprior = glb_func_chkvl($_POST['txthmprior']);
	$title = glb_func_chkvl($_POST['txtseotitle']);
	$seodesc = glb_func_chkvl($_POST['txtseodesc']);
	$seokywrd = glb_func_chkvl($_POST['txtkywrd']);
	$seoh1_tle = glb_func_chkvl($_POST['txtseoh1tle']);
	$seoh2_tle = glb_func_chkvl($_POST['txtseoh2tle']);
	$seoh1_desc = glb_func_chkvl($_POST['txtseoh1desc']);
	$seoh2_desc = glb_func_chkvl($_POST['txtseoh2desc']);
	$mncatimg = glb_func_chkvl($_POST['flemncatimg']);
	$mncatbnrimg = glb_func_chkvl($_POST['flemncatbnrimg']);
	$sts = glb_func_chkvl($_POST['lststs']);
	$cur_dt = date('Y-m-d h:i:s');
	$sqryprodmn_cat_mst = "SELECT prodmn_catm_name from <?php	
    include_once  "../includes/inc_nocache.php"; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_usr_functions.php";//Use function for validation and more
	
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
			if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")){					
				$bimgval = funcUpldImg('flebnrimg','bimg');
				if($bimgval != ""){
					$bimgary    = explode(":",$bimgval,2);
					$bdest 		= $bimgary[0];					
					$bsource 	= $bimgary[1];					
				}						
			}	
			$iqryprodcat_mst="insert into prodmnlnks_mst(
						      prodmnlnksm_name,prodmnlnksm_desc,prodmnlnksm_bnrimg,prodmnlnksm_typ,
							  prodmnlnksm_seotitle,prodmnlnksm_dsplytyp,prodmnlnksm_seodesc,
							  prodmnlnksm_seokywrd,
							  prodmnlnksm_seohone,prodmnlnksm_seohtwo,prodmnlnksm_sts,prodmnlnksm_prty,
							  prodmnlnksm_crtdon,prodmnlnksm_crtdby)values(							  
						      '$name','$desc','$bdest','$cattyp',
							  '$seotitle','$disptyp','$seodesc','$seokywrd',
							  '$seoh1','$seoh2','$sts','$prior',
							  '$dt','$s_admin')";	
							  //echo 	$iqryprodcat_mst;exit;	
			$irsprodcat_mst= mysqli_query($conn,$iqryprodcat_mst);
			if($irsprodcat_mst==true){
				if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 
					move_uploaded_file($bsource,$a_mnlnks_bnrfldnm.$bdest);
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
?>_mst where prodmn_catm_name = '$name'";
	$srsprodmn_cat_mst = mysqli_query($conn,$sqryprodmn_cat_mst);
	$rows = mysqli_num_rows($srsprodmn_cat_mst);
	if($rows < 1)
	{
		if(isset($_FILES['flemncatimg']['tmp_name']) && ($_FILES['flemncatimg']['tmp_name']!=""))
		{
			$mncatimgval = funcUpldImg('flemncatimg','mncatimg');
			if($mncatimgval != "")
			{
				$mncatimgary = explode(":",$mncatimgval,2);
				$mncatdest = $mncatimgary[0];
				$mncatsource = $mncatimgary[1];
			}
		}
		if(isset($_FILES['flemncatbnrimg']['tmp_name']) && ($_FILES['flemncatbnrimg']['tmp_name']!=""))
		{
			$mncatbnrimgval = funcUpldImg('flemncatbnrimg','mncatbnrimg');
			if($mncatbnrimgval != "")
			{
				$mncatbnrimgary = explode(":",$mncatbnrimgval,2);
				$mncatbnrdest = $mncatbnrimgary[0];
				$mncatbnrsource = $mncatbnrimgary[1];
			}
		}
		$iqryprodmn_cat_mst = "INSERT into prodmcat_mst(prodmn_catm_name, prodmn_catm_sts, prodmn_catm_desc, prodmn_catm_seotitle, prodmn_catm_seodesc, prodmn_catm_seokywrd, prodmn_catm_seohonetitle, prodmn_catm_seohonedesc, prodmn_catm_seohtwotitle, prodmn_catm_seohtwodesc, prodmn_catm_smlimg, prodmn_catm_bnrimg, prodmn_catm_prty, prodmn_catm_crtdon, prodmn_catm_crtdby) values ('$name', '$sts', '$desc', '$title', '$seodesc', '$seokywrd', '$seoh1_tle', '$seoh1_desc', '$seoh2_tle', '$seoh2_desc', '$mncatdest', '$mncatbnrdest', '$prior', '$cur_dt', '$ses_admin')";
		$irsprodmn_cat_mst= mysqli_query($conn,$iqryprodmn_cat_mst) or die (mysqli_error());
		if($irsprodmn_cat_mst==true)
		{
			if(($mncatsource!='none') && ($mncatsource!='') && ($mncatdest != ""))
			{ 			
				move_uploaded_file($mncatsource,$gmncat_fldnm.$mncatdest);					
			}
			if(($mncatbnrsource!='none') && ($mncatbnrsource!='') && ($mncatbnrdest != ""))
			{ 			
				move_uploaded_file($mncatbnrsource,$gmncat_fldnm.$mncatbnrdest);					
			}
			$gmsg = "Record saved successfully";
		}
		else
		{
			$gmsg = "Record not saved";
		}
	}
	else
	{
		$gmsg = "Duplicate name. Record not saved";
	}
}
?>