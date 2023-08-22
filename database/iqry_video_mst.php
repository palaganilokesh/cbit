<?php	

	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_connection.php";//Making database Connection
	include_once "../includes/inc_folder_path.php";

	if(isset($_POST['btnadprodsbmt']) && (trim($_POST['btnadprodsbmt']) != "") &&
	   isset($_POST['txtname']) && (trim($_POST['txtname'])!='') &&
	   isset($_POST['txtprty']) && ($_POST['txtprty'])!=''){
		 $name       	= glb_func_chkvl($_POST['txtname']);	 
		 $desc          = glb_func_chkvl($_POST['txtdesc']);
		 $prty          = glb_func_chkvl($_POST['txtprty']);
		 $nmsts          = glb_func_chkvl($_POST['lststs']);
  		 //$sts         	= glb_func_chkvl($_POST['lstphtsts1']);phtd_phtcatd_id
		 $dt          	= date('Y-m-d h:i:s');
		 $cntcntrl    	= glb_func_chkvl($_POST['hdntotcntrl']);
			
	     $iqryphtimg_dtl =	"INSERT into video_mst(
					         videom_name,videom_desc,
						     videom_prty,videom_sts,videom_crtdon, 
						     videom_crtdby)values(
							'$name','$desc','$prty','$nmsts',
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
							 
					
			            $video='txtvidur'.$i;
						$vid    	= glb_func_chkvl($_POST[$video]);
							
			   if($rspht_dtl == true){
				  
						$iqryprodimg_dtl =	"insert into video_dtl(
					                  videod_videom_id,videod_nm,videod_video,
									  videod_sts,videod_prty,videod_crtdon,
									  videod_crtdby)
									  values('$phtdtl','$phtname','$vid',
									  '$sts','$prior',
									  '$dt','$ses_admin')";
						$rsprod_dtl   = mysqli_query($conn,$iqryprodimg_dtl);
							
			}
					} 
		}
		}
											
				$gmsg = "Record saved successfully";
				
  }
	?>