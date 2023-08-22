<?php
	 /**********************************************************************/
	 /*************************Code for Paging******************************/
	 /*
	 	$num = Number of records to be displayed for one page
	 */
	 function funcPagVal($num)	
	 {
		 $rowsprpg  = $num;//maximum rows per page	
	 }
	/**********************************************************************/	
	
	/**********************************************************************/
	/*
		$cls = Style sheet name
		$rdrval = Value of the redirect page
		$qrystr = Takes the query stirng		
		$recprpg = Number of records per page
		$cntstart = Value of count start
		Call the function before displaying the page values
	*/
	/**********************************************************************/
	
	function  funcDispPag($conn,$cls,$rdval,$qrystr,$recprpg,$cntstart,$pgnum)
	{ 
		
	    $loc = $rdval;			
	    $temp          	  = explode("from",$qrystr);
			$sqrypg   		  = "select count(*) As numrows 
							 from ".$temp[1];//select query from cat_dtl table.
		
		$rspg	     	  = mysqli_query($conn,$sqrypg);//execute query
	    $rowpg    		  = mysqli_fetch_array($rspg);
		$numrows       	  = $rowpg['numrows'];//no of rows
		 $mxpg       	  = ceil($numrows/$recprpg);//maximum page number
		$self 		   	  = $_SERVER['PHP_SELF'];
		$nav  		   	  = '';
		$j                = 0;
		
		if($cntstart > 0) 
		{
			$tt		=	(($cntstart - 10)+1);
			$tt1	=	($cntstart - 10);
			$nav   .=	"<a class='$cls' href=\"$self?pg=1&cntstart=0$loc\">|<<</a>";
			$nav   .=	"&nbsp;<a class='$cls' href=\"$self?pg=$tt&cntstart=$tt1$loc\"> << </a>&nbsp;";
		}
		if($pgnum > $mxpg)
		{
			$pgnum = $mxpg;
		}			
		if($pgnum<=$mxpg)
		{
			for($j=$cntstart+1;$j < $cntstart+11;$j++)
			{
				if($j!=$pgnum && $j<=$mxpg)
				{
					$nav.="&nbsp;<a class='$cls' href=\"$self?pg=$j&cntstart=$cntstart$loc\">[$j]</a>&nbsp;";
				}
				else if($j<=$mxpg)
				{
					$nav.="<center><strong><font size='2px'>[$j]</font></strong></center>";
				}
			}
		 }			  
		 if($j<=$mxpg)
		 {
			$temp=($j-1);
			$temp1=($mxpg/10)*10;
			$nav.="&nbsp;<a class='$cls' href=\"$self?pg=$j&cntstart=$temp$loc\">>></a>&nbsp;";
			$nav.="&nbsp;<a class='$cls' href=\"$self?pg=$mxpg&cntstart=$temp1$loc\">>|</a>&nbsp;";
			if($pgnum = 1 && $cntstart ==0 && $mxpg < 1)
			{
				$nav="";
			}
		 }		 
		 return $nav;
		 
	}
	function  funcDispPagTxt($cls,$rdval,$qrystr,$recprpg,$cntstart,$pgnum){ 		
	    $loc = $rdval;				
	    $temp          	  = explode("from",$qrystr);
		$sqrypg   		  = "select count(*) As numrows 
							 from ".$temp[1];//select query from cat_dtl table.
		
		$rspg	     	  = mysqli_query($conn,$sqrypg);//execute query
	    $rowpg    		  = mysqli_fetch_array($rspg);
		$numrows       	  = $rowpg['numrows'];//no of rows
		$mxpg       	  = ceil($numrows/$recprpg);//maximum page number
		$self 		   	  = $_SERVER['PHP_SELF'];
		$nav  		   	  = '';
		$j                = 0;						

		if($pgnum > $mxpg){
			$pgnum = $mxpg;
		}			

		if(($mxpg > 0) && ($pgnum != 1)){
				$prvval	 = $pgnum - 1;
				$prvspg .= "<a class='$cls' href=\"$self?pg=$prvval$loc\"><img src='/images/pre_arrow.jpg' width='22' height='22' alt='Go To Previous Page'/></a>";		
		}		
		if(($mxpg > 1) && ($pgnum != $mxpg)){
				$nxtval	 = $pgnum + 1;
				$nxtpg  .= "<a class='$cls' href=\"$self?pg=$nxtval$loc\"><img src='/images/next_arrow.jpg' width='22' height='22' alt='Go To Next Page'/></a>";		
		}
		if($pgnum<=$mxpg){
			for($j=$cntstart+1; $j < $cntstart+11; $j++){
				if($j!=$pgnum && $j<=$mxpg){
					$nav .= "&nbsp;<a class='$cls' href=\"$self?pg=$j&cntstart=$cntstart$loc\">[$j]</a>&nbsp;";
				}
				elseif($j<=$mxpg){
					$crntno .= "$j";
				}
			}
		 }			  
		 $pgcnts = "<ul class='pageNum'><li>Page <input name='txtpgval' type='text' id='txtpgval' class='pg' onkeyup='funcCrntPgNo(this.value)'/></li>
						<li>$crntno&nbsp;of&nbsp;$mxpg</li>
						<li>$prvspg</li>
						<li>$nxtpg</li></ul>";		 
		  
		 return $pgcnts;		 
	}	
?>