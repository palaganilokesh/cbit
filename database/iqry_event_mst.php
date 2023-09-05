<?php	
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once '../includes/inc_usr_functions.php';//Use function for validation and more	
	include_once "../includes/inc_folder_path.php";
	//include_once "../includes/inc_fnct_fleupld.php";//files upload
	
	
	if(isset($_POST['btnaddevnt']) && ($_POST['btnaddevnt'] != "") && 	
	   isset($_POST['txtname']) && ($_POST['txtname'] != "") && 
      
	   isset($_POST['addtype']) && ($_POST['addtype'] != "") && 
	   isset($_POST['txtstdate']) && ($_POST['txtstdate'] != "") && 
	   isset($_POST['txtprior']) && ($_POST['txtprior'] != "")){
	   
		/* Required Database Entry fields ends */
		$name     = glb_func_chkvl(trim($_POST['txtname']));
		$add_type     = glb_func_chkvl(trim($_POST['addtype']));
		$lnkval   = glb_func_chkvl(trim($_POST['txtlnk']));
		$desc     = addslashes(trim($_POST['txtdesc']));
		$city	  =	glb_func_chkvl(trim($_POST['txtcity']));
		$venue	  =	glb_func_chkvl(trim($_POST['txtvenue']));
		$dept	  =	glb_func_chkvl(trim($_POST['lstprodcat']));
		
		$dstrct   = 0;
		// if(isset($_POST['lstdstrct']) && $_POST['lstdstrct'] != ""){
		// $dstrct   =	glb_func_chkvl(trim($_POST['lstdstrct']));
		// }
		 $stdt 	  =	glb_func_chkvl(trim($_POST['txtstdate']));
		$sttm	  = trim($_POST['lststhr']);
					if($_POST['lststmin']!=""){
						$sttm.= ":".trim($_POST['lststmin']);
					}
					if($_POST['lstst'] !=""){
						$sttm.=" ".trim($_POST['lstst']);
					}
		//$eddt 	  =	'0';
		//if(isset($_POST['txteddt']) && $_POST['txteddt'] != ""){			
		$eddt 	  =	glb_func_chkvl(trim($_POST['txteddt']));
		//}
		$edtm	  = trim($_POST['lstethr']);
					if($_POST['lstetmin']!=""){
						$edtm.=":".trim($_POST['lstetmin']);
					}
					if($_POST['lstet']!=""){
						$edtm.=" ".trim($_POST['lstet']);
					}
		$nvets	  = glb_func_chkvl(trim($_POST['txtnvets']));
		$prior    = glb_func_chkvl(trim($_POST['txtprior']));
		$sts      = $_POST['lststs'];
		
		/* Required Database Entry fields ends */
		$curdt        = date('Y-m-d h:i:s');
		$fle_evnt     = 'evntfle';
		//$fle_evnt    		= 	glb_func_chkvl($_POST['evntfle']);
		
		$sqryevnt_mst="SELECT evntm_name
					  from evnt_mst
					  where evntm_name='$name' and
					  		evntm_strtdt = '$stdt'";
		
		$srsevnt_mst = mysqli_query($conn,$sqryevnt_mst);
		$cnt_evntm       = mysqli_num_rows($srsevnt_mst);
		if($cnt_evntm < 1){
		//======================Image Uploading ========================//	
		if(isset($_FILES['fleimg']['tmp_name']) && ($_FILES['fleimg']['tmp_name']!="")){			  
			$imgval = funcUpldImg('fleimg','img');
			if($imgval != ""){
				$imgary    = explode(":",$imgval,2);
				$imgdest   = $imgary[0];					
				$imgsource = $imgary[1];	
			}
	}			
		//==================================================================//	
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
		  $iqryevnt_mst="INSERT into evnt_mst(
						   evntm_name,evntm_desc,evntm_city,evntm_venue,
						   evntm_dstrctm_id,evntm_strtdt,evtnm_strttm,evntm_enddt,
						   evntm_endtm,evntm_btch,evntm_fle,evntm_lnk,evntm_dept,
						   evntm_prty,evntm_sts,evntm_typ,evntm_crtdon,evntm_crtdby)values(
						   '$name','$desc','$city','$venue',
						   '$dstrct','$stdt','$sttm','$eddt',
						   '$edtm','$nvets','$evntdest','$lnkval','$dept',
						   '$prior','$sts','$add_type','$curdt','$ses_admin')";
					
			$irsevnt_mst = mysqli_query($conn,$iqryevnt_mst) or die (mysqli_error($conn));
			if($irsevnt_mst==true){
				$id = mysqli_insert_id($conn);
				if(($evntsource!='none') && ($evntsource!='') && ($evntdest != "")){ 
				
					
							$evntdest = $id."-".$evntdest;
							move_uploaded_file($evntsource,$gevnt_fldnm.$evntdest);
					
					
					
					
				}
				/*if(($imgsource!='none') && ($imgsource!='') && ($imgdest != "")){ 
					move_uploaded_file($imgsource,$imgevnt_fldnm.$imgdest);					
				}*/					
				$gmsg = "Record saved successfully";
				
				/*-------- Image Upload Starts Hear-----*/
			$cntcntrl    		= 	glb_func_chkvl($_POST['hdntotcntrl']);
			$curdt             	=  	date('Y-m-d h:i:s');
		
			if($id !="" && $cntcntrl!=""){
			  	for($i=1;$i<=$cntcntrl;$i++){
					
					$prtycntrl_nm = glb_func_chkvl("txtphtprior".$i);
					$prtyval      = glb_func_chkvl($_POST[$prtycntrl_nm]);
					$phtcntrl_nm  = glb_func_chkvl("txtphtname".$i);
					$phtval       = glb_func_chkvl($_POST[$phtcntrl_nm]);
					$phtname      = $i ."-".$phtval;
					if($phtval == ""){
						$phtname    =  $i."-".$name;
					}				
					if(($prtyval == '') || ($prtyval < 1)){
						$prtyval = $i;
					}
					$phtsts       = glb_func_chkvl("lstphtsts".$i);
					$sts    	  = glb_func_chkvl($_POST[$phtsts]);
					
					//if($rspgcnts_dtl == true){
					
					//**********************IMAGE UPLOADING START*******************************//						
					$simg='flesimg'.$i;
					//$bimg='flebimg'.$i;
					/*------------------------------------Update small image----------------------------*/	
					if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
						$simgval = funcUpldImg($simg,'simg');
						if($simgval != ""){
							$simgary = explode(":",$simgval,2);
							$sdest 		= $simgary[0];
							$ssource 	= $simgary[1];
						}
					 }
						$sqryevntimg_dtl="select 
												evntimgd_name
											  from
												  evntimg_dtl
											  where 
												   evntimgd_name='$phtname' and
												   evntimgd_evntm_id ='$id'";
							$srsevntimg_dtl = mysqli_query($conn,$sqryevntimg_dtl);
							$cntevntimg_dtl = mysqli_num_rows($srsevntimg_dtl);
							if($cntevntimg_dtl < 1){
							   $iqryevntimg_dtl ="INSERT into evntimg_dtl(
												   evntimgd_name,evntimgd_evntm_id,evntimgd_img,evntimgd_typ,
												   evntimgd_prty,evntimgd_sts,evntimgd_crtdon,evntimgd_crtdby)values(
												   '$phtname','$id','$sdest','1',
												   '$prtyval','$sts','$curdt','$ses_admin')";												     
								 $rsevntimg_dtl  = mysqli_query($conn,$iqryevntimg_dtl) or die(mysqli_error($conn));
								if($rsevntimg_dtl == true){
									if(($ssource!='none') && ($ssource!='') && ($sdest != "")){ 
										//$sdest = $id."-".$sdest;
										move_uploaded_file($ssource,$imgevnt_fldnm.$sdest);
									}				
									$gmsg = "Record saved successfully";		
								}
						    }
							else{
								$gmsg = "Duplicate name. Record not saved";
							}
						   }
			     }
				/*----------Image Upload End--*/
				
				
			}
			else{
				$gmsg = "Record not saved";
			}
		}
		else{
			$gmsg = "Duplicate Event name. Record not saved";
		}
	}
?>