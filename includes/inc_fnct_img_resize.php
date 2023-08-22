<?php	
	function funcImzResize($mxsizehght,$mxsizewdth,$imgpth){
		global $glb_imgsz;		
		list($wdth,$hght) = getimagesize($imgpth);
		if($hght > $mxsizehght){
			$prper = floor($hght / $mxsizehght); // Propersinate percentage
			$hght = $mxsizehght; // Assigning maxsize
			$wdth = number_format($wdth / $prper); // New width;
			if($wdth > $mxsizewdth){
				$prper  = floor($wdth / $mxsizewdth); // Propersinate percentage
				$wdth = $mxsizewdth; // Assigning maxsize								
			 	$hght =  number_format($hght / $prper)  ; // New height;				
			}			
		}
		elseif($wdth > $mxsizewdth){
			$prper  = floor($wdth / $mxsizewdth); // Propersinate percentage
			$wdth = $mxsizewdth; // Assigning maxsize								
			$hght =  number_format($hght / $prper)  ; // New height;
			if($hght > $mxsizehght){
				$prper = $hght / $mxsizehght; // Propersinate percentage
				$hght = $mxsizehght; // Assigning maxsize
				$wdth = number_format($wdth / $prper); // New width;			
			}			 
		}
		$glb_imgsz = " width='$wdth' height='$hght'";
		return $glb_imgsz;	
	}
?>