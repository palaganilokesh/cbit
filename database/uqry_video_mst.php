<?php
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once '../includes/inc_adm_session.php';//checking for session
	include_once '../includes/inc_connection.php';//Making database Connection
	include_once '../includes/inc_usr_functions.php';//Use function for validation and more	
	include_once '../includes/inc_paging_functions.php';//Making paging validation
	include_once  "../includes/inc_config.php";	
if(isset($_POST['btnedtpht']) && (trim($_POST['btnedtpht']) != "")&&
   isset($_POST['txtname']) && (trim($_POST['txtname']) != "") &&
   isset($_POST['txtprty']) && (trim($_POST['txtprty']) != "")&& 
   isset($_POST['vw']) && (trim($_POST['vw'])!="")){ 
		$id  	    = glb_func_chkvl($_POST['vw']); 
		$catid       = glb_func_chkvl($_POST['lstphcat']);		
		$prty       = glb_func_chkvl($_POST['txtprty']);		
		$name       = glb_func_chkvl($_POST['txtname']);
		$desc       = addslashes(trim($_POST['txtdesc']));
		$rank       = glb_func_chkvl($_POST['txtprty']);
		$sts        = glb_func_chkvl($_POST['lststs']);
		$cntcntrl   = glb_func_chkvl($_POST['hdntotcntrl']);
		$curdt      = date('Y-m-d h:i:s');
		$pg       	= glb_func_chkvl($_REQUEST['pg']);
		$cntstart   = glb_func_chkvl($_REQUEST['countstart']);
		$val      	= glb_func_chkvl($_REQUEST['txtsrchval']);
		$emp      = $ses_admin;
		$sqryphtcat_mst="select
							 videod_id,videod_name
		              	 from 
					  		 video_dtl
					  	 where 
					 		 	videod_videom_id='$id'";
		$srsphtcat_mst = mysqli_query($conn,$sqryphtcat_mst);
		$rows          = mysqli_num_rows($srsphtcat_mst);
		
		if($rows > 0){
		?>
			<script>location.href="view_detail_video.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
		<?php
		}
		else{
			 $uqryphtcat_mst="update video_mst set 
							  videom_name='$name',
							  videom_desc='$desc',
							  videom_prty='$rank',
							  videom_sts='$sts',
							  videom_mdfdon='$curdt',
							  videom_mdfdby='$emp'";
			$uqryphtcat_mst .= "  where  videom_id=$id";
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
					$video      = glb_func_chkvl("txtvideo".$i);
					$video      = glb_func_chkvl($_POST[$video]);
					if($phtname ==""){
						$phtname    =  $i."-".$name;
					}
					$prty   = glb_func_chkvl("txtphtprior".$i);
					$prty   = glb_func_chkvl($_POST[$prty]);
					$phtsts  = "lstphtsts".$i;
					$psts     = $_POST[$phtsts];		
					if($prty ==""){
						$prty 	= $i;
					}
					//$bimg='flebgimg'.$i; 
					/*if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="") || $db_hdnimg !=''){
						$bimgval = funcUpldImg($bimg,'bimg');
						if($bimgval != ""){
							$bimgary    = explode(":",$bimgval,2);
							$bdest 		= $bimgary[0];					
							$bsource 	= $bimgary[1];					
						}	
					}*/							
					    if($pgdtlid != ''){	
						 $uqryphtimgd_dtl = "update video_dtl set
											  videod_nm='$phtname',
											  videod_video='$video',
											  videod_sts='$psts',
											  videod_prty='$prty',	
											  videod_mdfdon='$curdt',
											  videod_mdfdby='$emp'";
						/*if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 
							if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){	
								$bgimgpth      = $a_phtgalspath.$db_hdnimg;
								if(($db_hdnimg != ''))
								{
									unlink($bgimgpth);
								}
								$uqryphtimgd_dtl .= ",phtm_simg='$bdest'";
							}
							move_uploaded_file($bsource,$a_phtgalspath.$bdest);				
							
						 }*/
						$uqryphtimgd_dtl .= " where 
												  videod_videom_id = '$id' 
												  and 
												  videod_id='$pgdtlid'";
												  
										//echo $uqryphtimgd_dtl;exit; 		  
												  
												  
                        //echo $uqryphtimgd_dtl;exit; 		

												  
						$srphtimgd_dtl1 = mysqli_query($conn,$uqryphtimgd_dtl);																	
					  }
					 else{						
						$iqryprod_dtl ="insert into video_dtl(
										videod_nm,videod_video,videod_sts,videod_prty,
										videod_videom_id,videod_crtdon,videod_crtdby)
										values(
										'$phtname','$video','$psts','$prty',
										'$id' ,'$curdt','$emp')";  
						$srphtimgd_dtl = mysqli_query($conn,$iqryprod_dtl) or die (mysqli_error());
						 /*if($srphtimgd_dtl){
							if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 							
								move_uploaded_file($bsource,$a_phtgalspath.$bdest);			
							}
				  		}*/	
						}
					}
					
				}
			?>
				<script>location.href="view_detail_video.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";                </script>
			<?php
			}
			else
			{
			?>
				<script>location.href="view_detail_video.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";         </script>			
<?php 
			}
		}
	}
?>