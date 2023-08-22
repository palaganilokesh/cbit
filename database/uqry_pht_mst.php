<?php
error_reporting(0);
	include_once '../includes/inc_config.php';       //Making paging validation	
	  include_once $inc_nocache;        //Clearing the cache information
	  include_once $adm_session;    //checking for session
	  include_once $inc_cnctn;     //Making database Connection
	  include_once $inc_usr_fnctn;  //checking for session	
	  include_once $inc_fldr_pth;//Floder Path	
	global $a_phtgalspath1;
	if(isset($_POST['btnedtpht']) && (trim($_POST['btnedtpht']) != "")&&
		 isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
		isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")&& 
	     isset($_POST['vw']) && (trim($_POST['vw'])!="")/**/){ 
		 
		 
		
		$id  	    = glb_func_chkvl($_POST['vw']); 
		$catid       = glb_func_chkvl($_POST['lstphcat']);		
		$prty       = glb_func_chkvl($_POST['txtprty']);		
		$name       = glb_func_chkvl($_POST['txtname']);
		$desc       = addslashes(trim($_POST['txtdesc']));
		$rank       = glb_func_chkvl($_POST['txtprty']);
		$sts        = glb_func_chkvl($_POST['lststs1']);
		$cntcntrl   = glb_func_chkvl($_POST['hdntotcntrl']);
		$curdt      = date('Y-m-d h:i:s');
		$pg       	= glb_func_chkvl($_REQUEST['pg']);
		$cntstart   = glb_func_chkvl($_REQUEST['countstart']);
		$val      	= glb_func_chkvl($_REQUEST['txtsrchval']);
		$sqryphtcat_mst="select
							 phtm_id,phtm_name
		              	 from 
					  		 pht_mst
					  	 where 
					 		 	phtm_phtd_id='$id'";
		$srsphtcat_mst = mysqli_query($conn,$sqryphtcat_mst);
		$rows          = mysqli_num_rows($srsphtcat_mst);
		
		if($rows > 0){
		?>
			<script>location.href="view_detail_photogallery.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
		<?php
		}
		else{
			 $uqryphtcat_mst="update pht_dtl set 
							  phtd_phtcatm_id='$catid',
							  phtd_name='$name',
							  phtd_desc='$desc',
							  phtd_rank='$rank',
							  phtd_sts='$sts',
							  phtd_mdfdon='$curdt',
							  phtd_mdfdby='$ses_admin'";
			$uqryphtcat_mst .= "  where  phtd_id=$id";
			$ursphtcat_mst = mysqli_query($conn,$uqryphtcat_mst);
			if($uqryphtcat_mst==true){
			  if($id!="" && $cntcntrl !="" ){
				for($i=1;$i<=$cntcntrl;$i++){
					
					$cntrlid  = glb_func_chkvl("hdnproddid".$i);
					$pgdtlid  = glb_func_chkvl($_POST[$cntrlid]);
					$cntbgimg	= glb_func_chkvl("hdnbgimg".$i);
					$db_hdnimg  = glb_func_chkvl($_POST[$cntbgimg]);
				    $phtname   = glb_func_chkvl("txtphtname".$i); 
		 	        $validname  = glb_func_chkvl($_POST[$phtname]);
				    $phtname    =  glb_func_chkvl($_POST[$phtname]);
					if($validname ==""){
						$phtname    =  $i."-".$name;
					}
					$prty   = glb_func_chkvl("txtphtprior".$i);
					$prty   = glb_func_chkvl($_POST[$prty]);
					$phtsts  = "lstphtsts".$i;
					$psts     = $_POST[$phtsts];		
					if($prty ==""){
						$prty 	= $i;
					}
					$bimg='flebgimg'.$i; 
					if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="") || $db_hdnimg !=''){
						$bimgval = funcUpldImg($bimg,'bimg'.$i);
						if($bimgval != ""){
							$bimgary    = explode(":",$bimgval,2);
							$bdest 		= $bimgary[0];					
							$bsource 	= $bimgary[1];					
						}	
					}							
					    if($pgdtlid != ''){	
						 $uqryphtimgd_dtl = "update pht_mst set
											  phtm_simgnm='$phtname',
											  phtm_prty='$prty',
											  phtm_sts='$psts',	
											  phtm_mdfdon='$curdt',
											  phtm_mdfdby='$ses_admin'";
						if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 
							if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){	
								$bgimgpth      = $a_phtgalspath1.$db_hdnimg;
								if(($db_hdnimg != ''))
								{
									unlink($bgimgpth);
								}
								$uqryphtimgd_dtl .= ",phtm_simg='$bdest'";
							}
							move_uploaded_file($bsource,$a_phtgalspath1.$bdest);				
							
						 }
						$uqryphtimgd_dtl .= " where 
												  phtm_phtd_id = '$id' 
												  and 
												  phtm_id='$pgdtlid'";
												  
									//	echo $uqryphtimgd_dtl;exit; 		  
												  
												  
                        //echo $uqryphtimgd_dtl;exit; 		

												  
						$srphtimgd_dtl1 = mysqli_query($conn,$uqryphtimgd_dtl);																	
					  }
					 else{						
						$iqryprod_dtl ="insert into pht_mst(
										phtm_simgnm,phtm_simg,phtm_sts,phtm_prty,
										phtm_phtcatm_id,phtm_phtd_id,phtm_crtdon,phtm_crtdby)
										values(
										'$validname','$bdest','$psts','$prty',
										'$catid','$id' ,'$curdt','$ses_admin')";  
						$srphtimgd_dtl = mysqli_query($conn,$iqryprod_dtl) or die (mysqli_error());
						 if($srphtimgd_dtl){
							if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 							
								move_uploaded_file($bsource,$a_phtgalspath1.$bdest);			
							}
				  		}	
						}
					}
					
				}
			?>
				<script>location.href="view_detail_photogallery.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";                </script>
			<?php
			}
			else
			{
			?>
				<script>location.href="view_detail_photogallery.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";         </script>			
<?php 
			}
		}
	}
?>