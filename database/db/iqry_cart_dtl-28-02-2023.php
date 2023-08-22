<?php
//session_start();
include_once "includes/inc_usr_sessions.php";	 //Including user session value
include_once "includes/inc_membr_session.php";//checking for session
include_once "includes/inc_connection.php";
include_once "includes/inc_usr_functions.php";
include_once "includes/inc_config.php";
?>
<style type="text/css">
body {
	background-color: #000000;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>

<?php		
include_once "includes/inc_membr_session.php";//checking for session	
	if(isset($_SESSION['cartcode']) && (trim($_SESSION['cartcode']) != ""))
	{
		$usrmsg = "<table width=\"1003\" height=\"100%\" border=\"0\" align=\"center\" cellpadding=\"20\" cellspacing=\"1\" bgcolor=\"#000000\">
		  <tr>
			<td><table border=\"0\" align=\"center\" cellpadding=\"14\" cellspacing=\"0\">
			  <tr>
				<td valign=\"middle\"><img src=\"images/loading.gif\" width=\"32\" height=\"32\" /></td>
				<td align=\"center\" valign=\"middle\" bgcolor=\"#F7F7F7\" class=\"confirmtitles\">Order is in process, please wait... </td>
			  </tr>
			</table></td>
		  </tr>
		</table>";		
		$crtsesval 	= session_id();	
		date_default_timezone_set('Asia/Kolkata'); 
		//$dt         = date('Y-m-d h:i:s');
		$dt         = date('Y-m-d');	 		
		$newdate	= date("d-m-Y h:i:s");
		$rmrks		= htmlentities($_POST['txtmsg'],ENT_QUOTES);
		$paysts		= "n";
		$cartsts	= "r";	
		$ccrdid 	= 'NULL';
		$rdflag		= 0;
		if($paymode == "b")
		{
			$rdflag		= 2; // Redirection to payment gateway
		}
		else{
			$rdflag		= 1; // Redirection to payment gateway
		}
		$xlcrdtflag = 1; // Xl Credit Insertion
		$crncyid	= $_SESSION['sescrncy'];
		$shpchrgprc	  =  $gselshpchrg;		
		$shipprc = 0;		
/*		if(isset($_SESSION['sesdlvrychrg']) && (trim($_SESSION['sesdlvrychrg']) != ""))
		{
			$shpchrgtyp	  	 = $_SESSION['sesdlvrychrg'];				
			$sqryshpchrg_mst = "select 
									shpchrgm_name,shpchrgm_prc,shpchrgm_desc 
								from 
									shpchrg_mst 
								where 
									shpchrgm_id='$shpchrgtyp'";							
			$srsshpchrg_mst  =  mysqli_query($conn,$sqryshpchrg_mst);
			$srowshpchrg_mst =  mysqli_fetch_array($srsshpchrg_mst);		
			$shipprc         = $srowshpchrg_mst['shpchrgm_prc'];
	   }
	   	if(isset($_SESSION['ses_crt_cpnid']) && (trim($_SESSION['ses_crt_cpnid']) != ""))
		{
				$cpnid		= $_SESSION['ses_crt_cpnid']; // Couopon id
				$sqrycpn_mst  =  "select 
										cpnm_id,cpnm_code,
										cpnm_typ,cpnm_val
								  from 
										 cpn_mst 
								  where 
										cpnm_id 	= '$cpnid' and
										cpnm_sts  	= 'a'";
																										  
				$srscpn_mst   = mysqli_query($conn,$sqrycpn_mst);
				$cntrec_cpn   = mysqli_num_rows($srscpn_mst);
				$srowcpnmst   = mysqli_fetch_assoc($srscpn_mst);
				$usrcpntyp    = $srowcpnmst['cpnm_typ'];
				$usrcpnval    = $srowcpnmst['cpnm_val'];
				$usrcpncode   = $srowcpnmst['cpnm_id'];
		}
		else
		{
			$cpnid		= 'NULL'; // Couoponid
		
		}*/
		$sqrycrtmbr_dtl_adrs  = "select * from 
									vw_mbr_mst_dtl_bil 
								 where 
									mbrm_id = '$membrid' 
									and (mbrd_dfltbil='y' or 
									mbrd_dfltshp='y') limit 2";
		//	echo $sqrycrtmbr_dtl_adrs; exit;
		$srscrtmbr_dtl   = mysqli_query($conn,$sqrycrtmbr_dtl_adrs);
		while($srowscrtmbr_dtl = mysqli_fetch_assoc($srscrtmbr_dtl))
		{
			if($srowscrtmbr_dtl['mbrd_dfltbil'] == 'y')
			{
				$bfname 	  = $srowscrtmbr_dtl['mbrd_fstname'];
				$blname		  = $srowscrtmbr_dtl['mbrd_lstname'];								
				$badrs	 	  = $srowscrtmbr_dtl['mbrd_badrs'];
				$badrs2   	  = $srowscrtmbr_dtl['mbrd_badrs2'];
				$bcmpny   	  = $srowscrtmbr_dtl['mbrd_cmpny'];
				$bcty	 	  = $srowscrtmbr_dtl['mbrd_bcty_id'];								
				$bcounty  	  = $srowscrtmbr_dtl['mbrd_bmbrcntym_id'];
				$bzip	 	  = $srowscrtmbr_dtl['mbrd_bzip'];								
				$bcountry 	  = $srowscrtmbr_dtl['mbrd_bmbrcntrym_id'];
				$bemail	 	  = $srowscrtmbr_dtl['mbrm_emailid'];
				$bph		  = $srowscrtmbr_dtl['mbrd_bdayphone'];	
				$bctyname	  = $srowscrtmbr_dtl['ctym_name'];	
				$bcntyname	  = $srowscrtmbr_dtl['cntym_name'];	
				$bcntryname	  = $srowscrtmbr_dtl['cntrym_iso'];
			}
			if($srowscrtmbr_dtl['mbrd_dfltshp'] == 'y')
			{
				$sfname 	  = $srowscrtmbr_dtl['mbrd_fstname'];
				$slname		  = $srowscrtmbr_dtl['mbrd_lstname'];	 
				$sadrs	  	  = $srowscrtmbr_dtl['mbrd_badrs'];
				$sadrs2   	  = $srowscrtmbr_dtl['mbrd_badrs2'];
				$scmpny   	  = $srowscrtmbr_dtl['mbrd_cmpny'];
				$scty	  	  = $srowscrtmbr_dtl['mbrd_bcty_id'];								
				$scounty  	  = $srowscrtmbr_dtl['mbrd_bmbrcntym_id'];
				$szip	  	  = $srowscrtmbr_dtl['mbrd_bzip'];								
				$scountry 	  = $srowscrtmbr_dtl['mbrd_bmbrcntrym_id'];
				$semail	  	  = $srowscrtmbr_dtl['mbrm_emailid'];
				$sph	  	  = $srowscrtmbr_dtl['mbrd_bdayphone'];	
				$sctyname	  = $srowscrtmbr_dtl['ctym_name'];	
				$scntyname	  = $srowscrtmbr_dtl['cntym_name'];	
				$scntryname	  = $srowscrtmbr_dtl['cntrym_iso'];	
			}	
		}	
		$crtwt		= "";
		$totqty		= $_SESSION['totqty'];	
		$totamt     = $_POST['hdngnetcartprc'];
		$shipprcAry     = explode("-",$_POST['hdnshpngchrgesid']);
    $shpchrgtyp        = $_POST['hdnmnshpprc'];
	  //echo  "Shipping".$shpchrgtyp;exit;
		$shipprc        = $_POST['hdnshpngchrgesid'];
    //$shpchrgtyp        = $shipprcAry[0];
		//$totamt		= $_SESSION['totamt'];	
		//$grsamt		= $totamt + $shipprc;
		$paygrsamt		= $totamt;	
		$disc = $_POST['txtdisamt'];
		$cpnid = $_POST['hdncpncde'];
		$cpnscat = $_POST['hdncpnscat'];
		$cpnval = $_POST['hdncpnval'];
		$gst = $_POST['txtgst'];	
		$hsn = $_POST['txthsncde'];	
		$pygtwy = $_POST['chkpay']; 
		$chkshop = $_POST['chkshop'];
		$paymode	= $pygtwy;	
		/*if(isset($_SESSION['ses_usdxlcrdt']) && (trim($_SESSION['ses_usdxlcrdt']) != ""))
		{
			$xlcrdtflag 	= 2;	
			$usdxlcrdt		= $_SESSION['ses_usdxlcrdt'];					
			$usdxlcrdtval	= 0;
			if($grsamt > $usdxlcrdt)
			{
				$grsamt 	 -= $usdxlcrdt; 
				$usdxlcrdtval = $usdxlcrdt;				
			}
			elseif($usdxlcrdt >= $grsamt)
			{
				$usdxlcrdtval = $grsamt;
				$grsamt  = 0;
				$rdflag  = 2; //Redirection to thank you page			
				$paymode = 'x';
				$paysts  = 'y';
			}
		}
		else
		{
			$usdxlcrdt		= '0.00';
		}*/			
		/*		if(isset($_POST['rdocrdtyp']) && (trim($_POST['rdocrdtyp']) != ""))
		{
			$ccrdid     = $_POST['rdocrdtyp'];
		}	
		*/		$ccrdid     = "e";				
		//$paygrsamt 	  = ($grsamt * 100);		
		$sqrycrtord_mst = "SELECT crtordm_id, crtordm_code from crtord_mst order by crtordm_crtdon desc limit 1"; 
		$srscrtord_mst  = mysqli_query($conn,$sqrycrtord_mst);
		$cntord_code	= mysqli_num_rows($srscrtord_mst);
		if($cntord_code > 0)
		{
			$srowcrtord_mst = mysqli_fetch_assoc($srscrtord_mst);
			$oldcrtord_code = $srowcrtord_mst['crtordm_code'];
			$oldcrtord_code1 = strrchr($oldcrtord_code, '-');
			$oldcrtord_code = substr($oldcrtord_code1, 1);
			$newcrtord_code = (int)$oldcrtord_code + 1;
		}
		else
		{
			$newcrtord_code = 1;
		}
		$codval = 0;	
		// if($paymode =='a'){
		// 	$codval = $_POST['hdncodprc'];;	
		// 	$paygrsamt = ($paygrsamt+$codval);
		// }
		//$shpchrgtyp = 0;
		$paymode = 'o';
		$dt = date('Y-m-d h:i:s');		
		$orddt = "LIA-".date('my')."-";
	 $newcrtord_code = $orddt.$newcrtord_code;
		$usrcpnval = 0;		
		$iqrycrtordmst = "INSERT into crtord_mst(
						   crtordm_code,crtordm_sesid,crtordm_fstname,crtordm_lstname,
						   crtordm_badrs,crtordm_badrs2,crtordm_bcmpny,crtordm_bmbrctym_id,crtordm_bmbrcntym_id,
						   crtordm_bzip,crtordm_bmbrcntrym_id,crtordm_bdayphone,crtordm_emailid,
						   crtordm_sfstname,crtordm_slstname,crtordm_sadrs,crtordm_sadrs2,crtordm_scmpny,
						   crtordm_smbrctym_id,crtordm_smbrcntym_id,crtordm_szip,crtordm_smbrcntrym_id,
						   crtordm_sdayphone,crtordm_semailid,crtordm_qty,crtordm_amt,crtordm_disamt,
						   crtordm_hsncde,crtordm_igst,		   
						   crtordm_prcssts,crtordm_cartsts,crtordm_pmode,
						   crtordm_paysts,crtordm_rmks,crtordm_mbrm_id,
						   crtordm_shpchrgm_id,crtordm_shpchrgamt,
						   crtordm_cpnm_id,crtordm_cpnm_typ,crtordm_cpnm_val,
						   crtordm_codamt,crtordm_crtdon,crtordm_crtdby) values(						
						   '$newcrtord_code','$crtsesval','$bfname','$blname',
						   '$badrs','$badrs2','$bcmpny','$bcty', '$bcounty',
						   '$bzip','$bcountry','$bph','$bemail',
						   '$sfname','$slname','$sadrs','$sadrs2','$scmpny',
						   '$scty','$scounty','$szip','$scountry',
						   '$sph','$semail','$totqty','$paygrsamt','$disc','$hsn','$gst',
						   'r','$cartsts','$paymode',
						   '$paysts','$rmrks','$membrid','$shipprc','$chkshop',
						   '$cpnid','$cpnscat','$cpnval',
						   '$codval','$dt','$membremail')";
				//echo $iqrycrtordmst; exit;																	   
		  $irscrtordmst		= mysqli_query($conn,$iqrycrtordmst) or die(mysqli_error());		
		  if($irscrtordmst == true)
			{	
				$ordmstid 		= mysqli_insert_id($conn);	 
				$cartval    	= $_SESSION['cartcode'];
			 	$prodidval  	= $_SESSION['prodid'];			 
			 	$prodqtyval 	= $_SESSION['prodqty'];
			 	$ses_crncynm	= $_SESSION['sescrncy'];					
			 	if(($cartval != "") && ($prodidval != "") && ($prodqtyval != ""))
				{
					$codearr	=	explode(",",$prodidval);
					$qtyarr		=	explode(",",$prodqtyval);	
					//print_r($qtyarr);exit;
					$newArray	=	$codearr;
					$items = explode(',',$cartval);				
					$totqty    = 0;
					$totxlcredits = 0;
					$totcartprc = 0;
					foreach ($items as $items_id=>$items_val)
					{					
						$totuntprc = 0;
						$totbilprc = 0;											
						$cartcodeid  = ""; //For Storing the cart value id
						$cartcodeval = ""; //For Storing the cart code value
						$cartcodeid  = $items_id;
						$cartcodeval = $items_val; //  Stores the cart detail value
						$arr_cartcodeval  = explode("-",$cartcodeval);
						$cart_prodid	  = trim($arr_cartcodeval[0],' '); // Stores the product id 
						$cart_prodprc	  = trim($arr_cartcodeval[1],' '); // Stores the product colour
						$cart_szid	  = trim($arr_cartcodeval[2],' '); // Stores the product colour
						$untqty 		  = trim($qtyarr[$cartcodeid],' '); // Stores the unit quantities
						$cart_ordsts	  = "a";
						$sqryprod_dtl1 = "SELECT  
						prodm_id,prodm_hsncde,prodm_sku,prodprcm_sleprc,prodprcm_ofrprc,prodscatm_igst
						from 
						prod_mst 
						inner join prodprc_mst on prodprcm_prodm_id = prodm_id 	
						inner join prodscat_mst on prodm_prodscatid = prodscatm_id									 
						where 
						prodm_id='$cart_prodid' and
						prodprcm_id ='$cart_prodprc'";
						$srsprod_dtl1  = mysqli_query($conn,$sqryprod_dtl1);				
						$srowprod_dtl1 = mysqli_fetch_assoc($srsprod_dtl1);
						$qty_val 		= $srowprod_dtl1['untm_qty'];
						$igst 		= $srowprod_dtl1['prodscatm_igst'];
						$cgst 		= $srowprod_dtl1['prodscatm_cgst'];
						$sgst		= $srowprod_dtl1['prodscatm_sgst'];
						
						if($srowprod_dtl1['prodprcm_ofrprc'] > 0)
						{					
							$produntprc = $srowprod_dtl1['prodprcm_ofrprc'];
						}
						else
						{
							$produntprc = $srowprod_dtl1['prodprcm_sleprc'];
						}
						//-----------------------------------Product Code---------------------------------------------------------------//
						/*
						$sqryprodgft_mst =  "select 
						prodgftm_id,prodgftm_name,prodgftm_desc,prodgftm_prc,prodgftm_sts,prodgftm_prty ,prodgftm_crtdon,prodgftm_crtdby
						from 	prodgft_mst
						where 
						prodgftm_sts = 'a' 
						and 
						prodgftm_id = $cart_gftid
						order by prodgftm_prty desc";								
						$srsprodgft_mst	  = mysqli_query($conn,$sqryprodgft_mst) or die(mysqli_error());
						$srowsprodgft_dtl = mysqli_fetch_assoc($srsprodgft_mst);
						$gift_prc = $srowsprodgft_dtl['prodgftm_prc'];
						$gift_id = $srowsprodgft_dtl['prodgftm_id'];   
						*/

						$sqryprodsz_dtl = "select 
						prodprcm_id,prodprcm_vrtn_id
						from 
						prodprc_mst 
						INNER JOIN  prodsz_vrtns_mst ON prodszvrtnm_id = prodprcm_vrtn_id										 
						where 
						prodprcm_id='$cart_prodprc'
						and
						prodprcm_prodm_id = '$cart_prodid'";
						
						//echo $sqryprodsz_dtl;
						$srsprodsz_dtl  = mysqli_query($conn,$sqryprodsz_dtl);				
						$srowprodsz_dtl  = mysqli_fetch_assoc($srsprodsz_dtl);
						$sz_id 		= $srowprodsz_dtl['prodprcm_id'];
						//$totuntprc    = ($untqty * $produntprc); 
						//$produntprc ;exit;
						$iqrycrtord_dtl  ="insert into crtord_dtl(
						crtordd_sesid,crtordd_prodm_id,
						crtordd_prc,crtordd_qty,crtordd_sgst,crtordd_cgst,crtordd_igst,
						crtordd_sizem_id,crtordd_prodprcd_id,crtordd_sts,crtordd_crtordm_id,crtordd_crtdon,
						crtordd_untm_qty,crtordd_crtdby)values(
						'$crtsesval','$cart_prodid','$produntprc','$untqty','$sgst','$cgst','$igst','$cart_szid',
						'$cart_prodprc','$cart_ordsts','$ordmstid','$dt',
						'$qty_val','$membremail')";
						//echo $iqrycrtord_dtl ;exit;
						$irscrtord_dtl	= mysqli_query($conn,$iqrycrtord_dtl)  or die(mysqli_error($conn));
						//-----------------------------------------------update--------------------------------------------------------------//
						$sqlprcdtl = "select prodprcd_id,prodprcd_qty 
						from
						prodprc_dtl
						where prodprcd_id = '$sz_id'";
						///echo $sqlprcdtl; exit;
						$resprcdtl = mysqli_query($conn,$sqlprcdtl);
						$rwsprcdtl = mysqli_fetch_array($resprcdtl);
						$prdqnty = $rwsprcdtl['prodprcd_qty'];
						$updtqty = $prdqnty-$untqty;

						if($prdqnty == 0){
						$updtqty = 0;
						}else{
						$updtqty = $updtqty;
						}
						$uqryprcdtl = "update prodprc_dtl set
						prodprcd_qty = $updtqty
						where prodprcd_id = '$sz_id'";
						$resprcdtl = mysqli_query($conn,$uqryprcdtl);
						//  echo $uqryprcdtl; exit;
						//-----------------------------------------------update--------------------------------------------------------------//				
					}		// End of For each		
				}				
				if($irscrtord_dtl==true)
				{
					//	echo "-------------------------"."hello"; exit;
					$sqryordsts_mst="select ordstsm_id from ordsts_mst where ordstsm_sts='a' order by ordstsm_prty asc limit 1";
					$irsordsts_mst  = mysqli_query($conn,$sqryordsts_mst);
					$srowordsts_mst = mysqli_fetch_assoc($irsordsts_mst);
					$newid=$srowordsts_mst['ordstsm_id'];
					$iqryordsts_dtl="insert into ordsts_dtl(
								 ordstsd_ordstsm_id,ordstsd_crtordm_id,ordstsd_dttm,
								 ordstsd_crtdon,ordstsd_crtdby) values(
								'$newid','$ordmstid','$dt',
								'$dt','$membremail')";
								//echo $iqryordsts_dtl; exit;
					$irsordsts_dtl		  = mysqli_query($conn,$iqryordsts_dtl);
					unset($_SESSION['cartcode']);
				 	unset($_SESSION['prodid']);
				 	unset($_SESSION['prodqty']);
				 	unset($_SESSION['cart']);
				 	unset($_SESSION['prodgft']);
				 	unset($_SESSION['sescrncy']);
				 	$_SESSION['cartcode']	= '';
				 	$_SESSION['prodid']	= '';
				 	$_SESSION['prodqty']	= '';	
				 	$_SESSION['prodprc']	= '';	
				 	$_SESSION['cart']		= '';	
					// session_destroy();
				 	$sqrycrtord_mst = "select
									crtordm_id,crtordm_code,crtordm_fstname,crtordm_lstname, 
									crtordm_badrs,crtordm_badrs2,crtordm_bcmpny,
									blcty.ctym_name as bctynm,blcnty.cntym_name as bcntynm,
									crtordm_bzip,blcntry.cntrym_name as bcntrynm,crtordm_bdayphone,
									crtordm_emailid,crtordm_sfstname,crtordm_slstname,crtordm_sadrs,
									crtordm_sadrs2,crtordm_scmpny,shpcty.ctym_name as sctynm,
									shpcnty.cntym_name as scntynm,
									shpcnty.cntym_id as scntyid,
									crtordm_szip,shpcntry.cntrym_name as scntrynm,crtordm_codamt,
									crtordm_sdayphone,crtordm_semailid,crtordm_qty,crtordm_amt,crtordm_wt,
									crtordm_pmode,crtordm_prcssts,crtordm_cartsts,crtordm_paysts,crtordm_rmks,
									crtordm_shpchrgm_id,crtordm_shpchrgamt,crtordm_cpnm_val,crtordm_mbrm_id,
									crtordm_ordtyp,date_format(crtordm_crtdon,'%d-%m-%Y') as crtordm_crtdon_dt,
									date_format(crtordm_crtdon,'%h:%i:%s') as crtordm_crtdon_tm,
									crtordm_hsncde,crtordm_igst,cpnm_name,crtordm_cpnm_id,crtordm_cpnm_typ								
							  from
									crtord_mst crtord 
									left join cty_mst blcty on blcty.ctym_id = crtord.crtordm_bmbrctym_id
									left join cty_mst shpcty on shpcty.ctym_id = crtord.crtordm_smbrctym_id 
									
									left join cnty_mst blcnty on blcnty.cntym_id = blcty.ctym_cntym_id 
									left join cnty_mst shpcnty on shpcnty.cntym_id = shpcty.ctym_cntym_id
									
									left join cntry_mst blcntry on blcntry.cntrym_id= blcnty.cntym_cntrym_id 
									left join cntry_mst shpcntry on shpcntry.cntrym_id= shpcnty.cntym_cntrym_id	
									left join shpng_mst on crtord.crtordm_shpchrgm_id = shpngm_id	
								    left join cpn_mst on cpn_mst.cpnm_id = crtordm_cpnm_id 
								
								where 
									crtordm_id = '$ordmstid'";
									//echo $sqrycrtord_mst; exit;
					$srscrtord_mst = mysqli_query($conn,$sqrycrtord_mst);
					$cntord_rec	   = mysqli_num_rows($srscrtord_mst);
					if($cntord_rec > 0)
					{			
						$srowcrtord_mst = mysqli_fetch_assoc($srscrtord_mst);
						$crtord_id	= $srowcrtord_mst['crtordm_id'];											
						$bfname  	= $srowcrtord_mst['crtordm_fstname'];
						$blname	  	= $srowcrtord_mst['crtordm_lstname'];	
						$bemail 	= $srowcrtord_mst['crtordm_emailid'];
						$ordcode 	= $srowcrtord_mst['crtordm_code'];
						$ordmid	 	= base64_encode($srowcrtord_mst['crtordm_id']);
						$orddate 	= $srowcrtord_mst['crtordm_crtdon_dt']." ".$srowcrtord_mst['crtordm_crtdon_tm'];
						// $shipname 	= $srowcrtord_mst['shpchrgm_name'];	 
						$shpprc  	= $srowcrtord_mst['crtordm_shpchrgamt'];
						$sfname   	= $srowcrtord_mst['crtordm_sfstname'];	 
						$slname	  	= $srowcrtord_mst['crtordm_slstname'];	 			   
						$sadrs	  	= $srowcrtord_mst['crtordm_sadrs'];
						$sgst   	= $srowcrtord_mst['crtordm_sadrs2'];
						$scom   	= $srowcrtord_mst['crtordm_scmpny'];
						$scty 	  	= $srowcrtord_mst['sctynm'];
						$scounty  	= $srowcrtord_mst['scntynm'];
						$scountyid  = $srowcrtord_mst['scntyid'];
						$scountry 	= $srowcrtord_mst['scntrynm'];
						$badrs	  	= $srowcrtord_mst['crtordm_badrs'];
						$bgst   	= $srowcrtord_mst['crtordm_badrs2'];
						$bcom   	= $srowcrtord_mst['crtordm_bcmpny'];
						$bcty 	  	= $srowcrtord_mst['bctynm'];
						$bcounty  	= $srowcrtord_mst['bcntynm'];
						$bcountry 	= $srowcrtord_mst['bcntrynm'];
						$bzip	  	= $srowcrtord_mst['crtordm_bzip'];		
						$bemail	  	= $srowcrtord_mst['crtordm_emailid'];
						$bphno	  	= $srowcrtord_mst['crtordm_bdayphone'];
						$szip	  	= $srowcrtord_mst['crtordm_szip'];		
						$semail	  	= $srowcrtord_mst['crtordm_semailid'];	
						$sphno	  	= $srowcrtord_mst['crtordm_sdayphone'];
						$ordamt	  	= $srowcrtord_mst['crtordm_amt'];
						$shpamt	  	= $srowcrtord_mst['crtordm_shpchrgamt'];
						$crtwt	  	= $srowcrtord_mst['crtordm_wt'];
						$totcrtprc 	= $ordamt + $shipprc;
						// $srowcrtord_mst['crtordm_pmode'];
						$db_pmode 	= funcPayMod($srowcrtord_mst['crtordm_pmode']);
						//$db_pmode 	= $srowcrtord_mst['shpchrgm_name'];
						$dispsy 	= funcDispCrnt($srowcrtord_mst['crtordm_paysts']);
						$db_ordqty	= $srowcrtord_mst['crtordm_qty'];
						$db_ordamt	= $srowcrtord_mst['crtordm_amt'];
						$db_ordrmks	= $srowcrtord_mst['crtordm_rmks'];
						$db_codamt	= $srowcrtord_mst['crtordm_codamt'];
						$hsncde	= $srowcrtord_mst['crtordm_hsncde'];
						$crtgst	= $srowcrtord_mst['crtordm_igst'];
						$shpmnid  = $srowcrtord_mst['crtordm_shpchrgm_id']; 
						$cupid  = $srowcrtord_mst['crtordm_cpnm_id'];
						$cupnm  = $srowcrtord_mst['cpnm_name'];
						$cupval  = $srowcrtord_mst['crtordm_cpnm_val'];
						$cuptyp  = $srowcrtord_mst['crtordm_cpnm_typ'];
						$shpchrges_qry = "SELECT shpngm_id,shpngm_prc from shpng_mst where shpngm_sts = 'a' and shpngm_id = '$shpmnid'";
						$shpngchrges_mst = mysqli_query($conn,$shpchrges_qry);
						$num_rows = mysqli_num_rows($shpngchrges_mst);
						if($num_rows > 0 )
						{
							$shpngchrges_dtl = mysqli_fetch_assoc($shpngchrges_mst);
							$shpmnprc = $shpngchrges_dtl['shpngm_prc'];
						} 
						if(($scounty == "Telangana")||($scountyid == 115))
						{
							$nmstrws = 1;
						}			
						//$dispsy    ="No";
						$shpcmpltadrs ="";					
						if($sfname != ''){
							$shpcmpltadrs = $sfname;	
						}						 
						if($slname != ''){
							$shpcmpltadrs .= "&nbsp;".$slname;	
						}
						if($sadrs != ''){
							$shpcmpltadrs .= "<br>".$sadrs;	
						}						 
						if($sgst != ''){
							$shpcmpltadrs .= ",&nbsp;GST Number :&nbsp;".$sgst;	
						}
							if($scom != ''){
							$shpcmpltadrs .="<br>". ",&nbsp;Company :&nbsp;".$scom;	
						}						 
						if($scty != ''){
							$shpcmpltadrs .= "<br>".$scty;	
						}						 
						if($scounty != ''){
							$shpcmpltadrs .= ",&nbsp;".$scounty;	
						}						 
						if($scountry != ''){
							$shpcmpltadrs .= "<br>".$scountry;	
						}						 
						if($szip != ''){
							$shpcmpltadrs .= ",&nbsp;Zip Code :&nbsp;".$szip;	
						}
						if($sphno != ''){
							$shpcmpltadrs .= "<br>Mobile No :&nbsp;".$sphno;	
						}	
						if($bemail != ''){
							$shpcmpltadrs .= "<br>".$bemail;	
						}
						$blngcmpltadrs ="";					
						if($bfname != ''){
							$blngcmpltadrs = $bfname;	
						}						 
						if($blname != ''){
							$blngcmpltadrs .= "&nbsp;".$blname;	
						}						 
						if($badrs != ''){
							$blngcmpltadrs .= "<br>".$badrs;	
						}						 
						if($bgst != ''){
							$blngcmpltadrs .= ",&nbsp;GST Number :&nbsp;".$bgst;	
						}
							if($bcom != ''){
							$blngcmpltadrs .="<br>". ",&nbsp;Company :&nbsp;".$bcom;	
						}						 
						if($bcty != ''){
							$blngcmpltadrs .= "<br>".$bcty;	
						}						 
						if($bcounty != ''){
							$blngcmpltadrs .= ",&nbsp;".$bcounty;	
						}						 
						if($bcountry != ''){
							$blngcmpltadrs .= "<br>".$bcountry;	
						}						 
						if($bzip != ''){
							$blngcmpltadrs .= ",&nbsp;Zip Code :&nbsp;".$bzip;	
						}
						if($bphno != ''){
							$blngcmpltadrs .= "<br>Mobile No :&nbsp;".$bphno;	
						}
						if($bemail != ''){
							$blngcmpltadrs .= "<br>".$bemail;	
						}	   
			    	$dt = "DEL-".date('my')."-";
						$hdimg    = "http://".$u_prjct_mnurl."/".$site_logo;//Return the URL	
						$orddate	= date('l jS F Y',strtotime($orddate));	
						$msgbody="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
						<html>
						<head>
						<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
						<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
						<title>$usr_cmpny | Order has been logged, payment is pending</title>
						<style type='text/css'>
						#outlook a{padding:0}body{width:100% !important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;background-color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:12px}p{margin-top:0;margin-bottom:10px}table td{border-collapse:collapse}table{border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt}img{outline:none;text-decoration:none;-ms-interpolation-mode:bicubic}a img{border:none}.image_fix{display:block} a{color:#109547; text-decoration:none;} a:hover{color:#ea7724; text-decoration:none;}
						</style>
						</head>
						<body style='margin:0; background-color:#ffffff;' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
						<div style='background-color:#fff;'>
							<table style='background-color: #ffffff;' width='100%' border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td><table style=' background-color:#ffffff' background='#ffffff' width='605' border='0' align='center' cellpadding='20' cellspacing='0'>
									<tr>
									<td valign='top' bgcolor='#ffffff'><table width='181' border='0' align='left' cellpadding='0' cellspacing='0'>
										<tr>
											<td valign='top' align='center' bgcolor='#FFFFFF'><a href='".$u_prjct_mnurl."home' ><img src='".$hdimg."' alt='$usr_cmpny'  border='0'></a></td>
										</tr>
										</table></td>
									</tr>
								</table>
								<table style='background-color:#ffffff;padding:0' background='#ffffff' width='605' border='0' align='center' cellpadding='0' cellspacing='0'>
									<tr>
									<td valign='top' bgcolor='#ffffff'>
										<h2 style='margin-top:5px; margin-bottom:5px; font-family:Arial, Helvetica, sans-serif;font-size:25px'>Order Information</h2></td>
									</tr>
									<tr>
									<td height='4' valign='top' bgcolor='#cccccc' class='spacer'    style='margin-top:0;margi n-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
									</tr>
									<tr>
									<td height='10' valign='top' bgcolor='#fff' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
									</tr>
									<tr>
									<td valign='top' bgcolor='#ffffff'><p style='font-family:Arial, Helvetica, sans-serif; font-size:14px;'>Dear $bfname,</p>
									<p style='font-family:Arial, Helvetica, sans-serif; font-size:14px;'>Thank you for placing your order. </p>
										</td>
									</tr>
								</table>
								<table width='605' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#ffffff' style='background-color:#ffffff'>
									<tr>
									<td  bgcolor='#ffffff' ><p style='color:#d31b12; font-family:Arial, Helvetica, sans-serif; margin-top:5px; margin-bottom:5px'>Address Details:</p></td>
									</tr>
									<tr>
									<td ><table width='605' border='1' cellspacing='0' cellpadding='5' bordercolor='#dfdfdf' style='border:1px solid #dfdfdf'>
										<tr>
											<td align='center'><p style='color:#d31b12'>Billing Address</p></td>
											<td align='center'><p style='color:#d31b12'>Shipping Address</p></td>
										</tr>
										<tr>
											<td>$blngcmpltadrs</td>
											<td>$shpcmpltadrs</td>
										</tr><tr>
										<tr>
											<td align='center'><p style='color:#d31b12'>Payment Mode</p></td>
											<td align='center'><p style='color:#d31b12'>Payment Status</p></td>
											</tr>
											<tr><td align='center'>$db_pmode</td>
											<td align='center'>$dispsy</td></tr></tr>
										</table></td>
									</tr>
									<tr>
									<td height='10'  bgcolor='#ffffff' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
									</tr>
								</table>
								<table width='605' border='1' align='center' cellpadding='5' cellspacing='0' bordercolor='#dfdfdf' style='border:1px solid #dfdfdf' >
									<tr valign='top'>
									<td align='center' ><p style='color:#d31b12'>Order No</p></td>
									<td align='center'><p style='color:#d31b12'>Order Date</p></td>
								
									</tr>
									<tr valign='top'>
									<td align='center'  >$ordcode</td> 
									<td align='center' >$orddate</td>
									
									</tr> 
								</table>
								<table align='center'  cellpadding='0' cellspacing='0' bgcolor='#ffffff' style='background-color:#ffffff'>
									<tr>
									<td><p style='color:#d31b12;font-family:Arial, Helvetica, sans-serif;margin-top:5px; margin-bottom:5px'>Your Recent Order:</p></td>
									</tr>
									<tr>
									<td><table width='100%' cellpadding='5' cellspacing='0' border='1' bordercolor='#dfdfdf' style='border:1px solid #dfdfdf'>
										<tr >
											<td  valign='middle' colspan='2'><p style='color:#d31b12'>Product</p></td>
											<td  valign='middle'><p style='color:#d31b12'>Price</p></td>";
									  	if($nmstrws == 1)
											{ 
										 		$msgbody.=" <td  valign='middle'><p style='color:#d31b12'>CGST</p></td>
    									  <td  valign='middle'><p style='color:#d31b12'>SGST</p></td>"; 
										  }
											else
											{
		  								$msgbody.=" <td  valign='middle'><p style='color:#d31b12'>TAX</p></td>";
											}
	 										$msgbody.="<td  valign='middle'><p style='color:#d31b12'>Price + Tax</p></td><td  valign='middle'><p style='color:#d31b12'>Qty</p></td><td align='right' valign='middle'><p style='color:#d31b12'>Total Price</p>                                </td>
										</tr>";
										//Your order has been logged and we are waiting for the payment. Once we received the payment the order will be confirmed and expected date of dispatch of your order is $orddate
													/* $sqrycrtord_dtl ="select 
																			prodm_code,prodm_hsn,prodm_gst,crtordd_id,crtordd_qty,crtordd_prc,
																			(crtordd_prc * crtordd_qty) as crtorddprd_prc,prodprcd_prc,
																			crtordd_prc as unprcval,prodm_name,untm_name,concat(szd_name,' ',szm_name) as szd_name
																	  from 
																			crtord_dtl 
																	  inner join 
																			vw_prod_unt_dtl 
																	  on 
																			(crtordd_prodm_id=prodm_id)
																	  where 
																			crtordd_crtordm_id=$ordmstid
													  group by prodm_id,untm_id order by untm_prty desc";*/
										$sqrycrtord_dtl =	"SELECT  crtordd_id, crtordd_qty,(crtordd_prc * crtordd_qty) as crtordd_prc,prodm_id,prodm_name, crtordd_prc as unprcval,prodszvrtnm_vrtn_nms,prodszvrtnm_id,prodprcm_id,prodprcm_sku,prodprcm_sleprc,prodprcm_ofrprc ,prodm_name,crtordd_igst,crtordd_cgst,crtordd_sgst
										from crtord_dtl 
										inner join prod_mst on prod_mst.prodm_id = crtord_dtl.crtordd_prodm_id 
										inner join prodsz_vrtns_mst on prodszvrtnm_id = crtordd_sizem_id 
										inner join prodprc_mst on crtordd_prodprcd_id = prodprcm_id where crtordd_crtordm_id=$ordmstid	";	
										//concat(szd_name,' ',szm_name) as			  
										$srscrtord_dtl = mysqli_query($conn,$sqrycrtord_dtl);
										$cnttorec      = mysqli_num_rows($srscrtord_dtl);
										if($cnttorec > 0)
										{	
											$totcrtprc = "";						
											while($rowspo_mst=mysqli_fetch_assoc($srscrtord_dtl))
											{
									  		$prdgst =$rowspo_mst['prodm_gst'];
														    
												$db_shpprc = ($rowspo_mst['crtordd_qty']*$rowspo_mst['crtordd_shpprc']);
															$msgbody.="<tr>
															<td colspan='2'>Name: $rowspo_mst[prodm_name]<br/>
															Code: $rowspo_mst[prodprcm_sku] <br/>
															Size: $rowspo_mst[prodszvrtnm_vrtn_nms]</td>
															  ";

                              $prdtotprc = $rowspo_mst['unprcval'];
															$igstval = $rowspo_mst['crtordd_igst'];
															
																				 $gstval = $igstval;
														  
														  $gst = 1+($gstval/100);
														 
														   $prdprc  = $prdtotprc/$gst;
															$prdwoustgst = $prdprc; 
															$tax = $prdtotprc - $prdwoustgst;
															$totalprdprc +=	$prdprc;	
														$prdprc  =  number_format($prdprc,2,'.',',');
														$tax     = number_format($tax,2,'.',',');
														$clid = 6;
														if($nmstrws == 1){
															$gstdiv =  $tax/2;
															 $cgst =  number_format($gstdiv,2,'.',',');
															 $sgst =  number_format( $gstdiv,2,'.',',');
															$gstper = ($gstval/2)."%";
															$clid = 7;
															}
															$igstper  = $gstval."%";					
																						
														$msgbody.="
														<td valign='right'>$prdprc</td>";
														if($nmstrws == 1){
															$totalcgst += $cgst;
															$totalsgst += $sgst;
											$msgbody.="<td valign='right'>$cgst<br>$gstper</td>
														<td valign='right'>$sgst<br>$gstper</td>
														";		
															}else{
																$totaltax += $tax;
										$msgbody.="<td valign='right'>$tax<br>($igstper)</td>
										";		
																
															}
															
															$totalqnty +=  $rowspo_mst['crtordd_qty'];
															$totlprodtotprc += $prdtotprc;
																				$msgbody.="<td>$prdtotprc</td><td>$rowspo_mst[crtordd_qty]</td><td align='right' valign='right'>";
																				$totitmprc = ($rowspo_mst['crtordd_prc']); 
																					$ntitmprc += $totitmprc;
																				
																				$totcrtprc +=  $totitmprc+$db_shpprc;
																												
																				
																				
																				$untbx_prc 		   = ($rowspo_mst['crtordd_prc'] + $rowspo_mst['crtordd_shpprc']);
																			
																				$msgbody.=   number_format($totitmprc+$db_shpprc,2,".",",")."
																				</td>
																				
																										
																			
																			
																			
																			
																											
																											</tr>";							
																										}
																									}		
																									$grscrtprc = $totcrtprc + $shpmnprc;
																					//	echo "%%%%%%".$shipprc;			
																					$msgbody.="<tr><td colspan='2'></td>
																					";
																					$totalprdprc =  number_format($totalprdprc,2,'.',',');
																					$msgbody.="<td>$totalprdprc</td>";
																					if($nmstrws == 1){
																						$msgbody.="<td>$totalcgst</td>";
																						$msgbody.="<td>$totalsgst</td>";
																					}else{
																						$msgbody.="<td>$totaltax</td>";
																					}
																					$prodcost = number_format($ntitmprc,2,'.',',');
																						$msgbody.="<td>$totlprodtotprc</td><td>$totalqnty</td>
																						
																					<td align='right'>Product Cost:$prodcost";
																									/*if($shipprc > 0){ }
																										$msgbody.="<br/>Ship Cost:";*/
																										
																							if($db_codamt > 0){
																								$grscrtprc = ($grscrtprc+$db_codamt);
																								$codammt = number_format($db_codamt,2,'.',',');
																								}
																							if($db_codamt > 0){
																								$msgbody.="<br/>COD Cost:$codammt";
																							}
																						
																							if($cupid!=0){
																								$msgbody.= "<br><b>Coupon(Applied)-$cupnm : </b>";
																							

																								$totlprdprc -= $cupval;
													
																								$msgbody.= "-<b>$cupval </b>"; 
													
																																}
																														
																															$shpngchrges = number_format($shpmnprc,2,'.',',');
																										if($totcrtprc < 600){
																					$totcrtprc +=  $shpmnprc;
																					
																					$msgbody.= "<br><b>SHIPPING CHARGES :$shpngchrges</b>";
																															
																					}else{
																				
																						
																				$totcrtprc +=  $shpprc;		
														//	$msgbody.= "<br><strong>Shipping Charges Not Appilcable for More than 3000 Purchase: </strong>";
																$msgbody.= "<br><strong>Shipping Charges :$shpngchrges </strong>";
															
																						}
																										
												  
												   if($db_codamt > 0){
														$msgbody.="<br/>COD Cost:";
												   }
												   $msgbody.="</td>";
								
									  // <td align='right' valign='middle'>".number_format($ntitmprc,2,'.',',');
											// 	 if($cupid!=0){
										   
										  // $totlprc -= $cupval;
							        // $msgbody.= "<br><b>-$cupval </b>";
                      //        				 }else{
											//  }
											// 	  if($totcrtprc < 0){
											// 		$msgbody.="<br/>".number_format($shpmnprc,2,'.',',');
												  
											// 	  }else{
													  
		  								// 		 $msgbody.="<br/>".number_format($shpmnprc,2,'.',',');

											// 		  }
											// 	  if($db_codamt > 0){
											// 		$grscrtprc = ($grscrtprc+$db_codamt);
											// 		$msgbody.="<br/>".number_format($db_codamt,2,'.',',');
											// 	  }
												$msgbody.="</tr>";
					
												$msgbody.="<tr>
										<td colspan='$clid'  align='right'>Order Amount: </td>
										<td align='right' valign='middle'>";
										if($cupval >0){
										
									//	echo "$$$$".$grscrtprc;exit;
										
										$grscrtprc= $grscrtprc-$cupval;
											}else{
											$grscrtprc= $grscrtprc;  
												}
									$msgbody.= number_format($grscrtprc,2,'.',',')."</td>
													</tr>";
									$msgbody.="<tr>
														<td  colspan='$clid' align='right'>Payment : </td>
														<td align='right' valign='middle'>".number_format($grscrtprc,2,'.',',')."</td>
													</tr>";
												$msgbody .=	"</table></td>
													</tr>
							</table>
							<table width='605' border='0' align='center' cellpadding='0' cellspacing='0'>
							  <tr>
							    <tr>
								<td height='10'  bgcolor='#ffffff' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
							  </tr>
								<td><p>For suggestions / support please feel free to email us at <a href='mailto:info@liamsons.com' style='color:#d31b12;  text-decoration:none'>info@liamsons.com</a>.</p>
								  <p>Sincerely, <br>

									Customer Service,<br>

									
						                 $usr_cmpny<br><br>

								  </p></td>
							  </tr>
							</table></td>
						</tr>
					  </table>
					  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                  <td align='center'><strong>liamsons Industries.</strong><br />
										
										Shop on www.liamsons.com</td>
                </tr>
              </table>
					</div>
					</body>
					</html>";				
					$to       = $bemail;
					$from     = $u_prjct_email;
					$subject  = " $usr_cmpny order " .$ordcode." has been Placed";
					$headers  = "From: " . $from . "\r\n";
					$headers .= "CC: ".$from ."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					
				//echo $msgbody; exit;
					mail($to,$subject,$msgbody,$headers);	
			}				
			
				//if($paymode =='a'){
				
					
					
					
					// $action = '../ccavRequestHandler.php';				 

				?>

					<!-- <form action="<?php echo $action;?>" method="post" name="frmpymntccav" id="frmpymntccav">   

					  <input type="hidden" name="tid"  value="<?php echo $ordmstid;?>" /> 

					  <input type="hidden" name="merchant_id" value="67647" />

					  <input type="hidden" name="order_id" value="<?php echo $ordmstid;?>"/>

					  <input type="hidden" name="amount"  value="<?php echo $paygrsamt;?>"/>

					  <input type="hidden" name="currency"  value="INR" />

					  <input type="hidden" name="redirect_url"  value="http://<?php echo $u_prjct_mnurl;?>/successtran" />

					  <input type="hidden" name="cancel_url" value="http://<?php echo $u_prjct_mnurl;?>/successtran" />

					  <input type="hidden" name="language" value="EN" />

					  <input type="hidden" name="billing_name" value="<?php echo $bfname." ".$blname;?>"/>

					  <input type="hidden" name="billing_address" value="<?php echo $badrs." ".$badrs2;?>">  

                      <input type="hidden" name="billing_city" value="<?php echo $bctyname;?>">  

                      <input type="hidden" name="billing_state" value="<?php echo $bcntyname;?>">  

                      <input type="hidden" name="billing_zip" value="<?php echo $bzip;?>">

					  <input type="hidden" name="billing_country" value="<?php echo $bcntryname;?>"> 	

                      <input type="hidden" name="billing_tel" value="<?php echo $bph;?>"> 	

                      <input type="hidden" name="billing_email" value="<?php echo $bemail;?>"> 	

                      <input type="hidden" name="delivery_name" value="<?php echo $sfname." ".$slname;?>"> 

                      <input type="hidden" name="delivery_address" value="<?php echo $sadrs." ".$sadrs2;?>"> 

                      <input type="hidden" name="delivery_city" value="<?php echo $sctyname;?>"> 

                      <input type="hidden" name="delivery_state" value="<?php echo $scntyname;?>"> 

                      <input type="hidden" name="delivery_zip" value="<?php echo $szip;?>"> 

                      <input type="hidden" name="delivery_country" value="<?php echo $scntryname;?>"> 

                      <input type="hidden" name="delivery_tel" value="<?php echo $sph;?>"> 

                      <input type="hidden" name="merchant_param1" value="<?php echo $_SESSION['sesmbremail'];?>"> 

                      <input type="hidden" name="merchant_param2" value="<?php echo $_SESSION['sesmbrid'];?>"> 

                      <input type="hidden" name="merchant_param3" value="<?php echo $crtsesval;?>"> 

                      <input type="hidden" name="merchant_param4" value=""> 

                      <input type="hidden" name="merchant_param5" value=""> 

					</form>          				  -->

					<!-- <script language="javascript" type="text/javascript">

						document.getElementById('frmpymntccav').action = "<?php echo $action;?>";

						document.getElementById('frmpymntccav').submit();

					</script> -->

					
					
				<!---	<script>
						location.href = "thankyou";   
					    
					</script>--->
					
						             <?php
									
									$Rzaction = $rtpth."razorpay/pay.php";
									
									?>
									<form method="POST" name="frmpymntRzrpy" id="frmpymntRzrpy" action="<?php echo $Rzaction ?>">
										<input type="hidden" name="hdntxnid" value="<?php echo $ordcode;?>"/>
										<input type="hidden" name="hdnodrid" value="<?php echo $ordmstid;?>"/>
										<input type="hidden" name="hdnordcode" value="<?php echo $newcrtord_code; ?>"/>
										<input type="hidden" name="hdnamount" id="hdnamount" value="<?php echo number_format($grscrtprc,2,'.',','); ?>"/>
										<input type="hidden" name="hdnproductinfo" id="hdnproductinfo" value="" size="64"/>
										<input type="hidden" name="hdnfirstname" id="hdnfirstname" value="<?php echo $bfname;?>"/>
										<input type="hidden" name="hdnemail" id="hdnemail" value="<?php echo $bemail;?>"/>
										<input type="hidden" name="hdnphone" id="hdnphone" value="<?php echo $bph;?>"/>
									</form>
									
									<script language="javascript" type="text/javascript">
										document.getElementById('frmpymntRzrpy').action = "<?php echo $Rzaction;?>";
										document.getElementById('frmpymntRzrpy').submit();
									</script>
									<?php
			}
		}
		else{
			$msg = "Some error in your cart. Please contact customer care";
		}
	}
	else{
	?>
			<script language="javascript" type="text/javascript">
				location.href = '<?php echo $_SERVER['HTTP_HOST'];?>';
			</script>	
	<?php
	}
	?>		