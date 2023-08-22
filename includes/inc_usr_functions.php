<?php
	//Function for checking the valid values
		global $conn;

	
	function glb_func_chkvl($cntrlval)
	{
					global $conn;

		$crntval = $cntrlval;
		$newval  = htmlspecialchars(trim($cntrlval),ENT_QUOTES);
		return $newval;		
	}	
	function funcUpdtRecSts($tblnm,$idfldnm,$idval,$ufldnm,$curval)
	{
					global $conn;

		$tblname 	= $tblnm;    // Stores the table name
		$idfldname  = $idfldnm;  //Stores the id field name
		$recid	 	= $idval;    // Stores the id value
		$updtfldnm  = $ufldnm;   // Stores the update field name
		$curfldval	= $curval;  // Stores the current field value
		$updtval 	= "";
		if($curfldval == 'a')
		{
			$updtval = 'i';
		}
		elseif($curfldval == 'i')
		{
			$updtval = 'a';
		}
		$funcuqry = "update $tblname
				 	 set $updtfldnm = '$updtval'
				 	 where $idfldname = $recid";		
		mysqli_query($conn,$funcuqry);	
		if(mysqli_query($conn,$funcuqry))
		{
			return  "y";
		}
		else
		{
			return "n";
		}		
		$funcuqry = "";
	}
	function funcUpdtAllRecSts($tblnm,$idfldnm,$idval,$ufldnm){
			global $conn;

		$tblname 	= $tblnm;    // Stores the table name
		$idfldname  = $idfldnm;  //Stores the id field name
		$recid	 	= $idval;    // Stores the id value
		$updtfldnm  = $ufldnm;   // Stores the update field name
		$updtval 	= "";
			
		 $funcuqry = "update $tblname
				 	 	  set 
					      $updtfldnm =if($updtfldnm='a','i','a') 
				 	      where $idfldname in($recid)";	
						  	
		if(mysqli_query($conn,$funcuqry))
		{
			return  "y";
		}
		else
		{
			return "n";
		}		
		$funcuqry = "";
	}
	function funcDelRec($tblnm,$idfldnm,$idval)
	{
					global $conn;

		$tblname 	= $tblnm; // Stores the table name
		$idfldname  = $idfldnm; //Stores the id field name
		$recid	 	= $idval; // Stores the id value		
		$funcdqry = "delete from $tblname
				 	 where $idfldname = $recid";		
		if(mysqli_query($conn,$funcdqry))
		{
			return  "y";
		}
		else
		{
			return "n";
		}	
		$funcdqry = "";
	}	
	function funcDelAllRec($conn,$tblnm,$idfldnm,$idval)
	{
		global $conn;
		$tblname 	= $tblnm; // Stores the table name
		$idfldname  = $idfldnm; //Stores the id field name
		$recid	 	= $idval; // Stores the id value		
		$funcdqry = "delete from $tblname
				 	 where $idfldname in($recid)";		
		if(mysqli_query($conn,$funcdqry))
		{
			return  "y";
		}
		else
		{
			return "n";
		}	
		$funcdqry = "";
	}	
	function funcGetImg ($tblnm,$idval,$sidfldnm,$idfldnm)
	{
					global $conn;

		$tblname 	= $tblnm; // Stores the table name
		$sidfldname  = $sidfldnm; //Stores the id field name
		$idfldname  = $idfldnm; //Stores the id field name
		$recid	 	= $idval; // Stores the id value	
		$fieldval	= "";
		$funcsqry = "select $sidfldname from $tblname
				 	 	 where $idfldname in($recid)";	
		$funcsrs	= mysqli_query($conn,$funcsqry);
		while($funcsrow	= mysqli_fetch_array($funcsrs))
		{
			$fieldval	= $fieldval.",".$funcsrow[$sidfldname];
		}
		 $newfieldval = substr($fieldval,1);
		return $newfieldval;
		$funcsqry = "";	
		$newfieldval = "";
	}
	function funcRmvFle($tblnm,$updtfldnm,$updtfldval,$idfldnm,$idval)
	{
					global $conn;

		$tblname 	 = $tblnm; // Stores the table name
		$ufldname 	 = $updtfldnm; //Stores the update field name
		$ufldval  	 = $updtfldval; //Stores the update field name
		$idfldname   = $idfldnm; //Stores the id field name
		$recid	 	 = $idval; // Stores the id value
	    $funcuqry = "update $tblnm
					 set $ufldname = '$ufldval'
	    			 where $idfldnm = '$recid'";	
		if(mysqli_query($conn,$funcuqry))
		{
			return  "y";
		}
		else
		{
			return "n";
		}	
		$funcuqry = "";
	}
	/***************************************************/
	/********Function for displaying the status*********/
	/***************************************************/
	function funcDispSts($cursts){			
		$recsts = $cursts;		
		if($recsts == 'a'){
			return 'Active';			
		}
		elseif($recsts == 'i'){
			return 'Inactive';			
		}
	}
	function funcDispevnttyp($typ){			
		$evnttyp = $typ;		
		if($evnttyp == 'e'){
			return 'Event';			
		}
		elseif($evnttyp == 'n'){
			return 'News';			
		}
	}
	function funcDispcattyp($curtyp){			
		$rectyp = $curtyp;		
		if($rectyp == 'g'){
			return 'General';			
		}
		elseif($rectyp == 'd'){
			return 'Department';			
		}
		elseif($rectyp == 'm'){
			return 'Important Links';			
		}
		elseif($rectyp == 'f'){
			return 'Footer Menu';			
		}
	}
	
	function funcDispMedium($cursts)
	{			
		$recsts = $cursts;		
		if($recsts == 'a')
		{
			return 'All';
			
		}
		elseif($recsts == 'l')
		{
			return 'Languges Known';
			
		}
		elseif($recsts == 'm')
		{
			return 'Medium';
			
		}
	}	
	function funcDisptyp($cursts)
	{			
		$recsts = $cursts;		
		if($recsts == '1')
		{
			return 'Day';
			
		}
		elseif($recsts == '2')
		{
			return 'Month';
			
		}
		elseif($recsts == '3')
		{
			return 'Year';
			
		}
	}	
	/******************************************************/	
	/***************************************************/
	/********Function for displaying the current********/
	/***************************************************/
	function funcDispCrnt($cursts)
	{		
		$recsts = $cursts;		
		if($recsts == 'y')
		{
			return 'Yes';
		}
		elseif($recsts == 'n')
		{
			return 'No';
		}
	}		
	function funcDispPos($cursts)
	{		
		$recsts = $cursts;		
		if($recsts == 'l')
		{
			return 'Left';
		}
		elseif($recsts == 'r')
		{
			return 'Right';
		}
		elseif($recsts == 'c')
		{
			return 'Center';
		}
	}
	function get_months($date1,$date2)
	{ 
  		 $time1  = strtotime($date1); 
   		 $time2  = strtotime($date2); 
   		 $my     = date('mY', $time2); 
	     $months = array(date('F', $time1)); 
   		 $f      = ''; 
	     while($time1 < $time2) { 
			  $time1 = strtotime((date('Y-m-d', $time1).' +15days')); 
			  if(date('F', $time1) != $f) { 
				 $f = date('F', $time1); 
				 if(date('mY', $time1) != $my && ($time1 < $time2)) 
					$months[] = date('F', $time1); 
			  } 
		   } 
		  $months[] = date('F', $time2); 
         return $months; 
} 
function GetDays($sStartDate, $sEndDate)
{   
	 $sStartDate = date("Y-m-d", strtotime($sStartDate));   
	 $sEndDate   = date("Y-m-d", strtotime($sEndDate));   
 	 $aDays[] = $sStartDate;   
	 $sCurrentDate = $sStartDate;   
     while($sCurrentDate < $sEndDate)
	 {   
     	 $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));   
        $aDays[] = $sCurrentDate;   
     }   

     return $aDays;   
} 
function days_between($datefrom,$dateto)
{ 
    $fromday_start = mktime(0,0,0,date("m",$datefrom),date("d",$datefrom),date("Y",$datefrom)); 
	$diff = $dateto - $datefrom;  
    $days = intval( $diff / 86400 );
    if( ($datefrom - $fromday_start) + ($diff % 86400) > 86400 )   
	   $days++;    
	return  $days; 
}  
function weeks_between($datefrom, $dateto) 
{     
	$day_of_week = date("w", $datefrom);    
	$fromweek_start = $datefrom - ($day_of_week * 86400) - ($datefrom % 86400);  
	$diff_days = days_between($datefrom, $dateto);   
	$diff_weeks = intval($diff_days / 7);   
	$seconds_left = ($diff_days % 7) * 86400;   
	if( ($datefrom - $fromweek_start) + $seconds_left > 604800 )   
	   $diff_weeks ++;    
  return $diff_weeks;
 } 
 $month_array = array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July',
			  						  '8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
	function curPageName() {
					global $conn;

	 $pgnm = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	 $sqryhmpgnm_dtl ="select pgnmd_id from pgnm_dtl where pgnmd_name like '%$pgnm%'";
				$srshmpgnm_dtl  = mysqli_query($conn,$sqryhmpgnm_dtl);
				$srowhmpgnm_dtl = mysqli_fetch_array($srshmpgnm_dtl);
				$pageid = $srowhmpgnm_dtl['pgnmd_id'];
				return $pageid;
	 
	}
	function funcDispPyMd($cursts){	
		//Function for displaying payment mode		
		$recsts = $cursts;		
		if($recsts == 'vpp'){
			return 'V.P.P';			
		}
		else{
			return 'D.D/M.O/Cheque';			
		}
	}
	function funcDispOrdSts($cursts){	
		//Function for displaying payment mode		
		$recsts = $cursts;		
		if($recsts == 'p'){
			return 'Pending';			
		}
		elseif($recsts == 'c'){
			return 'Confirmed';			
		}
	}
	function funcBkTyp($cursts){	
		//Function for displaying payment mode		
		$recsts = $cursts;		
		if($recsts == '0'){
			return 'General';			
		}
		elseif($recsts == '1'){
			return 'New Arrival';			
		}
		elseif($recsts == '2'){
			return 'Best Seller';			
		}
		elseif($recsts == '3'){
			return 'CA Books';			
		}		
	}	
	function funcDsplyTyp($cursts){
		if($cursts == '1'){
			return 'General';
		}
		elseif($cursts == '2'){
			return 'Mega Menu';
		}
		else{
			return '';
		}	
	}
	function funcDsplyCattwoTyp($cursts){
		if($cursts == '1'){
			return 'Pagecontent';
		}
		elseif($cursts == '2'){
			return 'Photo Gallery';
		}
		elseif($cursts == '3'){
			return 'Video Gallery';
		}
		elseif($cursts == '4'){
			return 'Faculty';
		}		
		else{
			return '';
		}	
	}
	function funcDprtTyp($cursts){
		if($cursts == 'u'){
			return 'UG';
		}
		elseif($cursts == 'p'){
			return 'PG';
		}
		else{
			return '';
		}	
	}
	
	function funcDispBrndtyp($cursts){
		if($cursts == '1'){
			return 'Recruiters';
		}
		elseif($cursts == '2'){
			return 'Recognitions';
		}
		elseif($cursts == '3'){
			return 'Both';
		}
		else{
			return '';
		}	
	}
	function funcDispNwstyp($cursts){
		if($cursts == 'n'){
			return 'News';
		}
		elseif($cursts == 'l'){
			return 'Latest News';
		}
		else{
			return '';
		}	
	}
	
	function funcDispExmtyp($cursts){
		if($cursts == 'e'){
			return 'Exam';
		}
		elseif($cursts == 'l'){
			return 'Latest Exam';
		}
		else{
			return '';
		}	
	}
	
	function funcHmpgTyp($cursts){
		if($cursts == '1'){
			return 'Useful Links';
		}
		elseif($cursts == '2'){
			return 'Welcome Message';
		}
		elseif($cursts == '3'){
			return 'Top Links';
		}
		elseif($cursts == '4'){
			return 'Videos';
		}
		elseif($cursts == '5'){
			return 'Downloads';
		}
		else{
			return '';
		}	
	}
	
	


	function funcStrRplc($prmstr){		 

		$gnrtstr = strtolower(str_replace(' ','-',$prmstr));

		 $gnrtstr = strtolower(str_replace('.','-',$gnrtstr));

		  $gnrtstr = strtolower(str_replace(':','-',$gnrtstr));

		  $gnrtstr = strtolower(str_replace(',','-',$gnrtstr));



		return $gnrtstr;		 

	}	

	

	function funcStrRplcuscr($prmstr){		

		$gnrtstr = strtolower(str_replace('-','_',$prmstr));

		return $gnrtstr;		 

	}	

	function funcStrUnRplc($prmstr){	

		$gnrtstr = strtolower(str_replace('-',' ',$prmstr));

		return $gnrtstr;		

	}
?>