<?php
	include_once '../includes/inc_config.php';       //Making paging validation	
	  include_once $inc_nocache;        //Clearing the cache information
	  include_once $adm_session;    //checking for session
	  include_once $inc_cnctn;     //Making database Connection
	  include_once $inc_usr_fnctn;  //checking for session	
	  include_once $inc_fldr_pth;//Floder Path	
if(isset($_POST['btnedtblog']) && (trim($_POST['btnedtblog']) != "") && isset($_POST['txtname']) && (trim($_POST['txtname']) != "") && isset($_POST['hdnblogid']) && (trim($_POST['hdnblogid']) != "") && isset($_POST['txtprior']) && (trim($_POST['txtprior']) != ""))
{
		$id 	    = glb_func_chkvl($_REQUEST['vw']);
		$prty       = glb_func_chkvl($_POST['txtprior']);		
		$name       = glb_func_chkvl($_POST['txtname']);
			//$galleryname       = glb_func_chkvl($_POST['lstprodcatstk']);
		$desc       = addslashes(trim($_POST['txtdesc']));
		$vid       = addslashes(trim($_POST['txtvdolnk']));
		
		
		$sts        = glb_func_chkvl($_POST['lststs']);
		$cntcntrl   = glb_func_chkvl($_POST['hdntotcntrl']);
		
		$cntcntrlvdo   = glb_func_chkvl($_POST['hdntotcntrlvdo']);
		
		//echo  $cntcntrlvdo;exit;
		
		
		
		
		$curdt      = date('Y-m-d h:i:s');
		$pg       	= glb_func_chkvl($_REQUEST['pg']);
		$cntstart   = glb_func_chkvl($_REQUEST['countstart']);
		$val      	= glb_func_chkvl($_REQUEST['txtsrchval']);
		
		
			
		
		if(isset($_REQUEST['chkexact']) && $_REQUEST['chkexact']=='y'){
		  $chk="&chkexact=y";
		}		 
		if($val !=''){
			$srchval .= "&txtsrchval=".$val.$chk;
		}	
		$sqryphtcat_mst="select
							 blogm_name
		              	 from 
					  		 blog_mst
					  	 where 
					 		blogm_name='$name'  and
					 		blogm_id!=$id";
		$srsphtcat_mst = mysqli_query($conn,$sqryphtcat_mst);
		$rows          = mysqli_num_rows($srsphtcat_mst);
		if($rows > 0){
		?>
			<script>location.href="view_blog.php?vw=<?php echo $id;?>&sts=d&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";</script>
		<?php
		}
		else{
			 $uqryphtcat_mst="update blog_mst set 
							  blogm_name='$name',
							  blogm_prty='$prty',
							  blogm_sts='$sts',
							  blogm_desc='$desc',
							  blogm_video = '$vid',
							 		  
							  blogm_mdfdon='$curdt',
							 blogm_mdfdby='$ses_admin'";
							 
							 
							 
							 if(isset($_FILES['img']['tmp_name']) && ($_FILES['img']['tmp_name']!="")){
				$szimgval = funcUpldImg('img','bimg');
				if($szimgval != ""){
					$szimgary   = explode(":",$szimgval,2);
					$szdest 	= $szimgary[0];					
					$szsource 	= $szimgary[1];	
				}
				
				$uqryphtcat_mst .= ",blogm_img='$szdest'";
			}
			
			if(isset($_FILES['bigimg']['tmp_name']) && ($_FILES['bigimg']['tmp_name']!="")){
				$bzimgval = funcUpldImg('bigimg','bimg');
				if($bzimgval != ""){
					$bzimgary   = explode(":",$bzimgval,2);
					$bzdest 	= $bzimgary[0];					
					$bzsource 	= $bzimgary[1];	
				}
				$uqryphtcat_mst .= ",blogm_bigimg='$bzdest'";
			}
							 
							 
							 
			$uqryphtcat_mst .= "  where blogm_id=$id";	
			$ursphtcat_mst = mysqli_query($conn,$uqryphtcat_mst);
			if($ursphtcat_mst==true){
				
				if(($szsource!='none') && ($szsource!='') && ($szdest != "")){ 					
					move_uploaded_file($szsource,$gszchrt_upldpth.$szdest);					
				}
				if(($bzsource!='none') && ($bzsource!='') && ($bzdest != "")){ 					
					move_uploaded_file($bzsource,$gszchrt_upldpth.$bzdest);					
				}
			  if($id!="" && $cntcntrl !="" ){
				for($i=1;$i<=$cntcntrl;$i++){
					$cntrlid  = glb_func_chkvl("hdnproddid".$i);
					$pgdtlid  = glb_func_chkvl($_POST[$cntrlid]);
					$cntbgimg	= glb_func_chkvl("hdnbgimg".$i);
					$db_hdnimg  = glb_func_chkvl($_POST[$cntbgimg]);
					$phtname   = glb_func_chkvl("txtphtname1".$i);
					$validname  = glb_func_chkvl($_POST[$phtname]);
					$phtname    =  $i."-".glb_func_chkvl($_POST[$phtname]);
					if($validname ==""){
						$phtname    =  $i."-".$name;
					}
					$prty   = glb_func_chkvl("txtphtprior".$i);
					$prty   = glb_func_chkvl($_POST[$prty]);
					$phtsts  = "lstphtsts".$i;
					$sts     = $_POST[$phtsts];		
					if($prty ==""){
						$prty 	= $i;
					}
					$bimg='flebgimg'.$i; 
					if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){
						$bimgval = funcUpldImg($bimg,'bimg');
						if($bimgval != ""){
							$bimgary    = explode(":",$bimgval,2);
							$bdest 		= $bimgary[0];					
							$bsource 	= $bimgary[1];					
						}	
					}							
					    if($pgdtlid != ''){						
						 $uqryphtimgd_dtl = "update blogimg_dtl set
											  blogimgd_title = '$phtname',
											  blogimgd_sts='$sts',
											 blogimgd_prty='$prty',	
											 blogimgd_mdfdon='$curdt',
											 blogimgd_mdfdby='$ses_admin'";
						if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 
							if(isset($_FILES[$bimg]['tmp_name']) && ($_FILES[$bimg]['tmp_name']!="")){	
								$bgimgpth      = $gszchrt_upldpth.$db_hdnimg;
								if(($db_hdnimg != '') && file_exists($bgimgpth))
								{
									unlink($bgimgpth);
								}
								$uqryphtimgd_dtl .= ",blogimgd_bimg='$bdest'";
							}
							move_uploaded_file($bsource,$gszchrt_upldpth.$bdest);				
							
						 }
						$uqryphtimgd_dtl .= " where 
												  blogimgd_blogm_id = '$id' and 
												  blogimgd_id='$pgdtlid'";
						$srphtimgd_dtl1 = mysqli_query($conn,$uqryphtimgd_dtl);																	
					  }
					 else{						
						$iqryprod_dtl ="insert into blogimg_dtl(
										blogimgd_title,blogimgd_bimg,blogimgd_sts,blogimgd_prty,
										blogimgd_blogm_id,blogimgd_crtdon,blogimgd_crtdby)values(
										'$phtname','$bdest','$sts','$prty',
										'$id','$curdt','$ses_admin')";  
						$srphtimgd_dtl = mysqli_query($conn,$iqryprod_dtl) or die (mysql_error());
						 if($srphtimgd_dtl){
							if(($bsource!='none') && ($bsource!='') && ($bdest != "")){ 							
								move_uploaded_file($bsource,$gszchrt_upldpth.$bdest);			
							}
				  		}	
						}
					}
					
					
					
					/**************************video upload ***********************************/
					if($cntcntrlvdo!=""){
							for($i=1;$i<=$cntcntrlvdo;$i++){
					$cntrlid  = glb_func_chkvl("hdnproddidvdo".$i);
					$pgdtlid1  = glb_func_chkvl($_POST[$cntrlid]);
					$cntbgimg	= glb_func_chkvl("hdnbgvdo".$i);
					$db_hdnimg  = glb_func_chkvl($_POST[$cntbgimg]);
					$vdoname   = glb_func_chkvl("txtvdoname1".$i);
					$validname  = glb_func_chkvl($_POST[$vdoname]);
					$vdodesc   = glb_func_chkvl("txtvdodesc".$i);
					$validdesc  = glb_func_chkvl($_POST[$vdodesc]);
					
					$vdoname    =  $i."-".glb_func_chkvl($_POST[$vdoname]);
					if($validname ==""){
						$vdoname    =  $i."-".$name;
					}
					$prty   = glb_func_chkvl("txtvdoprior".$i);
					$prty   = glb_func_chkvl($_POST[$prty]);
					$vdosts  = "lstvdosts".$i;
					$sts     = $_POST[$vdosts];		
					if($prty ==""){
						$prty 	= $i;
					}
					$vdolnk    = glb_func_chkvl("txtvdo".$i);
					$vdolnknm  = glb_func_chkvl($_POST[$vdolnk]);
					    if($pgdtlid1 != ''){						
							 $uqryvdoimgd_dtl = "update blogvdo_dtl set
												  blogvdod_title = '$vdoname',
												   blogvdod_desc = '$validdesc',
												  blogvdod_video = '$vdolnknm',
												  blogvdod_sts = '$sts',
												  blogvdod_prty = '$prty',	
												   blogvdod_mdfdon = '$curdt',
												  blogvdod_mdfdby = '$ses_admin'";
							$uqryvdoimgd_dtl .= " where 
													  blogvdod_videom_id = '$id' and 
													  	blogvdod_id='$pgdtlid1'";
							$srvdoimgd_dtl1 = mysqli_query($conn,$uqryvdoimgd_dtl);																	
					  	}
					 	else{						
							$iqryprod_dtl ="insert into blogvdo_dtl(
											blogvdod_title,blogvdod_desc,blogvdod_video,blogvdod_sts,blogvdod_prty,
											blogvdod_videom_id,blogvdod_crtdon,blogvdod_crtdby)values(
											'$vdoname','$validdesc','$vdolnknm','$sts','$prty',
											'$id','$curdt','$ses_admin')";  
							$srvdoimgd_dtl = mysqli_query($conn,$iqryprod_dtl) or die (mysql_error());
						 
						}
					}
					
					}
					
					
					/*************************************************************/
				}
			?>
				<script>location.href="view_blog.php?vw=<?php echo $id;?>&sts=y&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";                </script>
			<?php
			}
			else
			{
			?>
				<script>location.href="view_blog.php?vw=<?php echo $id;?>&sts=n&pg=<?php echo $pg;?>&countstart=<?php echo $cntstart;?><?php echo $srchval;?>";         </script>			
<?php 
			}
		}
	}
?>