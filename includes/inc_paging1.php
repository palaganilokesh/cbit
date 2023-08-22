<?php
	 /**********************************************************************/
	 /*************************Code for Paging******************************/
     $pgnum     = 1;//page number
	 $cntstart  = 0;//count
	 if(isset($_REQUEST['pg']) && ($_REQUEST['pg'] > 0))//if page is set 
	 {
	 	 $pgnum=$_REQUEST['pg'];//page number
		if(isset($_REQUEST['cntstart']) && ($_REQUEST['cntstart'] > 0))
		{
			 $cntstart=$_REQUEST['cntstart'];
		}
	 }
	 $offset = ($pgnum - 1) * $rowsprpg;//offset of page number	
	/**********************************************************************/	
?>