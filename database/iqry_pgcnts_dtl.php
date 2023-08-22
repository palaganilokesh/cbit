<?php
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once '../includes/inc_adm_session.php';//checking for session
	include_once '../includes/inc_usr_functions.php';//Making database Connection
	include_once '../includes/inc_folder_path.php'; 
	
	if(isset($_POST['btnaddpgcnt']) && (trim($_POST['btnaddpgcnt']) != "") && 	
	   isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	   isset($_POST['lstcatone']) && (trim($_POST['lstcatone']) != "") && 
	   isset($_POST['lstcattwo']) && (trim($_POST['lstcattwo']) != "") &&
	isset($_POST['lstprodmcat']) && (trim($_POST['lstprodmcat']) != "") &&	  
	   isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")){	
	 	$arycatone     = glb_func_chkvl($_POST['lstcatone']);
		$chkdept     =explode('-',$arycatone);
		$rqst_lstdept     = glb_func_chkvl($_POST['lstdept']);
		//if((($chkdept[1]=='d') && ($rqst_lstdept !='')) || ($chkdept[1]=='g')|| ($chkdept[1]=='n')){
		
		$name     = glb_func_chkvl($_POST['txtname']);
		//$chkdept  = glb_func_chkvl($_POST['lstchkdept']);
		$lnk      = glb_func_chkvl($_POST['txtlnk']);
		$catone   = $chkdept[0];		
		$desc     = addslashes(trim($_POST['txtdesc']));
		/*$pric     = glb_func_chkvl($_POST['txtpric']);
		if($pric ==''){
		$pric = 0;
		}*/
		$mcatid =  glb_func_chkvl($_POST['lstprodmcat']);
		$scatid =  glb_func_chkvl($_POST['lstcattwo']);
		$seotitle =  glb_func_chkvl($_POST['txtseotitle']);
		$seodesc  =  glb_func_chkvl($_POST['txtseodesc']);
		$seokywrd =  glb_func_chkvl($_POST['txtseokywrd']);
		$seohone  =  glb_func_chkvl($_POST['txtseohone']);
		$seohtwo  =  glb_func_chkvl($_POST['txtseohtwo']);
		$prior    =  glb_func_chkvl($_POST['txtprty']);
		$sts      =  glb_func_chkvl($_POST['lststs']);
		$pgcntstyp   = glb_func_chkvl($_POST['lsttyp']);
		$curdt    =  date('Y-m-d h:i:s');
		$fle_evnt     = 'evntfle';
		$sqrypgcnts_dtl="SELECT 
							pgcntsd_name
					  	  from
							  pgcnts_dtl
					  	  where 
							   pgcntsd_name='$name'";
							    
		if(isset($_POST['lstcattwo']) && (trim($_POST['lstcattwo']) != '')){			
			$cattwo     = glb_func_chkvl($_POST['lstcattwo']);
			$sqrypgcnts_dtl .= " and pgcntsd_prodscatm_id ='$cattwo'";
		}
		else{
			$cattwo = 'NULL';
			$sqrypgcnts_dtl .= " and pgcntsd_prodscatm_id IS NULL";
		}
		
		if(isset($_POST['lstdept']) && (trim($_POST['lstdept']) != '')){
			$dept     		 = glb_func_chkvl($_POST['lstdept']);
			$sqrypgcnts_dtl .= " and pgcntsd_deptm_id ='$dept'";
			
		}
		else{
			$dept = 'NULL';
			$sqrypgcnts_dtl .= " and pgcntsd_deptm_id IS NULL";
		}
		$sqrypgcnts_dtl .=" and pgcntsd_prodcatm_id ='$catone'";
		$srspgcnts_dtl = mysqli_query($conn,$sqrypgcnts_dtl);
		$cntpgcnts_dtl       = mysqli_num_rows($srspgcnts_dtl);
		if($cntpgcnts_dtl < 1){
		//======================File Uploading ========================//	
			if(isset($_FILES[$fle_evnt]['tmp_name']) && ($_FILES[$fle_evnt]['tmp_name']!="")){													
					$upld_flenm  = '';	
					$dwnldfleval = funcUpldFle($fle_evnt,$upld_flenm);
					if($dwnldfleval!=""){
						$dwnldfleval = explode(":",$dwnldfleval,2);								
						$evntdest 	 = $dwnldfleval[0];					
						$evntsource  = $dwnldfleval[1];										
					}							
			  }		
		//==================================================================//	
		//======================Iamge Uploading ========================//	
		if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")){					
				$bimgval = funcUpldImg('flebnrimg','bimg');
				if($bimgval != ""){
					$bimgary    = explode(":",$bimgval,2);
					$bdest 		= $bimgary[0];					
					$bsource 	= $bimgary[1];					
				}						
			}	
		 //==================================================================//	
		 $iqrypgcnts_dtl="INSERT into pgcnts_dtl(
						  pgcntsd_name,pgcntsd_desc,pgcntsd_lnk,pgcntsd_prodcatm_id,pgcntsd_prodmnlnks_id,
						  pgcntsd_deptm_id,pgcntsd_prodscatm_id,pgcntsd_bnrimg,pgcntsd_seotitle,
						  pgcntsd_seodesc,pgcntsd_seokywrd,pgcntsd_seohone,pgcntsd_seohtwo,
						  pgcntsd_sts,pgcntsd_typ,pgcntsd_prty,pgcntsd_fle,
						  pgcntsd_crtdon,pgcntsd_crtdby)values(
						 '$name','$desc','$lnk','$catone','$mcatid',
						  $dept,$cattwo,'$bdest','$seotitle',
						 '$seodesc','$seokywrd','$seohone','$seohtwo',
						 '$sts','$pgcntstyp','$prior','$evntdest',
						 '$curdt','$ses_admin')";						 
			$rspgcnts_dtl   = mysqli_query($conn,$iqrypgcnts_dtl);
			if($rspgcnts_dtl==true){
				$pgimgd_pgcntsd_id     = mysqli_insert_id($conn);
				if(($evntsource!='none') && ($evntsource!='') && ($evntdest != "")){ 
					$evntdest = $pgimgd_pgcntsd_id.$evntdest;
					move_uploaded_file($evntsource,$gevnt_fldnm.$evntdest);
				}
				if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 
					move_uploaded_file($bsource,$a_pgcnt_bnrfldnm.$bdest);
				}	
			
			//Entire Image upload process here after
			
					$cntcntrlvdo    =  glb_func_chkvl($_POST['hdntotcntrlvdo']); 
						if($pgimgd_pgcntsd_id !="" && $cntcntrlvdo !="")
						{
							for($i=1;$i<=$cntcntrlvdo;$i++){
								$prior      = glb_func_chkvl("txtvdoprior".$i);
								$prior      = glb_func_chkvl($_POST[$prior]);
								$vdoname    = glb_func_chkvl("txtvdoname".$i);
								//$vdoname    = glb_func_chkvl($_POST[$vdoname]);
								$validname  = glb_func_chkvl($_POST[$vdoname]);
								$vdoname    = glb_func_chkvl($_POST[$vdoname]);
								if($validname ==""){
									$vdoname    = $vdoname;
								}
								$vdosts     = "lstvdosts".$i;
								$sts    	= $_POST[$vdosts];
								if($prior ==""){
									$prior 	= $pgimgd_pgcntsd_id;
								}
								
								
								$vdolnk    = glb_func_chkvl("txtvdo".$i);
								//$vdoname    = glb_func_chkvl($_POST[$vdoname]);
								$vdolnknm  = glb_func_chkvl($_POST[$vdolnk]);
								$sqrypgvdo_dtl="SELECT 
												   pgvdod_name
												from
												   pgvdo_dtl
												where 
												   pgvdod_name='$vdoname' and
												   pgvdod_pgcntsd_id ='$pgimgd_pgcntsd_id'";
								$srspgvdo_dtl = mysqli_query($conn,$sqrypgvdo_dtl);
								$cntpgvdo_dtl       = mysqli_num_rows($srspgvdo_dtl);
								if($cntpgvdo_dtl < 1){
									if($vdolnknm !=""){
										$iqrypgvdo_dtl ="INSERT into pgvdo_dtl(
														 pgvdod_name,pgvdod_pgcntsd_id,pgvdod_vdo,pgvdod_typ,
														 pgvdod_prty,pgvdod_sts,pgvdod_crtdon,pgvdod_crtdby)values(
														 '$vdoname','$pgimgd_pgcntsd_id','$vdolnknm','1',
														 '$prior','$sts','$curdt','$ses_admin')";										     
										$rspgvdo_dtl   = mysqli_query($conn,$iqrypgvdo_dtl);
										if($rspgvdo_dtl == true){								
											$gmsg = "Record saved successfully";		
										}
									}
								}						
							}
						}
					//Video upload end

	//Questtions and answers upload start
					$cntcntrlqns   =  glb_func_chkvl($_POST['hdntotcntrlQns']); 
						if($pgimgd_pgcntsd_id !="" && $cntcntrlqns !="")
						{
							for($i=1;$i<= $cntcntrlqns;$i++){
								$prior1      = glb_func_chkvl("txtqnsprty".$i);
								$prior2      = glb_func_chkvl($_POST[$prior1]);
								$qnsname    = glb_func_chkvl("txtqnsnm".$i);
							
								$validname1  = glb_func_chkvl($_POST[$qnsname]);
								$qnsname    =  glb_func_chkvl($_POST[$qnsname]);
								//$qnsname    =  glb_func_chkvl($_POST[$qnsname]);
								if($validname1 ==""){
									$qnsname    = $qnsname;
									// $qnsname    =  $name;
								}
								$qnssts     = "lstqnssts".$i;
								$sts1   	= $_POST[$qnssts];
								if($prior2 ==""){
									$prior2 	= $pgimgd_pgcntsd_id;
								}
								
								
								$qnsans   = glb_func_chkvl("txtansdesc".$i);
								//$vdoname    = glb_func_chkvl($_POST[$vdoname]);
								$qnsansnm  = glb_func_chkvl($_POST[$qnsans]);
								$sqrypgcntqnsm_dtl="SELECT 
												   pgcntqns_name
												from
												pgcntqnsm_dtl
												where 
												pgcntqns_name='$qnsname' and
												pgcntqns_pgcntsd_id ='$pgimgd_pgcntsd_id'"; 
								$srspgcntqnsm_dtl = mysqli_query($conn,$sqrypgcntqnsm_dtl);
							 $cntpgcntqnsm_dtl       = mysqli_num_rows($srspgcntqnsm_dtl);
								if($cntpgcntqnsm_dtl < 1){
									if($qnsansnm !=""){
										$iqrypgcntqnsm_dtl ="INSERT into pgcntqnsm_dtl(
														 pgcntqns_name,pgcntqns_pgcntsd_id,pgcntqns_vdo,pgcntqns_typ,
														 pgcntqns_prty,pgcntqns_sts,pgcntqns_crtdon,pgcntqns_crtdby)values(
														 '$qnsname','$pgimgd_pgcntsd_id','$qnsansnm','1',
														 '$prior2','$sts1','$curdt','$ses_admin')";								     
										$rspgcntqnsm_dtl1   = mysqli_query($conn,$iqrypgcntqnsm_dtl);
										if($rspgcntqnsm_dtl1 == true){								
											$gmsg = "Record saved successfully";		
										}
									}
								}						
							}
						}
					//Questtions and answers upload end
			
		$cntcntrl7  = 	glb_func_chkvl($_POST['hdntotcntrl']);
			$curdt   	=  	date('Y-m-d h:i:s');
		
			if($pgimgd_pgcntsd_id !="" && $cntcntrl7!=""){
			  	for($i=1;$i<=$cntcntrl7;$i++){
					
					$prtycntrl_nm = glb_func_chkvl("txtphtprior".$i);
					$prtyval      = glb_func_chkvl($_POST[$prtycntrl_nm]);
					$phtcntrl_desig  = glb_func_chkvl("txtphtdesig".$i);
					$phtcntrl_desig  = glb_func_chkvl($_POST[$phtcntrl_desig]);
					$phtcntrl_nm  = glb_func_chkvl("txtphtname".$i);
					$phtval       = glb_func_chkvl($_POST[$phtcntrl_nm]);
					$phtname      = $phtval;
					if($phtval == ""){
						$phtname    =  $phtname;
					}				
					// if(($prtyval == '') || ($prtyval < 1)){
					// 	$prtyval = $i;
					// }
					if($prtyval ==""){
						$prtyval 	= $pgimgd_pgcntsd_id;
					}
					$phtsts       = glb_func_chkvl("lstphtsts".$i);
					$sts2   	  = glb_func_chkvl($_POST[$phtsts]);
					
				
					//if($rspgcnts_dtl == true){
					
					//**********************IMAGE UPLOADING START*******************************//						
					$simg='flesimg'.$i;
					$bimg='facfle'.$i;
					/*------------------------------------Update small image----------------------------*/	
					if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
						$simgval = funcUpldImg($simg,'simg');
						if($simgval != ""){
							$simgary = explode(":",$simgval,2);
							$sdest 		= $simgary[0];
							$ssource 	= $simgary[1];
						}
					 }
					 /*------------------------------------Update file uploading----------------------------*/	
					
					if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){													
						$upld_flenm1  = '';	
						$dwnldfleval = funcUpldFle($bimg,$upld_flenm1);
						 //$prodimgd_typ='f';
						if($dwnldfleval!=""){
							$prodimgd_typ='f';
							$dwnldfleval = explode(":",$dwnldfleval,2);								
							$sdest1 	 = $dwnldfleval[0];					
							$ssource1 = $dwnldfleval[1];										
						}							
						
					 }
					/*if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){
						$bimgval = funcUpldImg($bimg,'bimg');
						if($bimgval != ""){
							$bimgary = explode(":",$bimgval,2);
							$bdest 		= $bimgary[0];
							$bsource 	= $bimgary[1];
						}		
					}*/
							
					// prodimgd_pgcntsd_id,prodimgd_img,prodimgd_typ,prodimgd_prty,prodimgd_sts
						//if($phtname !="" || $prior !=""){
							$sqrypgimg_dtl="SELECT 
												pgimgd_name
											  from
												  pgimg_dtl
											  where 
												   pgimgd_name='$phtname' and
												   pgimgd_pgcntsd_id ='$pgimgd_pgcntsd_id'";
							$srspgimg_dtl = mysqli_query($conn,$sqrypgimg_dtl);
							$cntpgimg_dtl = mysqli_num_rows($srspgimg_dtl);
							if($cntpgimg_dtl < 1){
								if($phtname !=""){
							    $iqrypgimg_dtl ="INSERT into pgimg_dtl(
												  pgimgd_name,pgimgd_desig,pgimgd_pgcntsd_id,pgimgd_img,pgimgd_fle,
												  pgimgd_typ,pgimgd_prty,pgimgd_sts,pgimgd_crtdon,
												  pgimgd_crtdby)values(
												  '$phtname','$phtcntrl_desig','$pgimgd_pgcntsd_id','$sdest','$sdest1',
												  '1','$prtyval','$sts2','$curdt',
												  '$ses_admin')";											     
								 $rspgimg_dtl  = mysqli_query($conn,$iqrypgimg_dtl) or die(mysqli_error($conn));
								if($rspgimg_dtl == true){
									if(($ssource!='none') && ($ssource!='') && ($sdest != "")){ 
										//$sdest = $id."-".$sdest;
										move_uploaded_file($ssource,$a_phtgalspath.$sdest);
									}				
									if(($ssource1!='none') && ($ssource1!='') && ($sdest1 != "")){ 
										move_uploaded_file($ssource1,$a_phtgalbpath.$sdest1);			
									}
									$gmsg = "Record saved successfully";		
								}
							}
						    }
								
							else{
								$gmsg = "Duplicate name. Record not saved";
							}
						   }
					  //}
			     }
				$gmsg = "Record saved successfully";
			}
			else{
				$gmsg = "Record Not Saved";
			}			
		}
		else{
			$gmsg = "Duplicate name. Record not saved";
		}
	 //}
	}		
	?>