<?php	
	include_once  "../includes/inc_nocache.php";     //Clearing the cache information
	include_once "../includes/inc_adm_session.php";  //checking for session
	include_once "../includes/inc_connection.php";   //Making database Connection
	include_once "../includes/inc_usr_functions.php";//Use function for validation and more 
	// $prdt = "Too-".date('my')."-";
	$cur =  date('y');
	$nxt =  date('y', strtotime('+1 year'));
	$prdt = "FY".$cur ."-".$nxt."MAN-";
	if(isset($_POST['btnupd']) &&
	isset($_POST['hdnordid']) && (trim($_POST['hdnordid']) != "") &&
	isset($_POST['txtdt']) && (trim($_POST['txtdt']) != ""))
	{
		$orderid    = glb_func_chkvl($_POST['hdnordid']);
		$desc       = addslashes(trim($_POST['txtdesc']));
		$stsdt      = glb_func_chkvl($_POST['txtdt']);
		$paymod      = glb_func_chkvl($_POST['hdnpaymod']);
		//echo  $stsdt    	= dateFormat('Y-m-d h:i:s', strtotime($sdate));
		$stsid		= glb_func_chkvl($_POST['ordsts']);
		$crnt_dt         = date('Y-m-d h:i:s');		
		$cstsprty   = glb_func_chkvl($_POST['hdnordsts']);
		$sqryordstsnm_mst  ="SELECT 
		ordstsm_id,ordstsm_name 
		FROM 
		ordsts_mst
		WHERE 
		ordstsm_id='$stsid' 
		";	
		// echo   $sqryordstsnm_mst;					  exit;
		$srsordstsnm_mst   = mysqli_query($conn,$sqryordstsnm_mst);
		$rwsordstsnm_mst  = mysqli_fetch_array($srsordstsnm_mst);
		$odrstsnm = $rwsordstsnm_mst['ordstsm_name'];=
		//echo "hello".$odrstsnm;exit;
		$sqryordsts_mst  ="SELECT 
			ordstsd_id,ordstsd_dttm,ordstsm_name 
		FROM 
			ordsts_dtl
		left join ordsts_mst on ordstsm_id  = ordstsd_ordstsm_id 	  
		WHERE 
			ordstsd_ordstsm_id='$stsid' AND
			ordstsd_crtordm_id='$orderid' AND
			ordstsd_dttm='$stsdt'
		ORDER BY
			ordstsd_id desc limit 0,1";				 
		$srsordsts_mst   = mysqli_query($conn,$sqryordsts_mst);
		$rowsordsts_mst  = mysqli_num_rows($srsordsts_mst); 
		//	echo $sqryordsts_mst;exit;
		//$rowsordsts_mst = 0;
		if($rowsordsts_mst < 1)
		{
			if((($stsid == '3')||($odrstsnm =="Delivered")))
			{
				$uqrycrtord_mst = "update 
				crtord_mst set crtordm_paysts = 'y'
				where
				crtordm_id = '$orderid'"; 
				//echo "Helooo";exit;
				$resuqrycrtord_mst = mysqli_query($conn,$uqrycrtord_mst);
				if($resuqrycrtord_mst==true)
				{
					//Cod Staus
					$sqrycrtord_mst = "SELECT 
					crtordm_id,crtordm_code,crtordm_fstname,crtordm_lstname, 
					crtordm_badrs,crtordm_badrs2,crtordm_bcmpny,
					blcty.ctym_name as bctynm,blcnty.cntym_name as bcntynm,
					crtordm_bzip,blcntry.cntrym_name as bcntrynm,crtordm_bdayphone,
					crtordm_emailid,crtordm_sfstname,crtordm_slstname,crtordm_sadrs,
					crtordm_sadrs2,crtordm_scmpny,shpcty.ctym_name as sctynm, shpcnty.cntym_name as scntynm,
					shpcnty.cntym_id as scntyid,
					crtordm_szip,shpcntry.cntrym_name as scntrynm,
					crtordm_sdayphone,crtordm_semailid,crtordm_qty,crtordm_amt,crtordm_wt,
					crtordm_pmode,crtordm_prcssts,crtordm_cartsts,crtordm_paysts,crtordm_rmks,
					crtordm_shpchrgm_id,crtordm_shpchrgamt,crtordm_cpnm_val,crtordm_mbrm_id,
					crtordm_ordtyp,date_format(crtordm_crtdon,'%d-%m-%Y') as crtordm_crtdon_dt,
					date_format(crtordm_crtdon,'%h:%i:%s') as crtordm_crtdon_tm,
					blcty.ctym_sts as bctysts,shpcty.ctym_sts as sctysts,
					blcnty.cntym_sts as bcntysts,shpcnty.cntym_sts as scntysts,
					blcntnt.cntntm_name as bcntntm_name,shpcntnt.cntntm_name as scntntm_name,
					crtordm_codm_id,crtordm_codm_prc,shpchrgm_name,crtordm_disamt,
					crtordm_hsncde,crtordm_igst,
					cpnm_name,crtordm_cpnm_id	
					from 
					crtord_mst crtord left join cntry_mst blcntry on 
					blcntry.cntrym_id=crtord.crtordm_bmbrcntrym_id 
					left join cnty_mst blcnty on blcnty.cntym_id = crtord.crtordm_bmbrcntym_id 
					left join cty_mst blcty on blcty.ctym_id = crtord.crtordm_bmbrctym_id
					left join cty_mst shpcty on shpcty.ctym_id = crtord.crtordm_smbrctym_id 
					left join cnty_mst shpcnty on shpcnty.cntym_id = crtord.crtordm_smbrcntym_id 
					left join cntry_mst shpcntry on shpcntry.cntrym_id= crtord.crtordm_smbrcntrym_id
					left join cntnt_mst blcntnt on blcntry.cntrym_cntntm_id= blcntnt.cntntm_id 
					left join cntnt_mst shpcntnt on shpcntry.cntrym_cntntm_id= shpcntnt.cntntm_id
					left join shpchrg_mst on crtord.crtordm_shpchrgm_id = shpchrgm_id
					left join cpn_mst on cpn_mst.cpnm_id = crtordm_cpnm_id	
					where
					crtordm_id= '$orderid'";
					//	echo $sqrycrtord_mst; exit;
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
						$shipname 	= $srowcrtord_mst['shpchrgm_name'];	 
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
						//$db_pmode 	= funcPayMod($srowcrtord_mst['crtordm_pmode']);
						$db_pmode 	= $srowcrtord_mst['shpchrgm_name'];
						$dispsy 	= $srowcrtord_mst['crtordm_paysts'];
						$db_ordqty	= $srowcrtord_mst['crtordm_qty'];
						$db_ordamt	= $srowcrtord_mst['crtordm_amt'];
						$db_ordrmks	= $srowcrtord_mst['crtordm_rmks'];
						$db_codamt	= $srowcrtord_mst['crtordm_codm_prc'];
						$hsncde	= $srowcrtord_mst['crtordm_hsncde'];
						$crtgst	= $srowcrtord_mst['crtordm_igst'];
						$shpmnprc  = $srowcrtord_mst['crtordm_shpchrgamt']; 
						$codprc  = $srowcrtord_mst['crtordm_codm_prc'];
						$cupid  = $srowcrtord_mst['crtordm_cpnm_id'];
						$cupnm  = $srowcrtord_mst['cpnm_name'];
						$cupval  = $srowcrtord_mst['crtordm_cpnm_val'];
						$cuptyp  = $srowcrtord_mst['crtordm_cpnm_typ'];
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
							$shpcmpltadrs .= ",&nbsp;TAX Number :&nbsp;".$sgst;	
						}
							if($scom != ''){
							$shpcmpltadrs .= ",&nbsp;Company :&nbsp;".$scom;	
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
							$blngcmpltadrs .= ",&nbsp;TAX Number :&nbsp;".$bgst;	
						}
							if($bcom != ''){
							$blngcmpltadrs .= ",&nbsp;Company :&nbsp;".$bcom;	
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
						//echo "Mobile".$bphno;
						/*	 $msg = "Thank you for placing an Order for $db_ordqty items for $db_ordamt Your order reference id is $ordcode,www.mangatrai.com,+0 70934 60111";	
						$msg = urlencode($msg);
						//$url="http://www.pointsms.in/API/sms.php?username=deliciousfoods&password=P5WB58f5&from=DELCIS&to=$bphno&msg=$msg"; 

						$ch=curl_init();

						curl_setopt($ch, CURLOPT_URL, $url);

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

						$output=curl_exec($ch);

						curl_close($ch);

						Hello {#var#}, your order has been shipped.
						You may track it by clicking on the following link: https://www.bluedart.com/tracking And searching for your reference number {#var#} 
						DarpanMangatraiPearls
						Punjagutta, Hyderabad
						*/
						if($stsid == 6)
						{
							$msg = " Hello $bfname $blname, your order has been shipped. You may track it by clicking on the following link: https://www.bluedart.com/tracking And searching for your reference number $ordcode
							DarpanMangatraiPearls
							Punjagutta, Hyderabad";
							$username = "mangatraijewellers";
							$password = "Mrj1905";
							$numbers = "$bphno"; // mobile number
							$from = 'MRJDAR'; // assigned Sender_ID
							$template_id = "1707161529400313011";
							$message = urlencode($msg); // Message text required to deliver on mobile number
							$messagetype = 1;
							$dnd_check = 0;
							$request = array('username' => $username,'password' => $password,'from' =>$from,'to' =>$numbers,'msg' =>$message,'type'=>$messagetype,'dnd_check' => $dnd_check,'template_id'=>$template_id);
							$url = "https://www.smsstriker.com/API/sms.php";
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
							curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							$result = curl_exec($ch);
							curl_close($ch);	
						}
						else if($stsid == 4)
						{
							$msg = " Hello $bfname $blname, your order has been delivered. Please rate your 
							experience on www.mangatrai.com by logging in your account. 
							DarpanMangatrai Pearls
							Punjagutta, Hyderabad";
							$username = "mangatraijewellers";
							$password = "Mrj1905";
							$numbers = "$bphno"; // mobile number
							$from = 'MRJDAR'; // assigned Sender_ID
							$template_id = "1707161529400313011";
							$message = urlencode($msg); // Message text required to deliver on mobile number
							$messagetype = 1;
							$dnd_check = 0;
							$request = array('username' => $username,'password' => $password,'from' =>$from,'to' =>$numbers,'msg' =>$message,'type'=>$messagetype,'dnd_check' => $dnd_check,'template_id'=>$template_id);
							$url = "https://www.smsstriker.com/API/sms.php";
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
							curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							$result = curl_exec($ch);
							curl_close($ch);
						}
						$hdimg    ="http://".$u_prjct_mnurl."/".$site_mail_logo;
						//$hdimg    = "http://www.".$u_prjct_mnurl."/".$site_logo;//Return the URL	
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
						<td height='4' valign='top' bgcolor='#cccccc' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
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
						</tr>
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
						<td align='center'><p style='color:#d31b12'>Payment Status</p></td>
						</tr>
						<tr valign='top'>
						<td align='center'  >$ordcode</td> 
						<td align='center' >$orddate</td>
						<td align='center'><p style='color:#d31b12'>Yes</p></td>
						</tr> 
						</table>
						<table align='center' width='605' cellpadding='0' cellspacing='0' bgcolor='#ffffff' style='background-color:#ffffff'>
						<tr>
						<td><p style='color:#d31b12;font-family:Arial, Helvetica, sans-serif;margin-top:5px; margin-bottom:5px'>Your Recent Order:</p></td>
						</tr>
						<tr>
						<td><table width='100%' cellpadding='5' cellspacing='0' border='1' bordercolor='#dfdfdf' style='border:1px solid #dfdfdf'>
						<tr>
						<td  valign='middle'><p style='color:#d31b12'>Product</p></td>
						<td  valign='middle'><p style='color:#d31b12'>Qty</p></td>
						<td  valign='middle'><p style='color:#d31b12'>Price($)</p></td>";
						$msgbody.="<td align='right' valign='middle'><p style='color:#d31b12'>Total Price($)<i class='fas fa-dollar-sign'></i></p> </td> </tr>";
						$sqrycrtord_dtl =	"select crtordd_id,crtordd_qty,(crtordd_prc) as crtordd_prc,prodm_id,prodm_name, crtordd_prc as unprcval,
						prodm_gst,crtordd_prodprcd_id,crtordd_prodm_id,prodm_code
						,prodprcd_wght,
						prodm_sgst,prodm_cgst
						from
						crtord_dtl 
						inner join prod_mst on prod_mst.prodm_id = crtord_dtl.crtordd_prodm_id
						inner join prodprc_dtl on prodprc_dtl.prodprcd_prodm_id = prod_mst.prodm_id 
						where crtordd_crtordm_id=$orderid group by crtordd_id  
						";	
						//  echo $sqrycrtord_dtl ;exit;
						$srscrtord_dtl = mysqli_query($conn,$sqrycrtord_dtl);
						$cnttorec      = mysqli_num_rows($srscrtord_dtl);
						if($cnttorec > 0)
						{	
							$totcrtprc = "";						
							while($rowspo_mst=mysqli_fetch_assoc($srscrtord_dtl))
							{
								$db_shpprc = ($rowspo_mst['crtordd_qty']*$rowspo_mst['crtordd_shpprc']);
								$msgbody.="<tr>
								<td>Name: $rowspo_mst[prodm_code]<br/>
								Code: $rowspo_mst[prodm_name] <br/>
								Price($): $rowspo_mst[crtordd_prc]</td>
								<td>$rowspo_mst[crtordd_qty]</td>";
								$db_prc = $rowspo_mst['crtordd_prc'];
								error_reporting(0);
								$gstval = $rowspo_mst['prodm_gst'];   
								$sgstval = $rowspo_mst['prodm_sgst'];   
								$cgstval = $rowspo_mst['prodm_cgst'];    
								$gst = 1+($gstval/100);
								$sgst = 1+($sgstval/100);
								$cgst = 1+($cgstval/100);
								$prdprc  = $db_prc/$gst;
								$sgstprdprc  = $db_prc/$sgst;
								$cgstprdprc  = $db_prc/$cgst;
								$prdwoustgst = $prdprc; 
								$prdwoustsgst = $sgstprdprc; 
								$prdwoustcgst = $cgstprdprc; 
								$tax = $db_prc - $prdwoustgst;
								$sgsttax = $db_prc - $prdwoustsgst;
								$cgsttax = $db_prc - $prdwoustcgst;
								$igstper =$gstper;													
								$clid = 4;		

								$msgbody.="
								<td valign='right'>". number_format($prdwoustgst,2,'.',',')."</td>";
								$msgbody.="<td align='right' valign='right'>";
								$totitmprc = ($rowspo_mst['crtordd_prc']*$rowspo_mst['crtordd_qty']);
								$totcrtprc +=  $totitmprc+$db_shpprc;
								$untbx_prc 		   = ($rowspo_mst['crtordd_prc'] + $rowspo_mst['crtordd_shpprc']);
								$totlprdprc = $totlprdprc+$totitmprc;
								$msgbody.=   number_format($totitmprc+$db_shpprc,2,".",",")."
								</td>
								</tr>";							
							}
						}		
						$taxcnty = 		$srowcrtord_mst['crtordm_igst'];
						$msgbody.="<tr><td  colspan='3' align='right'>Product Cost:";
						$msgbody.= "<br>Tax :";
						if($cupid!=0)
						{
							$msgbody.= "<br><b>Coupon(Applied)-$cupnm : </b>";
						}
						if($shpmnprc > 0)
						{
							$msgbody.= "<br><b>SHIPPING CHARGES :</b>";
						}
						else
						{
							$msgbody.= "<br><b>SHIPPING CHARGES :</b>";
						}			
							$msgbody.="</td>
							<td align='right' valign='TOP'>".number_format($totlprdprc,2,'.',',');
							$msgbody .= "<br> ".number_format($taxcnty,2,'.',',');
							$totlprdprc = $totlprdprc+$taxcnty;
						if($cupid!=0)
						{
							$totlprdprc -= $cupval;
							$msgbody.= "<br>-<b>$cupval </b>"; 
						}
						if($totcrtprc != 0)
						{
							$totlprdprc +=  $shpmnprc;
							$msgbody .=  "<br>".number_format($shpmnprc,2,'.',',');
						}	 
						$msgbody.="</td></tr>";
						$msgbody.="<tr> <td  colspan='3' align='right'>Order Amount: </td>";
						$msgbody.="<td align='right' valign='middle'>".number_format($totlprdprc,2,'.',',')."</td> </tr>";
						$msgbody .=	"</table></td></tr></table>
						<table width='605' border='0' align='center' cellpadding='0' cellspacing='0'>
							<tr>
							<tr>
								<td height='10'  bgcolor='#ffffff' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
							</tr>
							<td>
								<p>For suggestions / support please feel free to email us at <a href='mailto:$u_prjct_url1s' style='color:#d31b12; text-decoration:none'>$u_prjct_url1s</a>.</p>
								<p>Sincerely, <br>
									Customer Service,<br>
									Support &amp; Answer Center,<br>
									<a href='http://".$u_prjct_mnurl."'>Mangatrai Pearls &amp; Jewellers<br>
								</p>
							</td>
							</tr>
						</table>
						</td>
						</tr>
						</table>
						</div>
						</body>
						</html>";	
						//echo $msgbody; exit;		
						$to       = $bemail;
						$from     = $u_prjct_email;
						//	$subject  = "Your $usr_cmpny order " .$ordcode." Payment Confirm";
						$subject  = "Your order $usr_cmpny " .$ordcode." Payment Confirm"; 
						$headers  = "From: " . $from . "\r\n";
						$headers .= "CC: ".$from ."\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
						mail($to,$subject,$msgbody,$headers);	
					}
					//Cod Staus
				}
			}
			
			$uqryordsts_dtl= "UPDATE 
				ordsts_dtl 
			SET 
				ordstsd_sts = 'd',	
				ordstsd_crtdon	= '$crnt_dt',
				ordstsd_crtdby	= 'admin'						  								
			WHERE 
				ordstsd_ordstsm_id='$stsid' AND 
				ordstsd_crtordm_id='$orderid'";
			$srsordsts_dtl	= 	mysqli_query($conn,$uqryordsts_dtl);	

			$iqryordsts_mst="INSERT INTO ordsts_dtl(
			ordstsd_ordstsm_id,ordstsd_crtordm_id,
			ordstsd_dttm,ordstsd_desc,
			ordstsd_crtdon,ordstsd_crtdby)VALUES(
			'$stsid','$orderid','$stsdt','$desc',
			'$crnt_dt','admin')";
			$irsordsts_mst= mysqli_query($conn,$iqryordsts_mst);
			if($irsordsts_mst==true)
			{		
				echo $sqryordsts_mst  ="SELECT 
				ordstsm_name,ordstsm_desc
				FROM 
				ordsts_mst
				WHERE 
				ordstsm_id='$stsid'"; 
				$srsordsts_mst   = mysqli_query($conn,$sqryordsts_mst);
				$srowordsts_mst   = mysqli_fetch_assoc($srsordsts_mst);
				$db_ordstsnm = $srowordsts_mst['ordstsm_name'];
				$db_ordstsdesc = $desc;
				//$hdimg    = "http://".$u_prjct_mnurl."/".$site_logo;//Return the URL	
				$hdimg    ="http://".$u_prjct_mnurl."/".$site_mail_logo;
				$sqrycrtord_mst = "select 
				crtordm_id,crtordm_code,crtordm_fstname,crtordm_lstname, 
				crtordm_badrs,crtordm_badrs2,crtordm_bcmpny,
				blcty.ctym_name as bctynm,blcnty.cntym_name as bcntynm,
				crtordm_bzip,blcntry.cntrym_name as bcntrynm,crtordm_bdayphone,
				crtordm_emailid,crtordm_sfstname,crtordm_slstname,crtordm_sadrs,
				crtordm_sadrs2,crtordm_scmpny,shpcty.ctym_name as sctynm, shpcnty.cntym_name as                                 scntynm,
				shpcnty.cntym_id as scntyid,
				crtordm_szip,shpcntry.cntrym_name as scntrynm,
				crtordm_sdayphone,crtordm_semailid,crtordm_qty,crtordm_amt,crtordm_wt,
				crtordm_pmode,crtordm_prcssts,crtordm_cartsts,crtordm_paysts,crtordm_rmks,
				crtordm_shpchrgm_id,crtordm_shpchrgamt,crtordm_cpnm_val,crtordm_mbrm_id,
				crtordm_ordtyp,date_format(crtordm_crtdon,'%d-%m-%Y') as crtordm_crtdon_dt,
				date_format(crtordm_crtdon,'%h:%i:%s') as crtordm_crtdon_tm,
				blcty.ctym_sts as bctysts,shpcty.ctym_sts as sctysts,
				blcnty.cntym_sts as bcntysts,shpcnty.cntym_sts as scntysts,
				blcntnt.cntntm_name as bcntntm_name,shpcntnt.cntntm_name as scntntm_name,
				crtordm_codm_id,crtordm_codm_prc,shpchrgm_name,crtordm_disamt,
				crtordm_hsncde,crtordm_igst,
				cpnm_name,crtordm_cpnm_id	
				from 
				crtord_mst crtord left join cntry_mst blcntry on 
				blcntry.cntrym_id=crtord.crtordm_bmbrcntrym_id 
				left join cnty_mst blcnty on blcnty.cntym_id = crtord.crtordm_bmbrcntym_id 
				left join cty_mst blcty on blcty.ctym_id = crtord.crtordm_bmbrctym_id
				left join cty_mst shpcty on shpcty.ctym_id = crtord.crtordm_smbrctym_id 
				left join cnty_mst shpcnty on shpcnty.cntym_id = crtord.crtordm_smbrcntym_id 
				left join cntry_mst shpcntry on shpcntry.cntrym_id= crtord.crtordm_smbrcntrym_id
				left join cntnt_mst blcntnt on blcntry.cntrym_cntntm_id= blcntnt.cntntm_id 
				left join cntnt_mst shpcntnt on shpcntry.cntrym_cntntm_id= shpcntnt.cntntm_id
				left join shpchrg_mst on crtord.crtordm_shpchrgm_id = shpchrgm_id
				left join cpn_mst on cpn_mst.cpnm_id = crtordm_cpnm_id	
				where
				crtordm_id='$orderid'	";
				$srscrtord_mst = mysqli_query($conn,$sqrycrtord_mst);
				$cntord_rec	   = mysqli_num_rows($srscrtord_mst);
				if($cntord_rec > 0)
				{			
					$srowcrtord_mst = mysqli_fetch_assoc($srscrtord_mst);
					$crtord_id		= $srowcrtord_mst['crtordm_id'];											
					$bfname  = $srowcrtord_mst['crtordm_fstname'];
					$blname	  = $srowcrtord_mst['crtordm_lstname'];	
					$bemail  = $srowcrtord_mst['crtordm_emailid'];
					$ordcode = $srowcrtord_mst['crtordm_code'];
					$ordmid	 =  base64_encode($srowcrtord_mst['crtordm_id']);
					$orddate = $srowcrtord_mst['crtordm_crtdon_dt']." ".$srowcrtord_mst['crtordm_crtdon_tm'];	 
					$shipname = $srowcrtord_mst['shpchrgm_name'];	 
					$shpprc  = $srowcrtord_mst['crtordm_shpchrgamt'];
					$sfname   = $srowcrtord_mst['crtordm_sfstname'];	 
					$slname	  = $srowcrtord_mst['crtordm_slstname'];	 			   
					$sadrs	  = $srowcrtord_mst['crtordm_sadrs'];
					$sadrs2   = $srowcrtord_mst['crtordm_sadrs2'];
					$scty 	  = $srowcrtord_mst['sctynm'];
					$scounty  = $srowcrtord_mst['scntynm'];
					$scountry = $srowcrtord_mst['scntrynm'];
					$badrs	  = $srowcrtord_mst['crtordm_badrs'];
					$badrs2   = $srowcrtord_mst['crtordm_badrs2'];
					$bcty 	  = $srowcrtord_mst['bctynm'];
					$bcounty  = $srowcrtord_mst['bcntynm'];
					$bcountry = $srowcrtord_mst['bcntrynm'];
					$bzip	  = $srowcrtord_mst['crtordm_bzip'];		
					$bemail	  = $srowcrtord_mst['crtordm_emailid'];
					$bphno	  = $srowcrtord_mst['crtordm_bdayphone'];
					$szip	  = $srowcrtord_mst['crtordm_szip'];		
					$semail	  = $srowcrtord_mst['crtordm_semailid'];	
					$sphno	  = $srowcrtord_mst['crtordm_sdayphone'];
					$ordamt	  = $srowcrtord_mst['crtordm_amt'];
					$shipprc	  = $srowcrtord_mst['crtordm_shpchrgamt'];
					$crtwt	  = $srowcrtord_mst['crtordm_wt'];
					$totcrtprc = $ordamt + $shipprc;
					$db_pmode = funcPayMod($srowcrtord_mst['crtordm_pmode']);
					$db_psts = funcDispCrnt($srowcrtord_mst['crtordm_paysts']);
					$db_ordqty	  = $srowcrtord_mst['crtordm_qty'];
					$db_ordamt	  = $srowcrtord_mst['crtordm_amt'];
					$db_ordrmks	  = $srowcrtord_mst['crtordm_rmks'];
					$dispsy    =$db_psts;
					$shpcmpltadrs ="";
					if($bemail != ''){
						$shpcmpltadrs = $bemail;	
					}
					if($sfname != ''){
						$shpcmpltadrs .= "<br/>".$sfname;	
					}						 
					if($slname != ''){
						$shpcmpltadrs .= "&nbsp;".$slname;	
					}
					if($sadrs != ''){
						$shpcmpltadrs .= "<br>".$sadrs;	
					}						 
					if($sadrs2 != ''){
						$shpcmpltadrs .= ",&nbsp;".$sadrs2;	
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
					$blngcmpltadrs ="";
					if($bemail != ''){
						$blngcmpltadrs = $bemail;	
					}
					if($bfname != ''){
						$blngcmpltadrs .= "<br/>".$bfname;	
					}						 
					if($blname != ''){
						$blngcmpltadrs .= "&nbsp;".$blname;	
					}						 
					if($badrs != ''){
						$blngcmpltadrs .= "<br>".$badrs;	
					}						 
					if($badrs2 != ''){
						$blngcmpltadrs .= ",&nbsp;".$badrs2;	
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
					$orddate	= date('l jS F Y',strtotime($orddate));												
					$stsdate	= date('l jS F Y',strtotime($stsdt));	
					$msgbody="<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>
					<html>
					<head>
					<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0'/>
					<title>$usr_cmpny | Order Information</title>
					<style type='text/css'>
					#outlook a{padding:0}body{width:100% !important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;background-color:#fff;font-family:Arial,Helvetica,sans-serif;font-size:16px}p{margin-top:0;margin-bottom:10px}table td{border-collapse:collapse}table{border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt}img{outline:none;text-decoration:none;-ms-interpolation-mode:bicubic}a img{border:none}.image_fix{display:block}
					</style>
					</head>
					<body style='margin:0; background-color:#ffffff;' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
					<div style='background-color:#fff;'>
					<table style='background-color: #ffffff;' width='100%' border='0' cellspacing='0' cellpadding='0'>
					<tr>
					<td> <table style='background-color:#ffffff;padding:0' background='#ffffff' width='605' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
					<td><a href='https://".$u_prjct_mnurl."/home' ><img src='https://www.mangatrai.com/images/mangatrai-logo.png' alt='$usr_cmpny' hspace='10' vspace='15' width='200'></a></td>
					<td align='right' width='50%'> <a href='https://www.mangatrai.com/list-order' target='_blank' style='color:#e99005; margin-right:10px;'>Your Orders</a> | <a href='https://www.mangatrai.com/' target='_blank' style='color:#e99005; margin-left:10px;'>mangatrai.com</a><br>
					<h2 style='margin-top:5px; margin-bottom:5px; font-family: Georgia, 'Times New Roman', Times, serif; font-size:30px'>Order Information</h2>
					<p>$ordcode</p> </td>
					</tr>
					</table>
					<table style='background-color:#ffffff;padding:0' background='#ffffff' width='605' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
					<td height='4' valign='top' bgcolor='#cccccc' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
					</tr>
					<tr>
					<td height='10' valign='top' bgcolor='#fff' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
					</tr>
					<tr>
					<td valign='top' bgcolor='#ffffff'><p style='font-family:Arial, Helvetica, sans-serif; color:#e99005; font-weight:bold;'>Dear $bfname,</p>
					<p style='font-family:Arial, Helvetica, sans-serif; font-size:14px;'>Thank you for your order $ordcode <br> $db_ordstsnm: on " .$stsdate. ".</p>
					<p style='font-family:Arial, Helvetica, sans-serif; font-size:14px;'>
					If   you have any queries about your order, kindly contact our <a href=''https://".$u_prjct_mnurl."/contact-us' target='_blank' style='color:#ff6600; text-decoration:none'>Customer Care</a></p></td>
					</tr>
					</table>
					<table align='center' width='605' cellpadding='0' cellspacing='0' bgcolor='#ffffff' style='background-color:#ffffff'>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td>$desc</td>
					</tr>
					</table>
					</table>
					<table width='605' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
					<tr>
					<td height='10'  bgcolor='#ffffff' class='spacer'    style='margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;text-align:left;-webkit-text-size-adjust:none;font-size:0;line-height:0;'>&nbsp;</td>
					</tr>
					<td>
					<p>Thank You order with $usr_cmpny.</p>
					We hope to see you soon again<br>
					<a href='mailto:$u_prjct_mnurlhttp' style='color:#e99005; text-decoration:none'>$usr_cmpny</a>.<br>
					</p>
					</td>
					</tr>
					</table>

					</body>
					</html>";
					echo $msgbody; exit;
					$to       = $bemail;
					$from     =  $u_prjct_email;
					$subject  = "Your order $usr_cmpny " .$ordcode." $db_ordstsnm";
					$headers  = "From: " . $from . "\r\n";
					$headers .= "CC: ".$from ."\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
					mail($to,$subject,$msgbody,$headers);
					//echo $msgbody;
				}	
				$gmsg = "Record Updated successfully";
			}
    }
	  else
		{		
			$gmsg = "Duplicate name. Record not updated";
	  }
  }
?>