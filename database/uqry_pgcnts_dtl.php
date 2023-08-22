<?php
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once '../includes/inc_adm_session.php';//checking for session
	include_once '../includes/inc_usr_functions.php';//Use function for validation and more	
	include_once '../includes/inc_folder_path.php';		//Use function to set folder path	
	
	if(isset($_POST['btnedtphcntn']) && (trim($_POST['btnedtphcntn']) != "") && 	
	   isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
	   isset($_POST['lstcat1']) && (trim($_POST['lstcat1']) != "") &&
	   isset($_REQUEST['edtpgcntid']) && (trim($_REQUEST['edtpgcntid'])!= "")){
		$arycatone     = glb_func_chkvl($_POST['lstcat1']);
		$chkdept     =explode('-',$arycatone);
		$rqst_lstdept     = glb_func_chkvl($_POST['lstdept']);
		//if((($chkdept[1]=='d') && ($rqst_lstdept !='')) || ($chkdept[1]=='g') || ($chkdept[1]=='n')){
			
		$id 	  	 = glb_func_chkvl($_REQUEST['edtpgcntid']);
		$pgcnt_id  	 = glb_func_chkvl($_REQUEST['hdnpgimg_id']);
		$hdnbgimg	 = glb_func_chkvl($_POST['hdnbgimg']);	
		$name     	 = glb_func_chkvl($_POST['txtname']);
		$lnk     	 = glb_func_chkvl($_POST['txtlnk']);
		$desc     	 = addslashes(trim($_POST['txtdesc']));
		/*$pric        = glb_func_chkvl($_POST['txtprc']);
		if($pric ==''){
		$pric = 0;
		}*/
		$seotitle =  glb_func_chkvl($_POST['txtseotitle']);
		$seodesc  =  addslashes(trim($_POST['txtseodesc']));
		$seokywrd =  glb_func_chkvl($_POST['txtseokywrd']);
		$seohone  =  addslashes(trim($_POST['txtseohone']));
		$seohtwo  =  addslashes(trim($_POST['txtseohtwo']));
		$pgcntsd_typ=  glb_func_chkvl($_POST['lsttyp']);
		if(isset($_POST['lstdept']) && (trim($_POST['lstdept']) != '')){
			$deptmnt  = glb_func_chkvl($_POST['lstdept']);
		}
		else{
			$deptmnt = 'NULL';
		}		
		$catone   = $chkdept[0];
		if(isset($_POST['lstcat2']) && (trim($_POST['lstcat2']) != '')){
			$cattwo   = glb_func_chkvl($_POST['lstcat2']);
		}
		else{
			$cattwo = 'NULL';
		}	
		$cntcntrl    = glb_func_chkvl($_POST['hdntotcntrl']);
		$prior   	 = glb_func_chkvl($_POST['txtprty']);
		$sts      	 = glb_func_chkvl($_POST['lststs']);
		$curdt       = date('Y-m-d h:i:s');
		$pg          = glb_func_chkvl($_REQUEST['pg']);
		$chk         = glb_func_chkvl($_REQUEST['chkexact']);
		$optn        = glb_func_chkvl($_REQUEST['optn']);
		$val         = glb_func_chkvl($_REQUEST['txtsrchval']);
		$cntstart    = glb_func_chkvl($_REQUEST['cntstart']);
		$lstmnlnks 	 = glb_func_chkvl($_REQUEST['lstprodmcat']);//mainlinks id
		$lstctone 	 = glb_func_chkvl($_REQUEST['lstcatone']);//category id
		$lstcttwo 	 = glb_func_chkvl($_REQUEST['lstcattwo']);
		$lstdpt      = glb_func_chkvl($_REQUEST['hdnlstdept']);
		$rd_vwpgnm   = "view_pagecontain_detail.php";	
		// $rd_vwpgnm   = "view_all_pagecontain.php";	
		
	   $hdnfle_evnt = $id."-".glb_func_chkvl($_REQUEST['hdnevntnm']);
		if(isset($_REQUEST['chkexact']) && trim($_REQUEST['chkexact'])=='y'){
		  $chk="&chkexact=y";
		}
		if(($val != "") && ($optn !="")){
			 $srchval= "&optn=".$optn."&txtsrchval=".$val.$chk;
		}
		if($optn !="" && $lstctone != ""){
			$srchval = "&optn=".$optn."&lstcatone=".$lstctone;			
		}
		if($optn !="" && $lstcttwo != ""){
			$srchval = "&optn=".$optn."&lstcattwo=".$lstcttwo;			
		}
		if($optn !="" && $lstdpt != ""){
			$loc = "&optn=".$optn."&lstdept=".$lstdpt;			
		}
		
		$sqrypgcnts_dtl="select 
							 pgcntsd_name
		                 from 
							 pgcnts_dtl
					     where 
							 pgcntsd_name='$name' and
							 pgcntsd_prodcatm_id='$catone'";
		if(isset($_POST['lstcat2']) && (trim($_POST['lstcat2']) != '')){
			$sqrypgcnts_dtl .=" and pgcntsd_prodscatm_id='$cattwo' ";
		}				 
		if(isset($_POST['lstdept']) && (trim($_POST['lstdept']) != '')){
			$sqrypgcnts_dtl .=" and pgcntsd_deptm_id ='$deptmnt'";
		}
		$sqrypgcnts_dtl .=" and pgcntsd_id !='$id'";
		$srspgcnts_dtl = mysqli_query($conn,$sqrypgcnts_dtl) or die (mysqli_error($conn));
		$cnt_pgcnts   = mysqli_num_rows($srspgcnts_dtl);
		if($cnt_pgcnts > 0){
			
		?>
				<script>location.href="<?php echo $rd_vwpgnm;?>?edtpgcntid=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&cntstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
			<?php
			
		}
		elseif($_REQUEST['btnedtphcntn'] == 'Submit'){
	     $uqrypgcnts_dtl="UPDATE pgcnts_dtl set 
						 pgcntsd_name='$name',
						 pgcntsd_desc='$desc',
						 pgcntsd_lnk='$lnk',
						 pgcntsd_prodmnlnks_id='$lstmnlnks',
						 pgcntsd_prodcatm_id ='$catone',
						 pgcntsd_prodscatm_id =$cattwo,
						 pgcntsd_deptm_id = $deptmnt,
						 pgcntsd_typ = '$pgcntsd_typ',
						 pgcntsd_seotitle='$seotitle',
						 pgcntsd_seodesc='$seodesc ',
						 pgcntsd_seokywrd='$seokywrd',
						 pgcntsd_seohone='$seohone',
						 pgcntsd_seohtwo='$seohtwo',
						 pgcntsd_prty='$prior',
						 pgcntsd_sts='$sts',
						 pgcntsd_mdfdon='$curdt',
						 pgcntsd_mdfdby='$ses_admin'";
		$evntsource = "";
		$evntdest   = "";
		$fle_evnt	= 'evntfle';
	/*	if(isset($_FILES[$fle_evnt]['tmp_name']) && ($_FILES[$fle_evnt]['tmp_name']!="")){
				$dwnldfleval = funcUpldFle($fle_evnt,'');						
				if($dwnldfleval != ""){
					$dwnldfleval = explode(":",$dwnldfleval,2);
					$evntdest 		= $dwnldfleval[0];					
					$evntsource 	= $dwnldfleval[1];												
				}
		 $uqrypgcnts_dtl .= ",pgcntsd_fle='$evntdest'";
		}
				$uqrypgcnts_dtl .= " where    pgcntsd_id= '$id'";
							
		$urspgcnts_dtl = mysqli_query($conn,$uqrypgcnts_dtl) or die (mysql_error());
		if($urspgcnts_dtl==true){
			if(($evntsource!='none') && ($evntsource!='') && ($evntdest!= "")){ 
					 $evntflpath      = $gevnt_fldnm.$hdnfle_evnt;
					 if(($hdnfle_evnt != '') && file_exists($evntflpath)){							   
					 unlink($evntflpath);
					 }
					 move_uploaded_file($evntsource,$gevnt_fldnm.$id."-".$evntdest);	
				}*/
		 /*********************************Change*********************************/
		 if(isset($_FILES[$fle_evnt]['tmp_name']) && ($_FILES[$fle_evnt]['tmp_name']!="")){
				$dwnldfleval = funcUpldFle($fle_evnt,'');						
				if($dwnldfleval != ""){
					$dwnldfleval = explode(":",$dwnldfleval,2);
					$evntdest 		= $dwnldfleval[0];					
					$evntsource 	= $dwnldfleval[1];												
				}
				if(($evntsource!='none') && ($evntsource!='') && ($evntdest!= "")){ 
					 $evntflpath      = $gevnt_fldnm.$hdnfle_evnt;
					 if(($hdnfle_evnt != '') && file_exists($evntflpath)){							   
					 unlink($evntflpath);
					 }
					 move_uploaded_file($evntsource,$gevnt_fldnm.$evntdest);
					 $uqrypgcnts_dtl .= ",pgcntsd_fle='$evntdest'";	
				}
		 }		
		 else{			
			if(isset($_POST['chkbxfle']) && ($_POST['chkbxfle'] != "")){
				$delupflnm = $_POST['chkbxfle'];	
				$delupflpth = $gevnt_fldnm.$id."-".$delupflnm;								
				if(isset($delupflnm) && file_exists($delupflpth)){
					unlink($delupflpth);											
					$uqrypgcnts_dtl .= ",pgcntsd_fle=''";
				}					
			}				
		}
		if(isset($_FILES['flebnrimg']['tmp_name']) && ($_FILES['flebnrimg']['tmp_name'] != "")){							
			$bimgval = funcUpldImg('flebnrimg','bimg');
			if($bimgval != ""){
				$bimgary    = explode(":",$bimgval,2);
				$bdest 		= $bimgary[0];					
				$bsource 	= $bimgary[1];					
			}		
			if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 
					$bgimgpth      = $a_pgcnt_bnrfldnm.$hdnbgimg;
					if(($hdnbgimg != '') && file_exists($bgimgpth)){
						unlink($bgimgpth);
					}
				move_uploaded_file($bsource,$a_pgcnt_bnrfldnm.$bdest);				
				$uqrypgcnts_dtl .= ",pgcntsd_bnrimg='$bdest'";
			}
		}
		else{			
			if(isset($_POST['chkbximg']) && ($_POST['chkbximg'] != "")){
				$delimgnm   = $_POST['chkbximg'];	
				$delimgpth  = $a_pgcnt_bnrfldnm.$delimgnm;								
				if(isset($delimgnm) && file_exists($delimgpth)){
					unlink($delimgpth);											
					echo $uqrypgcnts_dtl .= ",pgcntsd_bnrimg=''";
				}					
			}				
		}
		$uqrypgcnts_dtl .= " where pgcntsd_id= '$id'";
		$urspgcnts_dtl = mysqli_query($conn,$uqrypgcnts_dtl) or die (mysqli_error($conn));
		/*********************************Change*********************************/
			$cntcntrlvdo = glb_func_chkvl($_POST['hdntotcntrlvdo']);
			if($id!="" && $cntcntrlvdo !="" ){
				for($i=1;$i<=$cntcntrlvdo;$i++){
					$cntrlid  = glb_func_chkvl("hdnpgvdoid".$i);
					$pgdtlid  = glb_func_chkvl($_POST[$cntrlid]);
					$vdoname   = glb_func_chkvl("txtvdoname1".$i);
						$validname  = glb_func_chkvl($_POST[$vdoname]);
					$vdoname    = glb_func_chkvl($_POST[$vdoname]);
					if($validname ==""){
						$vdoname    = $name;
					}
					$prty   = glb_func_chkvl("txtvdoprior".$i);
					$prty   = glb_func_chkvl($_POST[$prty]);
					$vdosts  = "lstvdosts".$i;
					$sts     = $_POST[$vdosts];		
					if($prty ==""){
						$prty 	= $id;
					}
					$vdolnk    = glb_func_chkvl("txtvdo".$i);
					//$vdoname    = glb_func_chkvl($_POST[$vdoname]);
					$vdolnknm  = glb_func_chkvl($_POST[$vdolnk]);
					if($pgdtlid != ''){						
					 /* $sqrypg_dtl = "select 
										pgvdod_vdo
									 from
										pgvdo_dtl
									 where 
										pgvdod_name ='$vdoname' and 
										pgvdod_id   ='$pgdtlid' and 
										pgvdod_pgcntsd_id ='$id'"; 
						$srpgvdod_dtl 	= mysql_query($sqrypg_dtl);		
						$cntrec_pgvdo = mysql_num_rows($srpgvdod_dtl);
						if($cntrec_pgvdo > 0){*/
							$uqrypgvdod_dtl = "UPDATE pgvdo_dtl set
												  pgvdod_name = '$vdoname', 
												  pgvdod_vdo = '$vdolnknm',
												  pgvdod_sts = '$sts',
												  pgvdod_prty = '$prty',											  	  
												  pgvdod_mdfdon= '$curdt',
												  pgvdod_mdfdby = '$ses_admin'
											  where 
												  pgvdod_pgcntsd_id = '$id' and 
												  pgvdod_id='$pgdtlid'";	 	
							$srpgvdod_dtl = mysqli_query($conn,$uqrypgvdod_dtl);							
						//}												
					}	
					else{
						 $sqrypg_dtl ="SELECT 
										 pgvdod_vdo
									  from
										 pgvdo_dtl
									  where 
										 pgvdod_name ='$vdoname' and 
										 pgvdod_pgcntsd_id ='$id'"; 
						$srpgvdod_dtl 	= mysqli_query($conn,$sqrypg_dtl);		
						$cntrec_pgvdo = mysqli_num_rows($srpgvdod_dtl);
						if($cntrec_pgvdo < 1){
							 $iqrypg_dtl ="INSERT into pgvdo_dtl(
										   pgvdod_name,pgvdod_vdo,pgvdod_sts,pgvdod_prty,
										   pgvdod_pgcntsd_id,pgvdod_typ,pgvdod_crtdon,pgvdod_crtdby)values(
										   '$vdoname','$vdolnknm','$sts','$prty',
										   '$id','1','$curdt','$ses_admin')";  
							$srpgvdod_dtl = mysqli_query($conn,$iqrypg_dtl);
						}
					}																		
				}//End of For Loop	
			 }
			
			   if($id!="" && $cntcntrl !="" ){
				for($i=1;$i<=$cntcntrl;$i++){
					$cntrlid  	 = glb_func_chkvl("hdnpgdid".$i);
					$pgdtlid  	 = glb_func_chkvl($_POST[$cntrlid]);
					$phtcntrl_nm = glb_func_chkvl("txtphtname1".$i);
					$phtval   	 = glb_func_chkvl($_POST[$phtcntrl_nm]);
					$phtcntrl_desig  = glb_func_chkvl("txtphtdesig".$i);
					$phtcntrl_desig       = glb_func_chkvl($_POST[$phtcntrl_desig]);
					
					$phtname     =  $phtval;
					if($phtval ==""){
						$phtname = $name;
					}
					$prtycntrl_nm = glb_func_chkvl("txtphtprior".$i);
					$prtyval 	  = glb_func_chkvl($_POST[$prtycntrl_nm]);
					if(($prtyval == '') || ($prtyval < 1)){
						$prtyval = $i;
					}
					$phtsts 	  = glb_func_chkvl("lstphtsts".$i);
					$sts     	  = glb_func_chkvl($_POST[$phtsts]);		
						
					//**********************IMAGE UPLOADING START*******************************//
				     $simg='flesmlimg'.$i; 
				 $fac_fle='facfle'.$i;
						 
					//*------------------------------------Update small image----------------------------*/	
					
					//if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
					    $simgval = funcUpldImg($simg,'simg'); 	
						if($simgval != ""){
							$simgary = explode(":",$simgval,2);
							$sdest 		= $simgary[0];					
							$ssource 	= $simgary[1];					
						}	
						$facltyval = funcUpldFLe($fac_fle,'fle'); 	
						if($facltyval != ""){
							$facltyary = explode(":",$facltyval,2);
							$facdest 		= $facltyary[0];					
							$facsource 	= $facltyary[1];					
						}	
					
						if($pgdtlid != ''){
						
						  $sqrypg_dtl = "SELECT 
											pgimgd_img,pgimgd_fle
										 from
											pgimg_dtl
										 where 
											pgimgd_name ='$phtname' and 
											pgimgd_id !='$pgdtlid' and 
											pgimgd_pgcntsd_id ='$id'"; 
							$srpgimgd_dtl 	= mysqli_query($conn,$sqrypg_dtl);		
							$cntrec_pgimg = mysqli_num_rows($srpgimgd_dtl);
							if($cntrec_pgimg < 1){
							//echo "text";
								$srowpgimgd_dtl  = mysqli_fetch_assoc($srpgimgd_dtl);
								$dbsmlimg 		= $srowpgimgd_dtl['pgimgd_img'];
								$dbfle 		= $srowpgimgd_dtl['pgimgd_fle'];
								$smlimgpth      = $a_phtgalspath.$dbsmlimg;
								if(($dbsmlimg != '') && file_exists($smlimgpth)){
									unlink($smlimgpth);
								}
								$facpth      = $a_phtgalbpath.$dbfle;
								if(($dbfle != '') && file_exists($facpth)){
									unlink($facpth);
								}
								$uqrypgimgd_dtl ="UPDATE pgimg_dtl set
													  pgimgd_name = '$phtname'"; 
							if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
								$uqrypgimgd_dtl .=" ,pgimgd_img = '$sdest'";
							}
							if(isset($_FILES[$fac_fle]['tmp_name']) && ($_FILES[$fac_fle]['tmp_name']!="")){
								$uqrypgimgd_dtl .=" ,pgimgd_fle='$facdest'";
							}
							$uqrypgimgd_dtl .=" ,pgimgd_sts = '$sts',
													  pgimgd_prty = '$prtyval',											  	                                                  pgimgd_desig = '$phtcntrl_desig',
													  pgimgd_mdfdon= '$curdt',
													  pgimgd_mdfdby = '$ses_admin'
												  where 
													  pgimgd_pgcntsd_id = '$id' and 
													  pgimgd_id='$pgdtlid'";	 	

								$srpgimgd_dtl = mysqli_query($conn,$uqrypgimgd_dtl) or die (mysqli_error($conn));							
							}																		
						}
						else{
							$sqrypg_dtl = "SELECT 
												pgimgd_img,pgimgd_fle
										   from
												pgimg_dtl
										   where 
											 	pgimgd_name ='$phtname' and 
												pgimgd_pgcntsd_id='$id'"; 
							$srpgimgd_dtl 	= mysqli_query($conn,$sqrypg_dtl) or die (mysqli_error($conn));		
							$cntrec_pgimg = mysqli_num_rows($srpgimgd_dtl);
							if($cntrec_pgimg < 1){
								$iqrypg_dtl ="INSERT into pgimg_dtl(
											  pgimgd_name,pgimgd_desig,pgimgd_img,pgimgd_fle,pgimgd_sts,pgimgd_prty,
											  pgimgd_pgcntsd_id,pgimgd_typ,pgimgd_crtdon,pgimgd_crtdby)values(
											  '$phtname','$phtcntrl_desig','$sdest','$facdest','$sts','$prtyval',
											  '$id','1','$curdt','$ses_admin')";  
								$srpgimgd_dtl = mysqli_query($conn,$iqrypg_dtl) or die (mysqli_error($conn));
							}
						}
						if($srpgimgd_dtl){
							if(($ssource!='none') && ($ssource!='') && ($sdest != "")){ 
								move_uploaded_file($ssource,$a_phtgalspath.$sdest);			
							}
							if(($facsource!='none') && ($facsource!='') && ($facdest != "")){ 
								move_uploaded_file($facsource,$a_phtgalbpath.$facdest);			
							}
						}							
					//}																	
				}//End of For Loop				 
		  }
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
						 
	 
				 $uqrypgvdod_dtl2 = "UPDATE  pgcntqnsm_dtl set
				 pgcntqns_name = '$qnsname', 
				 pgcntqns_vdo = '$qnsansdesc',
				 pgcntqns_sts = '$sts',
				 pgcntqns_prty = '$prty',											  	  
				 pgcntqns_mdfdon= '$curdt',
				 pgcntqns_mdfdby = '$ses_admin'
									 where 
									 pgcntqns_pgcntsd_id = '$id' and 
									 pgcntqns_id='$pgdtlid'";	
									//  echo $uqrypgvdod_dtl2;exit; 	
				 $srpgqns_dtl = mysqli_query($conn,$uqrypgvdod_dtl2);							
			 //}												
		 }	
		 else{
			 
			  $sqrypg_dtl2 ="SELECT 
			 pgcntqns_name
							 from
							 pgcntqnsm_dtl
							 where 
							 pgcntqns_name ='$qnsname' and 
							 pgcntqns_pgcntsd_id ='$id'"; 
			 $srpgvdod_dtl1 	= mysqli_query($conn,$sqrypg_dtl2);		
			 $cntrec_pgvdo1 = mysqli_num_rows($srpgvdod_dtl1);
			 if($cntrec_pgvdo1 < 1){
				 $iqrypgqns_dtl ="INSERT into pgcntqnsm_dtl(
					 pgcntqns_name,pgcntqns_vdo,pgcntqns_sts,pgcntqns_prty,
					 pgcntqns_pgcntsd_id,pgcntqns_typ,pgcntqns_crtdon,pgcntqns_crtdby)values(
								  '$qnsname','$qnsansdesc','$sts','$prty',
								  '$id','1','$curdt','$ses_admin')";  
									// echo  $iqrypgqns_dtl; 
				 $srpgvdod_dtl2 = mysqli_query($conn,$iqrypgqns_dtl);
			 }
		 }																		
	 }//End of For Loop	
  }
		  if($urspgcnts_dtl == true){
			  
		   ?>
				<script>location.href="<?php echo $rd_vwpgnm;?>?edtpgcntid=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&cntstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
			<?php
			
			}
			else{
				
			?>
				<script>location.href="<?php echo $rd_vwpgnm;?>?edtpgcntid=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&cntstart=<?php echo $cntstart;?><?php echo $srchval;?>";
				</script>				
		 <?php 
		
		   }
		//}
		//}
	 }
  //}
  }
?>