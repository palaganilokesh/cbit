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
	
	function  funcDispPag($cls,$rdval,$qrystr,$recprpg,$cntstart,$pgnum,$distinct,$fldnm,$conn)
	{ 		
	    $loc = $rdval;
		$temp          	  = explode("from",$qrystr);
		if($distinct != 'y')
		{					
			$sqrypg  = "select count(*) As numrows 
					 	from ".$temp[1];//select query from cat_dtl table.		
		}
		elseif($distinct == 'y')
		{
			$sqrypg  = "select count(distinct($fldnm)) As numrows 
					 	from ".$temp[1];//select query from cat_dtl table.						
		}
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
					$nav.="<strong><font size='2px'>[$j]</font></strong>";
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
	
	function  funcDispPagTxt($cls,$rdval,$qrystr,$recprpg,$cntstart,$pgnum,$distinct,$fldnm){ 		
	    $loc = $rdval;				
	    $temp          	  = explode("from",$qrystr);
		
		if($distinct != 'y')
		{					
			$sqrypg  = "select count(*) As numrows 
					 	from ".$temp[1];//select query from cat_dtl table.		
		}
		elseif($distinct == 'y')
		{
			$sqrypg  = "select count(distinct($fldnm)) As numrows 
					 	from ".$temp[1];//select query from cat_dtl table.						
		}				
		$rspg	     	  = mysqli_query($conn,$sqrypg);//execute query
	    $rowpg    		  = mysqli_fetch_array($rspg);
		$numrows       	  = $rowpg['numrows'];//no of rows
		$mxpg       	  = ceil($numrows/$recprpg);//maximum page number
		$self 		   	  = $_SERVER['PHP_SELF'];
		$nav  		   	  = '';
		$j                = 0;						
		
		/*$sqryprod_mst_lnk =  "select 
								catonem_name,cattwom_name
							  from 
								vw_cat_prod_mst".$temp[1];
								
		$srsprod_mst_lnk  = mysqli_query($conn,$sqryprod_mst_lnk);
		$srowprod_mst_lnk = mysqli_fetch_assoc($srsprod_mst_lnk);
		
		$pgcatone_name = $srowprod_mst_lnk['catonem_name'];
		$pgcattwo_name = $srowprod_mst_lnk['cattwom_name'];
		
		$pg_ucatone_name = funcStrRplc($pgcatone_name);
		
		$pg_ucattwo_name = funcStrRplc($pgcattwo_name);
		
		$pg_lnknm = "/$pg_ucatone_name/$pg_ucattwo_name/";
		*/
								
		//$pg_lnknm = "$_SESSION[seslocval]";
		$pg_lnknm = $_SERVER['PATH_INFO'];
		

		if($pgnum > $mxpg){
			$pgnum = $mxpg;
		}			
		
		if(($mxpg > 0) && ($pgnum != 1)){
				$prvval	 = $pgnum - 1;
				$prvspg .= "<a class='$cls' href=\"$pg_lnknm?pg=$prvval$loc\"> <i class='icon-chevron-left' ></i> </a>";		
		}		
		if(($mxpg > 1) && ($pgnum != $mxpg)){
				$nxtval	 = $pgnum + 1;
				$nxtpg  .= "<a class='$cls' href=\"$pg_lnknm?pg=$nxtval$loc\"> <i class='icon-chevron-right' ></i> </a>";		
		}
		if($pgnum<=$mxpg){
			for($j=$cntstart+1; $j < $cntstart+11; $j++){
				if($j!=$pgnum && $j<=$mxpg){
					$nav .= "&nbsp;<a class='$cls' href=\"$pg_lnknm?pg=$j&cntstart=$cntstart$loc\">[$j]</a>&nbsp;";
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
	
	
	function  funcDispPagTxtFltr($cls,$rdval,$qrystr,$recprpg,$cntstart,$pgnum,$distinct,$fldnm){ 		
	    $loc = $rdval;				
	    $temp          	  = explode("from",$qrystr);
		
		if($distinct != 'y')
		{					
			$sqrypg  = "select count(*) As numrows 
					 	from ".$temp[1];//select query from cat_dtl table.		
		}
		elseif($distinct == 'y')
		{
			$sqrypg  = "select count(distinct($fldnm)) As numrows 
					 	from ".$temp[1];//select query from cat_dtl table.						
		}		
		
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
				$prvspg .= "<a class='$cls' ><img src='./images/pgprev.png' onclick='funcfltr($prvval)'/></a>";		
		}		
		if(($mxpg > 1) && ($pgnum != $mxpg)){
				$nxtval	 = $pgnum + 1;
				$nxtpg  .= "<a class='$cls' ><img src='./images/pgnext.png' onclick='funcfltr($nxtval)'/></a>";		
		}
		if($pgnum<=$mxpg){
			for($j=$cntstart+1; $j < $cntstart+$numrows; $j++){
				if($j!=$pgnum && $j<=$mxpg){
					$nav .= "&nbsp;<a class='$cls' href=\"$self?pg=$j&cntstart=$cntstart$loc\">[$j]</a>&nbsp;";
				}
				elseif($j<=$mxpg){
					$crntno .= "$j";
				}
			}
		 }				  
		  	 $pgcnts = "<ul class='pageNum'><li>Page <input name='txtpgval' type='text' id='txtpgval' size='1' onkeyup='funcfltr(this.value,2)'/></li>
			<li>$crntno&nbsp;of&nbsp;$mxpg</li>
			<li>$prvspg</li>
			<li>$nxtpg</li>
			</ul>";			  
		 return $pgcnts;	 
	}	
	
?>
