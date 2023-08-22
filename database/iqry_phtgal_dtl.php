<?php	

	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_connection.php";//Making database Connection
	include_once "../includes/inc_folder_path.php";
	global $a_phtgalspath1;
	if(isset($_POST['btnadprodsbmt']) && (trim($_POST['btnadprodsbmt']) != "") &&
	   isset($_POST['txtname1']) && (trim($_POST['txtname1'])!='') &&
	   isset($_POST['txtprty1']) && ($_POST['txtprty1'])!=''){
		 $phtcatnm      = glb_func_chkvl($_POST['lstphcat']);
		 $name       	= glb_func_chkvl($_POST['txtname1']);	 
		 $desc          = glb_func_chkvl($_POST['txtdesc1']);
		 $prty          = glb_func_chkvl($_POST['txtprty1']);
		 $nmsts          = glb_func_chkvl($_POST['lststs1']);
  		 //$sts         	= glb_func_chkvl($_POST['lstphtsts1']);phtd_phtcatd_id
		 $dt          	= date('Y-m-d h:i:s');
		 $cntcntrl    	= glb_func_chkvl($_POST['hdntotcntrl']);
			
	     $iqryphtimg_dtl =	"INSERT into pht_dtl(
					         phtd_phtcatm_id,phtd_name,
						     phtd_desc,phtd_rank,phtd_sts, 
						     phtd_crtdon, phtd_crtdby)values(
							'$phtcatnm', '$name','$desc','$prty','$nmsts',
						    '$dt','$ses_admin')";
							
	     $rspht_dtl   = mysqli_query($conn,$iqryphtimg_dtl);
		 if($rspht_dtl==true){
		$phtdtl=mysqli_insert_id($conn);
		if($phtdtl !="" && $cntcntrl!=""){	 
				for($i=1;$i <= $cntcntrl;$i++){
					 $prior      = glb_func_chkvl("txtphtprior".$i);
				    	$prior      = glb_func_chkvl($_POST[$prior]);
					    $phtname  = glb_func_chkvl("txtphtname".$i);
						$phtname  = glb_func_chkvl($_POST[$phtname]);
						if($phtname == ''){
							$phtname = $i."-".$name; 	
						}
						if($prior == ''){
							
							$prior = $i; 	
						}
						
						$phtsts     = "lstphtsts".$i;
						$sts    	= glb_func_chkvl($_POST[$phtsts]);
							 
						//**********************IMAGE UPLOADING START*******************************//						
			            $simg='flesimg'.$i;
						/*------------------------------------Update small image----------------------------*/	
						$sqryphtcat_mst="SELECT phtcatm_id,phtcatm_name
											  from phtcat_mst
											  where phtcatm_id=phtm_phtcatm_id";
					    $stsphtcat_mst = mysqli_query($conn,$sqryphtcat_mst);
		if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
			
					    $simgval = funcUpldImg($simg,'simg'.$i);
						if($simgval != ""){
								$simgary = explode(":",$simgval,2);
						     	$sdest 		= $simgary[0];
								$ssource 	= $simgary[1];
						}		
		}								
			   if($rspht_dtl == true){
				  
						$iqryprodimg_dtl =	"INSERT into pht_mst(
					                  phtm_phtd_id,phtm_phtcatm_id,
									  phtm_simgnm,phtm_simg,phtm_prty,
									  phtm_sts,phtm_crtdon, phtm_crtdby)
									  values('$phtdtl','$phtcatnm','$phtname',
									  '$sdest','$prior','$sts',
									  '$dt','$ses_admin')";
						$rsprod_dtl   = mysqli_query($conn,$iqryprodimg_dtl);
						if(($ssource!='none') && ($ssource!='') && ($sdest != "")){
							 
							move_uploaded_file($ssource,$a_phtgalspath1.$sdest);			
						}
									
			}
					}
		}
		}
											
				$gmsg = "Record saved successfully";
				
  }
	?>