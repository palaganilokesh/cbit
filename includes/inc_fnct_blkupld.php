<?php
	/***************************************************************/
	/*******************FUNCTION FOR UPLOADING EXCEL FILES**********/
	/***TAKE TWO ARGUMENTS (NAME OF THE CONTROL, NAME OF THE FILE**/
	/***************************************************************/
	function funcBlkUpld($cntrlnm,$imgnm){
		if(isset($_FILES[$cntrlnm]) && ($_FILES[$cntrlnm]!="") && (
			$_FILES[$cntrlnm]['type'] == 'application/octet-stream' ||
			$_FILES[$cntrlnm]['type'] == 'application/ms-excel' || 
			$_FILES[$cntrlnm]['type'] == 'application/vnd.ms-excel' || 
			$_FILES[$cntrlnm]['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || 
			$_FILES[$cntrlnm]['type'] == 'application/vnd.ms-excel.sheet.macroEnabled.12') && 
		   ($_FILES[$cntrlnm]['error'] == 0)){
			$dest 		= $_FILES[$cntrlnm];
			$source 	= $_FILES[$cntrlnm]['tmp_name'];
			$flenm		= explode('.',$_FILES[$cntrlnm]['name']);
			$flextn		= $flenm[1];		
			$fledtl		= "";	
			$upldtm		= implode('',explode('-',date('Y-m-d-h-i-s')));
			if(($source != "none") && ($source != "")){ 
				$xlflenm = $upldtm;	
				$dest 	 = trim($xlflenm).".".$flextn; 
				$fledtl  = $dest.":".$source;									
			}				
			return $fledtl;
		}
	}	
?>