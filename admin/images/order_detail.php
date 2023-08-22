<?php
	include_once '../includes/inc_nocache.php'; // Clearing the cache information
	include_once "../includes/inc_adm_session.php";//checking for session
	include_once "../includes/inc_connection.php";//Making database Connection
	include_once "../includes/inc_usr_functions.php";//Use function for validation and more	
	include_once "../includes/inc_paging_functions.php";//Making paging validation
	include_once  "../includes/inc_config.php";		
	/**********************************************************
	Programm 	  : order_detail.php	
	Company 	  : Adroit
	************************************************************/
	global $msg,$loc,$disppg,$dispmsg;
	global $gdispallshp,$gselcrncynm,$gselshpchrg,$gselshpchrgdesc,$ggrscartprc,$gnetcartprc;

	if(isset($_REQUEST['oid']) && (trim($_REQUEST['oid']) != "")){
		$cid = addslashes(trim($_REQUEST['oid']));
		$sqrycrtord_mst	= "select 
								crtordm_id,crtordm_code,crtordm_fstname,crtordm_lstname, 
								crtordm_badrs,crtordm_badrs2,blcty.ctym_name as bctynm,blcnty.cntym_name as bcntynm,
								crtordm_bzip,blcntry.cntrym_name as bcntrynm,crtordm_bdayphone,
								crtordm_emailid,crtordm_sfstname,crtordm_slstname,crtordm_sadrs,
								crtordm_sadrs2,shpcty.ctym_name as sctynm, shpcnty.cntym_name as scntynm,
								crtordm_szip,shpcntry.cntrym_name as scntrynm,
								crtordm_sdayphone,crtordm_semailid,crtordm_qty,crtordm_amt,crtordm_wt,
								crtordm_pmode,crtordm_prcssts,crtordm_cartsts,crtordm_paysts,crtordm_rmks,
								crtordm_shpchrgm_id,crtordm_shpchrgamt,crtordm_cpnm_val,crtordm_mbrm_id,
								crtordm_ordtyp,date_format(crtordm_crtdon,'%d-%m-%Y') as crtordm_crtdon_dt,
								date_format(crtordm_crtdon,'%h:%i:%s') as crtordm_crtdon_tm
						   from 
								crtord_mst crtord inner join cntry_mst blcntry on 
								blcntry.cntrym_id=crtord.crtordm_bmbrcntrym_id 
								left join cnty_mst blcnty on blcnty.cntym_id = crtord.crtordm_bmbrcntym_id 
								left join cty_mst blcty on blcty.ctym_id = crtord.crtordm_bmbrctym_id
								left join cty_mst shpcty on shpcty.ctym_id = crtord.crtordm_smbrctym_id 
								left join cnty_mst shpcnty on shpcnty.cntym_id = crtord.crtordm_smbrcntym_id 
								left join cntry_mst shpcntry on shpcntry.cntrym_id= crtord.crtordm_smbrcntrym_id
						   where
								crtordm_id='$cid' and
								crtordm_cartsts='r'";
					   
		$srscrtord_mst = mysqli_query($conn,$sqrycrtord_mst);
		$cntrec		   = mysqli_num_rows($srscrtord_mst);
		if($cntrec > 0){
			$srowcrtord_mst=mysqli_fetch_array($srscrtord_mst);							
		}
		else{
			header('location:vw_all_orders.php');
			exit();
		}
	}	
	else{
		header('location:vw_all_orders.php');
		exit();
	}
	if(isset($_REQUEST['pg']) && (trim($_REQUEST['pg']) != "")){
		$pg = trim($_REQUEST['pg']);	
	}
	else{
		$pg = 1;
	}
	if(isset($_REQUEST['countstart']) && (trim($_REQUEST['countstart']) != "")){
		$cntstart = trim($_REQUEST['countstart']);	
	}	
	else{
		$cntstart = 1;
	}		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo $pgtl;?></title>
<script language="javascript">
	function funcBck(val)
	{			
		var pg,cntstart;
		pg = <?php echo $pg;?>;
		cntstart = <?php echo $cntstart;?>;		
		//location.href = "view_all_orders.php?oid="+val+"&pg="+pg+"&countstart="+cntstart;
		history.back();
	}
</script>
<link href="docstyle.css" rel="stylesheet" type="text/css">	
</head>
<body>
<?php include_once '../includes/inc_adm_header.php'; ?>
<table width="977"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="230" valign="top"><?php include_once('leftlinks.php');?></td>
    <td valign="top" class="admcnt_bdr"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="700" height="325" valign="middle" background="images/content_topbg.gif"  class="contentpadding" style="background-position:top; background-repeat:repeat-x; "><br>
          <form  method="post" enctype="multipart/form-data" name="frmsplradd" id="frmsplradd">			
			<input type="hidden" name="hdnord" id="hdnord" value="<?php echo $cid;?>">
			<input type="hidden" name="hdnordcode" id="hdnordcode" value="<?php echo $srowcrtord_mst['crtordm_code'];?>">									
              <table width="95%"  border="0" align="center" cellpadding="3" cellspacing="1">
			  	  <tr align="left" bgcolor="#F2F1F1">
					  <td colspan="4"  class="maintitles">
						ORDER DETAIL &nbsp;&nbsp;&nbsp;
					  </td>
				  </tr>			  			  		  
				  <tr bgcolor="#F2F1F1">			  
					  <td width="30%" align="left" bgcolor="#F2F1F1"><strong>Email id</strong></td>
					  <td align="left"><?php echo $srowcrtord_mst['crtordm_emailid'];?></td>
				  </tr>
				  <tr bgcolor="#F2F1F1">
						<td width="30%" align="left"><strong>Name</strong></td>
						<td align="left"><?php echo $srowcrtord_mst['crtordm_sfstname'];?></td>
				  </tr>
				  <tr>
						<td width="30%" align="left" bgcolor="#F2F1F1"><strong>Phone</strong></td>
						<td align="left" bgcolor="#F2F1F1"><?php echo $srowcrtord_mst['crtordm_bdayphone'];?></td>
				  </tr>	
				  <tr>
						<td width="30%" align="left" bgcolor="#F2F1F1"><strong>Order Number</strong></td>
						<td align="left" bgcolor="#F2F1F1"><?php echo $srowcrtord_mst['crtordm_id'];?></td>
				  </tr>			  			  			  		  
				  <tr>
						<td width="30%" align="left" bgcolor="#F2F1F1"><strong>Total Quantity</strong></td>
						<td align="left" bgcolor="#F2F1F1"><?php echo $srowcrtord_mst['crtordm_qty'];?></td>
				  </tr>
				  <tr>
						<td width="30%" align="left" bgcolor="#F2F1F1"><strong>Total Amount</strong></td>
						<td align="left" bgcolor="#F2F1F1"><?php echo $srowcrtord_mst['crtordm_amt'];?></td>
				  </tr>
				  <tr>
						<td width="30%" align="left" bgcolor="#F2F1F1"><strong>Booking Date</strong></td>
						<td align="left" bgcolor="#F2F1F1"><?php echo $srowcrtord_mst['crtordm_crtdon_dt'];?></td>
				  </tr>
				  <tr>
						<td width="30%" align="left" bgcolor="#F2F1F1"><strong>Booking Time</strong></td>
						<td align="left" bgcolor="#F2F1F1"><?php echo $srowcrtord_mst['crtordm_crtdon_tm'];?></td>
				  </tr>
			  <tr>
			  	<td width="30%" align="left" bgcolor="#F2F1F1"><strong>Customer Message</strong></td>
				<td align="left" bgcolor="#F2F1F1"><?php echo $srowcrtord_mst['crtordm_rmks'];?></td>
			  </tr>
			  <tr bgcolor="#F2F1F1">
				<td colspan="2">
					<table width="100%" border="0">
						<tr>
							<td width="50%" height="150px"> 
							   <table width="100%" border="0" cellpadding="3" cellspacing="1" >					
									<tr>
									  <td ><strong>BILLING ADDRESS</strong></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['crtordm_badrs'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['crtordm_badrs2'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['bctynm'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['bcntynm'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['bcntrynm'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['crtordm_bzip'];?></td>
									</tr>
									<tr>
									  <td>Phone No :<?php echo $srowcrtord_mst['crtordm_bdayphone'];?></td>
									</tr>
							  </table>			  		
						  </td>				
						  <td width="50%" height="150px" >
							   <table width="100%" border="0" cellpadding="3" cellspacing="1" >
									<tr >
									  <td ><strong>SHIPPING ADDRESS</strong></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['crtordm_sadrs'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['crtordm_sadrs2'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['sctynm'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['scntynm'];?></td>
									</tr>
									<tr>
									  <td width="70%"><?php echo $srowcrtord_mst['scntrynm'];?></td>
									</tr>
									<tr>
									  <td><?php echo $srowcrtord_mst['crtordm_szip'];?></td>
									</tr>
									<tr>
									  <td>Phone No :<?php echo $srowcrtord_mst['crtordm_sdayphone'];?></td>
									</tr>
					  		</table>			  		
			  	 		  </td>			  
		  	    		</tr>
				  </table>	
				</td>
			  </tr>
			  <tr >	
				<td colspan="2" bgcolor="#F2F1F1"><strong> CART DETAIL </strong></td>
			  </tr>
			  <tr >
			  		<td colspan="2">
						<table width="100%" border="0" cellpadding="3" cellspacing="1">
							<tr >
								<td width="6%" bgcolor="#F2F1F1"><strong>Sl No.</strong></td>
							  	<td width="20%" bgcolor="#F2F1F1"><strong>Product Code </strong></td>								
								<td width="20%" bgcolor="#F2F1F1"><strong>Product Name</strong></td>
								<td width="24%" bgcolor="#F2F1F1"><strong>Size - Colour</strong></td>
								<td width="10%" bgcolor="#F2F1F1" align="center"><strong>Unit Price</strong></td>					
					          	<td width="10%" align="center" bgcolor="#F2F1F1"><strong>Qty</strong></td>
								<td width="10%" align="center" bgcolor="#F2F1F1"><strong>Total Price</strong></td>													
					      	</tr>		
						  <?php
						  	$pototqty  = $srowcrtord_mst['crtordm_qty'];
							$pototprc  = $srowcrtord_mst['crtordm_amt'];	
							$sqrycrtord_dtl =	"select 
														crtordd_id,prodm_id,prodm_code,prodm_name,
														crtordd_qty,crtordd_prc,crtordd_sizem_id,crtordd_clrm_id
												 from 
													 crtord_dtl 
												 inner join 
													 (prod_mst)
												 on 
													crtordd_prodm_id=prodm_id 
												where 
													crtordd_crtordm_id=$cid";
																										
							$srscrtord_dtl 	= mysqli_query($conn,$sqrycrtord_dtl);
							$cnttorec      	= mysqli_num_rows($srscrtord_dtl);
							$totqty		   		= "";
							$totlprc	   			= "";							
							$cntord		   		= 0;						 
							if($cnttorec > 0){						
								while($rowspo_mst=mysqli_fetch_assoc($srscrtord_dtl)){
									 $cntord += 1;
									 $db_orddtlid 	= 	$rowspo_mst['crtordd_id'];									 
									 $db_qty 			= 	$rowspo_mst['crtordd_qty'];
									 $db_prc 			= 	$rowspo_mst['crtordd_prc'];								 
									 $totprc 			= ($db_qty * $db_prc); 						
							  ?>
										  <tr>
											<td align="left" bgcolor="#F2F1F1"><?php echo $cntord;?></td>
											<td align="left" bgcolor="#F2F1F1">
												<a href="#" onClick="open_win(<?php echo $rowspo_mst['prodm_id'];?>)" class="leftlinks">
													<?php echo $rowspo_mst['prodm_code'];?>
												</a>
											</td>											
											<td align="left" bgcolor="#F2F1F1"><?php echo $rowspo_mst['prodm_name'];?></td>
										<td align="left" bgcolor="#F2F1F1">
												<?php
													$sz_id = $rowspo_mst['crtordd_sizem_id'];
													if($sz_id !=0){
													$sqrysz_dtl = "select 
																					* 
																			   from 
																					vw_size_mst
																			   where 
																					sizem_id = '$sz_id'
																					and sizem_sts = 'a'";
																$srssz_dtl  =  mysqli_query($conn,$sqrysz_dtl);
																$cntsz_rec  =  mysqli_num_rows($srssz_dtl);
																if($cntsz_rec > 0)
																{
																	$srowsz_dtl =  mysqli_fetch_assoc($srssz_dtl);
																	$szname		=  $srowsz_dtl['sizem_name'];
																}
														}				
														else{
															$szname	=" ";
														}
														
														$clr_id = $rowspo_mst['crtordd_clrm_id'];
														if($clr_id !=""){
															$sqryclr_dtl = "select 
																					* 
																			   from 
																					clr_mst
																			   where 
																					clrm_id = '$clr_id'
																					and clrm_sts = 'a'";
																$srsclr_dtl  =  mysqli_query($conn,$sqryclr_dtl);
																$cntclr_rec  =  mysqli_num_rows($srsclr_dtl);
																if($cntclr_rec > 0)
																{
																	$srowclr_dtl =  mysqli_fetch_assoc($srsclr_dtl);
																	$clrnm		=  $srowclr_dtl['clrm_name'];
																}
														}
														else{
															$clrnm	=" ";
														}
														echo  $szname."  -  " .$clrnm;
												?>
											</td>
											<td align="right" bgcolor="#F2F1F1"><?php echo $db_prc;?></td>
											<td align="center" bgcolor="#F2F1F1">
												<?php 
													echo $db_qty;
													$totqty	=	$totqty + $db_qty;
												?>											</td>
											<td align="right" bgcolor="#F2F1F1">
												<?php 
												$totprc = $totprc + $totfcltyprc;
												echo number_format($totprc,2,".",",");
											 	$totlprc = $totlprc+$totprc;
												?>
											</td>
										  </tr>
							  <?php					
									}
								}				
						   	 ?>
			   			<tr>
							<td colspan="3" bgcolor="#F2F1F1"></td>
							<td bgcolor="#F2F1F1"><b>TOTAL QUANTITY : <?php echo $totqty;?></b></td>
							<td colspan="3" align="right" bgcolor="#F2F1F1">
								<?php
								/*								
									<b>SHIPPING CHARGES : <?php echo $shpprc;?></b><br>
									<b>DISCOUNT  AMOUNT : <?php echo $gtotdiscamt;?><br>
								*/?>
								   <strong>TOTAL PRICE : <?php echo number_format($totlprc+$shpprc,2,'.',',');?>								</strong></b>							</td>
						</tr>
					  </table>				   </td>
			  </tr>				 
			  <tr>
			    <td colspan="3" align="right" bgcolor="#F2F1F1">&nbsp;&nbsp;
					<input type="button" name="btnbck" id="btnbck" value="BACK" onClick="javascript:funcBck()">				
				</td>
			  </tr>				   
            </table>
            </FORM><br>         </td>
      </tr>
    </table></td>
  </tr>
</table>
<?php include_once '../includes/inc_adm_footer.php';?>
</body>
</html>
