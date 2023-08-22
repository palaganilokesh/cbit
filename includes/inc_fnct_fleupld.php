<?php
	function funcUpldImg($cntrlnm,$imgnm)
	{
		if(isset($_FILES[$cntrlnm]) && ($_FILES[$cntrlnm]!=""))
		{
			$dest 		= $_FILES[$cntrlnm];
			$source 	= $_FILES[$cntrlnm]['tmp_name'];
			$imgdtl		= "";			
			if(($source != "none") && ($source != "")){
			 
				$imagesize = getimagesize($source);
				if($imagesize['mime'] == 'image/gif' || $imagesize['mime'] == 'image/jpeg' || 
				   $imagesize['mime'] == 'image/bmp' || $imagesize['mime'] == 'image/png' ||
				   $imagesize['mime'] == 'application/x-shockwave-flash' || $imagesize['mime'] == 'image/tiff' ||
				   $imagesize['mime'] == 'image/psd')
				{					 					
					switch($imagesize[2]) 
					{ 
						case 0: 
							echo '<BR> Image is unknown <BR>'; 
							break; 
						case 1: 
							$dest =uniqid($imgnm).'.gif'; 
							break; 
						case 2: 
						   $dest = uniqid($imgnm).'.jpg'; 
							break; 
						case 3: 
							$dest = uniqid($imgnm).'.png'; 
							break;
						case 4: 
							$dest = uniqid($imgnm).'.swf'; 
							break;	
						case 5: 
							$dest = uniqid($imgnm).'.psd'; 
							break;	
						case 6: 
							$dest = uniqid($imgnm).'.bmp'; 
							break; 
						case 7: 
							$dest = uniqid($imgnm).'.tiff'; 
							break;
						case 8: 
							$dest = uniqid($imgnm).'.tiff'; 
							break; 					 
					}
					$imgdtl = $dest.":".$source;					
					return $imgdtl;
				} 
			}				
		}
	}	

	
	/***************************************************************/
	/*******************FUNCTION FOR UPLOADING IMAGES***************/
	/***TAKE TWO ARGUMENTS (NAME OF THE CONTROL, NAME OF THE IMAGE**/
	/***************************************************************/
	function funcUpldFle($cntrlnm,$imgnm){
		if(isset($_FILES[$cntrlnm]) && ($_FILES[$cntrlnm]!="") && 
		   ($_FILES[$cntrlnm]['type'] == 'application/msword' || 
			$_FILES[$cntrlnm]['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || 	
			$_FILES[$cntrlnm]['type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' ||	 
			$_FILES[$cntrlnm]['type'] == 'application/vnd.ms-excel' ||
			$_FILES[$cntrlnm]['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||  
		    $_FILES[$cntrlnm]['type'] == 'application/pdf' ||
			$_FILES[$cntrlnm]['type'] == 'application/vnd.ms-powerpoint') && 
		   ($_FILES[$cntrlnm]['error'] == 0)){
			$dest 		= $_FILES[$cntrlnm];
			$source 	= $_FILES[$cntrlnm]['tmp_name'];
			$fledtl		= "";			
			if(($source != "none") && ($source != "")){ 
				if($_FILES[$cntrlnm]['type'] == 'application/msword'){
					echo $dest =$imgnm."".$_FILES[$cntrlnm]['name']; 
				}
				elseif($_FILES[$cntrlnm]['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
					$dest =$imgnm."".$_FILES[$cntrlnm]['name']; 
				}
				elseif($_FILES[$cntrlnm]['type'] == 'application/vnd.ms-excel'){
					$dest =$imgnm."".$_FILES[$cntrlnm]['name']; 
				}
				elseif($_FILES[$cntrlnm]['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
					$dest =$imgnm."".$_FILES[$cntrlnm]['name']; 
				}
				elseif($_FILES[$cntrlnm]['type'] == 'application/pdf'){
					$dest =$imgnm."".$_FILES[$cntrlnm]['name']; 
				}
				elseif($_FILES[$cntrlnm]['type'] == 'application/vnd.ms-powerpoint'){
					$dest =$imgnm."".$_FILES[$cntrlnm]['name']; 
				}
				elseif($_FILES[$cntrlnm]['type'] == 'application/vnd.openxmlformats-officedocument.presentationml.presentation'){
					$dest =$imgnm."".$_FILES[$cntrlnm]['name']; 
				}
				$fledtl = $dest.":".$source;					
				return $fledtl;
			}				
		}
	}	
	
	/***************************************************************/
	/**********FUNCTION FOR UPLOADING FILES (DOCS / PDFS)***********/
	/***TAKE TWO ARGUMENTS (NAME OF THE CONTROL, NAME OF THE IMAGE**/
	/***************************************************************/
	
   function funcWtrMrkBg($pth,$flenm) {	 
	    $path_to_image_directory 	 = $pth;
	    //$path_to_thumbs_directory  = $upldpth;
		$path_to_water_mrk_image	 = '../admin/images/watermark-big.png';
		
       if(preg_match('/[.](jpg)$/', $flenm)) {  
           $im = imagecreatefromjpeg($path_to_image_directory . $flenm);  
        } else if (preg_match('/[.](gif)$/', $filename)) {  
            $im = imagecreatefromgif($path_to_image_directory . $flenm);  
        } else if (preg_match('/[.](png)$/', $flenm)) {  
           $im = imagecreatefrompng($path_to_image_directory . $flenm);  
       }  				
	   
	   //$flenm = uniqid('wimg');
	   //$flenm = $flenm.".jpg";
	   
	   //$watermark = @imagecreatefromgif($path_to_water_mrk_image); 
	   
	   //$watermark = @imagecreatefromjpeg($path_to_water_mrk_image); 
	   
	   $watermark = @imagecreatefrompng($path_to_water_mrk_image);
	   
	   
	   
		
	   $imagewidth = imagesx($im); 
	   $imageheight = imagesy($im);  
	   
	   $watermarkwidth =  imagesx($watermark); 
	   $watermarkheight =  imagesy($watermark); 		
		
	   $startwidth = (($imagewidth - $watermarkwidth)/2); 
	   $startheight = (($imageheight - $watermarkheight)/2); 
				
	   imagecopy($im, $watermark,  $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight); 
	   imagejpeg($im, $pth . $flenm); 		
	   return $flenm;		   
   }
   
   function funcWtrMrkSml($pth,$flenm) {	 
	    $path_to_image_directory 	 = $pth;
	    //$path_to_thumbs_directory  = $upldpth;
		$path_to_water_mrk_image	 = '../admin/images/watermark-sml.png';
		
       if(preg_match('/[.](jpg)$/', $flenm)) {  
           $im = imagecreatefromjpeg($path_to_image_directory . $flenm);  
        } else if (preg_match('/[.](gif)$/', $filename)) {  
            $im = imagecreatefromgif($path_to_image_directory . $flenm);  
        } else if (preg_match('/[.](png)$/', $flenm)) {  
           $im = imagecreatefrompng($path_to_image_directory . $flenm);  
       }  				
	   
	   //$flenm = uniqid('wimg');
	   //$flenm = $flenm.".jpg";
	   
	   //$watermark = @imagecreatefromgif($path_to_water_mrk_image); 
	   
	   //$watermark = @imagecreatefromjpeg($path_to_water_mrk_image); 
	   
	   $watermark = @imagecreatefrompng($path_to_water_mrk_image);
	   
	   
	   
		
	   $imagewidth = imagesx($im); 
	   $imageheight = imagesy($im);  
	   
	   $watermarkwidth =  imagesx($watermark); 
	   $watermarkheight =  imagesy($watermark); 		
		
	   $startwidth = (($imagewidth - $watermarkwidth)/2); 
	   $startheight = (($imageheight - $watermarkheight)/2); 
				
	   imagecopy($im, $watermark,  $startwidth, $startheight, 0, 0, $watermarkwidth, $watermarkheight); 
	   imagejpeg($im, $pth . $flenm); 		
	   return $flenm;		   
   }   
   	
?>