<?php	
 	include_once '../includes/inc_config.php';       //Making paging validation	
	  include_once $inc_nocache;        //Clearing the cache information
	  include_once $adm_session;    //checking for session
	  include_once $inc_cnctn;     //Making database Connection
	  include_once $inc_usr_fnctn;  //checking for session	
	  include_once $inc_fldr_pth;//Floder Path
if(isset($_POST['btnblogsbmt']) && (trim($_POST['btnblogsbmt']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
		 $name     =  glb_func_chkvl($_POST['txtname']);
		 $prty     =  glb_func_chkvl($_POST['txtprior']);
		 $desc     =  addslashes(trim($_POST['txtdesc']));
		 $sts      =  glb_func_chkvl($_POST['lststs']); 
		 // $gallery_cat      =  glb_func_chkvl($_POST['lstcat']);
		 
		 	// $img    =  glb_func_chkvl($_POST['fleszchrtimg']);
			 
			 	 $video     =  glb_func_chkvl($_POST['txtvdolnk']);
		 
		 
		 $cntcntrl =  glb_func_chkvl($_POST['hdntotcntrl']);
		 
		  $cntcntrlvdo =  glb_func_chkvl($_POST['hdntotcntrlvdo']);
		  
		  
		 $curdt       =  date('Y-m-d');
		 $sqrypht_mst="select 
		 					blogm_name
					   from 
					   		blog_mst
					   where 
					   		blogm_name='$name'";
		 $srspht_mst = mysqli_query($conn,$sqrypht_mst);
		 $rows         = mysqli_num_rows($srspht_mst);
		 if($rows < 1){		
		 
		 	if(isset($_FILES['img']['tmp_name']) && ($_FILES['img']['tmp_name']!="")){
				$szimgval = funcUpldImg('img','bimg');
				if($szimgval != ""){
					$szimgary   = explode(":",$szimgval,2);
					$szdest 	= $szimgary[0];					
					$szsource 	= $szimgary[1];	
				}
			}
			
			if(isset($_FILES['bigimg']['tmp_name']) && ($_FILES['bigimg']['tmp_name']!="")){
				$bzimgval = funcUpldImg('bigimg','bimg');
				if($bzimgval != ""){
					$bzimgary   = explode(":",$bzimgval,2);
					$bzdest 	= $bzimgary[0];					
					$bzsource 	= $bzimgary[1];	
				}
			}
			
			
			 	
		   $iqrypht_mst="insert into blog_mst(
						  blogm_name,blogm_desc,blogm_prty,blogm_sts,
						  blogm_crtdon,blogm_crtdby,blogm_img,blogm_bigimg,blogm_video) values(
						  '$name','$desc','$prty','$sts',
						  '$curdt','$ses_admin','$szdest','$bzdest','$video')";						     
			$irspht_mst = mysqli_query($conn,$iqrypht_mst);
			if($irspht_mst==true){
				if(($szsource!='none') && ($szsource!='') && ($szdest != "")){ 					
					move_uploaded_file($szsource,$gszchrt_upldpth.$szdest);					
				}
				if(($bzsource!='none') && ($bzsource!='') && ($bzdest != "")){ 					
					move_uploaded_file($bzsource,$gszchrt_upldpth.$bzdest);					
				}
				$prodid = mysqli_insert_id($conn);
				if($prodid != "" && $cntcntrl!=""){
					for($i=1;$i <= $cntcntrl;$i++){
						$prior    = glb_func_chkvl("txtphtprior".$i);
						$prior    = glb_func_chkvl($_POST[$prior]);
						$phtname  = glb_func_chkvl("txtphtname".$i);
						$phtname  = glb_func_chkvl($_POST[$phtname]);
						if($phtname == ''){
							$phtname = $i."-".$name; 	
						}
						else{
							$phtname = $i."-".$phtname;
						}
						if($prior == ''){
							$prior = $i; 	
						}
						$phtsts     = "lstphtsts".$i;
						$sts    	= glb_func_chkvl($_POST[$phtsts]);
						//**********************IMAGE UPLOADING START*******************************//						
						 //FOLDER THAT WILL CONTAIN THE IMAGES		
						$bimg='flebimg'.$i;
						/*------------------------------------Update small image----------------------------*/															
						if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){
							if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){
								$bimgval = funcUpldImg($bimg,'bimg');
								if($bimgval != ""){
									$bimgary = explode(":",$bimgval,2);
									$bdest 		= $bimgary[0];
									$bsource 	= $bimgary[1];
								}		
							}		
						

							if($bdest != ''){						
								$iqryphtimg_dtl ="insert into blogimg_dtl(
												  blogimgd_title,blogimgd_bimg,blogimgd_sts,blogimgd_prty,
												 blogimgd_blogm_id,blogimgd_crtdon,blogimgd_crtdby)values(											
												  '$phtname','$bdest','$sts','$prior',
												  '$prodid','$curdt','$ses_admin')";
								$rsprod_dtl   = mysqli_query($conn,$iqryphtimg_dtl);
								if($rsprod_dtl == true){
									if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 
										move_uploaded_file($bsource,$gszchrt_upldpth.$bdest);			
									}
								}
							}
						}
					}
					
					/**************************multiple video upload ************************/
					if($cntcntrlvdo!=""){
										for($i=1;$i <= $cntcntrlvdo;$i++){
						$prior    = glb_func_chkvl("txtvdoprior".$i);
						$prior    = glb_func_chkvl($_POST[$prior]);
						$vdoname  = glb_func_chkvl("txtvdoname".$i);
						$vdoname  = glb_func_chkvl($_POST[$vdoname]);
						$vdodesc  = glb_func_chkvl("txtvdodesc".$i);
						$vdodesc  = glb_func_chkvl($_POST[$vdodesc]);
						
						if($vdoname == ''){
							$vdoname = $i."-".$name; 	
						}
						else{
							$vdoname = $i."-".$vdoname;
						}
						if($prior == ''){
							$prior = $i; 	
						}
						$vdosts     = "lstvdosts".$i;
						$sts    	= glb_func_chkvl($_POST[$vdosts]);
						$vdolnk  = glb_func_chkvl("txtvdo".$i);
						$vdolnk  = glb_func_chkvl($_POST[$vdolnk]);
						//**********************IMAGE UPLOADING START*******************************//						
						 //FOLDER THAT WILL CONTAIN THE IMAGES		
						$bimg='flebimg'.$i;
						/*------------------------------------Update small image----------------------------*/															
						$sqrypgvdo_dtl="select 
											   blogvdod_title
											from
											   blogvdo_dtl
											where 
											   blogvdod_title='$vdoname' and
											   blogvdod_videom_id ='$prodid'";
							$srspgvdo_dtl = mysqli_query($conn,$sqrypgvdo_dtl);
							$cntpgvdo_dtl       = mysqli_num_rows($srspgvdo_dtl);
							if($cntpgvdo_dtl < 1){
								if($vdolnk !=""){					
									$iqryvdoimg_dtl ="insert into blogvdo_dtl(
													  	blogvdod_title,blogvdod_desc,blogvdod_video,blogvdod_sts,blogvdod_prty,
													  blogvdod_videom_id,blogvdod_crtdon,blogvdod_crtdby)values(											
													  '$vdoname','$vdodesc','$vdolnk','$sts','$prior',
													  '$prodid','$curdt','$ses_admin')";
									$rsprod_dtl   = mysqli_query($conn,$iqryvdoimg_dtl);
									if($rsprod_dtl == true){								
											//$gmsg = "Record saved successfully";		
									}
								}
							}	
					}

					}
				}				
				$gmsg = "Record saved successfully";
			}
			else{
				$gmsg = "Record not saved";
			}			
		 }
		 else{			
			$gmsg = "Duplicate Record. Record not saved";
		 }
	  }
?>