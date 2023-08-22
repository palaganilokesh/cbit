<?php	

	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_connection.php";//Making database Connection
	include_once "../includes/inc_folder_path.php";

	
	global $a_phtgalfaculty;
	if(isset($_POST['btnadprodsbmt']) && (trim($_POST['btnadprodsbmt']) != "") &&
	   isset($_POST['txtprty1']) && ($_POST['txtprty1'])!=''){
		 $dept     = glb_func_chkvl($_POST['lstprodcat']);
		 $prty          = glb_func_chkvl($_POST['txtprty1']);
		 $nmsts          = glb_func_chkvl($_POST['lststs1']);
  		 //$sts         	= glb_func_chkvl($_POST['lstphtsts1']);faculty_phtcatd_id
		 $dt          	= date('Y-m-d h:i:s');
		 $cntcntrl    	= glb_func_chkvl($_POST['hdntotcntrl']);
	

		 
			
	     $iqryfaculty_dtl =	"INSERT into faculty_mst(
					         faculty_dept_id,faculty_name,
						     faculty_desc,faculty_rank,faculty_sts, 
						     faculty_crtdon, faculty_crtdby)values(
							'$dept', '','','$prty','$nmsts',
						    '$dt','$ses_admin')";
							
	     $rspht_dtl   = mysqli_query($conn,$iqryfaculty_dtl);
		 if($rspht_dtl==true){
		$facultytl=mysqli_insert_id($conn);
		if($facultytl !="" && $cntcntrl!=""){	 
				for($i=1;$i <= $cntcntrl;$i++){

					 $prior      = glb_func_chkvl("txtphtprior".$i);
				    	$prior      = glb_func_chkvl($_POST[$prior]);

					    $phtname  = glb_func_chkvl("txtphtname".$i);
						$phtname  = glb_func_chkvl($_POST[$phtname]);
						
						$txtdesc  = glb_func_chkvl("txtdesc".$i);
						$txtdesc  = glb_func_chkvl($_POST[$txtdesc]);


						$desg  = glb_func_chkvl("txtdesg".$i);
						$desg  = glb_func_chkvl($_POST[$desg]);
						if($phtname == ''){
							$phtname =$phtname; 	
						}
						if($txtdesc == ''){
							$txtdesc = $txtdesc; 	
						}
						if($desg == ''){
							$desg =$desg; 	
						}
						if($prior == ''){
							
							$prior = $i; 	
						}
						
						$phtsts     = "lstphtsts".$i;
						$sts    	= glb_func_chkvl($_POST[$phtsts]);
						$factyp     = "factyp".$i;
						$fac_typ    	= glb_func_chkvl($_POST[$factyp]);
							 
						//**********************IMAGE UPLOADING START*******************************//						
			            $simg='flesimg'.$i;//image
									$fac_file='flelnk'.$i;//file

						/*------------------------------------Update small image----------------------------*/	
				
		if(isset($_FILES[$simg]['tmp_name']) && ($_FILES[$simg]['tmp_name']!="")){
			
					    $simgval = funcUpldImg($simg,'simg'.$i);
						if($simgval != ""){
								$simgary = explode(":",$simgval,2);
						     	$sdest 		= $simgary[0];
								$ssource 	= $simgary[1];
						}		
		}	//image	
		if(isset($_FILES[$fac_file]['tmp_name']) && ($_FILES[$fac_file]['tmp_name']!="")){
			
			 $simgval1 = funcUpldFle($fac_file,'flelnk'.$i); 
		if($simgval1 != ""){
				$simgary1 = explode(":",$simgval1,2);
					 $sdest1 		= $simgary1[0];
				$ssource1 	= $simgary1[1];
		}		
}		//files					
			   if($rspht_dtl == true){
				  
					 	$iqryprodimg_dtl =	"INSERT into faculty_dtl(
					                  faculty_mst_id,faculty_dtl_dept_id,
									  faculty_simgnm,faculty_desgn,faculty_typ,faculty_desc,faculty_simg,faculty_file,faculty_prty,
									  faculty_dtl_sts,faculty_crtdon, faculty_crtdby)
									  values('$facultytl','$dept','$phtname','$desg','$txtdesc','$fac_typ',
									  '$sdest','$sdest1','$prior','$sts',
									  '$dt','$ses_admin')";
						$rsprod_dtl   = mysqli_query($conn,$iqryprodimg_dtl);
						if(($ssource!='none') && ($ssource!='') && ($sdest != "")){
							 
							move_uploaded_file($ssource,$a_phtgalfaculty.$sdest);			
						}
						if(($ssource1!='none') && ($ssource1!='') && ($sdest1 != "")){
							 
							move_uploaded_file($ssource1,$a_phtgalfaculty.$sdest1);			
						}
							
									
			}
					}
		}
		}
											
				$gmsg = "Record saved successfully";
				
  }
	?>